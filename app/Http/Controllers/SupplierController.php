<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{

    public  function Supplier()
    {
        try {
            $allow = check_role(Session::get('UserID'), 'Supplier', 'List / Create');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited');
            }
            Session::put('menu', 'Supplier');
            $pagetitle = 'Supplier';

            $supplier = DB::table('v_supplier')->get();
            // $supplier_category = DB::table('supplier_category')->get();
            return view('supplier.supplier', compact('pagetitle', 'supplier'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public  function SaveSupplier(Request $request)
    {
        try {
            $allow = check_role(Session::get('UserID'), 'Supplier', 'List / Create');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited');
            }
            $request->validate(
                [
                    'SupplierName' => 'required',
                ],
                [
                    'SupplierName.required' => 'Supplier Name is required',
                ]
            );
            $data = array(
                'SupplierName' => $request->input('SupplierName'),
                'TRN' => $request->input('TRN'),
                'Address' => $request->input('Address'),
                'Mobile' => $request->input('Mobile'),
                'Phone' => $request->input('Phone'),
                'Email' => $request->input('Email'),
                'Website' => $request->input('Website'),
                'Active' => $request->input('Active'),
                'InvoiceDueDays' => $request->input('InvoiceDueDays'),
            );
            $id = DB::table('supplier')->insertGetId($data);
            return redirect('Supplier')->with('success', 'Save Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public  function SupplierEdit($id)
    {
        try {
            $allow = check_role(Session::get('UserID'), 'Supplier', 'Update');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited');
            }
            Session::put('menu', 'Supplier');
            $pagetitle = 'Supplier';
            $supplier = DB::table('v_supplier')->where('SupplierID', $id)->get();
            $supplier_category = DB::table('supplier_category')->get();
            return view('supplier.supplier_edit', compact('pagetitle', 'supplier', 'supplier_category'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public  function SupplierUpdate(Request $request)
    {
        try {
            $allow = check_role(Session::get('UserID'), 'Supplier', 'Update');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited');
            }
            $request->validate(
                [
                    'SupplierName' => 'required',
                ],
                [
                    'SupplierName.required' => 'Supplier Name is required',
                ]
            );
            $data = array(
                'SupplierName' => $request->input('SupplierName'),
                'TRN' => $request->input('TRN'),
                'Address' => $request->input('Address'),
                'Mobile' => $request->input('Mobile'),
                'Phone' => $request->input('Phone'),
                'Email' => $request->input('Email'),
                'Website' => $request->input('Website'),
                'Active' => $request->input('Active'),
                'InvoiceDueDays' => $request->input('InvoiceDueDays'),
            );
            $id = DB::table('supplier')->where('SupplierID', $request->input('SupplierID'))->update($data);
            return redirect('Supplier')->with('success', 'Updated Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public  function SupplierDelete($id)
    {
        try {
            $allow = check_role(Session::get('UserID'), 'Supplier', 'Delete');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited');
            }
            $id = DB::table('supplier')->where('SupplierID', $id)->delete();
            return redirect('Supplier')->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
