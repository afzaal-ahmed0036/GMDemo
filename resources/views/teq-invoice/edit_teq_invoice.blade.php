@extends('template.tmp')
@section('title', 'Edit Invoice')

@push('after-styles')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- multipe image upload  -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<style>

    .edit_footer{
        position: fixed;
        bottom: 0px;
        width: 76%;
        background: #2a2f42;
        color: #97a1be;
        z-index: 99999;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.47rem 0.75rem;
        font-size: .8125rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0rem !important;
        -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;

    }




    .form-select {
        display: block;
        width: 100%;
        padding: 0.47rem 1.75rem 0.47rem 0.75rem;
        font-size: .8125rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e);
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0rem !important;
    }

    .select2-container .select2-selection--single {
        background-color: #fff;
        border: 1px solid #ced4da;
        height: 38px
    }

    .select2-container .select2-selection--single:focus {
        outline: 0
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: .75rem;
        color: #495057
    }

    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 34px;
        width: 34px;
        right: 3px
    }

    .select2-container .select2-selection--single .select2-selection__arrow b {
        border-color: #adb5bd transparent transparent transparent;
        border-width: 6px 6px 0 6px
    }

    .select2-container .select2-selection--single .select2-selection__placeholder {
        color: #495057
    }

    .select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #adb5bd transparent !important;
        border-width: 0 6px 6px 6px !important
    }

    .select2-container--default .select2-search--dropdown {
        /*padding: 10px;*/
        background-color: #fff
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da;
        background-color: #fff;
        color: #74788d;
        outline: 0
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #556ee6
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        /*background-color: #f8f9fa;*/
        /*color: #343a40*/
    }

    .select2-container--default .select2-results__option[aria-selected=true]:hover {
        background-color: #556ee6;
        color: #fff
    }

    .select2-results__option {
        padding: 6px 12px
    }

    .select2-container[dir=rtl] .select2-selection--single .select2-selection__rendered {
        padding-left: .75rem
    }

    .select2-dropdown {
        border: 1px solid rgba(0, 0, 0, .15);
        background-color: #fff;
        -webkit-box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03);
        box-shadow: 0 .75rem 1.5rem rgba(18, 38, 63, .03)
    }

    .select2-search input {
        border: 1px solid #f6f6f6
    }

    .select2-container .select2-selection--multiple {
        min-height: 38px;
        background-color: #fff;
        border: 1px solid #ced4da !important
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        padding: 2px .75rem
    }

    .select2-container .select2-selection--multiple .select2-search__field {
        border: 0;
        color: #495057
    }

    .select2-container .select2-selection--multiple .select2-search__field::-webkit-input-placeholder {
        color: #495057
    }

    .select2-container .select2-selection--multiple .select2-search__field::-moz-placeholder {
        color: #495057
    }

    .select2-container .select2-selection--multiple .select2-search__field:-ms-input-placeholder {
        color: #495057
    }

    .select2-container .select2-selection--multiple .select2-search__field::-ms-input-placeholder {
        color: #495057
    }

    .select2-container .select2-selection--multiple .select2-search__field::placeholder {
        color: #495057
    }

    .select2-container .select2-selection--multiple .select2-selection__choice {
        background-color: #eff2f7;
        border: 1px solid #f6f6f6;
        border-radius: 1px;
        padding: 0 7px
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #ced4da
    }

    .select2-container--default .select2-results__group {
        font-weight: 600
    }

    .select2-result-repository__avatar {
        float: left;
        width: 60px;
        margin-right: 10px
    }

    .select2-result-repository__avatar img {
        width: 100%;
        height: auto;
        border-radius: 2px
    }

    .select2-result-repository__statistics {
        margin-top: 7px
    }

    .select2-result-repository__forks,
    .select2-result-repository__stargazers,
    .select2-result-repository__watchers {
        display: inline-block;
        font-size: 11px;
        margin-right: 1em;
        color: #adb5bd
    }

    .select2-result-repository__forks .fa,
    .select2-result-repository__stargazers .fa,
    .select2-result-repository__watchers .fa {
        margin-right: 4px
    }

    .select2-result-repository__forks .fa.fa-flash::before,
    .select2-result-repository__stargazers .fa.fa-flash::before,
    .select2-result-repository__watchers .fa.fa-flash::before {
        content: "\f0e7";
        font-family: 'Font Awesome 5 Free'
    }

    .select2-results__option--highlighted .select2-result-repository__forks,
    .select2-results__option--highlighted .select2-result-repository__stargazers,
    .select2-results__option--highlighted .select2-result-repository__watchers {
        color: rgba(255, 255, 255, .8)
    }

    .select2-result-repository__meta {
        overflow: hidden
    }

    .qty {
        width: 100px !important;

    }
</style>

