<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\PosSetting;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Image;
use Keygen;
use File;
use Illuminate\Validation\Rule;

class ItemsController extends Controller
{
    public  function Item()
    {
        try {
            Session::put('menu', 'Item');
            $pagetitle = 'Item';
            $item = Item::all();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $supplier = Supplier::all();
            $lims_pos_setting_data = PosSetting::latest()->first();

            return view('item', compact('pagetitle', 'item', 'lims_warehouse_list', 'supplier', 'lims_pos_setting_data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
        }
    }
    public  function ItemCreate()
    {
        try {
            Session::put('menu', 'Item');
            $pagetitle = 'Item';
            // $item = Item::all();
            $units = Unit::all();
            // $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $item_categories = ItemCategory::all();
            $lims_brand_all = Brand::where('is_active', true)->get();
            // $supplier = Supplier::all();
            // $lims_pos_setting_data = PosSetting::latest()->first();
            // $chartofaccount = DB::table('chartofaccount')->where(DB::raw('right(ChartOfAccountID,4)'), 00000)->where(DB::raw('right(ChartOfAccountID,5)'), '!=', 00000)->get();

            // return view('item_create', compact('pagetitle', 'item', 'chartofaccount', 'units', 'lims_warehouse_list', 'item_categories', 'lims_brand_all', 'supplier', 'lims_pos_setting_data'));
            return view('item_create', compact('pagetitle', 'units', 'item_categories', 'lims_brand_all'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
        }
    }
    public  function ItemSave(request $request)
    {
        try {
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(Session::get('UserID'), 'Item/Inventory', 'List / Create');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            // dd($request->all());
            $request->validate(
                [
                    'ItemName' => 'required|max:255',
                    'ItemCode' => 'required|max:255|unique:item,ItemCode',
                    // 'stockQty' => 'required|numeric',
                    // 'SellingPrice' => 'required|numeric',
                    // 'Percentage' => [
                    //     function ($attribute, $value, $fail) use ($request) {
                    //         if ($request->input('Taxable') == 'Yes' && empty($value)) {
                    //             $fail('The Taxable Percentage is required if Taxable is set to Yes');
                    //         }
                    //     },
                    // ],
                ],
                [
                    'ItemCode.required' => 'Item Code is required',
                    'ItemName.required' => 'Item Name is required'
                ]
            );
            DB::beginTransaction();
            $imageName = null;
            $image = $request->file('image');
            if ($image) {
                $imageName = time() . '.' . $image->extension();
                $destinationPath = public_path('/thumbnail');
                $img = Image::make($image->path());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imageName);
                $destinationPath = public_path('assets/images/items');
                $image->move($destinationPath, $imageName);
            }
            $data = array(
                'UnitID' => $request->input('unit_id'),
                'ItemCategoryID' => $request->input('item_category_id'),
                'BrandID' => $request->input('brand_id'),
                // 'WarehouseID' => $request->input('warehouse_id'),
                'ItemCode' => $request->input('ItemCode'),
                'ItemName' => $request->input('ItemName'),
                'ItemImage' => $imageName,
                'ItemType' => $request->input('ItemType'),
                // 'Taxable' => $request->input('Taxable'),
                // 'Percentage' => $request->input('Percentage'),
                // 'CostPrice' => $request->input('CostPrice'),
                // 'SellingPrice' => $request->input('SellingPrice'),
                // 'CostDescription' => $request->input('CostDescription'),
                // 'SellingDescription' => $request->input('SellingDescription'),
                'isFeatured' => 1,
                'isActive' => 1
            );
            $item = Item::create($data);
            // dd($item);
            // $quantity = 2147483647;
            // $quantity = trim($request->stockQty);
            // if ($quantity > 0) {
            //     $invoice_no = InvoiceMaster::select('InvoiceNo')
            //         ->where('InvoiceNo', 'like', 'BILL%')
            //         ->orderBy('InvoiceMasterID', 'desc')
            //         ->first();
            //     if ($invoice_no)
            //         $invoice_no = str_replace('BILL-', '', $invoice_no->InvoiceNo);
            //     else
            //         $invoice_no = 0;
            //     ++$invoice_no;
            //     switch (strlen($invoice_no)) {
            //         case 1:
            //             $paddingZeros = '0000';
            //             break;
            //         case 2:
            //             $paddingZeros = '000';
            //             break;
            //         case 3:
            //             $paddingZeros = '00';
            //             break;
            //         case 4:
            //             $paddingZeros = '0';
            //             break;
            //         default:
            //             $paddingZeros = '';
            //     }
            //     $invoice_no = 'BILL-'  . $paddingZeros . $invoice_no;
            //     $today_date = date('Y-m-d');
            //     $reference_no = date("his");
            //     $price = $request->CostPrice != null ? trim($request->CostPrice) : 0; // whether to store cost or selling price
            //     $subTotal = $price * $quantity;
            //     if ($request->Taxable == 'Yes') {
            //         if ($request->Percentage == null) {
            //             return redirect()->back()->withinput($request->all())->with('error', 'The Taxable Percentage is required if Taxable is set to Yes')->with('class', 'danger');
            //         } else {
            //             $tax = floatval((trim($request->Percentage) / 100) * $subTotal);
            //             $grandTotal = floatval($subTotal + $tax);
            //         }
            //     } else {
            //         $tax = 0;
            //         $grandTotal = $subTotal;
            //     }
            //     $invoice_mst = array(
            //         'InvoiceNo' => $invoice_no,
            //         'Date' => $today_date,
            //         'DueDate' => $today_date,
            //         'SupplierID' => $request->SupplierID,
            //         'WarehouseID' => $request->warehouse_id,
            //         'WalkinCustomerName' => 'Walkin Customer',
            //         'ReferenceNo' => $reference_no,
            //         'PaymentMode' => 'Cash',
            //         'SubTotal' => 0,
            //         'DiscountPer' => 0,
            //         'DiscountAmount' => 0,
            //         'Total' => $price,
            //         'TotalQty' => $quantity,
            //         'TaxPer' => $tax,
            //         'Tax' => $tax,
            //         'Shipping' => 0,
            //         'GrandTotal' => $grandTotal,
            //         'Paid' => 0,
            //         'Balance' => $grandTotal,
            //         'UserID' => Session::get('UserID'),
            //     );
            //     $invoiceMaster = InvoiceMaster::create($invoice_mst);
            //     // $invoiceMasterID = DB::table('invoice_master')->insertGetId($invoice_mst);
            //     $invoice_det = array(
            //         'InvoiceMasterID' =>  $invoiceMaster->InvoiceMasterID,
            //         'InvoiceNo' => $invoice_no,
            //         'ItemID' => $item->ItemID,
            //         'SupplierID' => $request->input('SupplierID'),
            //         'Qty' => $quantity,
            //         'Description' => $request->ItemName,
            //         'TaxPer' => $tax,
            //         'Tax' => $tax,
            //         'Rate' => $price,
            //         'Total' => $grandTotal
            //     );
            //     InvoiceDetail::create($invoice_det);
            // }
            DB::commit();
            return redirect('Item')->with('error', 'Save Successfully.')->with('class', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withinput($request->all())->with('error', $e->getMessage())->with('class', 'danger');
        }
    }

    public function generateCode()
    {
        $ItemCode = $this->getCode();
        $item = Item::where('ItemCode', $ItemCode)->count();
        if ($item == 0) {
            return $ItemCode;
        }
    }
    protected function getCode()
    {
        $id = Keygen::numeric(8)->generate();
        return $id;
    }
    public function ItemEdit($id)
    {
        try {

            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(Session::get('UserID'), 'Item/Inventory', 'Update');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            Session::put('menu', 'Item');
            $pagetitle = 'Item';

            $item = Item::find($id);
            $categories = DB::table('item_category')->get();
            $lims_brand_list = Brand::where('is_active', true)->get();
            $units = Unit::get();
            // $chartofaccount = DB::table('chartofaccount')->where(DB::raw('right(ChartOfAccountID,4)'), 00000)->where(DB::raw('right(ChartOfAccountID,5)'), '!=', 00000)->get();
            // $itemINVdetails = InvoiceDetail::where('ItemID', $id)->where('InvoiceNo', 'LIKE', 'BILL-%')->first();
            // $invMasterData = InvoiceMaster::find($itemINVdetails->InvoiceMasterID);
            // $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            // $supplier = DB::table('supplier')->get();

            return view('item_edit', compact('pagetitle', 'item', 'categories', 'lims_brand_list', 'units',));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
        }
    }
    public function ItemUpdate(request $request)
    {
        try {
            // dd($request->all());
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(session::get('UserID'), 'Item/Inventory', 'Update');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////
            $request->validate(
                [
                    'ItemName' => 'required|max:255',
                    'ItemCode' => [
                        'required',
                        'max:255',
                        Rule::unique('item', 'ItemCode')->ignore($request->input('ItemID'), 'ItemID'),
                    ],
                    // 'stockQty' => 'required|numeric',
                    // 'SellingPrice' => 'required|numeric',
                    // 'Percentage' => [
                    //     function ($attribute, $value, $fail) use ($request) {
                    //         if ($request->input('Taxable') == 'Yes' && empty($value)) {
                    //             $fail('The Taxable Percentage is required if Taxable is set to Yes');
                    //         }
                    //     },
                    // ],
                ],
                [
                    'ItemCode.required' => 'Item Code is required',
                    'ItemName.required' => 'Item Name is required'
                ]
            );
            DB::beginTransaction();
            $image = $request->file('image');
            $imageName = $request->item_image;
            if ($image) {
                $imageName = time() . '.' . $image->extension();
                $destinationPath = public_path('/thumbnail');
                File::makeDirectory($destinationPath, $mode = 0755, true, true);
                $img = Image::make($image->path());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imageName);
                $destinationPath = public_path('assets/images/items');
                $image->move($destinationPath, $imageName);
            }
            $data = array(
                'ItemCategoryID' => $request->input('category_id'),
                'BrandID' => $request->input('brand_id'),
                'ItemCode' => $request->input('ItemCode'),
                'ItemType' => $request->input('ItemType'),
                'ItemName' => $request->input('ItemName'),
                'ItemImage' => $imageName,
                'UnitID' => $request->input('unit_id'),
                // 'Taxable' => $request->input('Taxable'),
                // 'Percentage' => $request->input('Percentage'),
                // 'CostPrice' => $request->input('CostPrice'),
                // 'SellingPrice' => $request->input('SellingPrice'),
                // 'CostChartofAccountID' => $request->input('CostChartofAccountID'),
                // 'SellingChartofAccountID' => $request->input('SellingChartofAccountID'),
                // 'CostDescription' => $request->input('CostDescription'),
                // 'SellingDescription' => $request->input('SellingDescription'),
                // 'IsFeatured' => $request->input('isFeatured'),
                // 'IsActive' => $request->input('isActive')
            );
            Item::where('ItemID', $request->input('ItemID'))->update($data);
            DB::commit();
            return redirect('Item')->with('error', 'Updated Successfully.')->with('class', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withinput($request->all())->with('error', $e->getMessage())->with('class', 'danger');
        }
    }
    public  function ItemDelete($id)
    {
        try {
            ///////////////////////USER RIGHT & CONTROL ///////////////////////////////////////////
            $allow = check_role(session::get('UserID'), 'Item/Inventory', 'Delete');
            if ($allow[0]->Allow == 'N') {
                return redirect()->back()->with('error', 'You access is limited')->with('class', 'danger');
            }
            ////////////////////////////END SCRIPT ////////////////////////////////////////////////

            Item::where('ItemID', $id)->delete();
            return redirect('Item')->with('error', 'Deleted Successfully')->with('class', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->with('class', 'danger');
        }
    }

    public function addStockQuantity(Request $request)
    {
        try {
            $request->validate([
                'stockQuantity' => 'required|numeric'
            ]);
            // dump($request->all());
            DB::beginTransaction();
            $quantity = trim($request->stockQuantity);
            $item = Item::find($request->item_id);
            // dd($item);

            if ($quantity > 0) {
                $invoice_no = InvoiceMaster::select('InvoiceNo')
                    ->where('InvoiceNo', 'like', 'BILL%')
                    ->orderBy('InvoiceMasterID', 'desc')
                    ->first();
                if ($invoice_no)
                    $invoice_no = str_replace('BILL-', '', $invoice_no->InvoiceNo);
                else
                    $invoice_no = 0;
                ++$invoice_no;
                switch (strlen($invoice_no)) {
                    case 1:
                        $paddingZeros = '0000';
                        break;
                    case 2:
                        $paddingZeros = '000';
                        break;
                    case 3:
                        $paddingZeros = '00';
                        break;
                    case 4:
                        $paddingZeros = '0';
                        break;
                    default:
                        $paddingZeros = '';
                }
                $invoice_no = 'BILL-'  . $paddingZeros . $invoice_no;
                $today_date = date('Y-m-d');
                $reference_no = date("his");
                $price = trim($item->SellingPrice); // whether to store cost or selling price
                $subTotal = $price * $quantity;
                if ($item->Taxable == 'Yes') {
                    $tax = floatval((trim($item->Percentage) / 100) * $subTotal);
                    $grandTotal = floatval($subTotal + $tax);
                } else {
                    $tax = 0;
                    $grandTotal = $subTotal;
                }
                $invoice_mst = array(
                    'InvoiceNo' => $invoice_no,
                    'Date' => $today_date,
                    'DueDate' => $today_date,
                    'SupplierID' => $request->stSupplierID,
                    'WarehouseID' => $request->st_warehouse_id,
                    'WalkinCustomerName' => 'Walkin Customer',
                    'ReferenceNo' => $reference_no,
                    'PaymentMode' => 'Cash',
                    'SubTotal' => 0,
                    'DiscountPer' => 0,
                    'DiscountAmount' => 0,
                    'Total' => $subTotal,
                    'TotalQty' => $quantity,
                    'TaxPer' => $tax,
                    'Tax' => $tax,
                    'Shipping' => 0,
                    'GrandTotal' => $grandTotal,
                    'Paid' => 0,
                    'Balance' => $grandTotal,
                    'UserID' => Session::get('UserID'),
                );
                $invoiceMaster = InvoiceMaster::create($invoice_mst);
                // $invoiceMasterID = DB::table('invoice_master')->insertGetId($invoice_mst);
                $invoice_det = array(
                    'InvoiceMasterID' =>  $invoiceMaster->InvoiceMasterID,
                    'InvoiceNo' => $invoice_no,
                    'ItemID' => $item->ItemID,
                    'SupplierID' => $request->stSupplierID,
                    'Qty' => $quantity,
                    'Description' => $item->ItemName,
                    'TaxPer' => $tax,
                    'Tax' => $tax,
                    'Rate' => $price,
                    'Total' => $grandTotal
                );
                DB::commit();
                InvoiceDetail::create($invoice_det);
                return back()->with('error', 'Item Quantity Added Successfully')->with('class', 'success');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();
            return back()->with('error', $e->getMessage())->with('class', 'danger');

            //throw $th;
        }
    }
    public function ItemCategories()
    {
        $categories = ItemCategory::all();
        $options = [];

        foreach ($categories as $category) {
            $options[] = [
                'value' => $category->ItemCategoryID,
                'text' => $category->title,
            ];
        }

        return response()->json(['options' => $options]);
    }
    public function itemBrands()
    {
        $brands = Brand::all();
        $options = [];

        foreach ($brands as $brand) {
            $options[] = [
                'value' => $brand->id,
                'text' => $brand->title,
            ];
        }

        return response()->json(['options' => $options]);
    }
}
