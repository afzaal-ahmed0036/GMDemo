<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use URL;
use Image;
use Excel;
use File;
use PDF;
use App\Models\Warehouse;
class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        
        $id = DB::table('user')->where('UserID',$id)->delete();
        echo "del";
        
    }

    public function Show()
    {

        ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////// 
        $allow= check_role(session::get('UserID'),'User','List / Create');
        if($allow[0]->Allow=='N')
        {
        return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
        }
        ////////////////////////////END SCRIPT //////////////////////////////////////////////

        session::put('menu','User');     
        $pagetitle = 'User';
       
        $user= DB::table('user')
                ->select('user.*','warehouses.name as warehouseName')
                ->leftJoin('warehouses', 'user.WarehouseID', '=', 'warehouses.id')
                ->get();
        $warehouse_list     = Warehouse::where('is_active', true)->get();
        
        return  view ('user',compact('user','warehouse_list','pagetitle'));
     }


    public function UserSave (request $request)
    {
        ///////////////////////USER RIGHT & CONTROL //////////////////////////////////////////   
        $allow= check_role(session::get('UserID'),'User','List / Create');
        if($allow[0]->Allow=='N')
        {
        return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////

        $this->validate($request,[
            'Email'=>'required|max:40|unique:user',         
            'Password'=>'required'
          ]);
        $data = array (
                'FullName' => $request->input('FullName'),
                'Email' => $request->input('Email'),
                'Password' => $request->input('Password'),
                'Password' => $request->input('Password'),
                'Mobile' => $request->input('Mobile'),
                'UserType' => $request->input('UserType'),
                'WarehouseID' => $request->input('WarehouseID'),
                'Active' => $request->input('Active')
                 );

        $id =DB::table('user')->insert($data);
        return redirect('User')->with('error','User Created Successfully')->with('class','success');
     }

    public function UserEdit($id)
    {
        session::put('menu','User');     
        $pagetitle = 'User';
        ///////////////////////USER RIGHT & CONTROL //////////////////////////////////////    
        $allow= check_role(session::get('UserID'),'User','Update');
        if($allow[0]->Allow=='N')
        {
        return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
        }
        ////////////////////////////END SCRIPT ///////////////////////////////////////////

         $v_users= DB::table('user')->where('UserID',$id)->get();
         $warehouse_list     = Warehouse::where('is_active', true)->get();

        return  view ('user_edit',compact('v_users','warehouse_list','pagetitle'));
    }

    public function UserUpdate(request $request)
    { 
        ///////////////////////USER RIGHT & CONTROL //////////////////////////////////////// 
        $allow= check_role(session::get('UserID'),'User','Update');
        if($allow[0]->Allow=='N')
        {
        return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
        }
        ////////////////////////////END SCRIPT /////////////////////////////////////////////

         $this->validate(
            $request,['Password'=>'required' ],
            ['Password.required' => 'Customer Name is required',]);

        $data = array 
        (               
            'FullName' => $request->input('FullName'),
            'Email' => $request->input('Email'),
            'Password' => $request->input('Password'),                
            'Address' => $request->input('Address'),
            'Mobile' => $request->input('Mobile'),
            'UserType' => $request->input('UserType'),
            'WarehouseID' => $request->input('WarehouseID'),
            'Active' => $request->input('Active')
        );
 
        $id= DB::table('user')->where('UserID',$request->input('UserID'))->update($data);
        return redirect('User')->with('error','Users Updated Successfully')->with('class','success');
     }

    public function UserDelete($id)
    {  
        ///////////////////////USER RIGHT & CONTROL ////////////////////////////////////////    
        $allow= check_role(session::get('UserID'),'User','Delete');
        if($allow[0]->Allow=='N')
        {
        return redirect()->back()->with('error', 'You access is limited')->with('class','danger');
        }
        ////////////////////////////END SCRIPT ////////////////////////////////////////////////

        $id = DB::table('user')->where('UserID',$id)->delete();
        return redirect('User')->with('error','User Deleted Successfully')->with('class','success');
    }

}