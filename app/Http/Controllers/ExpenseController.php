<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Company;
use App\Models\ExpenseDetail;
use App\Models\ExpenseMaster;
use App\Models\Journal;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    public  function Expense(Request $request)
    {
        try {
            Session::put('menu', 'Expense');
            $pagetitle = 'Expense';
            if ($request->ajax()) {
                $data = DB::table('v_expense')->orderBy('Date', 'desc')
                    ->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex align-items-center col-actions"><a href="' . URL('/ExpenseView/' . $row->ExpenseMasterID) . '"><i class="font-size-18 mdi mdi-eye-outline align-middle me-1 text-secondary"></i></a><a href="' . URL('/ExpensePDF/' . $row->ExpenseMasterID) . '"><i class="font-size-18 me-1 mdi mdi-file-pdf-outline align-middle me-1 text-secondary"></i></a><a href="' . URL('/ExpenseEdit/' . $row->ExpenseMasterID) . '"><i class="font-size-18 bx bx-pencil align-middle me-1 text-secondary"></i></a><a href="' . URL('/ExpenseDelete/' . $row->ExpenseMasterID) . '"><i class="font-size-18 bx bx-trash align-middle me-1 text-danger"></i></a></div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('expense.expense', compact('pagetitle'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public  function ExpenseCreate()
    {
        try {
            $pagetitle = 'Expense Create';
            Session::put('menu', 'Expense');
            $items = ChartOfAccount::all();
            $item = json_encode($items);
            $supplier = Supplier::all();
            $tax = DB::table('tax')->get();
            $user = User::all();
            $vhno = DB::table('expense_master')
                ->select(DB::raw('LPAD(IFNULL(MAX(right(ExpenseNo,5)),0)+1,5,0) as VHNO '))->whereIn(DB::raw('left(ExpenseNo,3)'), ['EXP'])->get();
            Session::put('VHNO', 'EXP-' . $vhno[0]->VHNO);
            return view('expense.expensecreate', compact('tax', 'items', 'vhno', 'supplier', 'pagetitle', 'item', 'user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ExpenseSave(Request $request)
    {
        // dd($request->all());

        try {
            $request->validate(
                [
                    "ExpenseNo" => "required|unique:expense_master,ExpenseNo",
                    "ItemID0" => "required",
                ],
                [
                    "ItemID0.required" => "Please Add Atleast One Expense.",
                ]
            );
            DB::beginTransaction();
            Session::put('menu', 'Expense');
            $pagetitle = 'Invoice';
            $expense_mst = array(
                'ExpenseNo' => $request->ExpenseNo,
                'Date' => $request->Date,
                'ChartOfAccountID' => $request->ChartOfAccountID_From,
                'SupplierID' => $request->SupplierID,
                'ReferenceNo' => $request->ReferenceNo,
                'Tax' => $request->grandtotaltax,
                'GrantTotal' => $request->Grandtotal,
                'Paid' => $request->amountPaid,
            );
            $ExpenseMaster = ExpenseMaster::create($expense_mst);
            // JOURNAL ENTRY
            //bank debit
            $bank_cash = array(
                'VHNO' => $request->ExpenseNo,
                'ChartOfAccountID' => $request->ChartOfAccountID_From,   // Cash / bank / credit card
                'SupplierID' => $request->input('SupplierID'),
                'ExpenseMasterID' => $ExpenseMaster->ExpenseMasterID,
                'Date' => $request->input('Date'),
                'Cr' => $request->Grandtotal,
                'Narration' => '',
                'Trace' => 614
            );
            Journal::create($bank_cash);
            //  start for item array from invoice
            for ($i = 0; $i < count($request->ItemID0); $i++) {
                $expense_detail = array(
                    'ExpenseMasterID' =>  $ExpenseMaster->ExpenseMasterID,
                    'ChartOfAccountID' => $request->ChartOfAccountID[$i],
                    'Notes' => $request->Description[$i],
                    'TaxPer' => $request->Tax[$i],
                    'Tax' => $request->TaxVal[$i],
                    'Amount' => $request->ItemTotal[$i],
                );
                ExpenseDetail::create($expense_detail);
                if ($request->Tax[$i] > 0) {
                    // A/P debit
                    $ar_payment = array(
                        'VHNO' => $request->ExpenseNo,
                        'ChartOfAccountID' => $request->ChartOfAccountID[$i],  // chart of account direct debit
                        'SupplierID' => $request->input('SupplierID'),
                        'ExpenseMasterID' => $ExpenseMaster->ExpenseMasterID,
                        'Date' => $request->input('Date'),
                        'Dr' => $request->ItemTotal[$i] - $request->TaxVal[$i],
                        'Narration' => '',
                        'Trace' => 615
                    );
                    Journal::create($ar_payment);
                    //tax grandtotaltax
                    // Tax Payable debit
                    $ar_payment = array(
                        'VHNO' => $request->ExpenseNo,
                        'ChartOfAccountID' => 210300,  // TAX PAYABLES
                        'SupplierID' => $request->input('SupplierID'),
                        'ExpenseMasterID' => $ExpenseMaster->ExpenseMasterID,
                        'Date' => $request->input('Date'),
                        'Dr' => $request->TaxVal[$i],
                        'Narration' => '',
                        'Trace' => 617
                    );
                    Journal::create($ar_payment);
                } else {
                    // debit entry
                    $ar_payment = array(
                        'VHNO' => $request->ExpenseNo,
                        'ChartOfAccountID' => $request->ChartOfAccountID[$i],
                        'SupplierID' => $request->input('SupplierID'),
                        'ExpenseMasterID' => $ExpenseMaster->ExpenseMasterID,
                        'Date' => $request->input('Date'),
                        'Dr' => $request->ItemTotal[$i],
                        'Narration' => '',
                        'Trace' => 615
                    );

                    Journal::create($ar_payment);
                }
            }
            DB::commit();
            return redirect('Expense')->with('success', 'Expense Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withinput($request->all())->with('error', $e->getMessage());
        }
    }
    public function ExpenseView($id)
    {
        try {
            $pagetitle = 'Expense View';
            $company = Company::first();
            $expense_master = DB::table('v_expense')->where('ExpenseMasterID', $id)->first();
            if(!$expense_master){
                return back()->with('error', 'No Data Found');;
            }
            $expense_detail = DB::table('v_expense_detail')->where('ExpenseMasterID', $id)->get();
            $journal = Journal::where('ExpenseMasterID', $id)->get();
            return view('expense.expense_view', compact('expense_master', 'expense_detail', 'pagetitle', 'company'));
        } catch (\Exception $e) {
            // DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function  ExpenseEdit($id)
    {
        try {
            $pagetitle = 'Expense';
            Session::put('menu', 'Expense');
            $chartofaccount = ChartOfAccount::all();
            $supplier = DB::table('supplier')->get();
            $tax = DB::table('tax')->get();
            $user = User::all();
            $expense_master = ExpenseMaster::findOrFail($id);
            Session::put('VHNO', $expense_master->ExpenseNo);
            $expense_detail = ExpenseDetail::where('ExpenseMasterID', $id)->get();
            return view('expense.expense_edit', compact('tax', 'supplier', 'pagetitle', 'expense_master', 'chartofaccount', 'expense_detail'));
        } catch (\Exception $e) {
            // DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ExpenseUpdate(request $request)
    {
        try {
            DB::beginTransaction();
            Session::put('menu', 'Expense');
            $expense_mst = array(
                'ExpenseNo' => $request->ExpenseNo,
                'Date' => $request->Date,
                'ChartOfAccountID' => $request->ChartOfAccountID_From,
                'SupplierID' => $request->SupplierID,
                'ReferenceNo' => $request->ReferenceNo,
                'Tax' => $request->grandtotaltax,
                'GrantTotal' => $request->Grandtotal,
            );
            $ExpenseMasterID = ExpenseMaster::where('ExpenseMasterID', $request->ExpenseMasterID)->update($expense_mst);
            $idd = ExpenseDetail::where('ExpenseMasterID', $request->ExpenseMasterID)->delete();
            $id2 = Journal::where('ExpenseMasterID', $request->ExpenseMasterID)->delete();
            $bank_cash = array(
                'VHNO' => $request->ExpenseNo,
                'ChartOfAccountID' => $request->ChartOfAccountID_From,   // Cash / bank / credit card
                'SupplierID' => $request->input('SupplierID'),
                'ExpenseMasterID' => $request->ExpenseMasterID,
                'Date' => $request->input('Date'),
                'Cr' => $request->Grandtotal,
                'Narration' => '',
                'Trace' => 614
            );
            Journal::create($bank_cash);
            for ($i = 0; $i < count($request->ChartOfAccountID); $i++) {
                $expense_detail = array(
                    'ExpenseMasterID' =>  $request->ExpenseMasterID,
                    'ChartOfAccountID' => $request->ChartOfAccountID[$i],
                    'Notes' => $request->Description[$i],
                    'TaxPer' => $request->Tax[$i],
                    'Tax' => $request->TaxVal[$i],
                    'Amount' => $request->ItemTotal[$i],
                );
                ExpenseDetail::create($expense_detail);
                if ($request->Tax[$i] > 0) {
                    $ar_payment = array(
                        'VHNO' => $request->ExpenseNo,
                        'ChartOfAccountID' => $request->ChartOfAccountID[$i],  // chart of account direct debit
                        'SupplierID' => $request->input('SupplierID'),
                        'ExpenseMasterID' => $request->ExpenseMasterID,
                        'Date' => $request->input('Date'),
                        'Dr' => $request->ItemTotal[$i] - $request->TaxVal[$i],
                        'Narration' => '',
                        'Trace' => 615
                    );
                    Journal::create($ar_payment);
                    $ar_payment = array(
                        'VHNO' => $request->ExpenseNo,
                        'ChartOfAccountID' => 210300,  // TAX PAYABLES
                        'SupplierID' => $request->input('SupplierID'),
                        'ExpenseMasterID' => $request->ExpenseMasterID,
                        'Date' => $request->input('Date'),
                        'Dr' => $request->TaxVal[$i],
                        'Narration' => '',
                        'Trace' => 617
                    );
                    Journal::create($ar_payment);
                } else {
                    $ar_payment = array(
                        'VHNO' => $request->ExpenseNo,
                        'ChartOfAccountID' => $request->ChartOfAccountID[$i],
                        'SupplierID' => $request->input('SupplierID'),
                        'ExpenseMasterID' => $request->ExpenseMasterID,
                        'Date' => $request->input('Date'),
                        'Dr' => $request->ItemTotal[$i],
                        'Narration' => '',
                        'Trace' => 615
                    );
                    Journal::create($ar_payment);
                }
            }
            DB::commit();
            return redirect('Expense')->with('success', 'Expense Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withinput($request->all())->with('error', $e->getMessage());
        }
    }
    public function ExpenseDelete($id)
    {
        try {
            DB::beginTransaction();
            ExpenseMaster::where('ExpenseMasterID', $id)->delete();
            ExpenseDetail::where('ExpenseMasterID', $id)->delete();
            Journal::where('ExpenseMasterID', $id)->delete();
            DB::commit();
            return redirect('Expense')->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ExpensePDF($id)
    {
        try {
            $pagetitle = 'Expense View PDF';
            $company = Company::first();
            $expense_master = DB::table('v_expense')->where('ExpenseMasterID', $id)->first();
            if(!$expense_master){
                return back()->with('error', 'No Data Found');;
            }
            $expense_detail = DB::table('v_expense_detail')->where('ExpenseMasterID', $id)->get();
            $journal = Journal::where('ExpenseMasterID', $id)->get();
            $pdf = PDF::loadView('expense.expense_view_pdf', compact('expense_master', 'expense_detail', 'pagetitle', 'company'));
            return $pdf->stream();
            return view('expense.expense_view', compact('expense_master', 'expense_detail', 'pagetitle', 'company'));
        } catch (\Exception $e) {
            // DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
