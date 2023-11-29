<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{

    public function demo()
    {
        $joural = DB::table('v_journal')->get();
        //    dd($joural);
        return view('a_blank', compact('joural'))->with('error', 'Logout Successfully.')->with('class', 'success');
    }
    public function store(Request $request)
    {
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $signature = uniqid() . '.' . $image_type;

        $file = $folderPath . $signature;

        file_put_contents($file, $image_base64);

        $save = new Signature;
        $save->name = $request->name;
        $save->signature = $signature;
        $save->save();


        return back()->with('success', 'Form successfully submitted with signature');
    }


    public function demo3()
    {

        return view('a_blank3');
    }
    public function bankjournal($id)
    {
        // dd($id);
        $data = DB::table('v_journal')->where('VHNO', $id)->get();
        // dd($data);
        return view('a_blank3', compact('data'))->with('error', 'Logout Successfully.')->with('class', 'success');
    }
    public function generalReport()
    {
        $company = DB::table('company')->get();
        return view('reports.journalreport',compact('company'));
    }
    public function showGeneralReport()
    {
        return view('reports.showjournalreport')->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    public function searchByDate(request $request)
    {
 $company = DB::table('company')->get();
        // dd($request->q_search);
        $today = Carbon::now()->format('y-m-d');


        if ($request->q_search != 'null') {
            //today
            if ($request->q_search == 'yesterday') {
                //yesterday
                $from_t = Carbon::yesterday()->format('d M Y');
                $to_t = Carbon::yesterday()->format('d M Y');
                $joural = DB::table('v_journal_report')->whereBetween('Date', array(Carbon::yesterday()->format('y-m-d'), Carbon::yesterday()->format('y-m-d')))->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'today') {
                // today
                $from_t = Carbon::now()->format('d M Y');
                $to_t = Carbon::now()->format('d M Y');
                $joural = DB::table('v_journal_report')->whereBetween('Date', array(Carbon::now()->format('y-m-d'), Carbon::now()->format('y-m-d')))->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                $from_t = Carbon::now()->startOfWeek()->format('d M Y');
                $to_t = Carbon::now()->endOfWeek()->format('d M Y');
                $joural = DB::table('v_journal_report')
                    ->whereBetween('Date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                $from_t = Carbon::now()->subWeek()->startOfWeek()->format("d M Y");
                $to_t = Carbon::now()->subWeek()->endOfWeek()->format("d M Y");
                $joural = DB::table('v_journal_report')
                    ->whereBetween('Date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                    ->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                $from_t = Carbon::now()->startOfMonth()->format('d M Y');
                $to_t = Carbon::now()->endOfMonth()->format('d M Y');
                $joural = DB::table('v_journal_report')
                    ->whereMonth('Date', date('m'))
                    ->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                $from_t = Carbon::now()->subMonth()->startOfMonth()->format('d M Y');
                $to_t = Carbon::now()->subMonth()->endOfMonth()->format('d M Y');
                $joural = DB::table('v_journal_report')
                    ->whereBetween(
                        'Date',
                        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
                    )
                    ->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t'))->with('i', (request()->input('page', 1) - 1) * 5);
            } elseif ($request->q_search == 'this_year') {
                //this year data
                $from_t = Carbon::now()->startOfYear()->format('d M Y');
                $to_t = Carbon::now()->endOfYear()->format('d M Y');
                $joural = DB::table('v_journal_report')
                    ->whereYear('Date', date('Y'))
                    ->paginate(5);
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                $from_t = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('d M Y');
                $to_t = Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('d M Y');
                $joural = DB::table('v_journal_report')
                    ->whereYear('Date', Carbon::createFromFormat('y-m-d', $today)->subYear()->format('Y'))
                    ->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                $from_t = Carbon::now()->startOfMonth()->subMonth(3)->format('d M Y');
                $to_t = Carbon::now()->startOfMonth()->format('d M Y');
                $joural = DB::table('v_journal_report')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d'), Carbon::now()->startOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            } elseif ($request->q_search == 'previous_quarter') {
                //previous_quarter
                $from_t = Carbon::now()->subMonth(6)->startOfMonth()->format('d M Y');

                $to_t = Carbon::now()->subMonth(3)->startOfMonth()->format('d M Y');

                $joural = DB::table('v_journal_report')
                    ->whereBetween('Date', [Carbon::now()->subMonth(6)->startOfMonth(), Carbon::now()->subMonth(3)->startOfMonth()])
                    ->get();

                return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t','company'));
            }
        } else
            $from_t = $request->from;
        $to_t = $request->to;
        $joural = DB::table('v_journal_report')->whereBetween('Date', array($request->from, $request->to))->get();

        return view('reports.showjournalreport', compact('joural', 'from_t', 'to_t'));
    }

    public function completejournal()
    {
        $joural = DB::table('v_journal')->get();

        return view('reports.completejournal', compact('joural'))->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    // .......................Trail Report Section.................
    public function trialreportsearch()
    {
        return view('trial_report.trialreportsearch')->with('error', 'Logout Successfully.')->with('class', 'success');
    }




    public function trialreport(request $request)
    {

        $company = DB::table('company')->where('CompanyID', 1)->get();
        $coaName = DB::select('SELECT CODE,ChartOfAccountID,ChartOfAccountName from chartofaccount where (right(ChartOfAccountID,5)=00000 )and (CODE ="E" OR CODE = "R") ' );

        if ($request->q_search != 'null') {
            if ($request->q_search == 'yesterday') {
                // yesterday
                $from = Carbon::yesterday()->format('y-m-d');
                $to = Carbon::yesterday()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'today') {
                // today
                $from = Carbon::now()->format('y-m-d');
                $to = Carbon::now()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                $from = Carbon::now()->startOfWeek()->format('y-m-d');
                $to = Carbon::now()->endOfWeek()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                $from = Carbon::now()->subWeek()->startOfWeek()->format("y-m-d");
                $to = Carbon::now()->subWeek()->endOfWeek()->format("y-m-d");
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                $from = Carbon::now()->startOfMonth()->format('y-m-d');
                $to = Carbon::now()->endOfMonth()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                $from = Carbon::now()->subMonth()->startOfMonth()->format('y-m-d');
                $to = Carbon::now()->subMonth()->endOfMonth()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                $from = Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d');
                $to = Carbon::now()->startOfMonth()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'this_year') {
                //this year data
                $from = Carbon::now()->startOfYear()->format('y-m-d');
                $to = Carbon::now()->endOfYear()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                $today = Carbon::now()->format('y-m-d');
                $from = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('y-m-d');
                $to = Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d');
                return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
            }
        } else


            $from = $request->from;
        $to = $request->to;
        // dd($to);
        return view('trial_report.trialreport', compact('company', 'coaName', 'from', 'to'));
    }


    public function receiveabledetailsearch()
    {
        return view('reports.receiveabledetailsearch')->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    public function receiveabledetail(request $request)
    {

        if ($request->q_search != 'null') {
            if ($request->q_search == 'yesterday') {
                // yesterday
                // yesterday
                $from = Carbon::yesterday()->format('d M Y');
                $to = Carbon::yesterday()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::yesterday()->format('y-m-d'), Carbon::yesterday()->format('y-m-d')])
                    ->get();
                // dd($data);
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'today') {
                // today
                // today
                $from = Carbon::now()->format('d M Y');
                $to = Carbon::now()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->format('y-m-d'), Carbon::now()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                //this week
                $from = Carbon::now()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->endOfWeek()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfWeek()->format('y-m-d'), Carbon::now()->endOfWeek()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                //previous week
                $from = Carbon::now()->subWeek()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->subWeek()->endOfWeek()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subWeek()->startOfWeek()->format("y-m-d"), Carbon::now()->subWeek()->endOfWeek()->format("y-m-d")])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                //this month
                $from = Carbon::now()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->endOfMonth()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->format('y-m-d'), Carbon::now()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                //this previous
                $from = Carbon::now()->subMonth()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->subMonth()->endOfMonth()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subMonth()->startOfMonth()->format('y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                //this quarter
                $from = Carbon::now()->startOfMonth()->subMonth(3)->format('d M Y');
                $to = Carbon::now()->startOfMonth()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d'), Carbon::now()->startOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'this_year') {
                //this year data
                //this year data
                $from = Carbon::now()->startOfYear()->format('d M Y');
                $to = Carbon::now()->endOfYear()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfYear()->format('y-m-d'), Carbon::now()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                //previous year
                $today = Carbon::now()->format('d M Y');
                $from = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('d M Y');

                $today = Carbon::now()->format('y-m-d');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('y-m-d'), Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetail', compact('data','from','to'));
            }
        } else


            $from = $request->from;
        $to = $request->to;

        return view('reports.receiveabledetail', compact('data', 'from', 'to'));
    }

    public function paymentsmadesearch()
    {
        return view('reports.paymentsmadesearch')->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    public function paymentsmade(request $request)
    {
        // dd($request);
        // $customerbalance = DB::table('v_invoicereport')->selectRaw(" *, SUM(if(ISNULL(Dr),0,Dr)) - SUM(if(ISNULL(Cr),0,Cr)) as RemainingBalance  ")->where('InvoiceNo', 'LIKE',  'INV%')->where('ChartOfAccountID' ,  '110400')->get();
$company = DB::table('company')->get();
        if ($request->q_search != 'null') {
            if ($request->q_search == 'yesterday') {
                // yesterday
                $from = Carbon::yesterday()->format('d M Y');
                $to = Carbon::yesterday()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::yesterday()->format('y-m-d'), Carbon::yesterday()->format('y-m-d')])
                    ->get();
                // dd($data);
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'today') {
                // today
                $from = Carbon::now()->format('d M Y');
                $to = Carbon::now()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->format('y-m-d'), Carbon::now()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                $from = Carbon::now()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->endOfWeek()->format('d M Y');

                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfWeek()->format('y-m-d'), Carbon::now()->endOfWeek()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                $from = Carbon::now()->subWeek()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->subWeek()->endOfWeek()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subWeek()->startOfWeek()->format("y-m-d"), Carbon::now()->subWeek()->endOfWeek()->format("y-m-d")])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                $from = Carbon::now()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->endOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->format('y-m-d'), Carbon::now()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                $from = Carbon::now()->subMonth()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->subMonth()->endOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subMonth()->startOfMonth()->format('y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                $from = Carbon::now()->startOfMonth()->subMonth(3)->format('d M Y');
                $to = Carbon::now()->startOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d'), Carbon::now()->startOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_year') {
                //this year data
                $from = Carbon::now()->startOfYear()->format('d M Y');
                $to = Carbon::now()->endOfYear()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfYear()->format('y-m-d'), Carbon::now()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                $today = Carbon::now()->format('d M Y');
                $from = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('d M Y');
                $to = Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('y-m-d'), Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.paymentsmade', compact('data', 'from', 'to','company'));
            }
        } else


            $from = $request->from;
        $to = $request->to;

        return view('reports.vendorcredits', compact('data'));
    }

    public function payablesearch()
    {
        return view('reports.payablesearch')->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    public function payable(request $request)
    {

$company = DB::table('company')->get();

        // dd($request);
        if ($request->q_search != 'null') {
            if ($request->q_search == 'yesterday') {
                // yesterday
                // yesterday
                $from = Carbon::yesterday()->format('d M Y');
                $to = Carbon::yesterday()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::yesterday()->format('y-m-d'), Carbon::yesterday()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'today') {
                // today
                // today
                $from = Carbon::now()->format('d M Y');
                $to = Carbon::now()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->format('y-m-d'), Carbon::now()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                //this week
                $from = Carbon::now()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->endOfWeek()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfWeek()->format('y-m-d'), Carbon::now()->endOfWeek()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                //previous week
                $from = Carbon::now()->subWeek()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->subWeek()->endOfWeek()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subWeek()->startOfWeek()->format("y-m-d"), Carbon::now()->subWeek()->endOfWeek()->format("y-m-d")])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                //this month
                $from = Carbon::now()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->endOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->format('y-m-d'), Carbon::now()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                //this previous
                $from = Carbon::now()->subMonth()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->subMonth()->endOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subMonth()->startOfMonth()->format('y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                //this quarter
                $from = Carbon::now()->startOfMonth()->subMonth(3)->format('d M Y');
                $to = Carbon::now()->startOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d'), Carbon::now()->startOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_year') {
                //this year data
                //this year data
                $from = Carbon::now()->startOfYear()->format('d M Y');
                $to = Carbon::now()->endOfYear()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfYear()->format('y-m-d'), Carbon::now()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                //previous year
                $today = Carbon::now()->format('d M Y');
                $from = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('d M Y');
                $to = Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('y-m-d'), Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.payable', compact('data', 'from', 'to','company'));
            }
        } else


            $from = $request->from;
        $to = $request->to;

        return view('reports.payable', compact('data', 'from', 'to'));
    }



    public function receiveabledetailsummarysearch()
    {
        return view('reports.receiveabledetailsummarysearch')->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    public function receiveabledetailsummary(request $request)
    {


$company = DB::table('company')->get();
        if ($request->q_search != 'null') {
            if ($request->q_search == 'yesterday') {
                // yesterday
                // yesterday
                $from = Carbon::yesterday()->format('d M Y');
                $to = Carbon::yesterday()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::yesterday()->format('y-m-d'), Carbon::yesterday()->format('y-m-d')])
                    ->get();
                // dd($data);
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'today') {
                // today
                // today
                $from = Carbon::now()->format('d M Y');
                $to = Carbon::now()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->format('y-m-d'), Carbon::now()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                //this week
                $from = Carbon::now()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->endOfWeek()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfWeek()->format('y-m-d'), Carbon::now()->endOfWeek()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                //previous week
                $from = Carbon::now()->subWeek()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->subWeek()->endOfWeek()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subWeek()->startOfWeek()->format("y-m-d"), Carbon::now()->subWeek()->endOfWeek()->format("y-m-d")])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                //this month
                $from = Carbon::now()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->endOfMonth()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->format('y-m-d'), Carbon::now()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                //this previous
                $from = Carbon::now()->subMonth()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->subMonth()->endOfMonth()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subMonth()->startOfMonth()->format('y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                //this quarter
                $from = Carbon::now()->startOfMonth()->subMonth(3)->format('d M Y');
                $to = Carbon::now()->startOfMonth()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d'), Carbon::now()->startOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'this_year') {
                //this year data
                //this year data
                $from = Carbon::now()->startOfYear()->format('d M Y');
                $to = Carbon::now()->endOfYear()->format('d M Y');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfYear()->format('y-m-d'), Carbon::now()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                //previous year
                $today = Carbon::now()->format('d M Y');
                $from = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('d M Y');
                $today = Carbon::now()->format('y-m-d');
                $data = DB::table('v_receivabledetail')->select('*', DB::raw('sum(SubTotal) as subtotal'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'INV%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('y-m-d'), Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
            }
        } else


            $from = $request->from;
        $to = $request->to;
        $from = $request->from;

        return view('reports.receiveabledetailsummary', compact('data', 'from', 'to','company'));
    }


    public function vendorcreditsearch()
    {
        return view('reports.vendorcreditsearch')->with('error', 'Logout Successfully.')->with('class', 'success');
    }

    public function vendorcredits(request $request)
    {
        // dd($request);
        if ($request->q_search != 'null') {
            if ($request->q_search == 'yesterday') {
                // yesterday
                // yesterday
                $from = Carbon::yesterday()->format('d M Y');
                $to = Carbon::yesterday()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::yesterday()->format('y-m-d'), Carbon::yesterday()->format('y-m-d')])
                    ->get();
                // dd($data);
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'today') {
                // today
                // today
                $from = Carbon::now()->format('d M Y');
                $to = Carbon::now()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->format('y-m-d'), Carbon::now()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'this_week') {
                //this week
                //this week
                $from = Carbon::now()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->endOfWeek()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfWeek()->format('y-m-d'), Carbon::now()->endOfWeek()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'previous_week') {
                //previous week
                //previous week
                $from = Carbon::now()->subWeek()->startOfWeek()->format('d M Y');
                $to = Carbon::now()->subWeek()->endOfWeek()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subWeek()->startOfWeek()->format("y-m-d"), Carbon::now()->subWeek()->endOfWeek()->format("y-m-d")])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'this_month') {
                //this month
                //this month
                $from = Carbon::now()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->endOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->format('y-m-d'), Carbon::now()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'previous_month') {
                //this previous
                //this previous
                $from = Carbon::now()->subMonth()->startOfMonth()->format('d M Y');
                $to = Carbon::now()->subMonth()->endOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->subMonth()->startOfMonth()->format('y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'this_quarter') {
                //this quarter
                //this quarter
                $from = Carbon::now()->startOfMonth()->subMonth(3)->format('d M Y');
                $to = Carbon::now()->startOfMonth()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfMonth()->subMonth(3)->format('y-m-d'), Carbon::now()->startOfMonth()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'this_year') {
                //this year data
                //this year data
                $from = Carbon::now()->startOfYear()->format('d M Y');
                $to = Carbon::now()->endOfYear()->format('d M Y');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::now()->startOfYear()->format('y-m-d'), Carbon::now()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            } elseif ($request->q_search == 'previous_year') {
                //previous year
                //previous year
                $today = Carbon::now()->format('d M Y');
                $from = Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('d M Y');

                $today = Carbon::now()->format('y-m-d');
                $data = DB::table('v_invoice_master_supplier')->select('*', DB::raw('sum(Balance) as balance'), DB::raw('sum(Total) as total'))->where('InvoiceNo', 'LIKE', 'DN%')
                    ->groupBy('InvoiceNo')
                    ->whereBetween('Date', [Carbon::createFromFormat('y-m-d', $today)->subYear()->startOfYear()->format('y-m-d'), Carbon::createFromFormat('y-m-d', $today)->subYear()->endOfYear()->format('y-m-d')])
                    ->get();
                return view('reports.vendorcredits', compact('data', 'from', 'to'));
            }
        } else


            $from = $request->from;
        $to = $request->to;

        return view('reports.vendorcredits', compact('data'));
    }
}