@endpush
@section('content')
<div class="main-content">
    <div class="page-content">
        <section class="forms">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h4>{{trans('file.Update Sale')}}</h4>
                            </div>
                            <div class="card-body">
                                <!-- <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p> -->
                                <form action="{{route('teqInvoice.update', ['id' => $lims_sale_data->InvoiceMasterID])}}" method="post" id="payment-form" enctype="multipart/form-data" >
                                    @csrf



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{trans('file.reference')}} : <strong>{{ $lims_sale_data->ReferenceNo }}</strong></label>
                                                        <p></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                        <label>{{trans('file.User')}} : <strong>{{ $biller ? $biller->FullName : Session::get('FullName') }}</strong></label>
                                                        <input type="hidden" name="biller_id_hidden" value="{{$lims_sale_data->SupplierID}}" />
                                                        <input type="hidden" name="biller_id" value="{{$lims_sale_data->UserID}}" />
                                                        <p></p>
                                                        <!-- <select required name="biller_id" class="form-select select2" data-live-search="true" data-live-search-style="begins" title="Select Biller...">
                                                            @foreach($lims_biller_list as $biller)
                                                            <option value="{{$biller->UserID}}" {{$lims_sale_data->UserID == $biller->UserID ? 'selected' : ''}}>{{$biller->FullName}}</option>
                                                            @endforeach
                                                        </select> -->
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Warehouse')}} *</label>
                                                        <input type="hidden" name="warehouse_id_hidden" value="{{$lims_sale_data->WarehouseID}}" />
                                                        <select required id="warehouse_id" name="warehouse_id" class="form-select select2" onchange="getWarehouseDetail(this.value)" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                                            @foreach($lims_warehouse_list as $warehouse)
                                                            <option value="{{$warehouse->id}}" {{$lims_sale_data->WarehouseID == $warehouse->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{trans('file.customer')}} *</label>
                                                        <input type="hidden" name="customer_id_hidden" value="{{ $lims_sale_data->PartyID }}" />
                                                        <select required name="customer_id" class="form-select select2" onchange="getCustomerGroupDetail(this.value)" data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                                                            @foreach($lims_customer_list as $customer)
                                                            <option value="{{$customer->PartyID}}" {{$lims_sale_data->PartyID == $customer->PartyID ? 'selected' : ''}}>{{$customer->PartyName . ' (' . $customer->Phone . ')'}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                @if($lims_pos_setting_data->is_dish_enabled == 1)
                                                    <div class="col-md-3">
                                                        <label>Select Table</label>
                                                        <select id="dish_table_id" name="dish_table_id" class="form-select select2" data-live-search="true" data-live-search-style="begins" title="Take Away...">
                                                            @foreach($dish_tables as $dish_table)
                                                            <option value="{{$dish_table->id}}" {{$lims_sale_data->DishTableID == $dish_table->id ? 'selected' : ''}}>{{$dish_table->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                <div class="col-md-3">
                                                    <label>Select Date</label>
                                                    <div class="input-group">
                                                        <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-calendar"></i></button>
                                                        <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{$lims_sale_data->Date}}" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label>{{trans('file.Select Product')}}</label>
                                                    <div class="search-box input-group">
                                                        <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                                        <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row mt-5">
                                                <div class="col-md-12">
                                                    <h5>{{trans('file.Order Table')}} *</h5>
                                                    <div class="table-responsive mt-3">
                                                        <table id="myTable" class="table table-hover order-list">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{trans('file.name')}}</th>
                                                                    <th>{{trans('file.Code')}}</th>
                                                                    <th>{{trans('file.Quantity')}}</th>
                                                                    <th>{{trans('file.Net Unit Price')}}</th>
                                                                    <th>{{trans('file.Discount')}}</th>
                                                                    <!-- <th>{{trans('file.Tax')}}</th> -->
                                                                    <th>{{trans('file.Subtotal')}}</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $temp_unit_name = [];
                                                                $temp_unit_operator = [];
                                                                $temp_unit_operation_value = [];
                                                                ?>
                                                                @foreach($lims_product_sale_data as $product_sale)
                                                                <tr>
                                                                    <?php
                                                                    $product_data = DB::table('item')->where('ItemID', $product_sale->ItemID)->first();




                                                                    // echo "<pre>";
                                                                    // print_r($product_data);




                                                                    if (@$product_sale->variant_id) { // focus
                                                                        $product_variant_data = \App\ProductVariant::select('id', 'item_code')->FindExactProduct($product_data->id, $product_sale->variant_id)->first();
                                                                        $product_variant_id = $product_variant_data->id;
                                                                        $product_data->code = $product_variant_data->item_code;
                                                                    } else
                                                                        $product_variant_id = null;
                                                                    if ($product_data->TaxMethod == 1) {
                                                                        $product_price = $product_sale->Rate + ($product_sale->Discount / $product_sale->Qty);
                                                                    } elseif ($product_data->TaxMethod == 2) {
                                                                        $product_price = ($product_sale->Total / $product_sale->Qty) + ($product_sale->Discount / $product_sale->Qty);
                                                                    }

                                                                    $tax = DB::table('taxes')->where('rate', @$product_sale->tax_rate)->first();
                                                                    $unit_name = array();
                                                                    $unit_operator = array();
                                                                    $unit_operation_value = array();
                                                                    // if ($product_data->ItemType == 'standard') {
                                                                    //     $units = DB::table('units')->where('id', 1)->get();
                                                                    //     foreach ($units as $unit) {
                                                                    //         $sale_unit_id = 1; //added by usman
                                                                    //         if ($sale_unit_id == $unit->id) {
                                                                    //             array_unshift($unit_name, $unit->unit_name);
                                                                    //             array_unshift($unit_operator, $unit->operator);
                                                                    //             array_unshift($unit_operation_value, $unit->operation_value);
                                                                    //         } else {
                                                                    //             $unit_name[]  = $unit->unit_name;
                                                                    //             $unit_operator[] = $unit->operator;
                                                                    //             $unit_operation_value[] = $unit->operation_value;
                                                                    //         }
                                                                    //     }
                                                                    //     if (@$unit_operator[0] == '*') {
                                                                    //         @$product_price = $product_price / $unit_operation_value[0];
                                                                    //     } elseif (@$unit_operator[0] == '/') {
                                                                    //         $product_price = $product_price * $unit_operation_value[0];
                                                                    //     }
                                                                    // } else {
                                                                        $unit_name[] = 'n/a' . ',';
                                                                        $unit_operator[] = 'n/a' . ',';
                                                                        $unit_operation_value[] = 'n/a' . ',';
                                                                    // }
                                                                    $temp_unit_name = $unit_name = implode(",", $unit_name) . ',';

                                                                    $temp_unit_operator = $unit_operator = implode(",", $unit_operator) . ',';

                                                                    $temp_unit_operation_value = $unit_operation_value =  implode(",", $unit_operation_value) . ',';

                                                                    $product_batch_id = null; //added by usman
                                                                    $product_batch_data = 0; //\App\Models\ProductBatch::select('batch_no', 'expired_date')->find($product_batch_id);
                                                                    ?>
                                                                    <td>{{$product_data->ItemName}} <button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button> <input type="hidden" class="product-type" value="{{$product_data->ItemType}}" /></td>
                                                                    <td>{{$product_data->ItemCode}}</td>
                                                                    <td><input type="number" class="form-control qty" name="qty[]" value="{{$product_sale->Qty}}" step="any" required /></td>
                                                                    <td class="net_unit_price">{{ number_format((float)$product_sale->Rate, 2, '.', '') }} </td>
                                                                    <td class="discount">{{ number_format((float)$product_sale->Discount, 2, '.', '') }}</td>
                                                                    <!-- <td class="tax">{{ number_format((float)$product_sale->Tax, 2, '.', '') }}</td> -->
                                                                    <td class="sub-total">{{ number_format((float)$product_sale->Total, 2, '.', '') }}</td>
                                                                    <td>
                                                                        <!-- <button type="button" class="ibtnDel btn btn-md btn-danger"><i class="fa fa-trash"></i></button> -->
                                                                        <a href="#" class="ibtnDel"><i class="bx bx-trash  align-middle me-1"></i></a>
                                                                    </td>
                                                                    <input type="hidden" class="product-code" name="product_code[]" value="{{$product_data->ItemCode}}" />
                                                                    <input type="hidden" class="itemType" name="itemType[]" value="pos" />
                                                                    <input type="hidden" class="product-id" name="product_id[]" value="{{$product_data->ItemID}}" />
                                                                    <input type="hidden" name="product_variant_id[]" value="{{$product_variant_id}}" />
                                                                    <input type="hidden" class="product-price" name="product_price[]" value="{{$product_price}}" />
                                                                    <input type="hidden" class="sale-unit" name="sale_unit[]" value="{{$unit_name}}" />
                                                                    <input type="hidden" class="sale-unit-operator" value="{{$unit_operator}}" />
                                                                    <input type="hidden" class="sale-unit-operation-value" value="{{$unit_operation_value}}" />
                                                                    <input type="hidden" class="net_unit_price" name="net_unit_price[]" value="{{$product_sale->Rate}}" />
                                                                    <input type="hidden" class="discount-value" name="discount[]" value="{{$product_sale->Discount}}" />
                                                                    <input type="hidden" class="tax-rate" name="tax_rate[]" value="{{$product_sale->Tax}}" />
                                                                    @if($tax)
                                                                    <input type="hidden" class="tax-name" value="{{$tax->name}}" />
                                                                    @else
                                                                    <input type="hidden" class="tax-name" value="No Tax" />
                                                                    @endif
                                                                    <input type="hidden" class="tax-method" value="{{$product_data->TaxMethod}}" />
                                                                    <input type="hidden" class="tax-value" name="tax[]" value="{{$product_sale->Tax}}" />
                                                                    <input type="hidden" class="subtotal-value" name="subtotal[]" value="{{$product_sale->Total}}" />
                                                                </tr>
                                                                @endforeach

                                                                @foreach($dish_invoices as $dish_invoice)
                                                                <tr>
                                                                    <?php
                                                                    $product_data = $dish_invoice->dish_type;
                                                                    $product_variant_id = null;
                                                                    $product_price = $product_data->price;

                                                                    $tax = 0;
                                                                    $unit_name = array();
                                                                    $unit_operator = array();
                                                                    $unit_operation_value = array();
                                                                    $unit_name[] = 'n/a' . ',';
                                                                    $unit_operator[] = 'n/a' . ',';
                                                                    $unit_operation_value[] = 'n/a' . ',';
                                                                    $temp_unit_name = $unit_name = implode(",", $unit_name) . ',';

                                                                    $temp_unit_operator = $unit_operator = implode(",", $unit_operator) . ',';

                                                                    $temp_unit_operation_value = $unit_operation_value =  implode(",", $unit_operation_value) . ',';

                                                                    $product_batch_id = null;
                                                                    $product_batch_data = 0;
                                                                    $total = $dish_invoice->quantity *  $dish_invoice->price;
                                                                    ?>
                                                                    <td>{{$product_data->type}} <button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button> <input type="hidden" class="product-type" value="Restaurant" /></td>
                                                                    <td>{{$product_data->code}}</td>
                                                                    <td><input type="number" class="form-control qty" name="qty[]" value="{{$dish_invoice->quantity}}" step="any" required /></td>
                                                                    <td class="net_unit_price">{{ number_format((float)$dish_invoice->price, 2, '.', '') }} </td>
                                                                    <td class="discount">0.00</td>
                                                                    <td class="sub-total">{{ number_format((float)$total, 2, '.', '') }}</td>
                                                                    <td>
                                                                        <!-- <button type="button" class="ibtnDel btn btn-md btn-danger"><i class="fa fa-trash"></i></button> -->
                                                                        <a href="#" class="ibtnDel"><i class="bx bx-trash  align-middle me-1"></i></a>
                                                                    </td>
                                                                    <input type="hidden" class="product-code" name="product_code[]" value="{{$product_data->code}}" />
                                                                    <input type="hidden" class="itemType" name="itemType[]" value="dish" />
                                                                    <input type="hidden" class="product-id" name="product_id[]" value="{{$product_data->id}}" />
                                                                    <input type="hidden" name="product_variant_id[]" value="{{$product_variant_id}}" />
                                                                    <input type="hidden" class="product-price" name="product_price[]" value="{{$product_price}}" />
                                                                    <input type="hidden" class="sale-unit" name="sale_unit[]" value="{{$unit_name}}" />
                                                                    <input type="hidden" class="sale-unit-operator" value="{{$unit_operator}}" />
                                                                    <input type="hidden" class="sale-unit-operation-value" value="{{$unit_operation_value}}" />
                                                                    <input type="hidden" class="net_unit_price" name="net_unit_price[]" value="{{$dish_invoice->price}}" />
                                                                    <input type="hidden" class="discount-value" name="discount[]" value="0" />
                                                                    <input type="hidden" class="tax-rate" name="tax_rate[]" value="0" />
                                                                    @if($tax)
                                                                    <input type="hidden" class="tax-name" value="{{$tax->name}}" />
                                                                    @else
                                                                    <input type="hidden" class="tax-name" value="No Tax" />
                                                                    @endif
                                                                    <input type="hidden" class="tax-method" value="0" />
                                                                    <input type="hidden" class="tax-value" name="tax[]" value="0" />
                                                                    <input type="hidden" class="subtotal-value" name="subtotal[]" value="{{$total}}" />
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot class="tfoot active">
                                                                <th colspan="2">{{trans('file.Total')}}</th>
                                                                <th id="total-qty">{{$lims_sale_data->TotalQty}}</th>

                                                                <th></th>
                                                                <th id="total-discount">{{ number_format((float)$lims_sale_data->DiscountAmount, 2, '.', '') }}</th>

                                                                <th id="total">{{ number_format((float)$lims_sale_data->SubTotal, 2, '.', '') }}</th>
                                                                <!-- <th><i class="dripicons-trash"></i></th> -->
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="total_qty" id="total_qty" value="{{$lims_sale_data->TotalQty}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="total_discount" value="{{$lims_sale_data->DiscountAmount}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="total_tax" value="{{$lims_sale_data->Tax}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="total" value="{{$lims_sale_data->Total}}" />
                                                        <input type="hidden" name="total_price" value="{{$lims_sale_data->GrandTotal}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" name="item" value="{{@$lims_sale_data->item}}" />
                                                        <input type="hidden" name="order_tax" value="{{@$lims_sale_data->order_tax}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    @if(@$lims_sale_data->coupon_id)
                                                    @php
                                                    $coupon_data = DB::table('coupons')->find($lims_sale_data->coupon_id);
                                                    @endphp
                                                    <input type="hidden" name="coupon_active" value="1" />
                                                    <input type="hidden" name="coupon_type" value="{{$coupon_data->type}}" />
                                                    <input type="hidden" name="coupon_amount" value="{{$coupon_data->amount}}" />
                                                    <input type="hidden" name="coupon_minimum_amount" value="{{$coupon_data->minimum_amount}}" />
                                                    <input type="hidden" name="coupon_discount" value="{{$lims_sale_data->coupon_discount}}">

                                                    @else
                                                    <input type="hidden" name="coupon_active" value="0" />
                                                    @endif
                                                    <div class="form-group">
                                                        <input type="hidden" name="grand_total" value="{{$lims_sale_data->GrandTotal}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="hidden" name="order_tax_rate_hidden" value="{{@$lims_sale_data->TaxPer}}">
                                                        <label>
                                                            <strong>{{trans('file.Order Tax')}}</strong>
                                                        </label>
                                                        <select name="order_tax_rate" id="order_tax_rate" class="form-select changesNo tax exclusive_cal bg-light select2"onchange="calculateGrandTotal()">
                                                            @foreach($lims_tax_list as $tax)
                                                            <option value="{{$tax->rate}}" @if($tax->name == 'Inclusive') selected="selected" @endif data-id="{{$tax->id}}" data-value="{{$tax->name}}">{{$tax->name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>



                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            <strong>{{trans('file.Order Discount')}}</strong>
                                                        </label>
                                                        <input type="number" name="order_discount" class="form-control" value="{{@$lims_sale_data->DiscountPer}}" step="any" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        @if($lims_sale_data->DiscountModel == 'percentage')
                                                        @php
                                                        $discount_model = 1;
                                                        @endphp
                                                        <input type="hidden" name="discount_model_hidden" value="percentage" />
                                                        @else
                                                        @php
                                                        $discount_model = 2;
                                                        @endphp
                                                        <input type="hidden" name="discount_model_hidden" value="number" />
                                                        @endif
                                                        <label>
                                                            <strong>Discount Type</strong>
                                                        </label>
                                                        <select id="disc_percent" name="discount_model" class="form-select select2">
                                                            <option value="percentage" @if($discount_model=='1' ) selected='selected' @endif>Percent (%)</option>
                                                            <option value="number" @if($discount_model=='2' ) selected='selected' @endif>Fixed Amount</option>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row mt-3">
                                                <!--  <div class="col-md-4">
                                          <div class="form-group">
                                              <label>
                                                  <strong>Daraz Amount</strong>
                                              </label>
                                              <input type="hidden" name="daraz_amount" class="form-control" value="{{@$lims_sale_data->daraz_amount}}" step="any" />
                                          </div>
                                      </div> -->
                                                <input type="hidden" name="daraz_amount" class="form-control" value="{{@$lims_sale_data->daraz_amount}}" step="any" />

                                                   <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            <strong>{{trans('file.Shipping Cost')}}</strong>
                                                        </label>
                                                        <input type="number" name="shipping_cost" class="form-control" value="{{@$lims_sale_data->Shipping}}" step="any" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Sale Status')}} *</label>
                                                        @if($lims_sale_data->Balance == 0.00)
                                                        @php
                                                        $sale_status = 1;
                                                        @endphp
                                                        <input type="hidden" name="sale_status_hidden" value="1" />
                                                        @else
                                                        @php
                                                        $sale_status = 2;
                                                        @endphp
                                                        <input type="hidden" name="sale_status_hidden" value="2" />
                                                        @endif
                                                        <select name="sale_status" class="form-control select2">
                                                            <option value="1" @if($sale_status==1) selected @endif>{{trans('file.Completed')}}</option>
                                                            <option value="2" @if($sale_status==2) selected @endif>{{trans('file.Pending')}}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Attach-Document1')}}</label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                                        <input type="file" name="document1" class="form-control" />
                                                        @if($errors->has('extension'))
                                                        <span>
                                                            <strong>{{ $errors->first('extension') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                    <div class="col-md-4 mt-3">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Attach-Document2')}}</label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                                        <input type="file" name="document2" class="form-control" />
                                                        @if($errors->has('extension'))
                                                        <span>
                                                            <strong>{{ $errors->first('extension') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if(@$lims_sale_data->coupon_id)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>
                                                            <strong>{{trans('file.Coupon Discount')}}</strong>
                                                        </label>
                                                        <p class="mt-2 pl-2"><strong id="coupon-text">{{ number_format((float)$lims_sale_data->coupon_discount, 2, '.', '') }}</strong></p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        @if($lims_sale_data->Balance == 0.00)
                                                        <input type="hidden" name="payment_status" value="1" />
                                                        @else
                                                        <input type="hidden" name="payment_status" value="0" />
                                                        @endif
                                                        <input type="hidden" name="paid_amount" value="{{$lims_sale_data->Paid}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Sale Note')}}</label>
                                                        <textarea rows="5" class="form-control" name="sale_note">{{ @$lims_sale_data->DescriptionNotes }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('file.Staff Note')}}</label>
                                                        <textarea rows="5" class="form-control" name="staff_note">{{ $lims_sale_data->DescriptionNotes }}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group mt-3">
                                                <input type="submit" value="Save" class="btn btn-success w-lg" id="submit-button">
                                                <a href="{{url('/invoice-listing')}}" class="btn btn-secondary w-lg">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <table class="table table-bordered table-condensed totals edit_footer">
                    <td><strong>{{trans('file.Items')}}</strong>
                        <span class="ps-2" id="item">0.00</span>
                    </td>
                    <td><strong>{{trans('file.Total')}}</strong>
                        <span class="ps-2" id="subtotal">{{$lims_sale_data->Total}}</span>
                    </td>
                    <td><strong>{{trans('file.Order Tax')}}</strong>
                        <span class="ps-2" id="order_tax">{{$lims_sale_data->Tax}}</span>
                    </td>
                    <td><strong>{{trans('file.Order Discount')}}</strong>
                        <span class="ps-2" id="order_discount">{{$lims_sale_data->DiscountAmount}}</span>
                    </td>
                    <td><strong>{{trans('file.Shipping Cost')}}</strong>
                        <span class="ps-2" id="shipping_cost">0.00</span>
                    </td>
                    <!-- <td><strong>Daraz Amount</strong>
                        <span class="ps-2" id="daraz_amount">0.00</span>
                    </td> -->
                    <td><strong>{{trans('file.grand total')}}</strong>
                        <span class="ps-2" id="grand_total">0.00</span>
                    </td>
                </table>
            </div>
            <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="" method="post">
                        <div class="modal-header">
                            <h5 id="modal_header" class="modal-title"></h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row col-md-12">
                                <div class="col-md-4 form-group">
                                    <label>{{trans('file.Quantity')}}</label>
                                    <input type="number" name="edit_qty" class="form-control" step="any">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{trans('file.Unit Discount')}}</label>
                                    <input type="text" name="edit_discount" class="form-control numkey">
                                    <div class="form-check d-none">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" value="amount" id="radioAmount">
                                        <label class="form-check-label" for="radioAmount">
                                            Amount
                                        </label>
                                    </div>
                                    <div class="form-check d-none">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" value="percent" id="radioPercent" checked>
                                        <label class="form-check-label" for="radioPercent">
                                            Percentage
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>{{trans('file.Unit Price')}}</label>
                                    <input type="number" name="edit_unit_price" class="form-control" step="any">
                                </div>
                            </div>

                                <!-- <div class="form-group">
                                    <label>{{trans('file.Unit Discount')}}</label>
                                    <input type="number" name="edit_discount" class="form-control" step="any">
                                </div> -->


                                <?php
                                $tax_name_all[] = 'No Tax';
                                $tax_rate_all[] = 0;
                                foreach ($lims_tax_list as $tax) {
                                    $tax_name_all[] = $tax->name;
                                    $tax_rate_all[] = $tax->rate;
                                }
                                ?>
                            <div class="row col-md-12">
                                <div class="col-md-4 form-group">
                                    <label>{{trans('file.Tax Rate')}}</label>
                                    <select name="edit_tax_rate" class="form-control select2" style="width: 100% !important;padding: 0;">
                                        @foreach($tax_name_all as $key => $name)
                                        <option value="{{$key}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="edit_unit" class="col-md-4 form-group">
                                    <label>{{trans('file.Product Unit')}}</label>
                                    <select name="edit_unit" class="form-control select2" style="width: 100% !important;padding: 0;">
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" name="update_btn" class="btn btn-primary">{{trans('file.update')}}</button>
                            </div>

                            </form>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- add cash register modal -->
            <div id="cash-register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Cash Register')}}</h5>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                                <div class="row">
                                    <div class="col-md-6 form-group warehouse-section">
                                        <label>{{trans('file.Warehouse')}} *</strong> </label>
                                        <select required name="warehouse_id" class="select2 form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                            @foreach($lims_warehouse_list as $warehouse)
                                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{trans('file.Cash in Hand')}} *</strong> </label>
                                        <input type="number" name="cash_in_hand" required class="form-control">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection @section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection

@push('after-scripts')

<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.timepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/keyboard/js/jquery.keyboard.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/keyboard/js/jquery.keyboard.extension-autocomplete.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery.cookie/jquery.cookie.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/chart.js/Chart.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/charts-custom.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/front.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/daterange/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/daterange/js/knockout-3.4.2.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/daterange/js/daterangepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/dropzone.js') ?>"></script>

<!-- table sorter js-->
<script type="text/javascript" src="<?php echo asset('vendor/datatable/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.bootstrap4.min.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.print.min.js') ?>"></script>

<script type="text/javascript" src="<?php echo asset('vendor/datatable/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.checkboxes.min.js') ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<!-- Custom stylesheet - for your changes-->


<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/saleproposmajed/service-worker.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    }
</script>
<script type="text/javascript">
    function myFunction() {
        setTimeout(showPage, 150);
    }

    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("content").style.display = "block";
        $("#lims_productcodeSearch").focus();
    }

    $("div.alert").delay(3000).slideUp(750);
    $('select').selectpicker({
        style: 'btn-link',
    });

    $("li#notification-icon").on("click", function(argument) {
        $.get('notifications/mark-as-read', function(data) {
            $("span.notification-number").text(alert_product);
        });
    });

    $("a#add-expense").click(function(e) {
        e.preventDefault();
        $('#expense-modal').modal();
    });

    $("a#send-notification").click(function(e) {
        e.preventDefault();
        $('#notification-modal').modal();
    });

    $("a#add-account").click(function(e) {
        e.preventDefault();
        $('#account-modal').modal();
    });

    $("a#account-statement").click(function(e) {
        e.preventDefault();
        $('#account-statement-modal').modal();
    });

    $("a#profitLoss-link").click(function(e) {
        e.preventDefault();
        $("#profitLoss-report-form").submit();
    });

    $("a#report-link").click(function(e) {
        e.preventDefault();
        $("#product-report-form").submit();
    });

    $("a#purchase-report-link").click(function(e) {
        e.preventDefault();
        $("#purchase-report-form").submit();
    });

    $("a#sale-report-link").click(function(e) {
        e.preventDefault();
        $("#sale-report-form").submit();
    });

    $("a#payment-report-link").click(function(e) {
        e.preventDefault();
        $("#payment-report-form").submit();
    });

    $("a#warehouse-report-link").click(function(e) {
        e.preventDefault();
        $('#warehouse-modal').modal();
    });

    $("a#user-report-link").click(function(e) {
        e.preventDefault();
        $('#user-modal').modal();
    });

    $("a#customer-report-link").click(function(e) {
        e.preventDefault();
        $('#customer-modal').modal();
    });

    $("a#supplier-report-link").click(function(e) {
        e.preventDefault();
        $('#supplier-modal').modal();
    });

    $("a#due-report-link").click(function(e) {
        e.preventDefault();
        $("#due-report-form").submit();
    });

    $(".daterangepicker-field").daterangepicker({
        callback: function(startDate, endDate, period) {
            var start_date = startDate.format('YYYY-MM-DD');
            var end_date = endDate.format('YYYY-MM-DD');
            var title = start_date + ' To ' + end_date;
            $(this).val(title);
            $('#account-statement-modal input[name="start_date"]').val(start_date);
            $('#account-statement-modal input[name="end_date"]').val(end_date);
        }
    });
</script>
<script type="text/javascript">
    $("#card-element").hide();
    $("#cheque").hide();

    // array data depend on warehouse
    var lims_product_array = [];
    var product_code = [];
    var product_name = [];
    var product_qty = [];
    var product_type = [];
    var product_id = [];
    var product_list = [];
    var qty_list = [];

    // array data with selection
    var product_price = [];
    var product_discount = [];
    var tax_rate = [];
    var tax_name = [];
    var tax_method = [];
    var unit_name = [];
    var unit_operator = [];
    var unit_operation_value = [];

    // temporary array
    var temp_unit_name = [];
    var temp_unit_operator = [];
    var temp_unit_operation_value = [];

    var exist_type = [];
    var exist_code = [];
    var exist_qty = [];
    var rowindex;
    var customer_group_rate;
    var row_product_price;
    var currency = <?php echo json_encode(config('currency')) ?>;
    var role_id = <?php echo json_encode(1) ?>;

    var rownumber = $('table.order-list tbody tr:last').index();

    for (rowindex = 0; rowindex <= rownumber; rowindex++) {
        product_price.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-price').val()));
        exist_code.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text());
        exist_type.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-type').val());
        var total_discount = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount').text());
        var quantity = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val());
        exist_qty.push(quantity);
        product_discount.push((total_discount / quantity).toFixed(2));
        tax_rate.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val()));
        tax_name.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-name').val());
        tax_method.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-method').val());
        temp_unit_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val().split(',');
        unit_name.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val());
        unit_operator.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit-operator').val());
        unit_operation_value.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit-operation-value').val());
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val(temp_unit_name[0]);
    }

    $('.selectpicker').selectpicker({
        style: 'btn-link',
    });

    $('[data-toggle="tooltip"]').tooltip();

    //assigning value
    $('select[name="customer_id"]').val($('input[name="customer_id_hidden"]').val());
    $('select[name="warehouse_id"]').val($('input[name="warehouse_id_hidden"]').val());
    $('select[name="biller_id"]').val($('input[name="biller_id_hidden"]').val());
    $('select[name="sale_status"]').val($('input[name="sale_status_hidden"]').val());
    $('select[name="discount_model"]').val($('input[name="discount_model_hidden"]').val());

    $('select[name="order_tax_rate"]').val($('input[name="order_tax_rate_hidden"]').val());

    //$('.selectpicker').selectpicker('refresh');

    $('#item').text($('input[name="item"]').val() + '(' + $('input[name="total_qty"]').val() + ')');
    //$('#subtotal').text(parseFloat($('input[name="total_price"]').val()).toFixed(2));
    //$('#order_tax').text(parseFloat($('input[name="order_tax"]').val()).toFixed(2));
    if (!$('input[name="order_discount"]').val())
        $('input[name="order_discount"]').val('0.00');
    // $('#order_discount').text(parseFloat($('input[name="order_discount"]').val()).toFixed(2));
    if (!$('input[name="shipping_cost"]').val())
        $('input[name="shipping_cost"]').val('0.00');
    $('#shipping_cost').text(parseFloat($('input[name="shipping_cost"]').val()).toFixed(2));
    if (!$('input[name="daraz_amount"]').val())
        $('input[name="daraz_amount"]').val('0.00');
    $('#daraz_amount').text(parseFloat($('input[name="daraz_amount"]').val()).toFixed(2));
    $('#grand_total').text(parseFloat($('input[name="grand_total"]').val()).toFixed(2));

    var id = $('select[name="customer_id"]').val();
    $.get('../getcustomergroup/' + id, function(data) {
        customer_group_rate = (data / 100);
    });

    var id = $('select[name="warehouse_id"]').val();
    $.get('../getproduct/' + id, function(data) {
        lims_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        product_type = data[3];
        product_id = data[4];
        product_list = data[5];
        qty_list = data[6];
        product_warehouse_price = data[7];
        batch_no = data[8];
        product_batch_id = data[9];

        $.each(product_code, function(index) {
            if (exist_code.includes(product_code[index])) {
                pos = exist_code.indexOf(product_code[index]);
                // product_qty[index] = product_qty[index] + exist_qty[pos];
                exist_code.splice(pos, 1);
                // exist_qty.splice(pos, 1);
            }
            lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });
        $.each(exist_code, function(index) {
            product_type.push(exist_type[index]);
            product_code.push(exist_code[index]);
            // product_qty.push(exist_qty[index]);
        });
    });

    isCashRegisterAvailable(id);

    function getCustomerGroupDetail(seletedVal) {
        $.get('../getcustomergroup/' + seletedVal, function(data) {
            customer_group_rate = (data / 100);
        });
    }
    // $('select[name="customer_id"]').on('change', function() {
    //     var id = $(this).val();
    //     $.get('../getcustomergroup/' + id, function(data) {
    //         customer_group_rate = (data / 100);
    //     });
    // });getWarehouseDetail

    function getWarehouseDetail(seletedVal) {
        $.get('../getproduct/' + seletedVal, function(data) {
            lims_product_array = [];
            product_code = data[0];
            product_name = data[1];
            product_qty = data[2];
            product_type = data[3];
            product_id = data[4];
            product_list = data[5];
            qty_list = data[6];
            product_warehouse_price = data[7];
            batch_no = data[8];
            product_batch_id = data[9];

            $.each(product_code, function(index) {
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
            });
        });
        isCashRegisterAvailable(seletedVal);
    }

    // $('select[name="warehouse_id"]').on('change', function() {
    //     var id = $(this).val();
    //     $.get('../getproduct/' + id, function(data) {
    //         lims_product_array = [];
    //         product_code = data[0];
    //         product_name = data[1];
    //         product_qty = data[2];
    //         product_type = data[3];
    //         product_id = data[4];
    //         product_list = data[5];
    //         qty_list = data[6];
    //         product_warehouse_price = data[7];
    //         batch_no = data[8];
    //         product_batch_id = data[9];

    //         $.each(product_code, function(index) {
    //             lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
    //         });
    //     });
    //     isCashRegisterAvailable(id);
    // });

    var lims_productcodeSearch = $('#lims_productcodeSearch');
    lims_productcodeSearch.autocomplete({
        source: function(request, response) {
            var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(lims_product_array, function(item) {
                return matcher.test(item);
            }));
        },
        response: function(event, ui) {
            if (ui.content.length == 1) {
                var data = ui.content[0].value;
                $(this).autocomplete("close");
                productSearch(data);
            };
        },
        select: function(event, ui) {
            var data = ui.item.value;
            productSearch(data);
        }
    });

    //Change quantity
    $("#myTable").on('input', '.qty', function() {
        rowindex = $(this).closest('tr').index();
        if ($(this).val() < 1 && $(this).val() != '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
            alert("Quantity can't be less than 1");
        }
        checkQuantity($(this).val(), true);
    });


    //Delete product
    $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
        rowindex = $(this).closest('tr').index();
        product_price.splice(rowindex, 1);
        product_discount.splice(rowindex, 1);
        tax_rate.splice(rowindex, 1);
        tax_name.splice(rowindex, 1);
        tax_method.splice(rowindex, 1);
        unit_name.splice(rowindex, 1);
        unit_operator.splice(rowindex, 1);
        unit_operation_value.splice(rowindex, 1);
        $(this).closest("tr").remove();
        calculateTotal();
    });

    //Edit product
    $("table.order-list").on("click", ".edit-product", function() {
        rowindex = $(this).closest('tr').index();
        edit();
    });

    //Update product
    $('button[name="update_btn"]').on("click", function() {
        var edit_discount = $('input[name="edit_discount"]').val();
        var edit_qty = $('input[name="edit_qty"]').val();
        var edit_unit_price = $('input[name="edit_unit_price"]').val();

        if (parseFloat(edit_discount) > parseFloat(edit_unit_price)) {
            alert('Invalid Discount Input!');
            return;
        }

        if (edit_qty < 1) {
            $('input[name="edit_qty"]').val(1);
            edit_qty = 1;
            alert("Quantity can't be less than 1");
        }

        var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;
        tax_rate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
        tax_name[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();
        if (product_type[pos] == 'standard') {
            var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
            var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));
            if (row_unit_operator == '*') {
                product_price[rowindex] = $('input[name="edit_unit_price"]').val() / row_unit_operation_value;
            } else {
                product_price[rowindex] = $('input[name="edit_unit_price"]').val() * row_unit_operation_value;
            }
            var position = $('select[name="edit_unit"]').val();
            var temp_operator = temp_unit_operator[position];
            var temp_operation_value = temp_unit_operation_value[position];
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val(temp_unit_name[position]);
            temp_unit_name.splice(position, 1);
            temp_unit_operator.splice(position, 1);
            temp_unit_operation_value.splice(position, 1);

            temp_unit_name.unshift($('select[name="edit_unit"] option:selected').text());
            temp_unit_operator.unshift(temp_operator);
            temp_unit_operation_value.unshift(temp_operation_value);

            unit_name[rowindex] = temp_unit_name.toString() + ',';
            unit_operator[rowindex] = temp_unit_operator.toString() + ',';
            unit_operation_value[rowindex] = temp_unit_operation_value.toString() + ',';
        }
        product_discount[rowindex] = $('input[name="edit_discount"]').val();
        checkQuantity(edit_qty, false);
    });

    $("#myTable").on("change", ".batch-no", function() {
        rowindex = $(this).closest('tr').index();
        var product_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-id').val();
        var warehouse_id = $('select[name="warehouse_id"]').val();
        $.get('../../check-batch-availability/' + product_id + '/' + $(this).val() + '/' + warehouse_id, function(data) {
            if (data['message'] != 'ok') {
                alert(data['message']);
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.batch-no').val('');
            } else {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-batch-id').val(data['product_batch_id']);
                code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
                console.log(code);
                pos = product_code.indexOf(code);
                product_qty[pos] = data['qty'];
            }
        });
    });

    function isCashRegisterAvailable(warehouse_id) {
        $.ajax({
            url: '../../cash-register/check-availability/' + warehouse_id,
            type: "GET",
            success: function(data) {
                if (data == 'false') {
                    $('#cash-register-modal select[name=warehouse_id]').val(warehouse_id);
                    $('.selectpicker').selectpicker('refresh');
                    if (role_id <= 2) {
                        $("#cash-register-modal .warehouse-section").removeClass('d-none');
                    } else {
                        $("#cash-register-modal .warehouse-section").addClass('d-none');
                    }
                    $("#cash-register-modal").modal('show');
                }
            }
        });
    }

    function productSearch(data) {
        $.ajax({
            type: 'GET',
            url: '../lims_product_search',
            data: {
                data: data
            },
            success: function(data) {
                var flag = 1;
                $(".product-code").each(function(i) {
                    if ($(this).val() == data[1]) {
                        rowindex = i;
                        var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                        checkQuantity(String(qty), true);
                        flag = 0;
                    }
                });
                $("input[name='product_code_name']").val('');
                if (flag) {
                    var newRow = $("<tr>");
                    var cols = '';
                    pos = product_code.indexOf(data[1]);
                    temp_unit_name = (data[6]).split(',');
                    cols += '<td>' + data[0] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button></td>';
                    cols += '<td>' + data[1] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';

                    cols += '<td class="net_unit_price"></td>';
                    cols += '<td class="discount">0.00</td>';

                    if (data[13] == 'dishItem') {
                        cols += '<input type="hidden" class="itemType" name="itemType[]" value="dish"/>';
                    } else {
                        cols += '<input type="hidden" class="itemType" name="itemType[]" value="pos"/>';
                    }

                    cols += '<td class="sub-total"></td>';
                    cols += '<td><a href="#" class="ibtnDel"><i class="bx bx-trash  align-middle me-1"></i></a></td>';
                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[9] + '"/>';
                    cols += '<input type="hidden" name="product_variant_id[]" value="' + data[10] + '"/>';
                    cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + temp_unit_name[0] + '"/>';
                    cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
                    cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                    newRow.append(cols);
                    $("table.order-list tbody").prepend(newRow);
                    rowindex = newRow.index();
                    pos = product_code.indexOf(data[1]);
                    if (!data[11] && product_warehouse_price[pos]) {
                        product_price.splice(rowindex, 0, parseFloat(product_warehouse_price[pos] * currency['exchange_rate']) + parseFloat(product_warehouse_price[pos] * currency['exchange_rate'] * customer_group_rate));
                    } else {
                        product_price.splice(rowindex, 0, parseFloat(data[2] * 1) + parseFloat(data[2] * 1 * customer_group_rate));
                    }

                    product_discount.splice(rowindex, 0, '0.00');
                    tax_rate.splice(rowindex, 0, parseFloat(data[3]));
                    tax_name.splice(rowindex, 0, data[4]);
                    tax_method.splice(rowindex, 0, data[5]);
                    unit_name.splice(rowindex, 0, data[6]);
                    unit_operator.splice(rowindex, 0, data[7]);
                    unit_operation_value.splice(rowindex, 0, data[8]);
                    checkQuantity(1, true);
                }
            }
        });
    }

    function edit() {
        var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
        var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
        $('#modal_header').text(row_product_name + '(' + row_product_code + ')');

        var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
        $('input[name="edit_qty"]').val(qty);

        $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

        var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
        pos = tax_name_all.indexOf(tax_name[rowindex]);
        $('select[name="edit_tax_rate"]').val(pos);

        pos = product_code.indexOf(row_product_code);
        if (product_type[pos] == 'standard') {
            unitConversion();
            temp_unit_name = (unit_name[rowindex]).split(',');
            temp_unit_name.pop();
            temp_unit_operator = (unit_operator[rowindex]).split(',');
            temp_unit_operator.pop();
            temp_unit_operation_value = (unit_operation_value[rowindex]).split(',');
            temp_unit_operation_value.pop();
            $('select[name="edit_unit"]').empty();
            $.each(temp_unit_name, function(key, value) {
                $('select[name="edit_unit"]').append('<option value="' + key + '">' + value + '</option>');
            });
            $("#edit_unit").show();
        } else {
            row_product_price = product_price[rowindex];
            $("#edit_unit").hide();
        }
        $('input[name="edit_unit_price"]').val(row_product_price.toFixed(2));
        $('.selectpicker').selectpicker('refresh');
    }

    function checkQuantity(sale_qty, flag) {
        var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
        pos = product_code.indexOf(row_product_code);
        if (product_type[pos] == 'standard') {
            var operator = unit_operator[rowindex].split(',');
            var operation_value = unit_operation_value[rowindex].split(',');
            // if (operator[0] == '*')
            //     total_qty = sale_qty * operation_value[0];
            // else if (operator[0] == '/')
            //     total_qty = sale_qty / operation_value[0];
            // else
                total_qty = sale_qty;

            if (total_qty > parseFloat(product_qty[pos])) {
                alert('Quantity exceeds stock quantity!');
                if (flag) {
                    sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                } else {
                    edit();
                    return;
                }
            }
        } else if (product_type[pos] == 'combo') {
            child_id = product_list[pos].split(',');
            child_qty = qty_list[pos].split(',');
            $(child_id).each(function(index) {
                var position = product_id.indexOf(parseInt(child_id[index]));
                if (parseFloat(sale_qty * child_qty[index]) > product_qty[position]) {
                    alert('Quantity exceeds stock quantity!');
                    if (flag) {
                        sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                    } else {
                        edit();
                        flag = true;
                        return false;
                    }
                }
            });
        }

        if (!flag) {
            $('#editModal').modal('hide');
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
        }

        calculateRowProductData(sale_qty);
    }

    function calculateRowProductData(quantity) {
        if (product_type[pos] == 'standard')
            unitConversion();
        else
            row_product_price = product_price[rowindex];

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount').text((product_discount[rowindex] * quantity).toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[rowindex] * quantity).toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));

        if (tax_method[rowindex] == 1) {
            var amount = $("#radioAmount:checked").val();
            console.log(amount);
            var percent = $("#radioPercent:checked").val();
            console.log(percent);


            if (amount == "amount") {
                var net_unit_price = row_product_price - product_discount[rowindex];
            } else if (percent == "percent") {
                var net_unit_price = row_product_price - (row_product_price * (product_discount[rowindex] / 100));

            }

            // var net_unit_price = row_product_price - product_discount[rowindex];



            var tax = net_unit_price * quantity * (tax_rate[rowindex] / 100);
            var sub_total = (net_unit_price * quantity) + tax;

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').text(net_unit_price.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val(net_unit_price.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax').text(tax.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
        } else {
            var sub_total_unit = row_product_price - product_discount[rowindex];
            var net_unit_price = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
            var tax = (sub_total_unit - net_unit_price) * quantity;
            var sub_total = sub_total_unit * quantity;

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').text(net_unit_price.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val(net_unit_price.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax').text(tax.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
        }

        calculateTotal();
    }

    function unitConversion() {
        var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
        var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));

        if (row_unit_operator == '*') {
            row_product_price = product_price[rowindex] * row_unit_operation_value;
        } else {
            // row_product_price = product_price[rowindex] / row_unit_operation_value;
            row_product_price = product_price[rowindex];
        }
    }

    function calculateTotal() {
        //Sum of quantity
        var total_qty = 0;
        $(".qty").each(function() {

            if ($(this).val() == '') {
                total_qty += 0;
            } else {
                total_qty += parseFloat($(this).val());
            }
        });
        $("#total-qty").text(total_qty);
        $('input[name="total_qty"]').val(total_qty);

        //Sum of discount
        var total_discount = 0;
        $(".discount").each(function() {
            total_discount += parseFloat($(this).text());
        });
        $("#total-discount").text(total_discount.toFixed(2));
        $('input[name="total_discount"]').val(total_discount.toFixed(2));

        //Sum of tax
        var total_tax = 0;
        $(".tax").each(function() {
            total_tax += parseFloat($(this).text());
        });
        $("#total-tax").text(total_tax.toFixed(2));
        $('input[name="total_tax"]').val(total_tax.toFixed(2));

        //Sum of subtotal
        var total = 0;
        $(".sub-total").each(function() {
            total += parseFloat($(this).text());
        });
        $("#total").text(total.toFixed(2));
        $('input[name="total_price"]').val(total.toFixed(2));

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        var item = $('table.order-list tbody tr:last').index();
        var total_qty = parseFloat($('#total-qty').text());
        var subtotal = parseFloat($('#total').text());
        var order_tax = parseFloat($('select[name="order_tax_rate"]').val());
        if (isNaN(order_tax)) {
            order_tax = 0;
        }

        var order_discount = parseFloat($('input[name="order_discount"]').val());
        var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());
        var daraz_amount = parseFloat($('input[name="daraz_amount"]').val());

        var order_tax_rate_select = $('select[name="order_tax_rate"]').find(':selected').attr('data-value');

        if (!order_discount)
            order_discount = 0.00;
        if (!shipping_cost)
            shipping_cost = 0.00;
        if (!daraz_amount)
            daraz_amount = 0.00;

        item = ++item + '(' + total_qty + ')';

        if (order_tax_rate_select == 'Exclusive') {
            order_tax = (subtotal - order_discount) * (order_tax / 100); //EHSAN OLD
        }

        var discount_model = $('select[name="discount_model"]').val();
        var discount = order_discount.toFixed(2);
        if (discount_model == 'percentage') {
            discount = subtotal * (order_discount / 100);
            subtotal = subtotal - discount;

        } else {
            subtotal = subtotal - order_discount;
        }
        //order_tax = (subtotal - order_discount) * (order_tax / 100);
        if (order_tax_rate_select == 'Inclusive') {
            order_tax = subtotal * (order_tax / 100); //EHSAN
            subtotal = subtotal - order_tax; //EHSAN
        }

        var grand_total = ((subtotal + order_tax + shipping_cost)) - daraz_amount;

        console.log(subtotal);
        $('input[name="grand_total"]').val(grand_total.toFixed(2));
        $('input[name="paid_amount"]').val(grand_total.toFixed(2)); // added by usman
        if ($('input[name="coupon_active"]').val()) {
            couponDiscount();
            var coupon_discount = parseFloat($('input[name="coupon_discount"]').val());
            if (!coupon_discount)
                coupon_discount = 0.00;
            grand_total -= coupon_discount;
        }

        $('#item').text(item);
        $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
        $('#subtotal').text(subtotal.toFixed(2));
        $('input[name="total"]').val(subtotal.toFixed(2));
        $('#order_tax').text(order_tax.toFixed(2));
        $('input[name="order_tax"]').val(order_tax.toFixed(2));
        $('#shipping_cost').text(shipping_cost.toFixed(2));
        $('#daraz_amount').text(daraz_amount.toFixed(2));
        $('#grand_total').text(grand_total.toFixed(2));
        $('input[name="grand_total"]').val(grand_total.toFixed(2));
        $('#order_discount').text(discount.toFixed(2));
        $("#total-discount").text(discount);
        $('input[name="total_discount"]').val(discount.toFixed(2));
    }

    function couponDiscount() {
        var rownumber = $('table.order-list tbody tr:last').index();
        if (rownumber < 0) {
            alert("Please insert product to order table!")
        } else {
            if ($('input[name="coupon_type"]').val() == 'fixed') {
                if ($('input[name="grand_total"]').val() >= $('input[name="coupon_minimum_amount"]').val()) {
                    $('input[name="grand_total"]').val($('input[name="grand_total"]').val() - $('input[name="coupon_amount"]').val());
                } else
                    alert('Grand Total is not sufficient for discount! Required ' + currency['code'] + ' ' + $('input[name="coupon_minimum_amount"]').val());
            } else {
                var grand_total = $('input[name="grand_total"]').val();
                var coupon_discount = grand_total * (parseFloat($('input[name="coupon_amount"]').val()) / 100);
                grand_total = grand_total - coupon_discount;
                $('input[name="grand_total"]').val(grand_total);
                $('input[name="coupon_discount"]').val(coupon_discount);
                $('#coupon-text').text(parseFloat(coupon_discount).toFixed(2));
            }
        }
    }

    $('input[name="order_discount"]').on("input", function() {
        calculateGrandTotal();
    });

    $('input[name="shipping_cost"]').on("input", function() {
        calculateGrandTotal();
    });

    $('input[name="daraz_amount"]').on("input", function() {
        calculateGrandTotal();
    });

    // $('select[name="order_tax_rate"]').on("change", function() {
    //     calculateGrandTotal();
    // });

    // $('select[name="discount_model"]').on("change", function() {
    //     calculateGrandTotal();
    // });

    $(window).keydown(function(e) {
        if (e.which == 13) {
            var $targ = $(e.target);
            if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                var focusNext = false;
                $(this).find(":input:visible:not([disabled],[readonly]), a").each(function() {
                    if (this === e.target) {
                        focusNext = true;
                    } else if (focusNext) {
                        $(this).focus();
                        return false;
                    }
                });
                return false;
            }
        }
    });

    $('#payment-form').on('submit', function(e) {
        var rownumber = $('table.order-list tbody tr:last').index();
        if (rownumber < 0) {
            alert("Please insert product to order table!")
            e.preventDefault();
        } else {
            $(".batch-no").prop('disabled', false);
        }
    });
</script>



@endpush
