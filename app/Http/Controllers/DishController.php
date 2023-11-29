<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\DishType;
use App\Models\DishImage;
use App\Models\Item;
use App\Models\DishRecipe;
use App\Models\Unit;
use App\Models\DishTable;
use App\Models\InvoiceDishDetail;
use Image;
use DB;
use session;
use Yajra\DataTables\DataTables;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dishes = Dish::get();
            return Datatables::of($dishes)
                ->addIndexColumn()
                ->addColumn('dish_img', function ($row) {
                    if ($row->image_thumbnail)
                        $dish_img = '<td><img src="'.url('thumbnail', $row->image_thumbnail).'" height="50"></td>';
                    else
                        $dish_img = '<td><img src="'.url('assets/images/product/zummXD2dvAtI.png').'" height="100" width="100"></td>';

                    return $dish_img;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1)
                        $status = 'Active';
                    else
                        $status = 'In-Active';

                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('dish.edit', $row->id) . '" target="_blank"><i class="bx bx-pencil align-middle me-1"></i></a>';
                    if($row->dish_types->isEmpty() && $row->dish_images->isEmpty() && $row->dish_recipes->isEmpty())
                    $btn .= '<a href="#" onclick="delete_confirm2(`dishDelete`,' . $row->id . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';

                    return $btn;
                })
                ->rawColumns(['dish_img', 'status' ,'action'])
                ->make(true);
        }

        return view('dish.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dish.create'); //create page
    }

    public function addDish()
    {
        $kitchen_items = Item::where('ItemType','Restaurant')->get();
        return view('dish.add-dish',compact('kitchen_items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name.required' => 'Dish Name is required',
            ]
        );
        // dd($request->all());
        $input = $request->except('image_thumbnail');
        $image = $request->file('image_thumbnail');
        if ($image) {

            $imageName = time().'.'.$image->extension();
            $destinationPath = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            // $destinationPath = public_path('assets/images/dishes');
            // $image->move($destinationPath, $imageName);
            $input['image_thumbnail'] = $imageName;
        }
        $dish = Dish::create($input);
        return redirect()->route('dish.type', $dish->id)->with('error', 'Saved Successfully')->with('class', 'success');
    }

    public function saveSingleDish(Request $request)
    {
        $this->validate(
            $request,
            [
                'name.required' => 'Dish Name is required',
                'price.required' => 'Dish Price is required',
                'code.required' => 'Dish Code is required',
            ]
        );
        $input = $request->all();
        $input['image_thumbnail'] = null;
        $image = $request->file('image_thumbnail');
        if ($image) {

            $imageName = time().'.'.$image->extension();
            $destinationPath = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            $destinationPath = public_path('assets/images/dish-types');
            $image->move($destinationPath, $imageName);
            $input['image_thumbnail'] = $imageName;
        }

        $dish = new Dish();
        $dish->name = $input['name'];
        $dish->image_thumbnail = $input['image_thumbnail'];
        $dish->save();

        $dish_type = new DishType();
        $dish_type->dish_id = $dish->id;
        $dish_type->type = $input['name'];
        $dish_type->price = $input['price'];
        $dish_type->code = $input['code'];
        $dish_type->image = $input['image_thumbnail'];
        $dish_type->save();

        $item_ids = $input['ItemID'];

        if($item_ids){
            foreach ($item_ids as $key => $item_id) {
                $dish_recipe = array(
                    "dish_id" => $dish->id,
                    "dish_type_id" => $dish_type->id,
                    "item_id" => $item_id,
                    "base_unit_amount_cooked" => $input['base_unit_amount_cooked'][$key],
                    "child_unit_amount_cooked" => $input['child_unit_amount_cooked'][$key],
                );

                 DishRecipe::create($dish_recipe);

            }
        }

        
        return redirect()->route('dish.list')->with('error', 'Saved Successfully')->with('class', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        return view('dish.edit-dish',compact('dish'));
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
        $this->validate(
            $request,
            [
                'name.required' => 'Dish Name is required',
            ]
        );
        $input = $request->except('image_thumbnail');
        $image = $request->file('image_thumbnail');
        if ($image) {

            $imageName = time().'.'.$image->extension();
            $destinationPath = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            // $destinationPath = public_path('assets/images/dishes');
            // $image->move($destinationPath, $imageName);
            $input['image_thumbnail'] = $imageName;
        }
        $dish = Dish::find($id)->update($input);
        return redirect()->route('dish.edit', $id)->with('error', 'Saved Successfully')->with('class', 'success');
    }

    public function dishType(Dish $dish, $dish_type_id = null)
    {
        $dish_types = DishType::where('dish_id',$dish->id)->get();
        
        $code = null;
        if($dish_type_id){
            $dish_type = $dish_types->firstWhere('id',$dish_type_id);
            if($dish_type->code){
                $code = explode('-', $dish_type->code);
                $code = $code[1];   
            }
        }
        else{
            $dish_type = $dish_type_id;
        }
             
        return view('dish.dish-type',compact('dish','dish_types','dish_type','code'));
    }

    public function storeDishType(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'type.required' => 'Dish Type is required',
                'price.required' => 'Dish Price is required',
                'code.required' => 'Dish Code is required',
                'code.integer' => 'Dish Code must be of numeric value',
            ]
        );
        $input = $request->all();
        $image = $request->file('image');
        $input['code'] = $input['code'];
        $input['image'] = null;
        if ($image) {
            $imageName = time().'.'.$image->extension();
            $destinationPath = public_path('assets/images/dish-types');
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
        }

        if($input['dish_type_id']){
            $dish_type = DishType::findOrFail($input['dish_type_id']);
            $dish_type->type = $input['type'];
            $dish_type->price = $input['price'];
            $dish_type->code = $input['code'];
            if($input['image']){
                $file_path = public_path().'/assets/images/dish-types/'.$dish_type->image;
                unlink($file_path);
                $dish_type->image = $input['image'];
            }

            $dish_type->save();
        }
        else{
            $input['dish_id'] = $id;
            $dish_type = DishType::create($input);
        }
        
        return redirect()->route('dish.type', $id)->with('error', 'Saved Successfully')->with('class', 'success');
    }

    public function dishImage(Dish $dish)
    {
        $dish_images = DishImage::where('dish_id',$dish->id)->get();
        return view('dish.dish-image',compact('dish','dish_images'));
    }

    public function storeDishImage(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'title.required' => 'Image Name is required',
            ]
        );
        // dd($request->all());
        $input = $request->all();
        $input['dish_id'] = $id;
        $image = $request->file('image');
        if ($image) {

            $imageName = time().'.'.$image->extension();
            // $destinationPath = public_path('/thumbnail');
            // $img = Image::make($image->path());
            // $img->resize(100, 100, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($destinationPath.'/'.$imageName);
            $destinationPath = public_path('assets/images/dishes');
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
        }
        DishImage::create($input);
        return redirect()->route('dish.image', $id)->with('error', 'Saved Successfully')->with('class', 'success');
    }

    public function dishRecipe(Dish $dish, $dish_recipe_id = null)
    {
        $dish_types = DishType::where('dish_id',$dish->id)->get();
        if($dish_recipe_id){
            $dish_type_recipe = DishRecipe::findOrFail($dish_recipe_id);
            $item = Item::where('ItemID',$dish_type_recipe->item_id)->first();
            $item_unit = $item->unit; 
        }
        else{
            $dish_type_recipe = $dish_recipe_id;
            $item_unit = $dish_recipe_id;
        }


        $kitchen_items = Item::where('ItemType','Restaurant')->get();
        $dish_recipes = [];
        foreach($dish_types as $dish_type)
        {
            $dish_recipes[$dish_type->type] = $dish_type->dish_recipe;
        } 
        return view('dish.dish-recipe',compact('dish','dish_types','kitchen_items','dish_recipes','dish_type_recipe','item_unit'));
    }

    public function storeDishRecipe(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'dish_type_id.required' => 'Select Dish Type',
                'item_id.required' => 'Select Item',
                'base_unit_amount_cooked.required' => 'Enter Base unit need to cook',
                'child_unit_amount_cooked.required' => 'Enter Child unit need to cook',
            ]
        );

        $input = $request->all();
        /* $dish_type     = DishType::find($input['dish_type_id']);
        $dish_recipies = DishRecipe::where('dish_type_id','=',$input['dish_type_id'])->get();  */

        if($input['dish_type_recipe_id']){
            DishRecipe::updateOrCreate(['id' => $input['dish_type_recipe_id']],$input);
        }
        else{
            $input['dish_id'] = $id;
            DishRecipe::updateOrCreate(['dish_type_id' => $input['dish_type_id'],'item_id' => $input['item_id']],$input);
        }
        
        return redirect()->route('dish.recipe', $id)->with('error', 'Saved Successfully')->with('class', 'success');
    }

    public function getItemUnit($item_id)
    {
        $item = Item::where('ItemID',$item_id)->first();
        $unit = $item->unit;
        if(!empty($unit)){
            return $unit;
        }
            
        return;
    }

    public function deleteDishType($id)
    {
        $dish_type = DishType::find($id);
        $dish_type->delete();
        return redirect()->back()->with('error', 'Deleted Successfully')->with('class', 'success');
    }

    public function deleteDishImage($id)
    {
        $dish_image = DishImage::find($id);
        $file_path = public_path().'/assets/images/dishes/'.$dish_image->image;
        unlink($file_path);
        $dish_image->delete();
        return redirect()->back()->with('error', 'Deleted Successfully')->with('class', 'success');
    }

    public function deleteDishRecipe($id)
    {
        $dish_recipe = DishRecipe::find($id);
        $dish_recipe->delete();
        return redirect()->back()->with('error', 'Deleted Successfully')->with('class', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish_recipes = $dish->dish_recipes()->delete();
        $dish_types = $dish->dish_types()->delete();
        $dish_images = $dish->dish_images;
        foreach($dish_images as $dish_image)
        {
            $file_path = public_path().'/assets/images/dishes/'.$dish_image->image;
            unlink($file_path);
            $dish_image->delete();
        }
        if($dish->image_thumbnail){
            $thumbnail_path = public_path().'/thumbnail/'.$dish->image_thumbnail;
            unlink($thumbnail_path);
        }
        

        $dish->delete();
        return redirect()->back()->with('error', 'Deleted Successfully')->with('class', 'success');
    }

    public function createDishOrder()
    {
        $pagetitle='Order Dish';
        $tax = DB::table('tax')->get();
        $dishes = Dish::orderBy('name')->pluck('name','id')->toArray();
        $dish_tables = DishTable::orderBy('id')->get();
        $invoice_no = DB::table('invoice_master')->where('InvoiceNo','like','RES%')->count();
        $invoice_no = 'RES-0000' . ++$invoice_no;
        return view('dish.order-dish', compact('invoice_no','pagetitle','tax','dishes','dish_tables'));
    }

    public function getDishTypes(Request $request)
    {
        $dish_types = DishType::where('dish_id',$request->dish_id)->get();
        return response()->json($dish_types);
    }

    public function getDishTypesByFilter($dish_id)
    {
        $data = [];
        if ($dish_id) {
            $dish_types = DishType::where('dish_id',$dish_id)->get();
        } else
            $dish_types = DishType::get();

        $index = 0;
        foreach ($dish_types as $dish_type) {
            $data['name'][$index] = $dish_type->type;
            $data['code'][$index] = $dish_type->code;
            $data['image'][$index] = $dish_type->image;
            $index++;
        }
        return $data;
    }

    public function getDishTypeDetail(Request $request)
    {
        $dish_type_detail = DishType::findOrFail($request->item_idd);
        return response()->json($dish_type_detail);
    }

    public function saveOrderDish(Request $request)
    {
        $invoice_no = DB::table('invoice_master')->where('InvoiceNo','like','RES%')->count();
        $invoice_no = 'RES-0000' . ++$invoice_no;
        $today_date = date('Y-m-d');
        if (!empty($request->invoice_date))
            $today_date = $request->invoice_date;

        $reference_no = date("his");
        $paying_method = 'Cash';

        $invoice_mst = array(
          'InvoiceNo' => $invoice_no, 
          'Date' => $today_date, 
          'DueDate' => $today_date, 
          'DishTableID' => $request->dish_table_id, 
          'WalkinCustomerName' => $request->WalkinCustomerName, 
          'ReferenceNo' => $reference_no, 
          'PaymentMode' => $paying_method, 
          // 'PaymentDetails' => $request->PaymentDetails, 
          // 'Subject' => $request->Subject, 
          'SubTotal' => $request->SubTotal, 
          'DiscountPer' => $request->DiscountPer, 
          'DiscountAmount' => $request->DiscountAmount, 
          'Total' => $request->Total, 
          'TaxPer' => $request->Taxpercentage, 
          'Tax' => $request->grandtotaltax, 
          'Shipping' => $request->Shipping, 
          'GrandTotal' => $request->Grandtotal, 
          'Paid' => $request->Grandtotal, 
          'Balance' => $request->amountDue, 
          // 'CustomerNotes' => $request->CustomerNotes,               
          // 'DescriptionNotes' => $request->DescriptionNotes,               
          'UserID' => session::get('UserID'), 
        );

        $InvoiceMasterID = DB::table('invoice_master')->insertGetId($invoice_mst);
        $dish_types = $request->ItemID;
 

        foreach ($dish_types as $key => $dish_type_id) {
            $dish_type = DishType::findOrFail($dish_type_id);            

            $invoice_dish_detail = new InvoiceDishDetail();
            $invoice_dish_detail->invoice_master_id = $InvoiceMasterID;
            $invoice_dish_detail->dish_id = $dish_type->dish_id;
            $invoice_dish_detail->dish_type_id = $dish_type_id;
            $invoice_dish_detail->quantity = $request->Qty[$key];
            $invoice_dish_detail->price = $dish_type->price;
            $invoice_dish_detail->save();

            $dish_items = $dish_type->dish_recipe;
            foreach($dish_items as $dish_item)
            {
                $item_name = DB::table('item')->where('ItemID', $dish_item->item_id)->pluck('ItemName')->first();
                $invoice_det = array (
                    'InvoiceMasterID' =>  $InvoiceMasterID, 
                    'InvoiceNo' => $invoice_no, 
                    'dish_id' => $dish_type->dish_id,
                    'dish_type_id' => $dish_type_id,
                    'ItemID' => $dish_item->item_id,
                    "Description" => $item_name,
                    'Qty' => $dish_item->base_unit_amount_cooked,
                    // 'TaxPer' => $request->Tax[$key],
                    // 'Tax' => $request->TaxVal[$key],
                    // 'Rate' => $request->Price[$key],
                    // 'Total' => $request->ItemTotal[$key],
                
                );

                $id = DB::table('invoice_detail')->insertGetId($invoice_det);
            }

            
        }
        return redirect('create-dish-order')->with('error', 'Order Placed Successfully')->with('class', 'success');
    }

    public function dishInvoices(Request $request)
    {
        if ($request->ajax()) {
            $invoices = DB::table('invoice_master')->where('InvoiceNo','like','RES%')->get();
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('payment_status', function ($row) {
                    if ($row->Balance == 0)
                        $pay_status = '<span class="badge alert-success">Paid</span>';
                    else
                        $pay_status = '<span class="badge alert-danger">Due</span>';

                    return $pay_status;
                })
                ->addColumn('table_no', function ($row) {
                    if ($row->DishTableID)
                        $table_no = DishTable::where('id',$row->DishTableID)->pluck('name')->first();
                    else
                        $table_no = 'Take Away';

                    return $table_no;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown"><a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal font-size-18"></i></a><div class="dropdown-menu dropdown-menu-end">';
                    $btn .= '<a href="' . route('dish.invoice.edit',$row->InvoiceMasterID) . '" class="dropdown-item" target="_blank">Edit Invoice</a><a href="' . route('invoice.show', ['id' => $row->InvoiceMasterID]) . '" class="dropdown-item" target="_blank">View Invoice</a><a href="' . route('invoice.print', ['id' => $row->InvoiceMasterID]) . '" class="dropdown-item" target="_blank">Print Invoice</a><button type="button" class="add-payment dropdown-item" data-id = "'.$row->InvoiceMasterID.'" data-bs-toggle="modal" data-bs-target="#add-payment">'.trans('file.Add Payment').'</button>';
                    $btn .= ' </div></div>';
                    return $btn;
                })
                ->rawColumns(['payment_status','table_no', 'action'])
                ->make(true);
        }
        return view('dish.invoice_listing');
    }

    public function editDishInvoice($id)
    {
        $tax = DB::table('tax')->get();
        $dishes = Dish::orderBy('name')->pluck('name','id')->toArray();
        $dish_tables = DishTable::orderBy('id')->get();
        $invoice_master = DB::table('invoice_master')->where('InvoiceMasterID', $id)->first();
        $dish_table_id = DishTable::where('id',$invoice_master->DishTableID)->pluck('id')->first();
        $invoice_detail = InvoiceDishDetail::where('invoice_master_id', $id)->get();

        return view('dish.edit_dish_invoice', compact('dishes','dish_table_id','dish_tables','invoice_master', 'invoice_detail','tax'));
    }

    public function updateDishOrder(Request $request)
    {
        $invoice_no = DB::table('invoice_master')->where('InvoiceNo','like','RES%')->count();
        $invoice_no = 'RES-0000' . ++$invoice_no;
        $today_date = date('Y-m-d');
        if (!empty($request->invoice_date))
            $today_date = $request->invoice_date;

        $reference_no = date("his");
        $paying_method = 'Cash';

        $invoice_mst = array(
          'InvoiceNo' => $invoice_no, 
          'Date' => $today_date, 
          'DueDate' => $today_date, 
          'DishTableID' => $request->dish_table_id, 
          'WalkinCustomerName' => $request->WalkinCustomerName, 
          'ReferenceNo' => $reference_no, 
          'PaymentMode' => $paying_method, 
          // 'PaymentDetails' => $request->PaymentDetails, 
          // 'Subject' => $request->Subject, 
          'SubTotal' => $request->SubTotal, 
          'DiscountPer' => $request->DiscountPer, 
          'DiscountAmount' => $request->DiscountAmount, 
          'Total' => $request->Total, 
          'TaxPer' => $request->Taxpercentage, 
          'Tax' => $request->grandtotaltax, 
          'Shipping' => $request->Shipping, 
          'GrandTotal' => $request->Grandtotal, 
          'Paid' => $request->Grandtotal, 
          'Balance' => $request->amountDue, 
          // 'CustomerNotes' => $request->CustomerNotes,               
          // 'DescriptionNotes' => $request->DescriptionNotes,               
          'UserID' => session::get('UserID'), 
        );

      
        $InvoiceMst= DB::table('invoice_master')->where('InvoiceMasterID',$request->InvoiceMasterID)->update($invoice_mst);

        $invoice_detail = DB::table('invoice_detail')->where('InvoiceMasterID',$request->InvoiceMasterID)->delete();
        $invoice_dish_detail = InvoiceDishDetail::where('invoice_master_id',$request->InvoiceMasterID)->delete();

        $dish_types = $request->ItemID;
 

        foreach ($dish_types as $key => $dish_type_id) {
            $dish_type = DishType::findOrFail($dish_type_id);            

            $invoice_dish_detail = new InvoiceDishDetail();
            $invoice_dish_detail->invoice_master_id = $request->InvoiceMasterID;
            $invoice_dish_detail->dish_id = $dish_type->dish_id;
            $invoice_dish_detail->dish_type_id = $dish_type_id;
            $invoice_dish_detail->quantity = $request->Qty[$key];
            $invoice_dish_detail->price = $dish_type->price;
            $invoice_dish_detail->save();

            $dish_items = $dish_type->dish_recipe;
            foreach($dish_items as $dish_item)
            {
                $item_name = DB::table('item')->where('ItemID', $dish_item->item_id)->pluck('ItemName')->first();
                $invoice_det = array (
                    'InvoiceMasterID' =>  $request->InvoiceMasterID, 
                    'InvoiceNo' => $invoice_no, 
                    'dish_id' => $dish_type->dish_id,
                    'dish_type_id' => $dish_type_id,
                    'ItemID' => $dish_item->item_id,
                    "Description" => $item_name,
                    'Qty' => $dish_item->base_unit_amount_cooked,
                    // 'TaxPer' => $request->Tax[$key],
                    // 'Tax' => $request->TaxVal[$key],
                    // 'Rate' => $request->Price[$key],
                    // 'Total' => $request->ItemTotal[$key],
                
                );

                $id = DB::table('invoice_detail')->insertGetId($invoice_det);
            }

            
        }
        return redirect('invoice-dish-listing')->with('error', 'Order Updated Successfully')->with('class', 'success');
    }
    
}
