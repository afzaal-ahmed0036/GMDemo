<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Product;
use App\Models\Item;
use App\Models\ProductVariant;
use App\Models\ProductBatch;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Sale;
use App\Models\Warehouse;
use App\Models\PosSetting;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Coupon;
use App\Models\Tax;
use App\Models\Product_Sale;
use App\Models\InvoiceDishDetail;
use App\Models\Payment;
use App\Models\Dish;
use App\Models\DishType;
use App\Models\DishTable;
use App\Models\PaymentWithCreditCard;
use Stripe\Stripe;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
/* use Keygen\Keygen;
use DNS1D;
use DNS2D; */
use App\CashRegister;
use App\Models\InvoiceDetail;
use App\Models\TempInvoiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Models\InvoiceMaster;
use App\Models\Journal;




class TeqPosController extends Controller
{
    public function createTeqInvoice()
    {
        $lims_customer_list      = DB::table('party')->where('Active', 'Yes')->get();
        $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
        $lims_warehouse_list     = Warehouse::where('is_active', true)->get();
        $lims_biller_list        = DB::table('user')->where('UserType', 'Biller')->get();
        $lims_tax_list           = Tax::where('is_active', true)->get();
        $lims_product_list       = DB::table('item')->selectRaw('ItemID AS id,ItemName as name,ItemCode AS code,ItemImage AS image')->where('isActive', 1)->where('IsFeatured', 1)->where('ItemType', '!=', 'Restaurant')->get();

        foreach ($lims_product_list as $key => $product) {
            $images = explode(",", $product->image);
            $product->base_image = $images[0];
        }

        $product_number = count($lims_product_list);
        $lims_pos_setting_data = PosSetting::latest()->first();
        $lims_brand_list = Brand::where('is_active', true)->get();
        $lims_category_list = DB::table('item_category')->where('type', '!=', 'RES')->orWhere('type', null)->get();


        $recent_sale = DB::table('invoice_master')->where('InvoiceNo', 'like', 'INV%')->orderBy('InvoiceMasterID', 'desc')->take(10)->get();
        $recent_draft = DB::table('invoice_master')->where('InvoiceNo', 'like', 'INV%')->orderBy('InvoiceMasterID', 'desc')->take(10)->get();

        $lims_coupon_list = Coupon::where('is_active', true)->get();
        $flag = 0;
        $invoice_no = DB::table('invoice_master')->where('InvoiceNo', 'like', 'POS%')->count();
        $invoice_no = 'POS-0000' . ++$invoice_no;
        return view('teq-invoice.new_teq_invoice', compact('lims_customer_list', 'lims_customer_group_all', 'lims_warehouse_list', 'lims_product_list', 'product_number', 'lims_tax_list', 'lims_biller_list', 'lims_pos_setting_data', 'lims_brand_list', 'lims_category_list', 'recent_sale', 'recent_draft', 'lims_coupon_list', 'flag', 'invoice_no'));
    }

