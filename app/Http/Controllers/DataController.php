<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\InvoiceMaster;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function SaleReport()
    {
        try {
            if (Session::get('UserType') == 'Biller') {
                return redirect('create-voucher');
            }
            $pagetitle = 'sale report';
            return view('sale_report', compact('pagetitle'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function SaleReport1(request $request)
    {
        try {
            $pagetitle = 'Sale report';

            $v_invoice_profit = DB::table('v_invoice_profit')
                ->whereDate('Date', '>=', $request->StartDate)
                ->whereDate('Date', '<=', $request->EndDate)
                ->orderBy('Date')
                ->get();
            return view('sale_report1', compact('v_invoice_profit', 'pagetitle'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function saleReportPDF(Request $request)
    {
        try {
            $pagetitle = 'Sale report';
            $company = DB::table('company')->first();

            $v_invoice_profit = DB::table('v_invoice_profit')
                ->whereDate('Date', '>=', $request->StartDate)
                ->whereDate('Date', '<=', $request->EndDate)
                ->orderBy('Date')
                ->get();
            // return view('sale_report_pdf', compact('v_invoice_profit', 'pagetitle', 'company'));
            $pdf = Pdf::loadView('sale_report_pdf', compact('v_invoice_profit', 'pagetitle', 'company'));
            $pdf->setpaper('A4', 'portiate');
            return $pdf->stream();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function ItemSaleReport()
    {
        try {
            if (session::get('UserType') == 'Biller') {
                return redirect('create-voucher');
            }
            $pagetitle = 'Item Report';
            $items = Item::all();
            // dd($drivers);

            return view('item.item_sale_report', compact('pagetitle', 'items'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ItemSaleReportPDF(Request $request)
    {
        // dd($request->all());
        try {
            $pagetitle = 'Item Report';
            $company = DB::table('company')->first();
            $item_name = null;
            $item_code = null;
            $item_cost = null;
            if ($request->item_id != null) {
                $item = Item::findOrFail($request->item_id);
                $item_name = $item->ItemName;
                $item_code = $item->ItemCode;
                $item_cost = $item->CostPrice != null ? $item->CostPrice : 0;
            }
            // dd($biller_name);
            $v_invoice_profit = InvoiceMaster::where(function ($query) {
                $query->where('sale_status', '!=', 10)
                    ->orWhereNull('sale_status');
            })
                // ->whereDate('Date', '>=', $request->StartDate)
                // ->whereDate('Date', '<=', $request->EndDate)
                ->when($request->item_id != null, function ($query) use ($request) {
                    $query->whereHas('invoiceDetails', function ($subquery) use ($request) {
                        $subquery->where('ItemID', $request->item_id)
                            ->select('*', DB::raw('SUM(invoice_detail.Qty) as Qtys'), DB::raw('SUM(invoice_detail.Total) as Totals'))
                            ->groupBy('invoice_detail.ItemID');
                    });
                })
                ->with('invoiceDetails', function ($query) use ($request) {
                    $query->where('ItemID', $request->item_id);
                    // ->groupBy('invoice_detail.ItemID');
                })
                ->orderBy('InvoiceMasterID')
                ->get();

            $purchases = $v_invoice_profit->filter(function ($item) {
                return Str::startsWith($item->InvoiceNo, 'BILL-');
            });
            $sales = $v_invoice_profit->filter(function ($item) {
                return Str::startsWith($item->InvoiceNo, 'INV-');
            });
            $P_sum = $purchases->flatMap(function ($item) {
                return $item->invoiceDetails->map(function ($detail) {
                    return $detail->Qty;
                });
            })->sum();
            $S_sum = $sales->flatMap(function ($item) {
                return $item->invoiceDetails->map(function ($detail) {
                    return $detail->Qty;
                });
            })->sum();
            $remaining_stock = $P_sum - $S_sum;

            $pdf = PDF::loadView('item.item_sale_report_pdf', compact('purchases', 'sales', 'pagetitle', 'company', 'item_name', 'item_code', 'item_cost', 'remaining_stock'));
            $pdf->setpaper('A4', 'portiate');
            return $pdf->stream();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ItemSaleReport1(Request $request)
    {
        try {
            $pagetitle = 'Item Report';
            $company = DB::table('company')->first();
            $item_name = null;
            $item_code = null;
            $item_cost = null;
            if ($request->item_id != null) {
                $item = Item::findOrFail($request->item_id);
                $item_name = $item->ItemName;
                $item_code = $item->ItemCode;
                $item_cost = $item->CostPrice != null ? $item->CostPrice : 0;
            }
            // dd($biller_name);
            $v_invoice_profit = InvoiceMaster::where(function ($query) {
                $query->where('sale_status', '!=', 10)
                    ->orWhereNull('sale_status');
            })
                // ->whereDate('Date', '>=', $request->StartDate)
                // ->whereDate('Date', '<=', $request->EndDate)
                ->when($request->item_id != null, function ($query) use ($request) {
                    $query->whereHas('invoiceDetails', function ($subquery) use ($request) {
                        $subquery->where('ItemID', $request->item_id)
                            ->select('*', DB::raw('SUM(invoice_detail.Qty) as Qtys'), DB::raw('SUM(invoice_detail.Total) as Totals'))
                            ->groupBy('invoice_detail.ItemID');
                    });
                })
                ->with('invoiceDetails', function ($query) use ($request) {
                    $query->where('ItemID', $request->item_id);
                    // ->groupBy('invoice_detail.ItemID');
                })
                ->orderBy('InvoiceMasterID')
                ->get();

            $purchases = $v_invoice_profit->filter(function ($item) {
                return Str::startsWith($item->InvoiceNo, 'BILL-');
            });
            $sales = $v_invoice_profit->filter(function ($item) {
                return Str::startsWith($item->InvoiceNo, 'INV-');
            });
            $P_sum = $purchases->flatMap(function ($item) {
                return $item->invoiceDetails->map(function ($detail) {
                    return $detail->Qty;
                });
            })->sum();
            $S_sum = $sales->flatMap(function ($item) {
                return $item->invoiceDetails->map(function ($detail) {
                    return $detail->Qty;
                });
            })->sum();
            $remaining_stock = $P_sum - $S_sum;
            // dd($sum);
            return view('item.item_sale_report_view', compact('purchases', 'sales', 'pagetitle', 'company', 'item_name', 'item_code', 'item_cost', 'remaining_stock'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    function ExpenseReport()
    {
        try {
            if (session::get('UserType') == 'Biller') {
                return redirect('create-voucher');
            }
            $pagetitle = 'Expense';
            return view('expense.expense_report', compact('pagetitle'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ExpenseReport1(request $request)
    {
        try {
            $pagetitle = 'Expense Report';
            $company = DB::table('company')->get();
            $expense_detail = DB::table('v_expense_detail')
                ->whereDate('Date', '>=', $request->StartDate)
                ->whereDate('Date', '<=', $request->EndDate)
                ->orderBy('Date')
                ->get();
            return View('expense.expense_report1', compact('expense_detail', 'pagetitle', 'company'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ExpenseReportPDF(Request $request)
    {
        try {
            $pagetitle = 'Expense Report';
            $company = DB::table('company')->first();
            $expense_detail = DB::table('v_expense_detail')
                ->whereDate('Date', '>=', $request->StartDate)
                ->whereDate('Date', '<=', $request->EndDate)
                ->orderBy('Date')
                ->get();
            $pdf = PDF::loadView('expense.expense_report_pdf', compact('expense_detail', 'pagetitle', 'company'));
            $pdf->setpaper('A4', 'portiate');
            return $pdf->stream();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function VatReport(){
        $pagetitle = 'VAT Report';
        return view('reports.vatReport', compact('pagetitle'));
    }
    public function VatReportPDF(Request $request){
        try {
            $invoice_masters = InvoiceMaster::whereDate('Date','>=' , $request->StartDate)
            ->whereDate('Date','<=' , $request->EndDate)
            ->where('sale_status', '!=', 10)
            ->where('partyID', '!=', null)
            ->with('party')
            ->get();
            $company = Company::first();
            $startDate = $request->StartDate;
            $endDate = $request->EndDate;

            // dd($invoice_masters);
            $pdf = PDF::loadView('reports.vatReportPDF', compact('invoice_masters', 'company', 'startDate', 'endDate'));
            // return $pdf->download('pdfview.pdf');
            $pdf->setpaper('A4', 'portiate');
            return $pdf->stream();
            // return view('teq-invoice.dailyTransactions', compact('invoice_masters'));
        } catch (\Exception $e) {
            //throw $th;
            // dd('here');
            // DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
        // dd($request->all());
    }
    public function ItemsPurchaseReport()
    {
        $items = Item::all();
        return view('item.item_purchase_report_view', compact('items'));
    }
}
