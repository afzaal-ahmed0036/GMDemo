<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PartyController extends Controller
{
    public  function Parties(Request $request)
    {
        try {
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(Session::get('UserID'), 'Supplier', 'Delete');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            Session::put('menu', 'Party');
            $pagetitle = 'Parties';
            $supplier = Party::with('invoiceMaster')->get();
            return view('party', compact('pagetitle', 'supplier'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
            //throw $th;
        }
    }
    public function CreateParty()
    {
        try {
            $pagetitle = 'Create Party';
            return view('create_party', compact('pagetitle'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
            //throw $th;
        }
    }
    public  function SaveParties(request $request)
    {
        // dd($request->all());
        try {
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(Session::get('UserID'), 'Party / Customers', 'List / Create');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            $this->validate(
                $request,
                [
                    'PartyName' => 'required',
                ],
                [
                    'PartyName.required' => 'Party / Cusomter Name is required',
                ]
            );
            DB::beginTransaction();
            $data = array(
                'PartyName' => $request->input('PartyName'),
                'TRN' => $request->input('TRN'),
                'Address' => $request->input('Address'),
                'City' => $request->input('City'),
                'Mobile' => $request->input('Mobile'),
                'Phone' => $request->input('Mobile'),
                'Email' => $request->input('Email'),
                'Website' => $request->input('Website'),
                'Active' => 'Yes',
            );
            // $id = DB::table('party')->insertGetId($data);
            Party::create($data);
            DB::commit();
            return redirect('Parties')->with('error', 'Save Successfully.')->with('class', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger')->withInput();
            //throw $th;
        }
    }
    public  function PartiesEdit($id)
    {
        try {
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(Session::get('UserID'), 'Party / Customers', 'Update');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            Session::put('menu', 'Party');
            $pagetitle = 'Party';

            $supplier = Party::findOrFail($id);

            return view('party_edit', compact('pagetitle', 'supplier'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
            //throw $th;
        }
    }
    public  function PartiesUpdate(request $request)
    {
        ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
        $allow = check_role(Session::get('UserID'), 'Party / Customers', 'Update');
        if ($allow[0]->Allow == 'N') {
            return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////
        $this->validate(
            $request,
            [
                'PartyName' => 'required',
            ],
            [
                'PartyName.required' => 'Party / Cusomter Name is required',
            ]
        );


        $data = array(

            'PartyName' => $request->input('PartyName'),
            'TRN' => $request->input('TRN'),
            'Address' => $request->input('Address'),
            'City' => $request->input('City'),
            'Mobile' => $request->input('Mobile'),
            'Phone' => $request->input('Phone'),
            'Email' => $request->input('Email'),
            'Website' => $request->input('Website'),
            'Active' => $request->input('Active'),
            'InvoiceDueDays' => $request->input('InvoiceDueDays'),



        );

        $id = DB::table('party')->where('PartyID', $request->input('PartyID'))->update($data);




        return redirect('Parties')->with('error', 'Updated Successfully.')->with('class', 'success');
    }
    public  function PartiesDelete($id)
    {
        ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
        $allow = check_role(Session::get('UserID'), 'Party / Customers', 'Delete');
        if ($allow[0]->Allow == 'N') {
            return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////


        $id = DB::table('party')->where('PartyID', $id)->delete();
        return redirect('Parties')->with('error', 'Deleted Successfully')->with('class', 'success');
    }
}
