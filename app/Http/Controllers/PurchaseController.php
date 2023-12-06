<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrderMaster;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    public function PurchaseOrder(Request $request)
    {
        Session::put('menu', 'Purchase Order');
        $pagetitle = 'Purchase Order';
        if ($request->ajax()) {
            $data = DB::table('v_purchase_order_master')->orderBy('PurchaseOrderMasterID')->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex align-items-center col-actions"><a href="' . URL('/PurchaseOrderView/' . $row->PurchaseOrderMasterID) . '"><i class="font-size-18 mdi mdi-eye-outline align-middle me-1 text-secondary"></i></a><a href="' . URL('/PurchaseOrderEdit/' . $row->PurchaseOrderMasterID) . '"><i class="font-size-18 bx bx-pencil align-middle me-1 text-secondary"></i></a><a href="' . URL('/PurchaseOrderDelete/' . $row->PurchaseOrderMasterID) . '"><i class="font-size-18 bx bx-trash align-middle me-1 text-secondary"></i></a><a href="' . URL('/PurchaseOrderViewPDF/' . $row->PurchaseOrderMasterID) . '"><i class="font-size-18 me-1 mdi mdi-file-pdf-outline align-middle me-1 text-secondary"></i></a></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('ebooks.purchaseorder', compact('pagetitle'));
    }

    public function PurchaseOrderCreate()
    {
        try {
            $pagetitle = 'Purchase Order';
            $vhno = PurchaseOrderMaster::select(DB::raw('LPAD(IFNULL(MAX(PurchaseOrderMasterID),0)+1,5,0) as VHNO '))
                ->get();
            Session::put('VHNO', 'PON-' . $vhno[0]->VHNO);
            $tax = DB::table('tax')->get();
            $supplier = Supplier::all();
            $items = Item::all();
            $user = User::all();
            $item = json_encode($items);
            return view('ebooks.po_create', compact('vhno', 'supplier', 'user', 'items', 'item', 'tax', 'pagetitle'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function PurchaseOrderSave(Request $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $purchase_master = array(
                'PON' => $request->input('PON'),
                'Date' => $request->input('Date'),
                'DeliveryDate' => $request->input('DueDate'),
                'SupplierID' => $request->input('SupplierID'),
                // 'ReferenceNo' => $request->input('ReferenceNo'),
                'Subject' => $request->input('Subject'),
                'Tax' => $request->input('grandtotaltax'),
                'SubTotal' => $request->input('SubTotal'),


                'PONotes' => $request->input('CustomerNotes'),
                'DeliveryNotes' => $request->input('DeliveryNotes'),
                'Grandtotal' => $request->input('Grandtotal'),
                'UserID' => Session::get('UserID'),
            );
            $PurchaseMaster = PurchaseOrderMaster::create($purchase_master);
            // dd($PurchaseMaster->PurchaseOrderMasterID);
            for ($i = 0; $i < count($request->ItemID); $i++) {
                $purchase_det = array(
                    'PurchaseOrderMasterID' =>  $PurchaseMaster->PurchaseOrderMasterID,
                    'Date' => $request->input('Date'),
                    'ItemID' => $request->ItemID[$i],
                    'Description' => $request->Description[$i],
                    'Qty' => $request->Qty[$i],
                    'TaxPer' => $request->Tax[$i],
                    'Tax' => $request->TaxVal[$i],
                    'Rate' => $request->Price[$i],
                    'Amount' => $request->ItemTotal[$i]
                );
                PurchaseOrderDetail::create($purchase_det);
            }
            DB::commit();
            return redirect('PurchaseOrder')->with('success', 'Purchase Order Created');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }


    function PurchaseOrderEdit($id)
    {
        try {
            $pagetitle = 'Purchase Order';
            $supplier = DB::table('supplier')->get();
            $user = DB::table('user')->get();
            $purchaseorder_master = DB::table('purchase_order_master')->where('PurchaseOrderMasterID', $id)->get();
            $purchaseorder_detail = DB::table('purchase_order_detail')->where('PurchaseOrderMasterID', $id)->get();
            $items = DB::table('item')->get();
            $tax = DB::table('tax')->get();

            $item = json_encode($items);
            Session()->forget('VHNO');

            Session::put('VHNO', $purchaseorder_master[0]->PON);



            return view('ebooks.po_edit', compact('supplier', 'user', 'purchaseorder_master', 'purchaseorder_detail', 'items', 'tax', 'pagetitle', 'item'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    function PurchaseOrderUpdate(Request $request)
    {
        try {
            // dd($request->all());
            $purchase_master = array(
                'PurchaseOrderMasterID' => $request->input('PurchaseOrderMasterID'),
                'PON' => $request->input('PurchaseOrderNo'),
                'Date' => $request->input('Date'),
                'SupplierID' => $request->input('SupplierID'),
                'ReferenceNo' => $request->input('ReferenceNo'),
                'Subject' => $request->input('Subject'),
                'PONotes' => $request->input('CustomerNotes'),
                'DeliveryNotes' => $request->input('DescriptionNotes'),
                'UserID' => Session::get('UserID'),
                'Tax' => $request->input('grandtotaltax'),
                'Grandtotal' => $request->input('SubTotal')

            );

            //delete previous
            $id = DB::table('purchase_order_master')->where('PurchaseOrderMasterID', $request->PurchaseOrderMasterID)->delete();
            $id2 = DB::table('purchase_order_detail')->where('PurchaseOrderMasterID', $request->PurchaseOrderMasterID)->delete();
            ////////

            $PurchaseMasterID = DB::table('purchase_order_master')->insertGetId($purchase_master);

            for ($i = 0; $i < count($request->ItemID); $i++) {
                $purchase_det = array(
                    'PurchaseOrderMasterID' =>  $PurchaseMasterID,
                    'Date' => $request->input('Date'),
                    'ItemID' => $request->ItemID[$i],
                    'Description' => $request->Description[$i],
                    'Qty' => $request->Qty[$i],
                    'TaxPer' => $request->Tax[$i],
                    'Tax' => $request->TaxVal[$i],
                    'Rate' => $request->Price[$i],
                    'Amount' => $request->ItemTotal[$i]
                );


                $id = DB::table('purchase_order_detail')->insertGetId($purchase_det);
            }
            return redirect('PurchaseOrder')->with('success', 'Order Updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    function PurchaseOrderView($PurchaseMasterid)
    {
        try {
            $user = DB::table('user')->get();
            $supplier = DB::table('supplier')->get();
            $purchaseorder_master = DB::table('v_purchase_order_master')->where('PurchaseOrderMasterID', $PurchaseMasterid)->get();
            $purchaseorder_detail = DB::table('purchase_order_detail')->where('PurchaseOrderMasterID', $PurchaseMasterid)->get();

            Session()->forget('VHNO');

            Session::get('VHNO', $purchaseorder_master[0]->PON);

            $company = DB::table('company')->get();
            return view('ebooks.purchaseorder_view', compact('purchaseorder_master',  'purchaseorder_detail', 'company'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function PurchaseOrderViewPDF($id)
    {
        try {
            $pagetitle = 'Purchase Order';

            $purchase_master = DB::table('v_purchase_order_master')->where('PurchaseOrderMasterID', $id)->get();
            $purchase_detail = DB::table('v_purchase_order_detail')->where('PurchaseOrderMasterID', $id)->get();
            $company = DB::table('company')->get();
            $pdf = PDF::loadView('ebooks.purchase_order_view_pdf', compact('purchase_master', 'pagetitle', 'company', 'purchase_detail', 'company'));
            //return $pdf->download('pdfview.pdf');
            $pdf->setpaper('A4', 'portiate');
            return $pdf->stream();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    function PurchaseOrderDelete($PurchaseMasterid)
    {
        try {
            $id = DB::table('purchase_order_master')->where('PurchaseOrderMasterID', $PurchaseMasterid)->delete();
            $id2 = DB::table('purchase_order_detail')->where('PurchaseOrderMasterID', $PurchaseMasterid)->delete();
            return redirect('PurchaseOrder')->with('success', 'Purchase Order Deleted');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