    public function storeInvoice(Request $request)
    {

        // dd($request->all());
        $data = $request->all();
        if (isset($request->reference_no)) {
            $this->validate($request, [
                'ReferenceNo' => [
                    'max:191', 'required', 'unique:sales'
                ],
            ]);
        }
        //return dd($data);
        $data['user_id'] = Session::get('UserID');


        // getting cash register id

        $cash_register_data = CashRegister::where([
            ['user_id', Session::get('UserID')],
            ['warehouse_id', $data['warehouse_id']],
            ['status', true]
        ])->first();

        if ($cash_register_data)
            $data['cash_register_id'] = $cash_register_data->id;



        // end of cash register getting id

        if ($data['pos']) {
            if (!isset($data['reference_no']))
                $data['reference_no'] = date("his");

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
                $data['reference_no'] = date("his");
        }

        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
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

        // dd($data);
        $today_date = date('Y-m-d');
        if (!empty($request->invoice_date))
            $today_date = $request->invoice_date;

        // $lims_sale_data = Sale::create($data);
        $invoice_no = DB::table('invoice_master')->where('InvoiceNo', 'like', 'POS%')->count();
        $invoice_no = 'POS-0000' . ++$invoice_no;
        $lims_customer_data = DB::table('party')->where('PartyID', $data['customer_id'])->first();
        $remaining_balance = $request->paying_amount -  $request->paid_amount;

        $paying_method = match ($data['paid_by_id']) {
            '1' => 'Cash',
            '2' => 'Gift Card',
            '3' => 'Credit Card',
            '4' => 'Cheque',
            '5' => 'Paypal',
            default => 'Deposit'
        };

        if ($request->biller_id)
            $biller_id = $request->biller_id;
        else
            $biller_id = Session::get('UserID');

        $invoice_data = array(
            "InvoiceNo"          => $invoice_no,
            "ReferenceNo"        => $data['reference_no'],
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
            "Paid"               => $request->paid_amount,
            "Balance"            => $remaining_balance,
            "TotalQty"           => $request->total_qty,
            "SubTotal"           => $request->total_price,
            "PaymentMode"        => $paying_method, // focus
            "DiscountModel"      => $request->discount_model,
            "DiscountPer"        => round($request->DiscountPer, 2),
            "DiscountAmount"     => $request->order_discount,
            "Shipping"           => $request->shipping_cost,
            "GrandTotal"         => $request->grand_total,
            "Total"              => $request->total,
            'cash_register_id'  => $cash_register_data->id,

        );

        $lims_sale_data = DB::table('invoice_master')->insertGetId($invoice_data);

        //collecting mail data
        /*
        $mail_data['email'] = $lims_customer_data->Email;
        $mail_data['reference_no'] = $lims_sale_data->ReferenceNo;
        $mail_data['sale_status'] = $lims_sale_data->sale_status;
        $mail_data['payment_status'] = $lims_sale_data->payment_status;
        $mail_data['total_qty'] = $lims_sale_data->total_qty;
        $mail_data['total_price'] = $lims_sale_data->total_price;
        $mail_data['order_tax'] = $lims_sale_data->order_tax;
        $mail_data['order_tax_rate'] = $lims_sale_data->order_tax_rate;
        $mail_data['order_discount'] = $lims_sale_data->order_discount;
        $mail_data['shipping_cost'] = $lims_sale_data->shipping_cost;
        $mail_data['grand_total'] = $lims_sale_data->grand_total;
        $mail_data['paid_amount'] = $lims_sale_data->paid_amount;
        */

        $product_quantities = $data['qty'];
        $product_prices = $data['net_unit_price'];
        $product_taxes = $data['tax']; // focus
        $product_discounts = $data['discount'];
        $product_taxa = $data['tax_rate']; // focus
        $product_disca = $data['discount']; //focus
        $product_subtotals = $data['subtotal'];
        $product_pids = $data['product_id'];
        $product_units = $data['sale_unit'];
        $product_hsns = $request->hsn;
        $product_serials = $request->serial;


        foreach ($product_pids as $key => $pid) {
            $item_name = DB::table('item')->where('ItemID', $pid)->pluck('ItemName')->first();
            $prod_qty = $product_quantities[$key];
            $invoice_detail = array(
                "InvoiceMasterID" => $lims_sale_data,
                "InvoiceNo" => $invoice_no,
                "ItemID" => $pid,
                "Description" => $item_name,
                "PartyID" => $request->customer_id,
                "Qty" => $prod_qty,
                "Rate" => $product_prices[$key],
                "TaxPer" => floatval(preg_replace('/[^\d.]/', '', $product_taxa[$key])),
                "Tax" => $product_taxes[$key],
                "Total" => floatval(preg_replace('/[^\d.]/', '', $product_subtotals[$key])),
            );

            $insert_detail = DB::table('invoice_detail')->insert($invoice_detail);
        }

        /* Payment Save */
        $data['amount']          = $data['paid_amount'];
        $data['InvoiceMasterID'] = $lims_sale_data;
        $data['paying_method']   = $paying_method;
        $this->payment($data);
        /* Payment Save Ends here. */

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
                $data['customer_stripe_id'] = $customer->id;
            } else {
                $customer_id =
                    $lims_payment_with_credit_card_data->customer_stripe_id;

                $charge = \Stripe\Charge::create([
                    'amount' => $grand_total * 100,
                    'currency' => 'usd',
                    'customer' => $customer_id, // Previously stored, then retrieved
                ]);
                $data['customer_stripe_id'] = $customer_id;
            }
            $data['charge_id'] = $charge->id;
            PaymentWithCreditCard::create($data);
        }


        if ($data['sale_status'] == 3)
            $message = 'Sale successfully added to draft';
        else
            $message = ' Sale created successfully';

        if ($data['sale_status'] == '1' && $data['print_status'] == '1')
            return redirect(route('invoice.print', ['id' => $lims_sale_data]))->with('message', $message);
        elseif ($data['sale_status'] == '1' && $data['print_status'] == '0')
            return redirect(route('invoice.create'))->with('message', $message);
        else
            return redirect()->back()->with('message', $message);
    }



    public function edit($InvoiceMasterID)
    {
        // dd($InvoiceMasterID);
        try {
            TempInvoiceDetail::truncate();
            DB::beginTransaction();
            $lims_customer_list    = DB::table('party')->where('Active', 'Yes')->get();
            $lims_warehouse_list   = Warehouse::where('is_active', true)->get();
            $lims_biller_list      = DB::table('user')->where('UserType', 'Biller')->get();
            $lims_tax_list         = Tax::where('is_active', true)->get();
            $lims_sale_data        = DB::table('invoice_master')->where('InvoiceMasterID', $InvoiceMasterID)->first();
            $lims_pos_setting_data = PosSetting::latest()->first();

            $lims_product_sale_data = DB::table('invoice_detail')
                ->join('item', 'invoice_detail.ItemId', '=', 'item.ItemId')
                ->where('invoice_detail.InvoiceMasterID', $InvoiceMasterID)
                ->whereNull('invoice_detail.dish_type_id')
                ->select('invoice_detail.*', 'item.*', DB::raw('SUM(invoice_detail.Qty) as Qty'), DB::raw('SUM(invoice_detail.Total) as Total'))
                ->groupBy('invoice_detail.ItemID')
                ->get();
            // dd($lims_product_sale_data);
            foreach ($lims_product_sale_data as $datum) {
                TempInvoiceDetail::create([
                    'ItemID' => $datum->ItemID,
                    'InvoiceNo' => $lims_sale_data->InvoiceNo
                ]);
            }
            // dd($lims_sale_data);
            $dish_invoices          = InvoiceDishDetail::where('invoice_master_id', $InvoiceMasterID)->get();
            $dish_tables            = DishTable::orderBy('id')->get();
            $biller                 = DB::table('user')->where('UserID', $lims_sale_data->UserID)->first();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            $lims_product_list       = DB::table('item')->selectRaw('ItemID AS id,ItemName as name,ItemCode AS code,ItemImage AS image')->where('isActive', 1)->where('IsFeatured', 1)->where('ItemType', '!=', 'Restaurant')->get();

            foreach ($lims_product_list as $key => $product) {
                $images = explode(",", $product->image);
                $product->base_image = $images[0];
            }

            $product_number = count($lims_product_list);
            $lims_brand_list = Brand::where('is_active', true)->get();
            $lims_category_list = DB::table('item_category')->where('type', '!=', 'RES')->orWhere('type', null)->get();

            $resturantItems = DB::table('item')->where('ItemType', '=', 'Restaurant')->get();

            $recent_sale = DB::table('v_invoice_master')->where('InvoiceNo', 'like', 'INV%')->orderBy('InvoiceMasterID', 'desc')->take(10)->get();
            $recent_draft = DB::table('v_invoice_master')->where('sale_status', 3)->orderBy('InvoiceMasterID', 'desc')->take(10)->get();

            $lims_coupon_list = Coupon::where('is_active', true)->get();
            $flag = 0;
            $invoice_no = $lims_sale_data->InvoiceNo;
            $dishes = Dish::where('status', 1)->get();
            $dish_tables = DishTable::orderBy('id')->get();
            DB::commit();
            return view('teq-invoice.edit-voucher', compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'lims_sale_data', 'lims_product_sale_data', 'dish_invoices', 'biller', 'lims_pos_setting_data', 'dish_tables', 'lims_customer_group_all',  'lims_product_list', 'product_number',  'lims_brand_list', 'lims_category_list', 'recent_sale', 'recent_draft', 'lims_coupon_list', 'flag', 'invoice_no', 'dishes', 'resturantItems'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
        }
    }



    public function update(Request $request, $invoice_master_id)
    {
        // dump($invoice_master_id);
        // dd($request->all());
        if (Session::has('UserID')) {
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
                $cash_register_data = CashRegister::where([
                    ['user_id', Session::get('UserID')],
                    ['warehouse_id', $request->warehouse_id],
                    ['status', true]
                ])->first();
                if ($cash_register_data) {
                    $data['cash_register_id'] = $cash_register_data->id;
                } else {
                    // dd('here');
                    // DB::rollBack();
                    return redirect('/')->with('error', 'You are not logged in, Login to Continue using the System')->with('class', 'danger');
                }
                $destinationPath = public_path('/uploads');
                $subTotal = 0;
                $grandTotal = 0;
                $quantity = 0;
                InvoiceDetail::where('InvoiceMasterID', $invoice_master_id)->delete();
                foreach ($request->product_id as $key => $prodId) {
                    $item = Item::where('ItemId', $prodId)->first();
                    $rate = $item->SellingPrice == $request->itemChangedRate[$key] ? $item->SellingPrice : $request->itemChangedRate[$key];
                    $itemsubTotal = ($rate + ($rate * (float)($item->Percentage / 100))) * $request->qty[$key];
                    $itemTax = ($rate * (float)($item->Percentage / 100)) * $request->qty[$key];
                    $subTotal = $subTotal + $itemsubTotal;
                    $grandTotal = $grandTotal + $itemsubTotal;
                    $quantity = $quantity + $request->qty[$key];
                    $invoiceDetailData = [
                        'InvoiceMasterID' => $invoice_master_id,
                        'InvoiceNo' => $request->invoice_no,
                        'ItemID' => $prodId,
                        'Description' => $item->ItemName,
                        'PartyID' => $request->customer_id,
                        'Qty' => $request->qty[$key],
                        'Rate' => $rate,
                        'TaxPer' => $item->percentage,
                        'Tax' => $itemTax,
                        'Total' => $itemsubTotal
                    ];

                    InvoiceDetail::create($invoiceDetailData);

                    // dump($invoiceDetailData);
                }
                // dd($grandTotal);
                $tax = (float)($request->order_tax);
                if ($request->biller_id != null)
                    $biller_id = $request->biller_id;
                else
                    $biller_id = Session::get('UserID');
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
                    // 'InvoiceNo' => $request->invoice_no,
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
                    'Paid' => $request->grand_total,
                    'DeliveryAddress' => $request->DeliveryAddress,
                    'driverName' => $request->driverName,
                    "Date" => $today_date,
                    "DueDate" => $today_date,
                    'cash_register_id'   => $cash_register_data->id,
                    "DiscountPer"        => isset($disPer) ?  $disPer : 0,
                    "DiscountModel"      => $request->discount_model,
                ];

                InvoiceMaster::where('InvoiceMasterID', $invoice_master_id)->update($invoiceMasterData);
                $invoice_master = InvoiceMaster::find($invoice_master_id);
                if ($request->sale_status != 3) {
                    Payment::where('InvoiceMasterID', $invoice_master_id)
                        ->orderBy('paymentID', 'DESC')
                        ->update(
                            [
                                'amount' => $request->grand_total,
                                "PartyID" => $request->customer_id,
                            ]
                        );
                    Journal::where('InvoiceMasterID', $invoice_master_id)->delete();
                    $data_ar = array(
                        'VHNO'             => $request->input('invoice_no'),
                        'ChartOfAccountID' => '110400',   //A/R
                        'PartyID'          => $request->customer_id,
                        'InvoiceMasterID'  => $invoice_master_id,
                        'Narration'        => $invoice_master->CustomerNotes,
                        'Date'             => $request->input('invoice_date'),
                        'Dr'               => $request->input('grand_total'),
                        'Trace'            => 123, // for debugging for reverse engineering

                    );
                    Journal::create($data_ar);
                    if (!empty($request->input('order_discount')) && $request->input('order_discount') > 0) { // if dis is given
                        $data_saledis        = array(
                            'VHNO'             => $request->input('invoice_no'),
                            'ChartOfAccountID' => '410155',   //Sales-Discount
                            'PartyID'          => $request->customer_id,
                            'InvoiceMasterID'  => $invoice_master_id,
                            'Narration'        => $invoice_master->CustomerNotes,
                            'Date'             => $request->input('invoice_date'),
                            'Dr'               => $request->input('order_discount'),
                            'Trace'            => 1234, // for debugging for reverse engineering
                        );
                        Journal::create($data_saledis);
                    }
                    $data_sale = array(
                        'VHNO'             => $request->input('invoice_no'),
                        'ChartOfAccountID' => '410100',   //Sales
                        'PartyID'          => $request->customer_id,
                        'InvoiceMasterID'  => $invoice_master_id,
                        'Narration'        => $invoice_master->CustomerNotes,
                        'Date'             => $request->input('invoice_date'),
                        'Cr'               => $request->input('paid_amount'),
                        'Trace'            => 12345, // for debugging for reverse engineering
                    );
                    Journal::create($data_sale);
                    if (!empty($request->input('order_tax')) && $request->input('order_tax')  > 0) { // if tax item is present in invoice
                        $data_vat_out = array(
                            'VHNO'             => $request->input('invoice_no'),
                            'ChartOfAccountID' => '210300',   //VAT-OUTPUT TAX ->tax payable
                            'PartyID'          => $request->customer_id,
                            'InvoiceMasterID'  => $invoice_master_id,
                            'Narration'        => $invoice_master->CustomerNotes,
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
                            'PartyID'          => $request->customer_id,
                            'InvoiceMasterID'  => $invoice_master_id,
                            'Narration'        => $invoice_master->CustomerNotes,
                            'Date'             => $request->input('invoice_date'),
                            'Cr'               => $request->input('shipping_cost'),
                            'Trace'            => 123467, // for debugging for reverse engineering
                        );

                        Journal::create($data_shipping);
                    }
                }
                // dd(DB::transactionLevel());
                DB::commit();
                TempInvoiceDetail::truncate();
                return redirect('create-voucher')->with('message', 'Data Updated Successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('message', $e->getMessage());
            }
        } else {
            return redirect('/')->with('error', 'You are Logged Out, Login to continue using the System')->with('class', 'danger');
        }
    }

    public function addPayment(Request $request)
    {
        $cash_register_data = CashRegister::where([
            ['user_id', Session::get('UserID')],
            // ['warehouse_id', $data['warehouse_id']],
            ['status', true]
        ])->first();

        if ($cash_register_data)
            $data['cash_register_id'] = $cash_register_data->id;


        $data = $request->all();
        if (!empty($data['amount']) && $data['amount'] > 0) {
            $paying_method = match ($data['paid_by_id']) {
                '1' => 'Cash',
                '2' => 'Gift Card',
                '3' => 'Credit Card',
                '4' => 'Card',
                '5' => 'Paypal',
                '6' => 'Cash And Card',
                '7' => 'Cash By Tabby',
                default => 'Deposit'
            };
            $data['paying_method'] = $paying_method;

            // $this->payment($data, true);



            $data = array(
                'PaymentMode' => $paying_method,
                'Paid' => $request->amount,
                'Balance' => $request->paying_amount - $request->amount,
                'cash_register_id' => $cash_register_data->id
            );



            $id = DB::table('invoice_master')->where('InvoiceMasterID', $request->InvoiceMasterID)->update($data);



            $message = 'Payment created successfully';
            return redirect()->back()->with('message', $message);
        } else {
            return redirect()->back()->with('message', 'No payment paid.');
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


    public function limsProductSearch(Request $request)
    {
        $ItemCode           = $request->get('data');
        $todayDate          = date('Y-m-d');
        $product_code       = explode("(", $ItemCode);
        $product_code[0]    = rtrim($product_code[0], " ");
        $product_variant_id = null;

        $lims_product_data  = DishType::where('code', $product_code[0])->first();
        if ($lims_product_data) {
            $product[] = $lims_product_data->type;
            $product[] = $lims_product_data->code;

            $product[] = $lims_product_data->price;

            $product[] = 0;
            $product[] = 'No Tax';
            $product[] = 1;
            if (1) {
                $unit_name = ['piece', 'carton', '12piece container', '24pc cnt', '36pc cntr', '48pc cntr', 'test unit upd'];
                $unit_operator = ['*', '*', '*', '*', '*', '*', '*'];
                $unit_operation_value = ['1', '12', '12', '24', '36', '48', '12'];
                $product[] = implode(",", $unit_name) . ',';
                $product[] = implode(",", $unit_operator) . ',';
                $product[] = implode(",", $unit_operation_value) . ',';
            } else {
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
            }
            $product[] = $lims_product_data->id;
            $product[] = $product_variant_id;
            $product[] = null;
            $product[] = null;
            $product[] = 'dishItem';
            $product[] = $lims_product_data->dish_recipe;
        } else {
            $lims_product_data = Item::where('ItemCode', $product_code[0])->first();
            $product[] = $lims_product_data->ItemName;
            $product[] = $lims_product_data->ItemCode;

            $product[] = $lims_product_data->SellingPrice;

            if ($lims_product_data->Taxable == 'Yes') {
                $product[]     = $lims_product_data->Percentage;
                $product[]     = 'unregistered ';
            } else {
                $product[] = 0;
                $product[] = 'No Tax';
            }
            $product[] = 1;
            if (1) {
                $unit_name = ['piece', 'carton', '12piece container', '24pc cnt', '36pc cntr', '48pc cntr', 'test unit upd'];
                $unit_operator = ['*', '*', '*', '*', '*', '*', '*'];
                $unit_operation_value = ['1', '12', '12', '24', '36', '48', '12'];
                $product[] = implode(",", $unit_name) . ',';
                $product[] = implode(",", $unit_operator) . ',';
                $product[] = implode(",", $unit_operation_value) . ',';
            } else {
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
            }
            $product[] = $lims_product_data->ItemID;
            $product[] = $product_variant_id;
            $product[] = null;
            $product[] = null;
            $product[] = 'posItem';
        }

        return $product;
    }


    public function getProduct($id)
    {
        // initializing arrays
        $product_code      = [];
        $product_name      = [];
        $product_qty       = [];
        $product_price     = [];
        $product_data      = [];
        $product_type      = [];
        $product_id        = [];
        $product_list      = [];
        $qty_list          = [];
        $batch_no          = [];
        $product_batch_id  = [];

        $lims_product_warehouse_data = Item::join('v_inventory', 'item.ItemID', '=', 'v_inventory.ItemID')
            ->where([
                ['v_inventory.WarehouseID', $id],
                ['v_inventory.Balance', '>', 0]
            ])->select('v_inventory.*', 'item.*')->get();

        $dish_type_codes   = DishType::pluck('type', 'code')->toArray();

        //product without variant
        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[]      = $product_warehouse->Balance;
            $product_price[]    = $product_warehouse->price;
            //$lims_product_data = Item::where('ItemID', $product_warehouse->product_id)->first();
            $product_code[]     =  $product_warehouse->ItemCode;
            $product_name[]     = htmlspecialchars($product_warehouse->ItemName);
            $product_type[]     = 'standard'; //$lims_product_data->type;
            $product_id[]       = $product_warehouse->ItemID;
            $product_list[]     = null; //$lims_product_data->product_list;
            $qty_list[]         = null; //$lims_product_data->qty_list;
            $batch_no[]         = null;
            $product_batch_id[] = null;
        }

        foreach ($dish_type_codes as $code => $name) {
            $product_code[]    =  $code;
            $product_name[]    =  $name;
        }
        $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id];

        return $product_data;
    }

    public function getCustomerGroup($id)
    {
        $customer_percentage = 0;
        return $customer_percentage;
        // $lims_customer_data = DB::table('party')->where('PartyID',$id);
        // $lims_customer_group_data = CustomerGroup::find($lims_customer_data->CustomerGroupID);
        // return $lims_customer_group_data->percentage;
    }

    public function checkAvailability($warehouse_id)
    {
        $open_register_number = 1;

        if ($open_register_number)
            return 'true';
        else
            return 'false';
    }



    public function getProductByFilter($category_id, $brand_id)
    {
        $data = [];
        if (($category_id != 0) && ($brand_id != 0)) {
            $lims_product_list = DB::table('item')
                ->join('item_category', 'item.ItemCategoryID', '=', 'item_category.ItemCategoryID')
                ->where([
                    ['item.IsActive', true],
                    ['item.ItemCategoryID', $category_id],
                    ['BrandID', $brand_id]
                ])->orWhere([
                    ['item_category.ParentID', $category_id],
                    ['item.IsActive', true],
                    ['BrandID', $brand_id]
                ])->select('item.ItemName', 'item.ItemCode', 'item.ItemImage', 'item.SellingPrice')->get();
        } elseif (($category_id != 0) && ($brand_id == 0)) {
            $lims_product_list = DB::table('item')
                ->join('item_category', 'item.ItemCategoryID', '=', 'item_category.ItemCategoryID')
                ->where([
                    ['item.IsActive', true],
                    ['item.ItemCategoryID', $category_id],
                ])->orWhere([
                    ['item_category.ParentID', $category_id],
                    ['item.IsActive', true]
                ])->select('item.ItemID', 'item.ItemName', 'item.ItemCode', 'item.ItemImage', 'item.SellingPrice')->get();
        } elseif (($category_id == 0) && ($brand_id != 0)) {
            $lims_product_list = DB::table('item')->where([
                ['BrandID', $brand_id],
                ['IsActive', true]
            ])
                ->select('item.ItemID', 'item.ItemName', 'item.ItemCode', 'item.ItemImage', 'item.SellingPrice')
                ->get();
        } else
            $lims_product_list = DB::table('item')->where('IsActive', true)->get();

        $index = 0;
        foreach ($lims_product_list as $product) {
            // if ($product->is_variant) {
            //     $lims_product_data = Product::select('id')->find($product->id);
            //     $lims_product_variant_data = $lims_product_data->variant()->orderBy('position')->get();
            //     foreach ($lims_product_variant_data as $key => $variant) {
            //         $data['name'][$index] = $product->name . ' [' . $variant->name . ']';
            //         $data['code'][$index] = $variant->pivot['item_code'];
            //         $images = explode(",", $product->image);
            //         $data['image'][$index] = $images[0];
            //         $index++;
            //     }
            // } else {
            $data['name'][$index] = $product->ItemName;
            $data['code'][$index] = $product->ItemCode;
            $data['SellingPrice'][$index] = $product->SellingPrice;
            $images = explode(",", $product->ItemImage);
            $data['image'][$index] = $images[0];
            $index++;
            // }
        }
        return $data;
    }

    public function getFeatured()
    {
        $data = [];
        $lims_product_list = DB::table('item')->where([
            ['IsActive', true],
            ['IsFeatured', true],
            ['ItemType', '!=', 'Restaurant']
        ])->select('item.ItemID', 'item.ItemName', 'item.ItemCode', 'item.ItemImage', 'item.SellingPrice')->get();

        $index = 0;
        foreach ($lims_product_list as $product) {
            // if ($product->is_variant) {
            //     $lims_product_data = Product::select('id')->find($product->id);
            //     $lims_product_variant_data = $lims_product_data->variant()->orderBy('position')->get();
            //     foreach ($lims_product_variant_data as $key => $variant) {
            //         $data['name'][$index] = $product->name . ' [' . $variant->name . ']';
            //         $data['code'][$index] = $variant->pivot['item_code'];
            //         $images = explode(",", $product->image);
            //         $data['image'][$index] = $images[0];
            //         $index++;
            //     }
            // } else {
            $data['name'][$index] = $product->ItemName;
            $data['code'][$index] = $product->ItemCode;
            $data['SellingPrice'][$index] = $product->SellingPrice;
            $images = explode(",", $product->ItemImage);
            $data['image'][$index] = $images[0];
            $index++;
            // }
        }
        return $data;
    }

    public function extra_tax_charged(Request $request)
    {
        $input = $request->all();
        $id = $request->sale_id;
        // dd($id);

        $lims_user_data = DB::table('invoice_master')->where('InvoiceMasterID', $InvoiceMasterID)->first();
        $lims_user_data->update($input);
        // return response()->json(['success'=>'Product saved successfully.']);
        return redirect()->back()->with('sale.invoice3', 'Data updated successfullly');
        // return 'hello';
    }

    /*  public function generateCode()
    {

        $id = Keygen::numeric(8)->generate();
        echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($id, 'UPCA') . '" alt="barcode"   />';
        return $id;
    } */

    public function cancelOrder(Request $request)
    {
        // dd($request->all());
        try {
            DB::table('journal')->where('InvoiceMasterID', $request->InvoiceMasterID)->delete();
            Payment::where('InvoiceMasterID', $request->InvoiceMasterID)->delete();
            DB::table('invoice_master')->where('InvoiceMasterID', $request->InvoiceMasterID)->update(['sale_status' => 10]);
            return redirect()->back()->with('error', 'Order Cancelled')->with('class', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
        }
    }
}
