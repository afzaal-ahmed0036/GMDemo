<?php

namespace App\Http\Controllers;

use App\CashRegister;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\CustomerGroup;
use App\Models\Dish;
use App\Models\DishTable;
use App\Models\DishType;
use App\Models\InvoiceDetail;
use App\Models\InvoiceDishDetail;
use App\Models\InvoiceMaster;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Journal;
use App\Models\Party;
use App\Models\Payment;
use App\Models\PaymentWithCreditCard;
use App\Models\PosSetting;
use App\Models\Tax;
use App\Models\TempInvoiceDetail;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;

class VoucherController extends Controller
{
    public function createVoucher()
    {
        try {
            $today = Carbon::now();
            $dateTwoDaysBefore = $today->subDays(2);
            $today = Carbon::now()->format('Y-m-d');
            $dateTwoDaysBefore = $dateTwoDaysBefore->format('Y-m-d');

            // dump($today);
            // dd($dateTwoDaysBefore);
            InvoiceDetail::where('InvoiceMasterID', null)->delete();
            $lims_customer_list      = Party::where('Active', 'Yes')->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            $lims_warehouse_list     = Warehouse::where('is_active', true)->get();
            $lims_biller_list        = User::where('UserType', 'Biller')->get();
            $lims_tax_list           = Tax::where('is_active', true)->get();
            $lims_product_list       = Item::selectRaw('ItemID AS id,ItemName as name,ItemCode AS code,ItemImage AS image,SellingPrice as SellingPrice ')->where('isActive', 1)->where('IsFeatured', 1)->where('ItemType', '!=', 'Restaurant')->get();

            foreach ($lims_product_list as $key => $product) {
                $images = explode(",", $product->image);
                $product->base_image = $images[0];
            }

            $product_number = count($lims_product_list);
            $lims_pos_setting_data = PosSetting::latest()->first();
            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = ItemCategory::where('type', '!=', 'RES')->orWhere('type', null)->get();

            $resturantItems = Item::where('ItemType', '=', 'Restaurant')->get();

            $recent_sale = DB::table('v_invoice_master')->where('sale_status', 1)
                ->where('InvoiceNo', 'like', 'INV%')
                ->whereDate('Date', '>=', $dateTwoDaysBefore)
                ->whereDate('Date', '<=', $today)
                ->orderBy('InvoiceMasterID', 'desc')
                ->get();
            // dd($recent_sale);
            $recent_draft = DB::table('v_invoice_master')
                ->where('sale_status', 3)
                ->whereDate('Date', '>=', $dateTwoDaysBefore)
                ->whereDate('Date', '<=', $today)
                ->orderBy('InvoiceMasterID', 'desc')
                ->get();

            $lims_coupon_list = Coupon::where('is_active', true)->get();
            $flag = 0;
            $invoice_no = InvoiceMaster::select('ReferenceNo')
                ->where('InvoiceNo', 'like', 'INV%')
                ->orderBy('InvoiceMasterID', 'desc')
                ->first();
            if ($invoice_no)
                $referenceNo = ++$invoice_no->ReferenceNo;
            else
                $referenceNo = 1;
            switch (strlen($referenceNo)) {
                case 1:
                    $paddingZeros = '0000';
                    break;
                case 2:
                    $paddingZeros = '000';
                    break;
                case 3:
                    $paddingZeros = '00';
                    break;
                case 4:
                    $paddingZeros = '0';
                    break;
                default:
                    $paddingZeros = '';
            }

            $invoice_no = 'INV-' . $paddingZeros . $referenceNo;
            // $invoice_no = 'INV-' . str_pad(++$invoice_no->ReferenceNo, 4 - strlen($invoice_no->ReferenceNo), '0', STR_PAD_LEFT);

            // dd($invoice_no);

            $dishes = Dish::where('status', 1)->get();
            $dish_tables = DishTable::orderBy('id')->get();
            return view('teq-invoice.voucher', compact('lims_customer_list', 'lims_customer_group_all', 'lims_warehouse_list', 'lims_product_list', 'product_number', 'lims_tax_list', 'lims_biller_list', 'lims_pos_setting_data', 'lims_brand_list', 'lims_category_list', 'recent_sale', 'recent_draft', 'lims_coupon_list', 'flag', 'invoice_no', 'dishes', 'dish_tables', 'resturantItems'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function storeVoucher(Request $request)
    {
        if (Session::has('UserID')) {
            // dd(Session::has('UserID'));
            $data    = $request->all();
            $message = '';
            // dd($data);
            $request->validate([
                'invoice_no' => 'required',
                'invoice_date' => 'required',
                'warehouse_id' => 'required',
                'biller_id' => 'required',
                'servingType' => 'required|in:pickup,delivery',
                'DeliveryAddress' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('servingType') == 'delivery' && empty($value)) {
                            $fail('The Delivery Address is required for delivery.');
                        }
                    },
                ],
                'driverName' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('servingType') == 'delivery' && empty($value)) {
                            $fail('The Driver Name is required for delivery.');
                        }
                    },
                ],
                'shipping_cost' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('servingType') == 'delivery' && empty($value)) {
                            $fail('Select the City or entre the Shipping Cost for delivery.');
                        }
                    },
                ],
            ]);
            if (isset($request->reference_no)) {
                $this->validate($request, [
                    'ReferenceNo' => [
                        'max:191', 'required', 'unique:sales'
                    ],
                ]);
            }
            try {
                DB::beginTransaction();
                // $loggedInUserId = Session::get('UserID');
                $cash_register_data = CashRegister::where([
                    ['user_id', Session::get('UserID')],
                    ['warehouse_id', $data['warehouse_id']],
                    ['status', true]
                ])->first();
                if ($cash_register_data) {
                    $data['cash_register_id'] = $cash_register_data->id;
                } else {
                    DB::rollBack();
                    return redirect('/')->with('error', 'You are not logged in, Login to Continue using the System');
                }
                $data['user_id'] = Session::get('UserID');
                if ($data['pos']) {
                    if (!isset($data['reference_no']))
                        $data['reference_no'] = str_replace('INV-', '', $data['invoice_no']);
                    $balance = $data['grand_total'] - $data['paid_amount'];
                    if ($balance > 0 || $balance < 0)
                        $data['payment_status'] = 2;
                    else
                        $data['payment_status'] = 4;

                    if ($data['draft']) {
                        $lims_sale_data = DB::table('invoice_master')->where('InvoiceMasterID', $data['sale_id'])->first();
                        $lims_product_sale_data = DB::table('invoice_detail')->where('InvoiceMasterID', $lims_sale_data->InvoiceMasterID)->get();
                        foreach ($lims_product_sale_data as $product_sale_data) {
                            $product_sale_data->delete();
                        }
                        $lims_sale_data->delete();
                    }
                } else {
                    if (!isset($data['reference_no']))
                        $data['reference_no'] = str_replace('INV-', '', $data['invoice_no']);
                }
                // dd($data);

                $document = $request->document;
                if ($document) {
                    $v = Validator::make(
                        ['extension' => strtolower($request->document->getClientOriginalExtension())],
                        ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                    );
                    if ($v->fails())
                        return redirect()->back()->withErrors($v->errors());

                    $documentName = $document->getClientOriginalName();
                    $document->move('public/sale/documents', $documentName);
                    $data['document'] = $documentName;
                }
                if ($data['coupon_active']) {
                    $lims_coupon_data = Coupon::find($data['coupon_id']);
                    $lims_coupon_data->used += 1;
                    $lims_coupon_data->save();
                }
                date_default_timezone_set('Asia/Dubai');
                $today_date = date('Y-m-d H:i:s');
                if (!empty($request->invoice_date))
                    $today_date = $request->invoice_date . ' ' . date('H:i:s');

                $exist_invoice_no = DB::table('invoice_master')
                    ->select('ReferenceNo')
                    ->where('InvoiceNo', 'like', 'INV%')
                    ->orderBy('ReferenceNo', 'desc')
                    ->first();
                if ($exist_invoice_no)
                    $referenceNo = ++$exist_invoice_no->ReferenceNo;
                else
                    $referenceNo = 1;
                switch (strlen($referenceNo)) {
                    case 1:
                        $paddingZeros = '0000';
                        break;
                    case 2:
                        $paddingZeros = '000';
                        break;
                    case 3:
                        $paddingZeros = '00';
                        break;
                    case 4:
                        $paddingZeros = '0';
                        break;
                    default:
                        $paddingZeros = '';
                }

                $exist_invoice_no = 'INV-' . $paddingZeros . $referenceNo;
                $invoice_no = $exist_invoice_no;
                $updateRef =  $paddingZeros . $referenceNo;

                $lims_customer_data = DB::table('party')->where('PartyID', $data['customer_id'])->first();
                $remaining_balance = $request->paying_amount -  $request->paid_amount;
                if ($data['sale_status'] == 3) {
                    $remaining_balance = $request->future_paying_amount -  $request->future_paid_amount;
                    $data['paid_by_id'] = $data['future_paid_by_id'];
                }
                $paying_method = match ($data['paid_by_id']) {
                    '1' => 'Cash',
                    '2' => 'Gift Card',
                    '3' => 'Credit Card',
                    '4' => 'Card',
                    '5' => 'Paypal',
                    '6' => 'Cash And Card',
                    '7' => 'Cash By Tabby',
                    '8' => 'Bank Transfer',
                    '9' => 'Credit',
                    '10' => 'Cash On Delivery',
                    default => 'Deposit'
                };



                if ($request->biller_id)
                    $biller_id = $request->biller_id;
                else
                    $biller_id    = Session::get('UserID');
                $invoice_data = array(
                    "InvoiceNo"          => $invoice_no,
                    "ReferenceNo"        => $updateRef,
                    "Date"               => $today_date,  // focus
                    "DueDate"            => $today_date, // focus
                    "PartyID"            => $request->customer_id,
                    "WarehouseID"        => $request->warehouse_id,
                    "DishTableID"        => $request->dish_table_id,
                    "WalkinCustomerName" => $lims_customer_data->PartyName,
                    "UserID"             => $biller_id,
                    "DescriptionNotes"   => $request->sale_note, // focus
                    "CustomerNotes"      => $request->sale_note, // focus
                    "Tax"                => $request->order_tax,
                    "TaxPer"             => $request->order_tax_rate,
                    "Paid"               =>  $request->paid_amount != null ? $request->paid_amount : ($request->future_paid_amount != null ? $request->future_paid_amount : '0.00'),
                    "Balance"            => $remaining_balance,
                    "TotalQty"           => $request->total_qty,
                    "SubTotal"           => $request->total_price,
                    "PaymentMode"        => $paying_method, // focus
                    "DiscountModel"      => $request->discount_model,
                    "DiscountPer"        => $request->order_discount,
                    "DiscountAmount"     => round($request->DiscountPer, 2),
                    "Shipping"           => $request->shipping_cost,
                    "GrandTotal"         => $request->grand_total,
                    "Total"              => $request->total,
                    "sale_status"        => $request->sale_status,
                    'cash_register_id'   => $cash_register_data->id,
                    'DeliveryAddress'    => $request->DeliveryAddress,
                    'driverName'         => $request->driverName,
                );
                $lims_sale_data     = InvoiceMaster::create($invoice_data);
                $product_quantities = $data['qty'];
                $product_prices     = $data['net_unit_price'];
                $product_taxes      = $data['tax']; // focus
                $product_discounts  = $data['discount'];
                $product_taxa       = $data['tax_rate']; // focus
                $product_disca      = $data['discount']; //focus
                $product_subtotals  = $data['subtotal'];
                $product_pids       = $data['product_id'];
                $product_units      = $data['sale_unit'];
                $product_codes      = $data['product_code'];
                $itemTypes          = $data['itemType'];
                $product_hsns       = $request->hsn;
                $product_serials    = $request->serial;

                /* Payment Save */
                $data['amount']          = $data['paid_amount'];
                $data['InvoiceMasterID'] = $lims_sale_data->InvoiceMasterID;
                $data['paying_method']   = $paying_method;

                //$this->payment($data);

                foreach ($product_pids as $key => $pid) {
                    if (!empty($itemTypes[$key]) && $itemTypes[$key] == 'dish') {
                        $dish_type = DishType::findOrFail($pid);
                        $invoice_dish_detail = new InvoiceDishDetail();
                        $invoice_dish_detail->invoice_master_id = $lims_sale_data->InvoiceMasterID;
                        $invoice_dish_detail->dish_id = $dish_type->dish_id;
                        $invoice_dish_detail->dish_type_id = $pid;
                        $invoice_dish_detail->quantity = $product_quantities[$key];
                        $invoice_dish_detail->price = $dish_type->price;
                        $invoice_dish_detail->save();

                        $dish_items = $dish_type->dish_recipe;
                        foreach ($dish_items as $dish_item) {
                            $item_name = DB::table('item')->where('ItemID', $dish_item->item_id)->pluck('ItemName')->first();
                            $invoice_det = array(
                                'InvoiceMasterID' =>  $lims_sale_data->InvoiceMasterID,
                                'InvoiceNo'       => $invoice_no,
                                'dish_id'         => $dish_type->dish_id,
                                'dish_type_id'    => $pid,
                                'ItemID'          => $dish_item->item_id,
                                "Description"     => $item_name,
                                'Qty'             => $dish_item->base_unit_amount_cooked
                            );
                            InvoiceDetail::create($invoice_det);
                        }
                    } else {
                        $item_name      = DB::table('item')->where('ItemID', $pid)->pluck('ItemName')->first();
                        $combo_services = '';

                        if (!empty($data['packages'][$pid])) {
                            foreach ($data['packages'][$pid] as $value) {
                                $combo_item_name = DB::table('item')->where('ItemID', $value)->pluck('ItemName')->first();
                                $combo_services .= $combo_item_name . ',';
                            }

                            $combo_services = '<br>( ' . rtrim($combo_services, ', ') . ' )';
                        }
                        $item_name = $item_name . $combo_services;
                        $in_stock = InvoiceDetail::select('Qty', 'Rate')->where('ItemID', $pid)->where('InvoiceNo', 'like', 'BILL-%')->get();
                        $out_stock = InvoiceDetail::join('invoice_master', 'invoice_detail.InvoiceMasterID', '=', 'invoice_master.InvoiceMasterID')
                            ->where('invoice_detail.ItemID', $pid)
                            ->where('invoice_detail.InvoiceNo', 'like', 'INV-%')
                            ->where('invoice_master.sale_status', '!=', 10)
                            ->sum('invoice_detail.Qty');

                        for ($i = 0; $i < count($in_stock); $i++) {
                            if ($out_stock > $in_stock[$i]->Qty) {
                                $out_stock -= $in_stock[$i]->Qty;
                            } else {
                                $new_out_stock = $out_stock + $product_quantities[$key];
                                if ($new_out_stock > $in_stock[$i]->Qty) {
                                    $difference_qty = $new_out_stock - $in_stock[$i]->Qty;
                                    $new_difference_qty = $product_quantities[$key] - $difference_qty;
                                    $invoice_detail = array(
                                        "InvoiceMasterID" => $lims_sale_data->InvoiceMasterID,
                                        "InvoiceNo"       => $invoice_no,
                                        "ItemID"          => $pid,
                                        "Description"     => $item_name,
                                        "PartyID"         => $request->customer_id,
                                        "Qty"             => $new_difference_qty,
                                        "Rate"            => $product_prices[$key],
                                        "TaxPer"          => floatval(preg_replace('/[^\d.]/', '', $product_taxa[$key])),
                                        "Tax"             => $product_taxes[$key],
                                        "Total"           => floatval($product_prices[$key] * $new_difference_qty),
                                        "cost_price"     => $in_stock[$i]->Rate
                                    );
                                    InvoiceDetail::create($invoice_detail);
                                    $i++;
                                    $invoice_detail = array(
                                        "InvoiceMasterID" => $lims_sale_data->InvoiceMasterID,
                                        "InvoiceNo"       => $invoice_no,
                                        "ItemID"          => $pid,
                                        "Description"     => $item_name,
                                        "PartyID"         => $request->customer_id,
                                        "Qty"             => $difference_qty,
                                        "Rate"            => $product_prices[$key],
                                        "TaxPer"          => floatval(preg_replace('/[^\d.]/', '', $product_taxa[$key])),
                                        "Tax"             => $product_taxes[$key],
                                        "Total"           => floatval($product_prices[$key] * $difference_qty),
                                        "cost_price"     => $in_stock[$i]->Rate
                                    );
                                    InvoiceDetail::create($invoice_detail);
                                } else {
                                    $invoice_detail = array(
                                        "InvoiceMasterID" => $lims_sale_data->InvoiceMasterID,
                                        "InvoiceNo"       => $invoice_no,
                                        "ItemID"          => $pid,
                                        "Description"     => $item_name,
                                        "PartyID"         => $request->customer_id,
                                        "Qty"             => $product_quantities[$key],
                                        "Rate"            => $product_prices[$key],
                                        "TaxPer"          => floatval(preg_replace('/[^\d.]/', '', $product_taxa[$key])),
                                        "Tax"             => $product_taxes[$key],
                                        "Total"           => floatval(preg_replace('/[^\d.]/', '', $product_subtotals[$key])),
                                        "cost_price"     => $in_stock[$i]->Rate
                                    );
                                    InvoiceDetail::create($invoice_detail);
                                }
                                break; // No need to continue checking once we find the appropriate record
                            }
                        }
                    }
                }
                /* Payment Save */
                $data['amount']          = $request->paid_amount != null ? $request->paid_amount : ($request->future_paid_amount != null ? $request->future_paid_amount : '0.00');
                $data['InvoiceMasterID'] = $lims_sale_data->InvoiceMasterID;
                $data['paying_method']   = $paying_method;
                $data['paying_amount']   = $request->paying_amount != null ? $request->paying_amount : ($request->future_paying_amount != null ? $request->future_paying_amount : '0.00');
                $payment = $this->payment($data);
                /* Payment Save Ends here. */


                if ($request->sale_status == 3) {
                    $data['print_status'] = '1';
                }

                if ($request->sale_status != 3) {

                    if ($paying_method == 'Credit Card') {
                        $lims_pos_setting_data = PosSetting::latest()->first();
                        Stripe::setApiKey($lims_pos_setting_data->stripe_secret_key);
                        $token = $data['stripeToken'];
                        $grand_total = $data['grand_total'];
                        $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('customer_id', $data['customer_id'])->first();
                        if (!$lims_payment_with_credit_card_data) {
                            // Create a Customer:
                            $customer = \Stripe\Customer::create([
                                'source' => $token
                            ]);
                            // Charge the Customer instead of the card:
                            $charge = \Stripe\Charge::create([
                                'amount' => $grand_total * 100,
                                'currency' => 'usd',
                                'customer' => $customer->id
                            ]);
                            // Handle successful payment
                            if ($charge->status === 'succeeded') {
                                // Payment successful, process further actions
                                $data['customer_stripe_id'] = $customer->id;
                            } else {
                                $message .= ' Payment failed. ';
                            }
                        } else {
                            $customer_id = $lims_payment_with_credit_card_data->customer_stripe_id;
                            $charge = \Stripe\Charge::create([
                                'amount' => $grand_total * 100,
                                'currency' => 'usd',
                                'customer' => $customer_id, // Previously stored, then retrieved
                            ]);
                            // Handle successful payment
                            if ($charge->status === 'succeeded') {
                                // Payment successful, process further actions
                                $data['customer_stripe_id'] = $customer_id;
                            } else {
                                $message .= ' Payment failed. ';
                            }
                        }
                        if ($charge->status === 'succeeded') {
                            $data['charge_id'] = $charge->id;
                            $data['payment_id'] = $payment->id;
                            PaymentWithCreditCard::create($data);
                        }
                    } //CREDIT PAYMENT ENDS HERER.
                    $data_ar = array(
                        'VHNO'             => $request->input('invoice_no'),
                        'ChartOfAccountID' => '110400',   //A/R
                        'PartyID'          => $data['customer_id'],
                        'InvoiceMasterID'  => $data['InvoiceMasterID'], #7A7A7A
                        'Narration'        => $request->input('sale_note'),
                        'Date'             => $request->input('invoice_date'),
                        'Dr'               => $request->input('grand_total'),
                        'Trace'            => 123, // for debugging for reverse engineering

                    );
                    Journal::create($data_ar);
                    if (!empty($request->input('total_discount')) && $request->input('total_discount') > 0) { // if dis is given
                        $data_saledis        = array(
                            'VHNO'             => $request->input('invoice_no'),
                            'ChartOfAccountID' => '410155',   //Sales-Discount
                            'PartyID'          => $data['customer_id'],
                            'InvoiceMasterID'  => $data['InvoiceMasterID'], #7A7A7A
                            'Narration'        => $request->input('sale_note'),
                            'Date'             => $request->input('invoice_date'),
                            'Dr'               => $request->input('total_discount'),
                            'Trace'            => 1234, // for debugging for reverse engineering
                        );
                        Journal::create($data_saledis);
                    }
                    $data_sale = array(
                        'VHNO'             => $request->input('invoice_no'),
                        'ChartOfAccountID' => '410100',   //Sales
                        'PartyID'          => $data['customer_id'],
                        'InvoiceMasterID'  => $data['InvoiceMasterID'], #7A7A7A
                        'Narration'        => $request->input('sale_note'),
                        'Date'             => $request->input('invoice_date'),
                        'Cr'               => $request->input('paying_amount'),
                        'Trace'            => 12345, // for debugging for reverse engineering
                    );
                    Journal::create($data_sale);
                    if (!empty($request->input('order_tax')) && $request->input('order_tax')  > 0) { // if tax item is present in invoice
                        $data_vat_out = array(
                            'VHNO'             => $request->input('invoice_no'),
                            'ChartOfAccountID' => '210300',   //VAT-OUTPUT TAX ->tax payable
                            'PartyID'          => $data['customer_id'],
                            'InvoiceMasterID'  => $data['InvoiceMasterID'], #7A7A7A
                            'Narration'        => $request->input('sale_note'),
                            'Date'             => $request->input('invoice_date'),
                            'Cr'               => $request->input('order_tax'),
                            'Trace'            => 12346, // for debugging for reverse engineering
                        );
                        Journal::create($data_vat_out);
                    }
                    if (!empty($request->input('shipping_cost')) && $request->input('shipping_cost') > 0) { // if tax item is present in invoice
                        $data_shipping = array(
                            'VHNO'             => $request->input('invoice_no'),
                            'ChartOfAccountID' => '500100',   //shipping
                            'PartyID'          => $data['customer_id'],
                            'InvoiceMasterID'  => $data['InvoiceMasterID'], #7A7A7A
                            'Narration'        => $request->input('sale_note'),
                            'Date'             => $request->input('invoice_date'),
                            'Cr'               => $request->input('shipping_cost'),
                            'Trace'            => 123467, // for debugging for reverse engineering
                        );

                        Journal::create($data_shipping);
                    }
                    //****************************************************************************** */
                }
                DB::commit();
                if ($data['sale_status'] == 3)
                    $message .= 'Sale successfully added to draft';
                else
                    $message .= ' Sale created successfully';

                if ($data['sale_status'] == 3 && $data['print_status'] == '1')
                    return redirect(route('voucher.print', ['id' => $lims_sale_data, 'GiftInvoice' => $request->GiftInvoice]))->with('success', $message);

                elseif ($data['sale_status'] == '1' && $data['print_status'] == '1')
                    return redirect(route('voucher.print', ['id' => $lims_sale_data, 'GiftInvoice' => $request->GiftInvoice]))->with('success', $message);

                elseif ($data['sale_status'] == '1' && $data['print_status'] == '0')
                    return redirect(route('voucher.create'))->with('success', $message);
                else
                    return redirect()->back()->with('success', $message);
            } catch (\Exception $e) {
                // dd($e->getMessage());
                DB::rollBack();

                return redirect()->back()->withinput($request->all())->with('error', $e->getMessage());
            }
        } else {
            return redirect('/')->with('error', 'You are Logged Out, Login to continue using the System');
        }
    }
    protected function payment($data, $updateInvoice = false)
    {
        $paying_amount  = @$data['paying_amount'];
        $amount         = @$data['amount'];
        $payment_note   = @$data['payment_note'];
        @$data['payment_reference'] = 'spr-' . date("Ymd") . '-' . date("his");
        if ($updateInvoice) {
            $paid_amount = $data['paid_amount'];
            $payment     = Payment::where('InvoiceMasterID', $data['InvoiceMasterID'])->orderBy('paymentID', 'DESC')->update(['amount' => $paid_amount]);
        } else {
            $UserID  = Session::get('UserID');
            $payments = [
                "PaymentReference" => $data['payment_reference'],
                "InvoiceMasterID"  => $data['InvoiceMasterID'],
                "PartyID"          => 1,
                "UserID"           => $UserID,
                "Amount"           => $amount,
                "Change"           => $paying_amount - $amount,
                "PayingMethod"     => $data['paying_method'],
                "PaymentNote"      => $payment_note
            ];
            if (!empty($data['AmountPaidByCard'])) {
                $payments['AmountPaidByCard'] = $data['AmountPaidByCard'];
            }
            if (!empty($data['cheque_no'])) {
                $payments['cheque_no'] = $data['cheque_no'];
            }
            $payment = Payment::create($payments);
        }
        return $payment;
    }
    public function finalizeDraftPayment(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $destinationPath = public_path('/uploads');
            $data = $request->all();
            $subTotal = 0;
            $grandTotal = 0;
            $quantity = 0;
            InvoiceDetail::where('InvoiceMasterID', $request->invoice_master_id)->delete();
            $invMaster = InvoiceMaster::find($request->invoice_master_id);
            if ($invMaster->sale_status == 3) {
                $data['paying_amount'] =  $data['paying_amount'] + $invMaster->Paid;
            }
            $product_ids = explode(',', $request->product_id);
            $qtys = explode(',', $request->qty);
            $itemChangedRate = explode(',', $request->itemChangedRate);
            // dd($product_ids);
            foreach ($product_ids as $key => $prodId) {
                $item = Item::where('ItemId', $prodId)->first();
                $rate = $item->SellingPrice == $itemChangedRate[$key] ? (float)$item->SellingPrice : (float)$itemChangedRate[$key];
                $itemsubTotal = ($rate + ($rate * (float)($item->Percentage / 100))) * $qtys[$key];
                $itemTax = ($rate * (float)($item->Percentage / 100)) * $qtys[$key];
                $subTotal = $subTotal + $itemsubTotal;
                $grandTotal = $grandTotal + $itemsubTotal;
                $quantity = $quantity + $qtys[$key];

                $in_stock = InvoiceDetail::select('Qty', 'Rate')->where('ItemID', $prodId)->where('InvoiceNo', 'like', 'BILL-%')->get();
                $out_stock = InvoiceDetail::join('invoice_master', 'invoice_detail.InvoiceMasterID', '=', 'invoice_master.InvoiceMasterID')
                    ->where('invoice_detail.ItemID', $prodId)
                    ->where('invoice_detail.InvoiceNo', 'like', 'INV-%')
                    ->where('invoice_master.sale_status', '!=', 10)
                    ->sum('invoice_detail.Qty');

                for ($i = 0; $i < count($in_stock); $i++) {
                    if ($out_stock > $in_stock[$i]->Qty) {
                        $out_stock -= $in_stock[$i]->Qty;
                    } else {
                        $new_out_stock = $out_stock + $qtys[$key];
                        if ($new_out_stock > $in_stock[$i]->Qty) {
                            $difference_qty = $new_out_stock - $in_stock[$i]->Qty;
                            $invoice_detail = array(
                                "InvoiceMasterID" => $request->invoice_master_id,
                                "InvoiceNo"       => $request->invoice_no,
                                "ItemID"          => $prodId,
                                "Description"     => $item->ItemName,
                                "PartyID"         => $request->customer_id,
                                "Qty"             => $difference_qty,
                                "Rate"            => $rate,
                                "TaxPer"          => $item->percentage,
                                "Tax"             => $itemTax,
                                "Total"           => floatval($rate * $difference_qty),
                                "cost_price"     => $in_stock[$i]->Rate
                            );
                            InvoiceDetail::create($invoice_detail);
                            $i++;
                            $new_difference_qty = $qtys[$key] - $difference_qty;
                            $invoice_detail = array(
                                "InvoiceMasterID" => $request->invoice_master_id,
                                "InvoiceNo"       => $request->invoice_no,
                                "ItemID"          => $prodId,
                                "Description"     => $item->ItemName,
                                "PartyID"         => $request->customer_id,
                                "Qty"             => $new_difference_qty,
                                "Rate"            => $rate,
                                "TaxPer"          => $item->percentage,
                                "Tax"             => $itemTax,
                                "Total"           => floatval($rate * $new_difference_qty),
                                "cost_price"     => $in_stock[$i]->Rate
                            );
                            InvoiceDetail::create($invoice_detail);
                        } else {
                            $invoiceDetailData = [
                                'InvoiceMasterID' => $request->invoice_master_id,
                                'InvoiceNo' => $request->invoice_no,
                                'ItemID' => $prodId,
                                'Description' => $item->ItemName,
                                'PartyID' => $request->customer_id,
                                'Qty' => $qtys[$key],
                                'Rate' => $rate,
                                'TaxPer' => $item->percentage,
                                'Tax' => $itemTax,
                                'Total' => $itemsubTotal,
                                "cost_price"     => $in_stock[$i]->Rate
                            ];
                            InvoiceDetail::create($invoiceDetailData);
                        }
                        break; // No need to continue checking once we find the appropriate record
                    }
                }
            }
            // dd($grandTotal);
            $tax = (float)($request->order_tax);
            if ($request->biller_id != null)
                $biller_id = $request->biller_id;
            else
                $biller_id = Session::get('UserID');
            $paying_method = match ($data['paid_by_id_select']) {
                '1' => 'Cash',
                '2' => 'Gift Card',
                '3' => 'Credit Card',
                '4' => 'Card',
                '5' => 'Paypal',
                '6' => 'Cash And Card',
                '7' => 'Cash By Tabby',
                '8' => 'Bank Transfer',
                '9' => 'Credit',
                '10' => 'Cash On Delivery',
                default => 'Deposit'
            };
            date_default_timezone_set('Asia/Dubai');
            $today_date = date('Y-m-d H:i:s');
            if (!empty($request->invoice_date))
                $today_date = $request->invoice_date . ' ' . date('H:i:s');
            if ($request->discount_model == 'percentage') {
                $disAmount = $request->order_discount;
                $disPer = round(($disAmount * 100) / $subTotal, 2);
                // dd($disPer);
            }
            $invoiceMasterData = [
                'WarehouseID' => $request->warehouse_id,
                'InvoiceNo' => $request->invoice_no,
                'PartyID' => $request->customer_id,
                'SubTotal' => $subTotal,
                'Total' => $request->total,
                'TotalQty' => $quantity,
                'Tax' => $tax,
                'GrandTotal' => $request->grand_total,
                'UserID' => $biller_id,
                'TaxPer' => $request->order_tax_rate,
                'Shipping' => $request->shipping_cost,
                'DiscountAmount' => $request->order_discount,
                'sale_status' => $request->sale_status,
                "PaymentMode"        => $paying_method,
                'Paid' => $request->paid_amount,
                'DeliveryAddress' => $request->DeliveryAddress,
                'driverName' => $request->driverName,
                "Date" => $today_date,
                "DueDate" => $today_date,
                "DiscountPer"        => isset($disPer) ?  $disPer : 0,
                "DiscountModel"      => $request->discount_model,
                "Balance" => '0.00',
            ];
            if ($request->has('payment_proof')) {
                $document1 = $request->file('payment_proof');
                $fileName1 = '1' . time() . '.' . $document1->extension();
                // Arr::add($invoiceMasterData, 'Document1',  $fileName1);
                $document1->move($destinationPath,  $fileName1);
                // dd('here');
                $invoiceMasterData['Document1'] = $fileName1;
            }
            // dd($invoiceMasterData);
            InvoiceMaster::where('InvoiceMasterID', $request->invoice_master_id)->update($invoiceMasterData);
            Journal::where('InvoiceMasterID', $request->invoice_master_id)->delete();
            $exist_payment = Payment::where('InvoiceMasterID', $request->invoice_master_id)->first();
            if ($exist_payment) {
                Payment::where('InvoiceMasterID', $request->invoice_master_id)
                    ->orderBy('paymentID', 'DESC')
                    ->update(
                        [
                            'amount' => $request->grand_total,
                            "PartyID" => $request->customer_id,
                            "PayingMethod" => $paying_method,
                            "Change" => '0.00'
                        ]
                    );
            } else {
                $data['amount']          = $data['paid_amount'];
                $data['InvoiceMasterID'] = $request->invoice_master_id;
                $data['paying_method']   = $paying_method;
                $payment = $this->payment($data);
            }

            $data_ar = array(
                'VHNO'             => $request->input('invoice_no'),
                'ChartOfAccountID' => '110400',   //A/R
                'PartyID'          => $data['customer_id'],
                'InvoiceMasterID'  => $data['invoice_master_id'],
                'Narration'        => $request->input('sale_note'),
                'Date'             => $request->input('invoice_date'),
                'Dr'               => $request->input('grand_total'),
                'Trace'            => 123, // for debugging for reverse engineering

            );
            Journal::create($data_ar);
            if (!empty($request->input('order_discount')) && $request->input('order_discount') > 0) { // if dis is given
                $data_saledis        = array(
                    'VHNO'             => $request->input('invoice_no'),
                    'ChartOfAccountID' => '410155',   //Sales-Discount
                    'PartyID'          => $data['customer_id'],
                    'InvoiceMasterID'  => $data['invoice_master_id'],
                    'Narration'        => $request->input('sale_note'),
                    'Date'             => $request->input('invoice_date'),
                    'Dr'               => $request->input('order_discount'),
                    'Trace'            => 1234, // for debugging for reverse engineering
                );
                Journal::create($data_saledis);
            }
            $data_sale = array(
                'VHNO'             => $request->input('invoice_no'),
                'ChartOfAccountID' => '410100',   //Sales
                'PartyID'          => $data['customer_id'],
                'InvoiceMasterID'  => $data['invoice_master_id'],
                'Narration'        => $request->input('sale_note'),
                'Date'             => $request->input('invoice_date'),
                'Cr'               => $request->input('paid_amount'),
                'Trace'            => 12345, // for debugging for reverse engineering
            );
            Journal::create($data_sale);
            if (!empty($request->input('order_tax')) && $request->input('order_tax')  > 0) { // if tax item is present in invoice
                $data_vat_out = array(
                    'VHNO'             => $request->input('invoice_no'),
                    'ChartOfAccountID' => '210300',   //VAT-OUTPUT TAX ->tax payable
                    'PartyID'          => $data['customer_id'],
                    'InvoiceMasterID'  => $data['invoice_master_id'], #7A7A7A
                    'Narration'        => $request->input('sale_note'),
                    'Date'             => $request->input('invoice_date'),
                    'Cr'               => $tax,
                    'Trace'            => 12346, // for debugging for reverse engineering
                );
                Journal::create($data_vat_out);
            }
            if (!empty($request->input('shipping_cost')) && $request->input('shipping_cost') > 0) { // if tax item is present in invoice
                $data_shipping = array(
                    'VHNO'             => $request->input('invoice_no'),
                    'ChartOfAccountID' => '500100',   //shipping
                    'PartyID'          => $data['customer_id'],
                    'InvoiceMasterID'  => $data['invoice_master_id'], #7A7A7A
                    'Narration'        => $request->input('sale_note'),
                    'Date'             => $request->input('invoice_date'),
                    'Cr'               => $request->input('shipping_cost'),
                    'Trace'            => 123467, // for debugging for reverse engineering
                );

                Journal::create($data_shipping);
            }
            DB::commit();
            TempInvoiceDetail::truncate();
            return redirect('print-voucher/' . $request->invoice_master_id)->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function addPartialPayment(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $destinationPath = public_path('/uploads');
            $data = $request->all();
            $subTotal = 0;
            $grandTotal = 0;
            $quantity = 0;
            InvoiceDetail::where('InvoiceMasterID', $request->invoice_master_id)->delete();
            $invMaster = InvoiceMaster::find($request->invoice_master_id);
            if ($invMaster->sale_status == 3) {
                $data['paying_amount'] =  ($data['partial_paying_amount'] != null ? $data['partial_paying_amount'] : 0)  + $invMaster->Paid;
            }
            $product_ids = explode(',', $request->product_id);
            $qtys = explode(',', $request->qty);
            $itemChangedRate = explode(',', $request->itemChangedRate);
            // dd($product_ids);
            foreach ($product_ids as $key => $prodId) {
                $item = Item::where('ItemId', $prodId)->first();
                $rate = $item->SellingPrice == $itemChangedRate[$key] ? (float)$item->SellingPrice : (float)$itemChangedRate[$key];
                $itemsubTotal = ($rate + ($rate * (float)($item->Percentage / 100))) * $qtys[$key];
                $itemTax = ($rate * (float)($item->Percentage / 100)) * $qtys[$key];
                $subTotal = $subTotal + $itemsubTotal;
                $grandTotal = $grandTotal + $itemsubTotal;
                $quantity = $quantity + $qtys[$key];
                $in_stock = InvoiceDetail::select('Qty', 'Rate')->where('ItemID', $prodId)->where('InvoiceNo', 'like', 'BILL-%')->get();
                $out_stock = InvoiceDetail::join('invoice_master', 'invoice_detail.InvoiceMasterID', '=', 'invoice_master.InvoiceMasterID')
                    ->where('invoice_detail.ItemID', $prodId)
                    ->where('invoice_detail.InvoiceNo', 'like', 'INV-%')
                    ->where('invoice_master.sale_status', '!=', 10)
                    ->sum('invoice_detail.Qty');
                for ($i = 0; $i < count($in_stock); $i++) {
                    if ($out_stock > $in_stock[$i]->Qty) {
                        $out_stock -= $in_stock[$i]->Qty;
                    } else {
                        $new_out_stock = $out_stock + $qtys[$key];
                        if ($new_out_stock > $in_stock[$i]->Qty) {
                            $difference_qty = $new_out_stock - $in_stock[$i]->Qty;
                            $invoice_detail = array(
                                "InvoiceMasterID" => $request->invoice_master_id,
                                "InvoiceNo"       => $request->invoice_no,
                                "ItemID"          => $prodId,
                                "Description"     => $item->ItemName,
                                "PartyID"         => $request->customer_id,
                                "Qty"             => $difference_qty,
                                "Rate"            => $rate,
                                "TaxPer"          => $item->percentage,
                                "Tax"             => $itemTax,
                                "Total"           => floatval($rate * $difference_qty),
                                "cost_price"     => $in_stock[$i]->Rate
                            );
                            InvoiceDetail::create($invoice_detail);
                            $i++;
                            $new_difference_qty = $qtys[$key] - $difference_qty;
                            $invoice_detail = array(
                                "InvoiceMasterID" => $request->invoice_master_id,
                                "InvoiceNo"       => $request->invoice_no,
                                "ItemID"          => $prodId,
                                "Description"     => $item->ItemName,
                                "PartyID"         => $request->customer_id,
                                "Qty"             => $new_difference_qty,
                                "Rate"            => $rate,
                                "TaxPer"          => $item->percentage,
                                "Tax"             => $itemTax,
                                "Total"           => floatval($rate * $new_difference_qty),
                                "cost_price"     => $in_stock[$i]->Rate
                            );
                            InvoiceDetail::create($invoice_detail);
                        } else {
                            $invoiceDetailData = [
                                'InvoiceMasterID' => $request->invoice_master_id,
                                'InvoiceNo' => $request->invoice_no,
                                'ItemID' => $prodId,
                                'Description' => $item->ItemName,
                                'PartyID' => $request->customer_id,
                                'Qty' => $qtys[$key],
                                'Rate' => $rate,
                                'TaxPer' => $item->percentage,
                                'Tax' => $itemTax,
                                'Total' => $itemsubTotal,
                                "cost_price"     => $in_stock[$i]->Rate
                            ];
                            InvoiceDetail::create($invoiceDetailData);
                        }
                        break; // No need to continue checking once we find the appropriate record
                    }
                }
            }
            // dd($grandTotal);
            $tax = (float)($request->order_tax);
            if ($request->biller_id != null)
                $biller_id = $request->biller_id;
            else
                $biller_id = Session::get('UserID');
            $paying_method = match ($data['paid_by_id_select']) {
                '1' => 'Cash',
                '2' => 'Gift Card',
                '3' => 'Credit Card',
                '4' => 'Card',
                '5' => 'Paypal',
                '6' => 'Cash And Card',
                '7' => 'Cash By Tabby',
                '8' => 'Bank Transfer',
                '9' => 'Credit',
                '10' => 'Cash On Delivery',
                default => 'Deposit'
            };
            date_default_timezone_set('Asia/Dubai');
            $today_date = date('Y-m-d H:i:s');
            if (!empty($request->invoice_date))
                $today_date = $request->invoice_date . ' ' . date('H:i:s');
            if ($request->discount_model == 'percentage') {
                $disAmount = $request->order_discount;
                $disPer = round(($disAmount * 100) / $subTotal, 2);
                // dd($disPer);
            }
            $invMData = InvoiceMaster::find($request->invoice_master_id);
            $remaining_balance = $request->grand_total - $data['paying_amount'];
            $invoiceMasterData = [
                'WarehouseID' => $request->warehouse_id,
                'InvoiceNo' => $request->invoice_no,
                'PartyID' => $request->customer_id,
                'SubTotal' => $subTotal,
                'Total' => $request->total,
                'TotalQty' => $quantity,
                'Tax' => $tax,
                'GrandTotal' => $request->grand_total,
                'UserID' => $biller_id,
                'TaxPer' => $request->order_tax_rate,
                'Shipping' => $request->shipping_cost,
                'DiscountAmount' => $request->order_discount,
                'sale_status' => $request->sale_status,
                "PaymentMode"        => $paying_method,
                'Paid' => $data['paying_amount'],
                'DeliveryAddress' => $request->DeliveryAddress,
                'driverName' => $request->driverName,
                "Date" => $today_date,
                "DueDate" => $today_date,
                "DiscountPer"        => isset($disPer) ?  $disPer : 0,
                "DiscountModel"      => $request->discount_model,
                "Balance" => $remaining_balance
            ];
            if ($request->has('payment_proof')) {
                $document1 = $request->file('payment_proof');
                $fileName1 = '1' . time() . '.' . $document1->extension();
                // Arr::add($invoiceMasterData, 'Document1',  $fileName1);
                $document1->move($destinationPath,  $fileName1);
                // dd('here');
                $invoiceMasterData['Document1'] = $fileName1;
            }
            // dd($invoiceMasterData);
            InvoiceMaster::where('InvoiceMasterID', $request->invoice_master_id)->update($invoiceMasterData);
            $exist_payment = Payment::where('InvoiceMasterID', $request->invoice_master_id)->first();
            if ($exist_payment) {
                Payment::where('InvoiceMasterID', $request->invoice_master_id)
                    ->orderBy('paymentID', 'DESC')
                    ->update(
                        [
                            'amount' => $data['paying_amount'],
                            "PartyID" => $request->customer_id,
                            "PayingMethod" => $paying_method,
                            "Change" => $remaining_balance
                        ]
                    );
            } else {
                $data['amount']          = $data['paying_amount'];
                $data['InvoiceMasterID'] = $request->invoice_master_id;
                $data['paying_method']   = $paying_method;
                $payment = $this->payment($data);
            }
            DB::commit();
            TempInvoiceDetail::truncate();
            return redirect('print-voucher/' . $request->invoice_master_id)->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
