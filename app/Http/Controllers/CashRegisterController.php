<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CashRegister;
use App\Sale;
use App\Payment;
use App\Returns;
use App\Expense;
use App\Models\InvoiceMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CashRegisterController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id <= 2) {
            $lims_cash_register_all = CashRegister::with('user', 'warehouse')->get();
            return view('backend.cash_register.index', compact('lims_cash_register_all'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    public function store(Request $request)
    {
        $data = array(
            'Status' => true,
            'user_id' => Session::get('UserID'),
            'cash_in_hand' => $request->cash_in_hand,
            'warehouse_id' => $request->warehouse_id,
            'created_at' => date('Y-m-d h:i:s'),
        );
        $id = DB::table('cash_registers')->insertGetId($data);

        return redirect()->back()->with('success', 'Cash register created successfully');
    }
    public function getDetails($id)
    {
        $cash_register_data = CashRegister::find($id);
        $data['cash_in_hand'] = $cash_register_data->cash_in_hand;
        $data['total_sale_amount'] = Sale::where([
            ['cash_register_id', $cash_register_data->id],
            ['sale_status', 1]
        ])->sum('grand_total');
        $data['total_payment'] = DB::table('invoice_master')
            ->select(DB::raw('sum(Paid) as Paid'))
            ->where('cash_register_id', $cash_register_data->id)->get();
        $data['cash_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['paying_method', 'Cash']
        ])->sum('amount');
        $data['credit_card_payment'] = Payment::where([
            ['cash_register_id', $cash_register_data->id],
            ['paying_method', 'Credit Card']
        ])->sum('amount');
        $data['gift_card_payment'] = Payment::where([
            ['cash_register_id', $cash_register_data->id],
            ['paying_method', 'Gift Card']
        ])->sum('amount');
        $data['deposit_payment'] = Payment::where([
            ['cash_register_id', $cash_register_data->id],
            ['paying_method', 'Deposit']
        ])->sum('amount');
        $data['cheque_payment'] = Payment::where([
            ['cash_register_id', $cash_register_data->id],
            ['paying_method', 'Cheque']
        ])->sum('amount');
        $data['paypal_payment'] = Payment::where([
            ['cash_register_id', $cash_register_data->id],
            ['paying_method', 'Paypal']
        ])->sum('amount');
        $data['total_sale_return'] = Returns::where('cash_register_id', $cash_register_data->id)->sum('grand_total');
        $data['total_expense'] = Expense::where('cash_register_id', $cash_register_data->id)->sum('amount');
        $data['total_cash'] = $data['cash_in_hand'] + $data['total_payment'] - ($data['total_sale_return'] + $data['total_expense']);
        $data['status'] = $cash_register_data->status;
        return $data;
    }

    public function showDetails($warehouse_id)
    {
        $cash_register_data = CashRegister::where([
            ['user_id', Session::get('UserID')],
            ['warehouse_id', $warehouse_id],
            ['status', true]
        ])->first();

        $data['cash_in_hand'] = $cash_register_data->cash_in_hand;

        $data['total_sale_amount'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['sale_status', 1]
        ])->sum('GrandTotal');


        $data['total_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
        ])->sum('Paid');


        $data['cash_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['PaymentMode', 'Cash']
        ])->sum('Paid');
        $data['credit_card_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['PaymentMode', 'Card']
        ])->sum('Paid');
        $data['gift_card_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['PaymentMode', 'Gift Card']
        ])->sum('Paid');
        $data['deposit_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['PaymentMode', 'Deposit']
        ])->sum('Paid');
        $data['cheque_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['PaymentMode', 'Cheque']
        ])->sum('Paid');
        $data['paypal_payment'] = InvoiceMaster::where([
            ['cash_register_id', $cash_register_data->id],
            ['PaymentMode', 'Paypal']
        ])->sum('Paid');

        $data['total_sale_return'] = 0;
        $data['total_expense'] = 0;
        $data['total_cash'] = $data['cash_in_hand'] + $data['total_payment'] - ($data['total_sale_return'] + $data['total_expense']);
        $data['id'] = $cash_register_data->id;
        return $data;
    }

    public function close(Request $request)
    {

        $cash_register_data = CashRegister::find($request->cash_register_id);
        $cash_register_data->status = 0;
        $cash_register_data->save();
        return redirect()->back()->with('success', 'Cash register closed successfully');
    }

    public function checkAvailability($warehouse_id)
    {
        $open_register_number = CashRegister::where([
            ['user_id', Session::get('UserID')],
            ['warehouse_id', $warehouse_id],
            ['status', true]
        ])->count();
        if ($open_register_number)
            return 'true';
        else
            return 'false';
    }
}
