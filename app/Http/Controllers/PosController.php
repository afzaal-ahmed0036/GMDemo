<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use NumberToWords\NumberToWords;
use App\Models\Warehouse;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\PosSetting;
use App\Models\Tax;
use App\Models\Payment;
use App\Models\Currency;
use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Http\Requests\StoreRequest;
use DNS1D;
use DNS2D;
use Keygen;
use Image;
use App\Models\Item;
use App\Models\Dish;
use App\Models\DishType;
use App\Models\DishTable;
use App\Models\InvoiceDishDetail;
use App\Models\ItemCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{


    public function printInvoice($InvoiceMasterID)
    {

        $lims_sale_data = DB::table('v_invoice_master')->where('InvoiceMasterID', $InvoiceMasterID)->first();
        $lims_product_sale_data = DB::table('v_invoice_detail')->where('InvoiceMasterID', $InvoiceMasterID)->get();
        $lims_biller_data = DB::table('user')->where('UserId', $lims_sale_data->UserID)->first();
        $lims_warehouse_data = Warehouse::find($lims_sale_data->WarehouseID);

        $lims_payment_data = Payment::where('InvoiceMasterID', $InvoiceMasterID)->get();

        $company = DB::table('company')->first();

        // $numberToWords = new NumberToWords();
        // if (\App::getLocale() == 'ar' || \App::getLocale() == 'hi' || \App::getLocale() == 'vi' || \App::getLocale() == 'en-gb')
        //     $numberTransformer = $numberToWords->getNumberTransformer('en');
        // else
        //     $numberTransformer = $numberToWords->getNumberTransformer(\App::getLocale());
        // $numberInWords = $numberTransformer->toWords($lims_sale_data->GrandTotal);


        return view('invoice.print_invoice', compact('lims_sale_data', 'lims_product_sale_data', 'lims_biller_data', 'lims_warehouse_data', 'lims_payment_data', 'company'));
    }



    public function liveKitchen(Request $request)
    {
        $pagetitle = 'Live Kitchen Screen';
        $invoice_dish_detail = InvoiceDishDetail::select(DB::raw('invoice_dish_details.id,name,image_thumbnail,quantity,invoice_dish_details.price,type,invoice_dish_details.status'))
            ->join('dishes', 'dishes.id', '=', 'invoice_dish_details.dish_id')
            ->join('dish_types', 'dish_types.id', '=', 'invoice_dish_details.dish_type_id')->get();
        if ($request->ajax()) {
            if (!empty($invoice_dish_detail)) {
                $html = '';
                foreach ($invoice_dish_detail as $invoice_dish) {
                    $html .= '<div class="col-sm-3">
                  <div class="card text-dark mb-3" style="width: 18rem;">
                    <div class="card-header card-title">' . $invoice_dish->name . '</div>';
                    if (!empty($invoice_dish->image_thumbnail) && !file_exists(public_path() . 'thumbnail/' . $invoice_dish->image_thumbnail)) {
                        $html .= '<img src="' . asset('thumbnail/' . $invoice_dish->image_thumbnail) . '" style="width: 18rem;">';
                    } else {
                        $html .= '<img src="' . asset('assets/images/product/noimage.jpg') . '" style="width: 18rem;">';
                    }

                    $html .= '<div class="card-body">
                      <p>' . $invoice_dish->type . '</p>
                      <p>Quantity : ' . $invoice_dish->quantity . '</p>
                      <p> <select class="form-select form-control-sm select2 dish_type_id" name="dish_type_id" id="dish_type_id">
                          <option value="Processing"';
                    if ($invoice_dish->status == 'Processing') {
                        $html .= 'selected="selected"';
                    }
                    $html .= 'data-value="' . $invoice_dish->id . '">Processing</option>
                          <option value="Cancelled" ';
                    if ($invoice_dish->status == 'Cancelled') {
                        $html .= 'selected="selected"';
                    }
                    $html .= 'data-value="' . $invoice_dish->id . '">Cancelled</option>
                          <option value="Completed"';
                    if ($invoice_dish->status == 'Completed') {
                        $html .= 'selected="selected"';
                    }
                    $html .= 'data-value="' . $invoice_dish->id . '">Completed</option>
                          <option value="Delivered"';
                    if ($invoice_dish->status == 'Delivered') {
                        $html .= 'selected="selected"';
                    }
                    $html .= 'data-value="' . $invoice_dish->id . '">Delivered</option>
                        </select></p></div></div></div>';
                }
            } else $html = '0';
            return $html;
        }

        return view('invoice.live-kitchen', compact('invoice_dish_detail', 'pagetitle'));
    }



    public function showInvoiceLiveKitchen(Request $request)
    {

        $invoice_master = DB::table('v_invoice_master')->select('v_invoice_master.InvoiceMasterID', 'v_invoice_master.InvoiceNo', 'v_invoice_master.DishTableID', 'v_invoice_master.PartyName')->distinct()
            ->join('invoice_dish_details', 'v_invoice_master.InvoiceMasterID', '=', 'invoice_dish_details.invoice_master_id')
            ->where('status', '=', 'Processing')->get();

        if ($request->ajax()) {
            $html = '0';
            if ($invoice_master->count() != '0') {
                $html = '<tr><th>Invoice Number</th><th>Table Number</th><th>Customer</th><th>Status</th></tr>';
                foreach ($invoice_master as $invoice) {
                    $html .= '<tr><td><a href="' . route('invoice.live.ktchen-details', $invoice->InvoiceMasterID) . '">' . $invoice->InvoiceNo . '</a></td><td>' . $invoice->DishTableID . '</td><td>' . $invoice->PartyName . '</td><td>Processing</td></tr>';
                }
            }
            return $html;
        }
        $pagetitle = 'Live Kitchen Screen';
        return view('invoice.show-invoice-live-kitchen', compact('invoice_master', 'pagetitle'));
    }

    public function invoiceLiveKitchenDetails($InvoiceMasterID)
    {
        $pagetitle = 'Live Kitchen Screen';
        $invoice_master = DB::table('invoice_master')->whereNotNull('DishTableID')->get();
        $lims_sale_data = DB::table('invoice_master')->select('InvoiceNo')->where('InvoiceMasterID', $InvoiceMasterID)->first();
        $invoice_detail = ''; //DB::table('invoice_detail')->where('InvoiceMasterID', $InvoiceMasterID)->get();
        $invoice_dish_detail = InvoiceDishDetail::where('invoice_master_id', $InvoiceMasterID)
            ->select(DB::raw('invoice_dish_details.id,name,quantity,invoice_dish_details.price,type,invoice_dish_details.status'))
            ->join('dishes', 'dishes.id', '=', 'invoice_dish_details.dish_id')
            ->join('dish_types', 'dish_types.id', '=', 'invoice_dish_details.dish_type_id')->get();
        $party = ''; //DB::table('party')->where('PartyID', $invoice_master->PartyID)->first();
        $payments            = ''; //Payment::where('InvoiceMasterID', $InvoiceMasterID)->first();
        return view('invoice.show-invoice-live-kitchen', compact('invoice_detail', 'invoice_master', 'party', 'invoice_dish_detail', 'lims_sale_data', 'pagetitle'));
    }

    public function invoiceCheckStatus($InvoiceMasterID)
    {
        $invoice_dish_detail = InvoiceDishDetail::where('invoice_master_id', $InvoiceMasterID)->where('status', 'Processing')->count();
        if (!empty($invoice_dish_detail) && $invoice_dish_detail > 0) {
            return true;
        }
        return $invoice_dish_detail;
    }

    public function invoiceStatus($id, $status)
    {
        $invoice_dish_detail = InvoiceDishDetail::find($id);
        $invoice_dish_detail->status = $status;
        $invoice_dish_detail->save();
        return $invoice_dish_detail;
    }



    public function wareHouseList(Request $request)
    {
        if ($request->ajax()) {
            $wareHouses = Warehouse::get();
            return Datatables::of($wareHouses)
                ->addIndexColumn()
                ->addColumn('no_of_prod', function ($row) {
                    $no_of_prod = DB::table('v_inventory')->where('WarehouseID', $row->id)->count('ItemID');
                    return $no_of_prod;
                })
                ->addColumn('stock_qty', function ($row) {
                    $stock_qty = DB::table('v_inventory')->where('WarehouseID', $row->id)->sum('Balance');
                    return $stock_qty;
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_active)
                        $status = 'Active';
                    else
                        $status = 'In-Active';
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit_warehouse" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2(`wareHouseDelete`,' . $row->id . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';

                    return $btn;
                })
                ->rawColumns(['no_of_prod', 'stock_qty', 'status', 'action'])
                ->make(true);
        }

        return view('warehouse_list');
    }

    public function storeWareHouse(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => [
                    'max:255',
                    Rule::unique('warehouses')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
            ],
            [
                'name.required' => 'WareHouse Name is required',
            ]
        );

        $input = $request->all();
        $input['is_active'] = true;
        Warehouse::create($input);
        return redirect('ware-house-list')->with('success', 'Saved Successfully');
    }

    public function getWarehouseDetail(Request $request)
    {
        $warehouse = Warehouse::findOrFail($request->warehouse_id);
        return response()->json($warehouse);
    }

    public function updateWareHouse(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => [
                    'max:255',
                    Rule::unique('warehouses')->ignore($request->warehouse_id)->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
            ],
            [
                'name.required' => 'WareHouse Name is required',
            ]
        );

        $input = $request->all();
        $lims_warehouse_data = Warehouse::find($input['warehouse_id']);
        $lims_warehouse_data->update($input);

        return redirect('ware-house-list')->with('success', 'Updated Successfully');
    }

    public function deleteWareHouse($id)
    {
        $lims_warehouse_data = Warehouse::find($id);
        $lims_warehouse_data->is_active = false;
        $lims_warehouse_data->save();
        return redirect('ware-house-list')->with('success', 'Deleted Successfully');
    }



    public function WareHouseOut(Request $request)
    {
        return view('warehouse.warehouseout');
    }

    public function WareHouseIn(Request $request)
    {
        return view('warehouse.warehousein');
    }

    public function ListWareHouseTransfers(Request $request)
    {
        $data = DB::table('v_warehouse_stock_transfer')->orderBy('InvoiceMasterID');
        return Datatables::of($data)
            ->addIndexColumn()->filter(function ($data) use ($request) {
                if ($request->get('warehouse') == 'out') {
                    $data->where('InvoiceNo', 'LIKE', "%WOUT%");
                } elseif ($request->get('warehouse') == 'in') {
                    $data->where('InvoiceNo', 'LIKE', "%WIN%");
                }
            })->addColumn('action', function ($row) {
                $btn = '<div class="d-flex align-items-center col-actions">
                <a href="' . URL('/BillView/' . $row->InvoiceMasterID) . '"><i class="font-size-18 mdi mdi-eye-outline align-middle me-1 text-secondary"></i></a></div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function stockWarehouseTransfer()
    {
        $warehouses = Warehouse::where('is_active', '1')->get();
        $pagetitle = 'Stock Warehouse Transfer';
        return view('warehouse.stockwarehousetransfer', compact('pagetitle', 'warehouses'));
    }

    public function fetchWareHouses(Request $request, $id)
    {
        if ($request->ajax()) {
            $warehouses = Warehouse::select('id', 'name')->where('is_active', '1')->where('id', '<>', $id)->get();
            $products   = DB::table('v_inventory')->select('ItemID', 'ItemName')->where('WarehouseID', $id)->get();
            $data['warehouses'] = $warehouses;
            $data['products']   = $products;
            return response()->json($data);
        }

        if ($request->ajax()) {
            $lims_product_warehouse_data = Item::join('v_inventory', 'item.ItemID', '=', 'v_inventory.ItemID')
                ->where([
                    ['v_inventory.WarehouseID', $id],
                    ['v_inventory.Balance', '>', 0]
                ])->select('v_inventory.*', 'item.*')->get();

            $dish_type_codes   = DishType::pluck('type', 'code')->toArray();
            $product_code      = [];
            $product_name      = [];
            $product_qty       = [];
            $product_price     = [];
            $product_data      = [];
            $product_type      = [];
            $product_id        = [];
            $product_list      = [];
            $qty_list          = [];
            $batch_no          = [];
            $product_batch_id  = [];
            //product without variant
            foreach ($lims_product_warehouse_data as $product_warehouse) {
                $product_qty[]      = $product_warehouse->Balance;
                $product_price[]    = $product_warehouse->price;
                //$lims_product_data = Item::where('ItemID', $product_warehouse->product_id)->first();
                $product_code[]     =  $product_warehouse->ItemCode;
                $product_name[]     = htmlspecialchars($product_warehouse->ItemName);
                $product_type[]     = 'standard'; //$lims_product_data->type;
                $product_id[]       = $product_warehouse->ItemID;
                $product_list[]     = null; //$lims_product_data->product_list;
                $qty_list[]         = null; //$lims_product_data->qty_list;
                $batch_no[]         = null;
                $product_batch_id[] = null;
            }

            foreach ($dish_type_codes as $code => $name) {
                $product_code[]    =  $code;
                $product_name[]    =  $name;
            }
            $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id];
            return $product_data;
        }
    }

    public function checkQty($warehouseid, $id)
    {
        $products   = DB::table('v_inventory')->select(DB::raw('QtyIn-QtyOut as qty'))->where('WarehouseID', $warehouseid)->where('ItemID', $id)->first();
        return response()->json($products);
    }

    public function getProductDetais1($warehouseid, $id)
    {
        $products   = DB::table('v_inventory')->select('ItemID', 'ItemName', DB::raw('QtyIn-QtyOut as qty'))->where('ItemID', $id)->where('WarehouseID', $warehouseid)->where('ItemID', $id)->first();
        $html = '<tr class="p-3">  <td class="p-1 bg-light borde-1 border-light text-center"></td><td><input type="hidden" value="' . $products->ItemID . '" name="product_id[]">' . $products->ItemName . '</td>';
        $html .= '<td><span class="stock_quantity_' . $products->ItemID . '">' . $products->qty . '</span></td>';
        $html .= '<td><input type="number" name="qty[' . $warehouseid . '][' . $products->ItemID . ']" id="qty_' . $products->ItemID . '" data-id="' . $warehouseid . '_' . $products->ItemID . '" class="form-control changesQuantityNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1" min="1" max="' . $products->qty . '"></td>';
        $html .= '<td><button class="btn btn-danger remove_field" type="button"><i class="bx bx-trash align-middle font-medium-3 me-20 remove_field"></i> Remove </button></td></tr>';
        return $html;
    }



    public function getProductDetais(Request $request, $warehouseid)
    {
        $ItemCode           = $request->get('data');
        $todayDate          = date('Y-m-d');
        $product_code       = explode("(", $ItemCode);
        $product_code[0]    = rtrim($product_code[0], " ");
        $product_variant_id = null;




        $lims_product_data  = DishType::where('code', $product_code[0])->first();
        if ($lims_product_data) {
            $qty   = DB::table('v_inventory')->select('Balance')->where('WarehouseID', $warehouseid)
                ->where('ItemID', $lims_product_data->id)->pluck('Balance')->first();

            $product[] = $lims_product_data->type;
            $product[] = $lims_product_data->code;
            $product[] = $lims_product_data->price;
            $product[] = 0;
            $product[] = 'No Tax';
            $product[] = 1;
            if (1) {
                $unit_name = ['piece', 'carton', '12piece container', '24pc cnt', '36pc cntr', '48pc cntr', 'test unit upd'];
                $unit_operator = ['*', '*', '*', '*', '*', '*', '*'];
                $unit_operation_value = ['1', '12', '12', '24', '36', '48', '12'];
                $product[] = implode(",", $unit_name) . ',';
                $product[] = implode(",", $unit_operator) . ',';
                $product[] = implode(",", $unit_operation_value) . ',';
            } else {
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
            }
            $product[] = $lims_product_data->id;
            $product[] = $product_variant_id;
            $product[] = null;
            $product[] = $qty;
            $product[] = 'dishItem';
        } else {
            $lims_product_data = Item::where('ItemCode', $product_code[0])->first();

            $qty   = DB::table('v_inventory')->select('Balance')->where('WarehouseID', $warehouseid)
                ->where('ItemID', $lims_product_data->ItemID)->pluck('Balance')->first();

            $product[] = $lims_product_data->ItemName;
            $product[] = $lims_product_data->ItemCode;

            $product[] = $lims_product_data->SellingPrice;

            if ($lims_product_data->Taxable == 'Yes') {
                $product[]     = $lims_product_data->Percentage;
                $product[]     = 'unregistered ';
            } else {
                $product[] = 0;
                $product[] = 'No Tax';
            }
            $product[] = 1;
            if (1) {
                $unit_name = ['piece', 'carton', '12piece container', '24pc cnt', '36pc cntr', '48pc cntr', 'test unit upd'];
                $unit_operator = ['*', '*', '*', '*', '*', '*', '*'];
                $unit_operation_value = ['1', '12', '12', '24', '36', '48', '12'];
                $product[] = implode(",", $unit_name) . ',';
                $product[] = implode(",", $unit_operator) . ',';
                $product[] = implode(",", $unit_operation_value) . ',';
            } else {
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
                $product[] = 'n/a' . ',';
            }
            $product[] = $lims_product_data->ItemID;
            $product[] = $product_variant_id;
            $product[] = null;
            $product[] = $qty;
            $product[] = 'posItem';
        }

        return $product;
    }

    public function runQuery()
    {
        DB::statement("ALTER TABLE `invoice_master` ADD `otherWareHouseID` INT NULL AFTER `WarehouseID`");
        dd(DB::statement("CREATE VIEW v_warehouse_stock_transfer AS select `extbooks_accounting`.`invoice_master`.`InvoiceMasterID` AS `InvoiceMasterID`,`extbooks_accounting`.`invoice_master`.`WarehouseID` AS `WarehouseID`,`extbooks_accounting`.`warehouses`.`name` AS `WarehouseName`,w.name as otherWareHouse,`extbooks_accounting`.`invoice_master`.`Date` AS `Date`,`extbooks_accounting`.`invoice_master`.`UserID` AS `UserID`,`extbooks_accounting`.`invoice_master`.`PaymentMode` AS `PaymentMode`,`extbooks_accounting`.`invoice_master`.`InvoiceNo` AS `InvoiceNo`,`extbooks_accounting`.`invoice_master`.`TotalQty`,`extbooks_accounting`.`invoice_master`.`CustomerNotes` AS `CustomerNotes`,`extbooks_accounting`.`invoice_master`.`Subject` AS `Subject`,`extbooks_accounting`.`invoice_master`.`WalkinCustomerName` AS `WalkinCustomerName`,`extbooks_accounting`.`invoice_master`.`DescriptionNotes` AS `DescriptionNotes`
        from  `extbooks_accounting`.`invoice_master`
        INNER JOIN `extbooks_accounting`.`warehouses` ON `extbooks_accounting`.`warehouses`.`id` = `extbooks_accounting`.`invoice_master`.`WarehouseID`
        INNER JOIN `extbooks_accounting`.`warehouses` as w ON w.`id` = `extbooks_accounting`.`invoice_master`.`otherWareHouseID`
        WHERE InvoiceNo LIKE 'WIN%' OR InvoiceNo LIKE 'WOUT%'
        order by `extbooks_accounting`.`invoice_master`.`InvoiceMasterID`"));
    }

    public function demoCards()
    {
        $pagetitle = 'Cards Demo';
        return view('warehouse.cards', compact('pagetitle'));
    }


    public function postStockWarehouseTransfer(StoreRequest $request)
    {
        try {
            if ($request->has('qty')) {
                $productsIds = $request->qty;
                $transferedQuantity = 0;
                /* foreach ($productsIds as $ids => $quantity) {
                    $transferedQuantity = $transferedQuantity + $quantity;
                } */
                $InvoiceNo  = DB::table('invoice_master')->where('InvoiceNo', 'like', 'WOUT%')->count();
                $invoice_no = 'WOUT-0000' . ++$InvoiceNo;
                $today_date = date('Y-m-d');
                $biller_id  = Session::get('UserID');
                /* INSET OUT ENTRY IN INVOICE MASTER */
                $invoice_data = array(
                    "InvoiceNo"          => $invoice_no,
                    "ReferenceNo"        => null,
                    "Date"               => $today_date,  // focus
                    "DueDate"            => $today_date, // focus
                    "PartyID"            => null,
                    "WarehouseID"        => $request->from_warehouse_id,
                    "otherWareHouseID"   => $request->to_warehouse_id,
                    "DishTableID"        => null,
                    "WalkinCustomerName" => null,
                    "UserID"             => $biller_id,
                    "DescriptionNotes"   => null, // focus
                    "CustomerNotes"      => null, // focus
                    "Tax"                => null,
                    "TaxPer"             => null,
                    "Paid"               => null,
                    "Balance"            => null,
                    "TotalQty"           => $transferedQuantity,
                    "SubTotal"           => null,
                    "PaymentMode"        => 'Cash', // focus
                    "DiscountModel"      => 'percentage',
                    "DiscountPer"        => null,
                    "DiscountAmount"     => null,
                    "Shipping"           => null,
                    "GrandTotal"         => null,
                    "Total"              => null
                );

                $InvoiceMasterOutID = DB::table('invoice_master')->insertGetId($invoice_data);
                $InvoiceNo      = DB::table('invoice_master')->where('InvoiceNo', 'like', 'WIN%')->count();
                $invoice_in_no     = 'WIN-0000' . ++$InvoiceNo;

                $invoice_data = array(
                    "InvoiceNo"          => $invoice_in_no,
                    "ReferenceNo"        => null,
                    "Date"               => $today_date,  // focus
                    "DueDate"            => $today_date, // focus
                    "PartyID"            => null,
                    "WarehouseID"        => $request->to_warehouse_id,
                    "otherWareHouseID"   => $request->from_warehouse_id,
                    "DishTableID"        => null,
                    "WalkinCustomerName" => null,
                    "UserID"             => $biller_id,
                    "DescriptionNotes"   => null, // focus
                    "CustomerNotes"      => null, // focus
                    "Tax"                => null,
                    "TaxPer"             => null,
                    "Paid"               => null,
                    "Balance"            => null,
                    "TotalQty"           => $transferedQuantity,
                    "SubTotal"           => null,
                    "PaymentMode"        => 'Cash', // focus
                    "DiscountModel"      => 'percentage',
                    "DiscountPer"        => null,
                    "DiscountAmount"     => null,
                    "Shipping"           => null,
                    "GrandTotal"         => null,
                    "Total"              => null,

                );

                $InvoiceMasterInID = DB::table('invoice_master')->insertGetId($invoice_data);
                $total_qty         = 0;
                foreach ($productsIds as $ids => $quantity) {
                    $item_name = DB::table('item')->where('ItemID', $ids)->pluck('ItemName')->first();
                    $prod_qty  = $quantity;
                    $invoice_detailOut = array(
                        "InvoiceMasterID" => $InvoiceMasterOutID,
                        "InvoiceNo"       => $invoice_no,
                        "ItemID"          => $ids,
                        "Description"     => $item_name,
                        "PartyID"         => null,
                        "Qty"             => $prod_qty,
                        "Rate"            => null,
                        "TaxPer"          => null,
                        "Tax"             => null,
                        "Total"           => null,
                    );
                    DB::table('invoice_detail')->insert($invoice_detailOut);
                    $invoice_detailIn = array(
                        "InvoiceMasterID" => $InvoiceMasterInID,
                        "InvoiceNo"       => $invoice_in_no,
                        "ItemID"          => $ids,
                        "Description"     => $item_name,
                        "PartyID"         => null,
                        "Qty"             => $prod_qty,
                        "Rate"            => null,
                        "TaxPer"          => null,
                        "Tax"             => null,
                        "Total"           => null,
                    );
                    $total_qty = $total_qty + $prod_qty;

                    DB::table('invoice_detail')->insert($invoice_detailIn);
                }
                InvoiceMaster::where('InvoiceMasterID', '=', $InvoiceMasterOutID)->update(['TotalQty' => $total_qty]);
                InvoiceMaster::where('InvoiceMasterID', '=', $InvoiceMasterInID)->update(['TotalQty' => $total_qty]);
            }
            session()->flash('success', 'Stock has been updated successfully.');
            return true;
        } catch (\Exception $exception) {
            session()->flash('error', 'Something went Wrong, Try again later');
            return false;
        }
    }


    public function brandList(Request $request)
    {
        if ($request->ajax()) {
            $lims_brand_all = Brand::where('is_active', true)->get();
            return Datatables::of($lims_brand_all)
                ->addIndexColumn()
                ->addColumn('brand_img', function ($row) {
                    if ($row->image)
                        $brand_img = '<td><img src="' . url('thumbnail', $row->image) . '"></td>';
                    else
                        $brand_img = '<td><img src="' . url('assets/images/product/zummXD2dvAtI.png') . '" height="100" width="100"></td>';

                    return $brand_img;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit_brand" data-id="' . $row->id . '"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2(`brandDelete`,' . $row->id . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';

                    return $btn;
                })
                ->rawColumns(['brand_img', 'action'])
                ->make(true);
        }

        return view('brand_list');
    }

    public function storeBrand(Request $request)
    {
        // dd($request->all());
        $request->title = preg_replace('/\s+/', ' ', $request->title);

        $this->validate(
            $request,
            [
                'title' => [
                    'max:255',
                    Rule::unique('brands')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],

                // 'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
            ],
            [
                'title.required' => 'Brand title is required',
                // 'image.required' => 'Image is required',
            ]
        );

        $input = $request->except('image');
        $input['is_active'] = true;
        $image = $request->file('image');
        if ($image) {
            // dd($image);
            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
            $destinationPath = public_path('assets/images/brand');
            $image->move($destinationPath, $imageName);
            $input['image'] = $imageName;
        }
        $data = Brand::create($input);
        if (isset($request->value_ajax)) {
            return response()->json(['message' => 'Brand Added Successfully', 'data' => $data]);
        } else {
            return redirect('brand-list')->with('success', 'Saved Successfully');
        }
    }

    public function getBrandDetail(Request $request)
    {
        $brand = Brand::findOrFail($request->brand_id);
        return response()->json($brand);
    }

    public function updateBrand(Request $request)
    {
        $this->validate($request, [
            'title' => [
                'max:255',
                Rule::unique('brands')->ignore($request->brand_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            // 'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);
        $lims_brand_data = Brand::findOrFail($request->brand_id);
        $lims_brand_data->title = $request->title;
        $image = $request->file('image');
        if ($image) {

            $imageName = time() . '.' . $image->extension();
            $destinationPath = public_path('/thumbnail');
            $img = Image::make($image->path());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $imageName);
            $destinationPath = public_path('assets/images/brand');
            $image->move($destinationPath, $imageName);

            $lims_brand_data->image = $imageName;
        }
        $lims_brand_data->save();
        return redirect('brand-list')->with('success', 'Saved Successfully');
    }

    public function deleteBrand($id)
    {
        $lims_brand_data = Brand::findOrFail($id);
        $lims_brand_data->is_active = false;
        $lims_brand_data->save();
        return redirect('brand-list')->with('success', 'Deleted Successfully');
    }

    public function unitList(Request $request)
    {
        $lims_unit_all = Unit::get();
        if ($request->ajax()) {
            return Datatables::of($lims_unit_all)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 1)
                        $status = 'Active';
                    else
                        $status = 'In Active';

                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit_unit" data-id="' . $row->id . '"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2(`unitDelete`,' . $row->id . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('unit_list', compact('lims_unit_all'));
    }

    public function storeUnit(Request $request)
    {
        $this->validate($request, [
            'base_unit' => [
                'max:255',
                Rule::unique('units')->where(function ($query) {
                    return $query->where('status', 1);
                }),
            ]

        ]);
        $input = $request->all();
        Unit::create($input);
        return redirect('unit-list')->with('success', 'Saved Successfully');
    }

    public function getUnitDetail(Request $request)
    {
        $lims_unit_data = Unit::findOrFail($request->unit_id);
        return response()->json($lims_unit_data);
    }

    public function updateUnit(Request $request)
    {
        $this->validate($request, [
            'base_unit' => [
                'max:255',
                Rule::unique('units')->ignore($request->unit_id)->where(function ($query) {
                    return $query->where('status', 1);
                }),
            ]

        ]);

        $input = $request->all();
        $lims_unit_data = Unit::where('id', $input['unit_id'])->first();
        $lims_unit_data->update($input);
        return redirect('unit-list')->with('success', 'Saved Successfully');
    }

    public function deleteUnit($id)
    {
        $lims_unit_data = Unit::findOrFail($id);
        $lims_unit_data->delete();
        return redirect('unit-list')->with('success', 'Deleted Successfully');
    }

    public function itemCategoryList(Request $request)
    {
        $item_categories = DB::table('item_category')->get();
        if ($request->ajax()) {
            return Datatables::of($item_categories)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image)
                        $image = '<img src="' . url('thumbnail', $row->image) . '">';
                    else
                        $image = '<img src="' . url('assets/images/product/zummXD2dvAtI.png') . '" height="100" width="100">';
                    return $image;
                })
                ->addColumn('parent_cat', function ($row) {
                    if ($row->ParentID)
                        $parent = DB::table('item_category')->where('ItemCategoryID', $row->ParentID)->pluck('title')->first();
                    else
                        $parent = "N/A";
                    return $parent;
                })
                ->addColumn('number_of_product', function ($row) {
                    $number_of_product = DB::table('item')->where('ItemCategoryID', $row->ItemCategoryID)->where('IsActive', true)->count();
                    return @$number_of_product;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit_category" data-id="' . $row->ItemCategoryID . '"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2(`itemCategoryDelete`,' . $row->ItemCategoryID . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';
                    return $btn;
                })
                ->rawColumns(['image', 'parent_cat', 'number_of_product', 'stock_qty', 'stock_worth', 'action'])
                ->make(true);
        }
        return view('item.item_category_list', compact('item_categories'));
    }
    public function getItemCategoryDetail(Request $request)
    {
        $lims_category_data = DB::table('item_category')->where('ItemCategoryID', $request->cat_id)->first();
        $parent_id = DB::table('item_category')->where('ItemCategoryID', $lims_category_data->ParentID)->pluck('ItemCategoryID')->first();
        return response()->json([
            'lims_category_data' => $lims_category_data,
            'parent_id' => $parent_id,
        ]);
    }

    public function storeItemCategory(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'itemCategoryName' => [
                'required',
                'max:255',
                Rule::unique('item_category', 'title')->where(function ($query) use ($request) {
                    return $request->input('is_active') == 1;
                }),
            ],
            'categoryImage' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
        try {
            DB::beginTransaction();
            $category_name = preg_replace('/\s+/', ' ', $request->itemCategoryName);
            $image = $request->file('categoryImage');
            if ($image) {

                $imageName = time() . '.' . $image->extension();
                $destinationPath = public_path('/thumbnail');
                $img = Image::make($image->path());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imageName);

                $destinationPath = public_path('assets/images/category');
                $image->move($destinationPath, $imageName);
            } else {
                $imageName = null;
            }

            $data = array(
                "ParentID" => $request->parent_id,
                "title" => $category_name,
                "image" => $imageName,
                "type" => $request->type,
                "IsActive" => true,
            );

            $data = ItemCategory::create($data);
            DB::commit();
            if (isset($request->value_ajax)) {
                return response()->json(['message' => 'Item Category Added Successfully', 'data' => $data]);
            } else {
                return redirect('item-category-list')->with('success', 'Saved Successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
            //throw $th;
        }
    }

    public function updateItemCategory(Request $request)
    {
        $request->validate([
            'editItemCategoryName' => [
                'required',
                'max:255',
                Rule::unique('item_category', 'title')->where(function ($query) use ($request) {
                    return $request->input('is_active') == 1;
                }),
            ],
            'editCategoryImage' => 'image|mimes:jpg,jpeg,png,gif',
        ]);
        try {
            DB::beginTransaction();
            $category_name = preg_replace('/\s+/', ' ', $request->editItemCategoryName);
            $input = $request->except('editCategoryImage');
            $image = $request->file('editCategoryImage');
            if ($image) {
                $imageName = time() . '.' . $image->extension();
                $destinationPath = public_path('/thumbnail');
                $img = Image::make($image->path());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imageName);

                $destinationPath = public_path('assets/images/category');
                $image->move($destinationPath, $imageName);

                $data = array(
                    "ParentID" => $request->edit_parent_id,
                    "title" => $category_name,
                    "image" => $imageName,
                    "type" => $request->edit_type,
                );
            } else {
                $data = array(
                    "ParentID" => $request->edit_parent_id,
                    "title" => $category_name,
                    "type" => $request->edit_type,
                );
            }
            ItemCategory::find($request->itemCategoryId)->update($data);
            return redirect('item-category-list')->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
            //throw $th;
        }
    }

    public function deleteItemCategory($id)
    {
        try {
            DB::beginTransaction();
            ItemCategory::find($id)->delete();
            DB::commit();
            return redirect('item-category-list')->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
            //throw $th;
        }
    }


    public function currencyList(Request $request)
    {
        if ($request->ajax()) {
            $currencies = Currency::get();
            return Datatables::of($currencies)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit_currency" data-id="' . $row->id . '"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2(`currencyDelete`,' . $row->id . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('currency_list');
    }

    public function storeCurrency(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'exchange_rate' => 'required',
        ]);

        $data = $request->all();
        Currency::create($data);
        return redirect('currency-list')->with('success', 'Currency Saved Successfully');
    }

    public function getCurrencyDetail(Request $request)
    {
        $lims_currency_data = Currency::findOrFail($request->currency_id);
        return response()->json($lims_currency_data);
    }

    public function updateCurrency(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'exchange_rate' => 'required',
        ]);

        $data = $request->all();
        Currency::find($data['currency_id'])->update($data);
        return redirect('currency-list')->with('success', 'Currency Updated Successfully');
    }

    public function deleteCurrency($id)
    {
        Currency::find($id)->delete();
        return redirect('currency-list')->with('success', 'Currency Deleted Successfully');
    }

    public function taxList(Request $request)
    {
        if ($request->ajax()) {
            $lims_tax_all = Tax::where('is_active', true)->get();
            return Datatables::of($lims_tax_all)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit_tax" data-id="' . $row->id . '"><i class="bx bx-pencil align-middle me-1"></i></a> <a href="#" onclick="delete_confirm2(`taxDelete`,' . $row->id . ')"><i class="bx bx-trash  align-middle me-1"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tax_list');
    }

    public function storeTax(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('taxes')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'rate' => 'numeric|min:0|max:100',

        ]);
        $input = $request->all();
        $input['is_active'] = true;
        Tax::create($input);
        return redirect('tax-list')->with('success', 'Saved Successfully');
    }

    public function getTaxDetail(Request $request)
    {
        $lims_tax_data = Tax::findOrFail($request->tax_id);
        return response()->json($lims_tax_data);
    }

    public function updateTax(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('taxes')->ignore($request->tax_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'rate' => 'numeric|min:0|max:100'
        ]);

        $input = $request->all();
        $lims_tax_data = Tax::where('id', $input['tax_id'])->first();
        $lims_tax_data->update($input);
        return redirect('tax-list')->with('success', 'Updated Successfully');
    }

    public function deleteTax($id)
    {
        $lims_tax_data = Tax::findOrFail($id);
        $lims_tax_data->is_active = false;
        $lims_tax_data->save();
        return redirect('tax-list')->with('success', 'Deleted Successfully');
    }

    public function posSetting()
    {
        $lims_customer_list = DB::table('party')->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_supplier_list = DB::table('supplier')->get();
        $lims_pos_setting_data = PosSetting::latest()->first();
        return view('pos_setting', compact('lims_customer_list', 'lims_warehouse_list', 'lims_pos_setting_data', 'lims_supplier_list'));
    }

    public function storePosSetting(Request $request)
    {
        $data = $request->all();
        //writting paypal info in .env file
        $path = '.env';
        $searchArray = array('PAYPAL_LIVE_API_USERNAME=' . env('PAYPAL_LIVE_API_USERNAME'), 'PAYPAL_LIVE_API_PASSWORD=' . env('PAYPAL_LIVE_API_PASSWORD'), 'PAYPAL_LIVE_API_SECRET=' . env('PAYPAL_LIVE_API_SECRET'));

        $replaceArray = array('PAYPAL_LIVE_API_USERNAME=' . $data['paypal_username'], 'PAYPAL_LIVE_API_PASSWORD=' . $data['paypal_password'], 'PAYPAL_LIVE_API_SECRET=' . $data['paypal_signature']);

        // file_put_contents($path, str_replace($searchArray, $replaceArray, file_get_contents($path)));

        $pos_setting = PosSetting::firstOrNew(['id' => 1]);
        $pos_setting->id = 1;
        $pos_setting->customer_id = $data['customer_id'];
        $pos_setting->warehouse_id = $data['warehouse_id'];
        $pos_setting->supplier_id = $data['supplier_id'];
        $pos_setting->product_number = $data['product_number'];
        $pos_setting->stripe_public_key = $data['stripe_public_key'];
        $pos_setting->stripe_secret_key = $data['stripe_secret_key'];
        $pos_setting->is_dish_enabled = $data['is_dish_enabled'];
        if (!isset($data['keybord_active']))
            $pos_setting->keybord_active = false;
        else
            $pos_setting->keybord_active = true;
        $pos_setting->save();
        return redirect('pos-setting')->with('success', 'Updated Successfully');
    }

    public function storeParty(Request $request)
    {
        // dd($request->all());
        // $this->validate($request, [
        //     'phone_number' => 'required|unique:party,Phone',
        // ]);
        $data = DB::table('party')->where('Phone', $request->phone_number)->first();
        if ($data) {
            $message = "User Already Exist";
            return response()->json(['data' => $data, 'message' => $message]);
        } else {
            $lims_customer_data = $request->all();
            $party_data = array(
                "CustomerGroupID" => $lims_customer_data['customer_group_id'],
                "PartyName" => $lims_customer_data['party_name'],
                "Email" => $lims_customer_data['party_email'],
                "Phone" => $lims_customer_data['phone_number'],
                "Mobile" => $lims_customer_data['phone_number'],
                "Address" => $lims_customer_data['address'],
                "Active" => 'Yes',
            );
            DB::table('party')->insert($party_data);
            $data = DB::table('party')->where('Phone', $request->phone_number)->first();
            $message = "User Created Successfully";
            return response()->json(['data' => $data, 'message' => $message]);
        }

        // if ($lims_customer_data['pos'])
        //     return redirect('create-voucher')->with('error', 'Customer Saved Successfully');
        // else
        //     return redirect()->back()->with('error', 'Something Went Wrong');
    }

    public function printBarcode()
    {
        // $lims_product_list_without_variant = $this->productWithoutVariant();
        // $lims_product_list_with_variant = $this->productWithVariant();
        $lims_product_list_without_variant = DB::table('item')->where([['IsActive', true], ['ItemType', 'standard']])->select('ItemID', 'ItemName', 'ItemCode')->get();
        return view('print_barcode', compact('lims_product_list_without_variant'));
    }

    public function printBarcodes()
    {
        // $lims_product_list_without_variant = $this->productWithoutVariant();
        // $lims_product_list_with_variant = $this->productWithVariant();
        $lims_product_list_without_variant = DB::table('item')->where([['IsActive', true], ['ItemType', 'Goods']])->select('ItemID', 'ItemName', 'ItemCode')->get();
        return view('print_barcodes', compact('lims_product_list_without_variant'));
    }
    public function limsStickerSearch(Request $request)
    {
        foreach ($request['code'] as $key => $product) {
            $item = Item::where('ItemCode', 'like', '%' . $product . '%')->first();

            $data = array(
                "qty" => $request['qty'][$key],
                "itemid" => $product,
                'price' => $item->SellingPrice,
                'itemName' => $item->ItemName,
            );
            $sticker = DB::table('sticker')->insert($data);
        }

        return response()->json(['url' => url('products/lims_sticker_print')]);



        // return $product;
    }

    public function limsStickerPrint()
    {

        $stickerxy = DB::table('sticker')->get();
        // dd($stickerxy);
        $companyName = DB::table('company')->first();
        //return view('printbarcodedata',compact('stickerxy','companyName'));
        //$pdf = PDF::loadView('printbarcodedata', compact('stickerxy'));

        $pdf = PDF::loadView('printbarcodedata', compact('stickerxy', 'companyName'));
        $customPaper = array(0, 0, 108.744, 70.866); // 2.85 cm to points and 4 cm to points


        //$customPaper = array(0, 0, 151, 116);
        $pdf->set_paper($customPaper);

        DB::table('sticker')->truncate();
        return $pdf->stream();
    }

    // public function productWithoutVariant()
    // {
    //     return Product::ActiveStandard()->select('id', 'name', 'code')
    //             ->whereNull('is_variant')->get();
    // }

    // public function productWithVariant()
    // {
    //     return Product::join('product_variants', 'products.id', 'product_variants.product_id')
    //             ->ActiveStandard()
    //             ->whereNotNull('is_variant')
    //             ->select('products.id', 'products.name', 'product_variants.item_code')
    //             ->orderBy('position')->get();
    // }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        $lims_product_data = DB::table('item')->where('ItemCode', $product_code[0])->first();
        // if(!$lims_product_data) {
        //     $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
        //         ->select('products.*', 'product_variants.item_code')
        //         ->where('product_variants.item_code', $product_code[0])
        //         ->first();
        // }
        $product[] = $lims_product_data->ItemName;
        // if($lims_product_data->is_variant)
        //     $product[] = $lims_product_data->item_code;
        // else
        //     $product[] = $lims_product_data->code;

        $barcode_symbology = 'C128';

        $product[] = $lims_product_data->ItemCode;
        $product[] = $lims_product_data->SellingPrice;
        $product[] = DNS1D::getBarcodePNG($lims_product_data->ItemCode, $barcode_symbology);
        $product[] = $lims_product_data->SellingPrice; // promotional price replaced by selling price
        $product[] = config('currency');
        $product[] = config('currency_position');
        return $product;
    }

    public function generateCode()
    {
        $id = Keygen::numeric(8)->generate();
        return $id;
    }

    public function testList(Request $request)
    {

        return view('test_list');
    }
    public function getUpdatedCustomers()
    {
        $customers = DB::table('party')->get(); // Replace YourModel with the actual model you're using
        $options = [];

        foreach ($customers as $customer) {
            $options[] = [
                'value' => $customer->PartyID,
                'text' => $customer->PartyName . ' (' . $customer->Mobile . ')',
            ];
        }

        return response()->json(['options' => $options]);
    }
}
