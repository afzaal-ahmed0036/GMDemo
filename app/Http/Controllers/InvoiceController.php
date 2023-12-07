<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDishDetail;
use App\Models\Payment;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberToWords\NumberToWords;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    public function invoiceListing(Request $request)
    {
        if ($request->ajax()) {
            $invoices = DB::table('invoice_master')->where('InvoiceNo', 'like', 'INV%')->where('sale_status', '!=', 10)->get();
            return DataTables::of($invoices)
                ->addIndexColumn()
                ->addColumn('payment_status', function ($row) {
                    if ($row->Balance == 0)
                        $pay_status = '<span class="badge alert-success">Paid</span>';
                    else
                        $pay_status = '<span class="badge alert-danger">Due</span>';

                    return $pay_status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown"><a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal font-size-18"></i></a><div class="dropdown-menu dropdown-menu-end">';
                    $btn .= '<a href="' . route('sales.edit',   $row->InvoiceMasterID) . '" class="dropdown-item" target="_blank">Edit Invoice</a><a href="' . route('invoice.show', ['id' => $row->InvoiceMasterID]) . '" class="dropdown-item" target="_blank">View Invoice</a><a href="' . route('voucher.print', ['id' => $row->InvoiceMasterID]) . '" class="dropdown-item" target="_blank">Print Invoice</a><a href="' . route('voucher.print', ['id' => $row->InvoiceMasterID, 'GiftInvoice' => 'Gift']) . '" class="dropdown-item" target="_blank">Print Gift Invoice</a><button type="button" class="cancel-order dropdown-item" data-id = "' . $row->InvoiceMasterID . '" data-bs-toggle="modal" data-bs-target="#cancel_Order">Cancel Order</button>';
                    $btn .= ' </div></div>';
                    return $btn;
                })
                ->rawColumns(['payment_status', 'action'])
                ->make(true);
        }
        return view('invoice.pos_listing');
    }
    public function cancelledInvoiceListing(Request $request)
    {
        if ($request->ajax()) {
            $invoices = DB::table('invoice_master')->where('InvoiceNo', 'like', 'INV%')->where('sale_status', 10)->get();
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('payment_status', function ($row) {
                    if ($row->Balance == 0)
                        $pay_status = '<span class="badge alert-success">Paid</span>';
                    else
                        $pay_status = '<span class="badge alert-danger">Due</span>';

                    return $pay_status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown"><a href="' . route('invoice.show', ['id' => $row->InvoiceMasterID]) . '" class="btn btn-sm btn-secondary" target="_blank"><i class="fa fa-eye"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['payment_status', 'action'])
                ->make(true);
        }
        return view('invoice.cancelled_listing');
    }
    public function showInvoice($InvoiceMasterID)
    {
        try {
            $invoice_master = DB::table('v_invoice_master')->where('InvoiceMasterID', $InvoiceMasterID)->first();
            $invoice_detail = DB::table('v_invoice_detail')
                ->where('InvoiceMasterID', $InvoiceMasterID)
                ->select('*', DB::raw('SUM(Qty) as Qty'), DB::raw('SUM(Total) as Total'))
                ->groupBy('ItemID')
                ->get();
            $invoice_dish_detail = InvoiceDishDetail::where('invoice_master_id', $InvoiceMasterID)->get();
            $party = DB::table('party')->where('PartyID', $invoice_master->PartyID)->first();
            $payments            = Payment::where('InvoiceMasterID', $InvoiceMasterID)->first();
            return view('invoice.show_invoice', compact('invoice_detail', 'invoice_master', 'party', 'invoice_dish_detail', 'payments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function printVoucher($InvoiceMasterID, $GiftInvoice = null)
    {
        try {
            $lims_sale_data = DB::table('invoice_master')->where('InvoiceMasterID', $InvoiceMasterID)->first();
            $lims_product_sale_data = DB::table('invoice_detail')
                ->where('InvoiceMasterID', $InvoiceMasterID)
                ->whereNull('dish_type_id')
                ->select('*', DB::raw('SUM(Qty) as Qty'), DB::raw('SUM(Total) as Total'))
                ->groupBy('ItemID')
                ->get();
            $lims_product_dish_data = DB::table('invoice_dish_details')->where('invoice_master_id', $InvoiceMasterID)->get();
            $lims_biller_data = DB::table('user')->where('UserId', $lims_sale_data->UserID)->first();

            $lims_warehouse_data = Warehouse::find($lims_sale_data->WarehouseID);
            $lims_customer_data = DB::table('party')->where('PartyID', $lims_sale_data->PartyID)->first();
            $lims_payment_data = Payment::where('InvoiceMasterID', $InvoiceMasterID)->orderBy('paymentID', 'DESC')->first();
            // dd($lims_payment_data);

            $company = DB::table('company')->first();

            // $numberToWords = new NumberToWords();
            // if (\App::getLocale() == 'ar' || \App::getLocale() == 'hi' || \App::getLocale() == 'vi' || \App::getLocale() == 'en-gb')
            //     $numberTransformer = $numberToWords->getNumberTransformer('en');
            // else
            //     $numberTransformer = $numberToWords->getNumberTransformer(\App::getLocale());
            // $numberInWords = $numberTransformer->toWords($lims_sale_data->GrandTotal);

            if ($GiftInvoice == null) {

                $GiftInvoice = "Normal";
            }
            if ($GiftInvoice == 'Normal') {
                return view('invoice.print_voucher', compact('lims_sale_data', 'lims_product_sale_data', 'lims_product_dish_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_customer_data', 'lims_payment_data', 'company'));
            } else {
                return view('invoice.print_voucher_no_price', compact('lims_sale_data', 'lims_product_sale_data', 'lims_product_dish_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_customer_data', 'lims_payment_data', 'company'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
