<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Party;
use App\Models\PosSetting;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BillController extends Controller
{
    public function Bill(Request $request)
    {
        Session::put('menu', 'PurchaseInvoice');
        $pagetitle = 'Purchase Invoice';
        if ($request->ajax()) {
            $data = DB::table('v_invoice_master_supplier')->orderBy('InvoiceMasterID')->where('InvoiceNo', 'like', 'BILL%')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex align-items-center col-actions"><a class="btn btn-sm btn-info me-1" href="' . URL('/BillView/' . $row->InvoiceMasterID) . '"><i class="mdi mdi-eye-outline"></i></a><a class="btn btn-sm btn-secondary me-1" href="' . URL('/BillEdit/' . $row->InvoiceMasterID) . '"><i class="bx bx-pencil"></i></a><button type="button" class="delete-btn btn btn-sm btn-danger me-1" data-url="' . URL('/BillDelete/' . $row->InvoiceMasterID) . '"><i class="bx bx-trash"></i></button><a class="btn btn-sm btn-primary" target="_blank" href="' . URL('/BillViewPDF/' . $row->InvoiceMasterID) . '"><i class="mdi mdi-file-pdf-outline"></i></a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('purchase.bill');
    }
    public function BillCreate()
    {
        try {
            $pagetitle = 'Purchase Invoice Create';
            $supplier = Supplier::all();
            $items = Item::all();
            $user = User::all();
            $tax = DB::table('tax')->get();
            $item = json_encode($items);
            $vhno = DB::table('invoice_master')
                ->select(DB::raw('LPAD(IFNULL(MAX(RIGHT(InvoiceNo,5)),0)+1,5,0) as VHNO '))
                ->where(DB::raw('left(InvoiceNo,4)'), 'BILL')
                ->get();
            Session::put('VHNO', 'BILL-' . $vhno[0]->VHNO);
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_pos_setting_data = PosSetting::latest()->first();
            return view('purchase.bill_create', compact('supplier',  'items', 'user', 'vhno', 'item', 'items', 'pagetitle', 'tax', 'lims_warehouse_list', 'lims_pos_setting_data'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function BillSave(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                // 'customer_id' => 'required|numeric',
                'ItemID' => 'required'
            ], [
                'ItemID.required' => 'Please select at least one item.'
            ]);
            DB::beginTransaction();
            $invoice_mst = array(
                'WarehouseID' => $request->warehouse_id,
                'InvoiceNo' => $request->InvoiceNo,
                'Date' => $request->Date,
                'DueDate' => $request->DueDate,
                'SupplierID' => $request->SupplierID,
                'WalkinCustomerName' => $request->WalkinCustomerName,
                'ReferenceNo' => $request->ReferenceNo,
                'PaymentMode' => $request->PaymentMode,
                'PaymentDetails' => $request->PaymentDetails,
                'Subject' => $request->Subject,
                'SubTotal' => $request->SubTotal,
                'DiscountPer' => $request->DiscountPer,
                'DiscountAmount' => $request->DiscountAmount,
                'Total' => $request->Total,
                'TaxPer' => $request->Taxpercentage,
                'Tax' => $request->grandtotaltax,
                'Shipping' => $request->Shipping,
                'GrandTotal' => $request->Grandtotal,
                'Paid' => $request->amountPaid,
                'Balance' => $request->amountDue,
                'CustomerNotes' => $request->CustomerNotes,
                'DescriptionNotes' => $request->DescriptionNotes,
                'UserID' => Session::get('UserID'),
            );
            $InvoiceMaster = InvoiceMaster::create($invoice_mst);
            //  start for item array from invoice
            for ($i = 0; $i < count($request->ItemID); $i++) {
                $item = Item::find($request->ItemID[$i]);
                $invoice_det = array(
                    'InvoiceMasterID' =>  $InvoiceMaster->InvoiceMasterID,
                    'InvoiceNo' => $request->InvoiceNo,
                    'ItemID' => $request->ItemID[$i],
                    'SupplierID' => $request->input('SupplierID'),
                    'Qty' => $request->Qty[$i],
                    'Description' => $request->Description[$i],
                    'TaxPer' => $request->Tax[$i],
                    'Tax' => $request->TaxVal[$i],
                    'selling_price' => $request->sellingPrice[$i],
                    'Rate' => $request->Price[$i],
                    'Total' => $request->ItemTotal[$i],
                );
                $item->update([
                    'SellingPrice' => $request->sellingPrice[$i],
                    'CostPrice' => $request->Price[$i],

                ]);
                InvoiceDetail::create($invoice_det);
            }
            // Journal Entries
            $data_stock_inventory = array(
                'VHNO' => $request->input('InvoiceNo'),
                'ChartOfAccountID' => '510102',   //Stock inventory
                'SupplierID' => $request->input('SupplierID'),
                'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                'Narration' => $request->input('Subject'),
                'Date' => $request->input('Date'),
                'Dr' => $request->input('SubTotal'),
                'Trace' => 111, // for debugging for reverse engineering
            );
            Journal::create($data_stock_inventory);
            // 2. Sale discount
            if ($request->input('DiscountAmount') > 0) {
                $data_saledis = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '410155',   //Sales-Discount
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Cr' => $request->input('DiscountAmount'),
                    'Trace' => 1111, // for debugging for reverse engineering
                );
                Journal::create($data_saledis);
            }
            if ($request->input('TaxpercentageAmount') > 0) {
                // 3. TAX ON PURCHASES
                $data_tax_dis = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '110800',   // TAX ON PURCHASES
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Dr' => $request->input('TaxpercentageAmount'),
                    'Trace' => 11112, // for debugging for reverse engineering
                );
                Journal::create($data_tax_dis);
            }
            // 4. Shipping Expenses
            if ($request->input('Shipping') > 0) { // if tax item is present in invoice
                $data_shipping = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '500100',   //Shipping Expenses
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Dr' => $request->input('Shipping'),
                    'Trace' => 11113, // for debugging for reverse engineering
                );
                Journal::create($data_shipping);
            }
            // 5. Acc Payable  ->credit
            $data_ac_payable = array(
                'VHNO' => $request->input('InvoiceNo'),
                'ChartOfAccountID' => '210100',   // Acc Payable  ->Credit
                'SupplierID' => $request->input('SupplierID'),
                'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                'Narration' => $request->input('Subject'),
                'Date' => $request->input('Date'),
                'Cr' => $request->input('Grandtotal'),
                'Trace' => 11114, // for debugging for reverse engineering
            );
            Journal::create($data_ac_payable);
            // when payment is made by us
            if ($request->input('amountPaid') > 0) {
                // 6. Acc Payable  ->Debit
                $data_ap_credit = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '210100',   //A/Payable credit
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Dr' => $request->input('amountPaid'),
                    'Trace' => 11116, // for debugging for reverse engineering
                );
                Journal::create($data_ap_credit);
                // 5. Cash/Bank ->Credit
                $data_cash_bank = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '110201',   //bank / cash Debit
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMaster->InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Cr' => $request->input('amountPaid'),
                    'Trace' => 11115, // for debugging for reverse engineering
                );
                Journal::create($data_cash_bank);
            }
            DB::commit();
            return redirect('Bill')->with('success', 'Invoice Saved')->with('class', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function BillView($id)
    {
        try {
            $pagetitle = 'Purchase Invoice View';
            Session::put('menu', 'PurchaseInvoice');
            $invoice_type = DB::table('invoice_type')->get();
            $items = Item::all();
            $company = Company::all();
            $invoice_master = DB::table('v_invoice_master_supplier')->where('InvoiceMasterID', $id)->first();
            if (!$invoice_master) {
                return back()->with('error','Data Not Found');
            }
            $invoice_detail = DB::table('v_invoice_detail')->where('InvoiceMasterID', $id)->get();
            $item = json_encode($items);
            // dd($item);
            $supplier = Supplier::all();
            $user = User::all();
            return view('purchase.bill_view', compact('invoice_type', 'items', 'supplier', 'pagetitle', 'item', 'user', 'invoice_master', 'invoice_detail', 'company'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public  function BillViewPDF($id)
    {
        try {
            $pagetitle = 'Purchase Invoice PDF';
            Session::put('menu', 'PurchaseInvoice');
            $company = Company::all();
            $invoice_master = DB::table('v_invoice_master_supplier')->where('InvoiceMasterID', $id)->first();
            if (!$invoice_master) {
                return back()->with('error','Data Not Found');
            }
            $invoice_detail = DB::table('v_invoice_detail')->where('InvoiceMasterID', $id)->get();
            $party = Party::all();
            $pdf = PDF::loadView('purchase.bill_view_pdf', compact('company', 'pagetitle', 'invoice_master', 'invoice_detail'));
            return $pdf->stream();
            // return view('sale_invoice_view_pdf', compact('invoice_type', 'items', 'party', 'pagetitle', 'item', 'user', 'invoice_master', 'invoice_detail', 'company'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }


    public function BillEdit($id)
    {
        try {
            $pagetitle = 'Purchase Invoice Edit';
            Session::put('menu', 'PurchaseInvoice');
            $invoice_type = DB::table('invoice_type')->get();
            $items = Item::all();
            $tax = DB::table('tax')->get();
            $invoice_master = DB::table('v_invoice_master_supplier')->where('InvoiceMasterID', $id)->first();
            if (!$invoice_master) {
                return back()->with('error','Data Not Found');
            }
            $invoice_detail = DB::table('v_invoice_detail')->where('InvoiceMasterID', $id)->get();
            $item = json_encode($items);
            $supplier = Supplier::all();
            $user = User::all();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            return view('purchase.bill_edit', compact('invoice_type', 'items', 'supplier', 'pagetitle', 'item', 'user', 'invoice_master', 'invoice_detail', 'tax', 'lims_warehouse_list'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function BillUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            // dd($request->all());
            $invoice_mst = array(
                'WarehouseID' => $request->warehouse_id,
                'InvoiceNo' => $request->InvoiceNo,
                'InvoiceType' => $request->InvoiceType,
                'Date' => $request->Date,
                'DueDate' => $request->DueDate,
                'PartyID' => $request->PartyID,
                'WalkinCustomerName' => $request->WalkinCustomerName,
                'ReferenceNo' => $request->ReferenceNo,
                'PaymentMode' => $request->PaymentMode,
                'PaymentDetails' => $request->PaymentDetails,
                'Subject' => $request->Subject,
                'SubTotal' => $request->SubTotal,
                'DiscountPer' => $request->DiscountPer,
                'DiscountAmount' => $request->DiscountAmount,
                'Total' => $request->Total,
                'TaxPer' => $request->Taxpercentage,
                'Tax' => $request->grandtotaltax,
                'Shipping' => $request->Shipping,
                'GrandTotal' => $request->Grandtotal,
                'Paid' => $request->amountPaid,
                'Balance' => $request->amountDue,
                'CustomerNotes' => $request->CustomerNotes,
                'DescriptionNotes' => $request->DescriptionNotes,
                'UserID' => Session::get('UserID'),
            );
            $InvoiceMasterID = $request->InvoiceMasterID;
            InvoiceMaster::where('InvoiceMasterID', $request->input('InvoiceMasterID'))->update($invoice_mst);
            InvoiceDetail::where('InvoiceMasterID', $InvoiceMasterID)->delete();
            Journal::where('InvoiceMasterID', $InvoiceMasterID)->delete();
            //  start for item array from invoice
            for ($i = 0; $i < count($request->ItemID); $i++) {
                $item = Item::find($request->ItemID[$i]);
                $invoice_det = array(
                    'InvoiceMasterID' => $InvoiceMasterID,
                    'InvoiceNo' => $request->InvoiceNo,
                    'ItemID' => $request->ItemID[$i],
                    'PartyID' => $request->input('PartyID'),
                    'Qty' => $request->Qty[$i],
                    'Rate' => $request->Price[$i],
                    'selling_price' => $request->sellingPrice[$i],
                    'Description' => $request->Description[$i],
                    'TaxPer' => $request->Tax[$i],
                    'Tax' => $request->TaxVal[$i],
                    'Total' => $request->ItemTotal[$i],
                );
                $item->update([
                    'SellingPrice' => $request->sellingPrice[$i],
                    'CostPrice' => $request->Price[$i],
                ]);
                InvoiceDetail::create($invoice_det);
            }
            // Journal Entries
            $data_stock_inventory = array(
                'VHNO' => $request->input('InvoiceNo'),
                'ChartOfAccountID' => '510102',   //purchases
                'SupplierID' => $request->input('SupplierID'),
                'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                'Narration' => $request->input('Subject'),
                'Date' => $request->input('Date'),
                'Dr' => $request->input('SubTotal'),
                'Trace' => 111, // for debugging for reverse engineering
            );
            Journal::create($data_stock_inventory);
            if ($request->input('DiscountAmount') > 0) {
                $data_saledis = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '410155',   //Sales-Discount
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Cr' => $request->input('DiscountAmount'),
                    'Trace' => 1111, // for debugging for reverse engineering

                );
                Journal::create($data_saledis);
            }
            if ($request->input('TaxpercentageAmount') > 0) {
                $data_tax_dis = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '110800',   // TAX ON PURCHASES
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Dr' => $request->input('TaxpercentageAmount'),
                    'Trace' => 11112, // for debugging for reverse engineering

                );
                Journal::create($data_tax_dis);
            }
            if ($request->input('Shipping') > 0) { // if tax item is present in invoice
                $data_shipping = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '500100',   //Shipping Expenses
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Dr' => $request->input('Shipping'),
                    'Trace' => 11113, // for debugging for reverse engineering
                );
                Journal::create($data_shipping);
            }
            $data_ac_payable = array(
                'VHNO' => $request->input('InvoiceNo'),
                'ChartOfAccountID' => '210100',   // Acc Payable  ->Credit
                'SupplierID' => $request->input('SupplierID'),
                'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                'Narration' => $request->input('Subject'),
                'Date' => $request->input('Date'),
                'Cr' => $request->input('Grandtotal'),
                'Trace' => 11114, // for debugging for reverse engineering
            );
            Journal::create($data_ac_payable);
            // when payment is made by us
            if ($request->input('amountPaid') > 0) {
                $data_ap_credit = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '210100',   //A/R credit
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Dr' => $request->input('amountPaid'),
                    'Trace' => 111116, // for debugging for reverse engineering
                );
                Journal::create($data_ap_credit);
                $data_cash_bank = array(
                    'VHNO' => $request->input('InvoiceNo'),
                    'ChartOfAccountID' => '110200',   //bank / cash Debit
                    'SupplierID' => $request->input('SupplierID'),
                    'InvoiceMasterID' => $InvoiceMasterID, #7A7A7A
                    'Narration' => $request->input('Subject'),
                    'Date' => $request->input('Date'),
                    'Cr' => $request->input('amountPaid'),
                    'Trace' => 111115, // for debugging for reverse engineering
                );
                Journal::create($data_cash_bank);
            }
            DB::commit();
            return redirect('Bill')->with('success', 'Invoice Saved')->with('class', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    public function BillDelete($id)
    {
        // dd($id);
        try {
            DB::beginTransaction();
            InvoiceMaster::where('InvoiceMasterID', $id)->delete();
            InvoiceDetail::where('InvoiceMasterID', $id)->delete();
            Journal::where('InvoiceMasterID', $id)->delete();
            DB::commit();
            return redirect('Bill')->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
