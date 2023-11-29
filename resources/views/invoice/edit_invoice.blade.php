@extends('template.tmp')
@section('title', 'Edit Invoice')
@push('after-styles')
<style type="text/css">
    .add-btn {
        border-color: #00A5A8 !important;
        background-color: #00B5B8 !important;
        color: #FFFFFF;
    }

    .round {
        border-radius: 1.5rem;
    }

    .btn-cyan {
        border-color: #0097A7 !important;
        background-color: #00838F !important;
        color: #FFF !important;
    }

    .btn-payment {
        border-color: #10C888 !important;
        background-color: #0CC27E !important;
        color: #FFF !important;
    }

    .btn-blue-grey {
        border-color: #10C888 !important;
        background-color: #607D8B !important;
        color: #FFF !important;
    }

    /*.btn-lg, .btn-group-lg > .btn {
    padding: 1rem 1.25rem;
    font-size: 1.25rem;
    line-height: 1.25;
    border-radius: 0.27rem;
}*/
</style>
@endpush
@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid" data-select2-id="15">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create Invoice</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->

            <!-- enctype="multipart/form-data" -->
            <span id="hdata" data-df="dd-mm-yyyy" data-curr="AED"></span>

            <!-- ////////////////////////////////////////////////////////////////////////////-->


            <form method="post" id="data_form">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$InvoiceMasterID}}" name="InvoiceMasterID">
                <div class="row ">
                    <div class="col-md-6 card p-mobile">
                        <div class="input-group mt-3">
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary add-btn round" data-toggle="modal" data-target="#Pos_addCustomer">
                                    <i class="fa fa-plus-circle"></i> Add
                                </a>
                            </div>
                            <div class="col-md-10" align="left">
                                <select class="form-control" name="customer" id="sel_customer">
                                    @foreach($parties as $party)
                                    <option value="{{$party->PartyID}},{{$party->PartyName}},'{{$discount}}" {{ $party->PartyID == $invoice_master->PartyID ? 'selected': '' }}>{{$party->PartyName}} &nbsp; &nbsp; {{$party->Phone}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- <input type="text" class="form-control round mousetrap" name="cst" id="pos-customer-box" placeholder="Enter Customer Name or Mobile Number to search " autocomplete="off"> -->

                        </div>

                        <div class="row ml-3">
                            <div id="customer-box-result" class="col-md-12"></div>
                            <div id="customer" class="col-md-12 ml-3">
                                <div class="clientinfo">
                                    <input type="hidden" name="customer_id" id="customer_id" value="{{$invoice_master->PartyID}}">
                                    <div id="customer_name" align="center">Default: <strong>{{$customer_name}}</strong></div>
                                </div>
                            </div>
                        </div>
                        <div id="saman-row-pos" class="rqw mt-3">
                            <div class="col p-mobile">
                                <table id="pos_list" class="table-responsive tfr pos_stripe" style="background-color: #933BB1;">
                                    <thead class="text-white">
                                        <tr class="item_header bg-gradient-directional-purple white">
                                            <th colspan="2" class="text-center"> Item Name</th>
                                            <th width="3%" class="text-center"> Quantity</th>
                                            <th width="10%" class="text-center">Rate</th>
                                            <th width="10%" class="text-center"> Tax(%)</th>
                                            <th width="10%" class="text-center"> Discount</th>
                                            <th width="20%" class="text-center">Amount</th>
                                            <th width="5%" class="text-center"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pos_items" class="text-white">
                                        @php
                                        $productCounter = 1;
                                        @endphp
                                        @foreach($invoice_detail as $key => $detail)
                                        @php
                                        $prodTotalPrice = $detail->Rate*$detail->Qty;
                                        @endphp
                                        <tr>
                                            <td colspan="2">
                                                <input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-{{$productCounter}}" value="{{$detail->Description}}">
                                                <input type="hidden" id="alert-{{$productCounter}}" value="105" name="alert[]">
                                            </td>
                                            <td><input type="text" inputmode="numeric" class="form-control p-mobile p-width req amnt" name="product_qty[]" id="amount-{{$productCounter}}" onkeypress="return isNumber(event)" onkeyup="rowTotal('{{$productCounter}}'), billUpyog()" autocomplete="off" value="{{$detail->Qty}}"></td>
                                            <td><input type="text" class="form-control p-width p-mobile req prc" name="product_price[]" inputmode="numeric" id="price-{{$productCounter}}" onkeypress="return isNumber(event)" onkeyup="rowTotal('{{$productCounter}}'), billUpyog()" autocomplete="off" value="{{$detail->Rate}}"></td>
                                            <td> <input type="text" class="form-control p-mobile p-width vat" inputmode="numeric" name="product_tax[]" id="vat-{{$productCounter}}" onkeypress="return isNumber(event)" onkeyup="rowTotal('{{$productCounter}}'), billUpyog()" autocomplete="off" value="{{$detail->Tax}}"></td>
                                            <td><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" inputmode="numeric" onkeypress="return isNumber(event)" id="discount-{{$productCounter}}" onkeyup="rowTotal('{{$productCounter}}'), billUpyog()" autocomplete="off" value="0"></td>
                                            <td class="text-center"><span class="currenty">AED</span> <strong><span class="ttlText" id="result-{{$productCounter}}">{{$prodTotalPrice}}</span></strong></td>
                                            <td class="text-center"><button type="button" data-rowid="1" class="btn btn-danger removeItem" title="Remove"> <i class="fa fa-minus-square"></i> </button> </td>
                                            <input type="hidden" name="taxa[]" id="taxa-{{$productCounter}}" value="17.00"><input type="hidden" name="disca[]" id="disca-{{$productCounter}}" value="0.00">
                                            <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-{{$productCounter}}" value="{{$detail->Total}}">
                                            <input type="hidden" class="pdIn" name="pid[]" id="pid-{{$productCounter}}" value="{{$detail->ItemID}}"> <input type="hidden" name="unit[]" id="unit-{{$productCounter}}" value="">
                                            <input type="hidden" name="hsn[]" id="hsn-{{$productCounter}}" value="ABC-1">
                                            <input type="hidden" name="serial[]" id="serial-{{$productCounter}}" value="">
                                        </tr>
                                        @php
                                        $productCounter ++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-3"><input type="hidden" value="{{@$invoice_master->SubTotal}}" id="subttlform" name="subtotal"> <input type="hidden" value="0" id="custom_discount"><strong> Total Tax</strong>
                                    </div>
                                    <div class="col-6"><span class="currenty lightMode">AED</span>
                                        <span id="taxr" class="lightMode">{{@$invoice_master->Tax}}</span>
                                    </div>
                                </div>
                                <div class="row mt-3" style="display: none;">
                                    <div class="col-3">
                                        <strong> Total Discount</strong>
                                    </div>
                                    <div class="col-6"><span class="currenty lightMode">AED</span>
                                        <span id="discs" class="lightMode">00.00</span>
                                    </div>
                                </div>
                                <div class="row mt-3" style="display: none;">
                                    <div class="col-3">
                                        <strong> Shipping</strong>
                                    </div>
                                    <div class="col-6"><input type="text" class="form-control shipVal" onkeypress="return isNumber(event)" placeholder="Value" name="shipping" autocomplete="off" onkeyup="billUpyog()">
                                        ( Tax AED <span id="ship_final">0.00</span> )
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-3"><strong> Grand Total(<span class="currenty lightMode">AED</span>)</strong>
                                </div>
                                <div class="col-6"><input type="text" name="total" class="form-control" id="invoiceyoghtml" readonly="" value="{{@$invoice_master->GrandTotal}}"></div>


                            </div>
                            <div class="row mt-3">
                                <div class="col-3"><strong> Paid(<span class="currenty lightMode">AED</span>)</strong>
                                </div>
                                <div class="col-6"><input type="text" name="paid_amount" class="form-control" value="{{@$invoice_master->Paid}}" id="paid_amount" onkeyup="showBalance()"></div>


                            </div>
                            <div class="row mt-3">
                                <div class="col-3"><strong> Balance(<span class="currenty lightMode">AED</span>)</strong>
                                </div>
                                <div class="col-6"><input type="text" name="remaining_bal" value="{{@$invoice_master->Balance}}" class="form-control" id="remaining_bal" readonly></div>


                            </div>
                            <div class="row mt-3">
                                <div class="col-3">
                                    <strong> Extra Discount</strong>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control form-control-sm discVal" onkeypress="return isNumber(event)" placeholder="Value" name="disc_val" autocomplete="off" value="{{@$invoice_master->Balance}}" onkeyup="billUpyog()">
                                    <input type="hidden" value="0" name="after_disc" id="after_disc">
                                </div>
                                <div class="col-3">
                                    ( AED <span id="disc_final">0</span> )
                                </div>
                            </div>
                            <hr>

                            <div class="col">
                                <div class="form-group form-group-sm text-g">
                                    <label for="salesman">Salesman</label>

                                    <select id="employee" name="employee" class="form-control form-control-sm">
                                        @foreach($salemans as $key => $val)
                                        <option value="{{$key}}" {{ $key == $invoice_master->SupplierID ? 'selected': '' }}>{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-center">
                                    <a href="#" class="possubmit btn btn-lg btn-cyan sub-btn" data-type="6"><i class="fa fa-save"></i> Draft</a>
                                    <!-- <a href="#" class="possubmit3 btn btn-lg btn-success sub-btn" data-type="6" data-toggle="modal" data-target="#basicPay"><i class="fa fa-money"></i> Payment</a> -->
                                    <button type="submit" class="update_invoice btn btn-lg btn-success sub-btn">Update</button>
                                    <!-- <a href="#" class="possubmit2 btn btn-lg btn-blue-grey sub-btn" data-type="4" data-toggle="modal" data-target="#cardPay"><i class="fa fa-credit-card"></i> Card</a> -->

                                </div>
                            </div>

                            <hr>
                            <ul class="nav nav-tabs" role="tablist">
                                <!-- <li class="nav-item">
                <a class="btn btn-outline-primary  mr-1 mb-1" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" role="tab" aria-selected="false"><i class="fa fa-trophy"></i>
                Coupon</a>
                </li> -->
                                <li class="nav-item">
                                    <a class="btn btn-outline-secondary mr-1 mb-1" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i class="icon-handbag"></i>
                                        POS Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-outline-danger  mr-1 mb-1" id="base-tab3" data-toggle="tab" aria-controls="tab3" href="#tab3" role="tab" aria-selected="false"><i class="fa fa-save"></i> Draft(s)</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-outline-success mb-1" id="base-tab4" data-toggle="tab" aria-controls="tab4" href="#tab4" role="tab" aria-selected="false"><i class="fa fa-cogs"></i>
                                        Invoice Properties</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                    <div class="input-group">

                                        <input type="text" class="form-control" id="coupon" name="coupon"><input type="hidden" name="coupon_amount" id="coupon_amount" value="0"><span class="input-group-addon round"> <button class="apply_coupon btn btn-small btn-primary sub-btn">Apply</button></span>


                                    </div>
                                    <input type="hidden" class="text-info" name="i_coupon" id="i_coupon" value="">
                                    <span class="text-primary text-bold-600" id="r_coupon"></span>
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                    <div class="row">
                                        <div class="col-4 blue text-xs-center">Warehouse
                                            <select id="warehouses" class="selectpicker form-control round teal">
                                                <option value="1">Main WareHouse</option>
                                                <option value="0">All</option>
                                                <option value="1">Main WareHouse</option>
                                            </select>
                                        </div>
                                        <div class="col-4 blue text-xs-center">Tax
                                            <select class="form-control round" onchange="changeTaxFormat(this.value)" id="taxformat">
                                                <option value="yes" data-tformat="yes">»On</option>
                                                <option value="yes" data-tformat="yes">On</option>
                                                <option value="inclusive" data-tformat="incl" selected="">Inclusive</option>
                                                <option value="off" data-tformat="off">Off</option>
                                                <option value="yes" data-tformat="cgst">CGST + SGST</option>
                                                <option value="yes" data-tformat="igst">IGST</option>
                                            </select>
                                        </div>
                                        <div class="col-4 blue text-xs-center"> Discount
                                            <select class="form-control round teal" onchange="changeDiscountFormat(this.value)" id="discountFormat">

                                                <option value="flat">--Flat Discount After TAX--</option>
                                                <option value="%"> % Discount After TAX</option>
                                                <option value="flat">Flat Discount After TAX</option>
                                                <option value="b_p"> % Discount Before TAX</option>
                                                <option value="bflat">Flat Discount Before TAX</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <li class="indigo p-1"><a href="http://103.179.143.245/pos-uae/pos_invoices/draft?id=1"> #1029 (2021-11-24)</a></li>
                                </div>
                                <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                                    <div class="form-group row">
                                        <div class="col-sm-3"><label for="invocieno" class="caption">Invoice Number</label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Invoice #" name="invocieno" id="invocieno" value="1142">
                                            </div>
                                        </div>
                                        <div class="col-sm-3"><label for="invocieno" class="caption">Reference</label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-bookmark-o" aria-hidden="true"></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Reference #" name="refer">
                                            </div>
                                        </div>


                                        <div class="col-sm-3"><label for="invociedate" class="caption">Invoice Date</label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-calendar4" aria-hidden="true"></span>
                                                </div>
                                                <input type="text" class="form-control required" placeholder="Billing Date" name="invoicedate" data-toggle="datepicker" autocomplete="false">
                                            </div>
                                        </div>
                                        <div class="col-sm-3"><label for="invocieduedate" class="caption">Invoice Due Date</label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-calendar-o" aria-hidden="true"></span>
                                                </div>
                                                <input type="text" class="form-control required" id="tsn_due" name="invocieduedate" placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            Payment Terms <select name="pterms" class="selectpicker form-control">
                                                <option value="1"> </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="toAddInfo" class="caption">Invoice Note</label>
                                            <textarea class="form-control" name="notes" rows="2"></textarea>
                                        </div>
                                    </div>


                                </div>
                            </div>


                        </div>

                    </div>


                    <div class="col-md-6 card  order-sm-first  order-md-2 border-amber bg-lighten-1 bg-faded round pt-1">

                        <div id="items_div">
                            <div class="row border-bottom-grey-blue  border-bottom-lighten-4">


                                <div class="col-md-9 pb-1">
                                    <input type="text" class="form-control text-center round mousetrap typeahead" name="product_barcode" placeholder="Enter Product name, scan barcode " id="search_bar" autocomplete="off" autofocus="autofocus">
                                </div>
                                <div class="col-md-3  grey text-xs-center">
                                    <select id="categories" class="form-control round teal">
                                        <option value="">All</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->ItemCategoryID}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-12 pt-0" id="pos_item">
                                    <div class="row match-height">

                                        @php
                                        $i = 0; $discount = 0; $tax = 17; $stock = 105;
                                        @endphp
                                        @foreach($items as $item)
                                        <div class="col-3 border mb-1 ">
                                            <div class="rounded">
                                                <a id="posp{{$i}}" class="select_pos_item btn btn-outline-light-blue round" data-name="{{$item->ItemName}}" data-price="{{$item->SellingPrice}}" data-tax="{{$tax}}" data-discount="{{$discount}}" data-pcode="{{$item->ItemCode}}" data-pid="{{$item->ItemID}}" data-stock="{{$stock}}" data-unit="" data-serial="">
                                                    <img class="round" src="{{asset('images/items/'.$item->ItemImage)}}" style="max-height: 100%;max-width: 100%">
                                                    <div class="text-xs-center text">
                                                        <small style="white-space: pre-wrap;">{{$item->ItemName}}</small>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @php
                                        $i++; $stock = $stock + 105;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </form>
        </div>
        <input type="hidden" value="pos_invoices/action" id="action-url">
        <input type="hidden" value="search" id="billtype">
        <input type="hidden" value="{{count($invoice_detail)}}" name="counter" id="ganak">
        <input type="hidden" value="AED" name="currency">
        <input type="hidden" value="%" name="taxformat" id="tax_format">
        <input type="hidden" value="yes" name="tax_handle" id="tax_status">
        <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
        <input type="hidden" value="flat" name="discountFormat" id="discount_format">
        <input type="hidden" value="0.00" name="shipRate" id="ship_rate">
        <input type="hidden" value="incl" name="ship_taxtype" id="ship_taxtype">
        <input type="hidden" value="0.00" name="ship_tax" id="ship_tax">


        <div id="shortkeyboard" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">ShortCuts</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>Alt+X</td>
                                    <td>Focus to products search</td>
                                </tr>
                                <tr>
                                    <td>Alt+C</td>
                                    <td>Focus to customer search</td>
                                </tr>

                                <tr>
                                    <td>Alt+S (twice)</td>
                                    <td>PayNow + Thermal Print</td>
                                </tr>
                                <tr>
                                    <td>Alt+Z</td>
                                    <td>Make Card Payment</td>
                                </tr>
                                <tr>
                                    <td>Alt+Q</td>
                                    <td>Select First product</td>
                                </tr>
                                <tr>
                                    <td>Alt+N</td>
                                    <td>Create New Invoice</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" id="Pos_addCustomer" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <form method="post" id="product_action" class="form-horizontal">
                        <!-- Modal Header -->
                        <div class="modal-header bg-gradient-directional-info white">

                            <h4 class="modal-title" id="myModalLabel"><i class="icon-user-plus"></i> Add Customer</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only"> Close</span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5>Billing Address</h5>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="name">Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Name" class="form-control margin-bottom" id="mcustomer_name" name="name" required="">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="phone"> Phone</label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Phone" class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="email"> Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" placeholder="Email" class="form-control margin-bottom" name="email" id="mcustomer_email">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="address"> Address</label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Address" class="form-control margin-bottom " name="address" id="mcustomer_address1">
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label" for="customergroup"> Group</label>

                                        <div class="col-sm-10">
                                            <select name="customergroup" class="form-control">
                                                <option value="1">Default Group</option>
                                            </select>


                                        </div>
                                    </div>



                                </div>

                                <!-- shipping -->


                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                            <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--card-->
        <div class="modal fade" id="cardPay" role="dialog">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content ">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Make Payment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            <span class="sr-only"> Close</span>

                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p id="statusMsg"></p>

                        <form role="form" id="card_data">


                            <div class="row">
                                <div class="col-6">
                                    <div class="card-title mb-3">
                                        <label for="cardNumber">Payment Gateways</label>
                                        <select class="form-control" name="gateway">
                                            <option value="1">Stripe </option>
                                            <option value="2">Authorize.Net </option>
                                            <option value="3">Pin Payments </option>
                                            <option value="4">PayPal </option>
                                            <option value="5">SecurePay </option>
                                            <option value="6">2Checkout </option>
                                            <option value="7">PayU Money </option>
                                            <option value="8">RazorPay </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6"><br><img class="img-responsive pull-right" src="./New Invoice_files/accepted_c22e0.png">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-success btn-lg btn-block" type="submit" id="pos_card_pay" data-type="2">Pay now</button>
                                </div>
                            </div>
                            <div class="form-group">


                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>

                            <input type="hidden" value="pos_invoices/action" id="pos_action-url">
                        </form>


                    </div>
                    <!-- Modal Footer -->


                </div>
            </div>
        </div>
        <div class="modal fade" id="basicPay" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <form method="post" id="basicpay_data" class="form-horizontal">
                        <!-- Modal Header -->
                        <div class="modal-header">

                            <h4 class="modal-title">Make Payment</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only"> Close</span>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p id="statusMsg"></p>

                            <div class="text-center">
                                <h1 id="b_total"></h1>
                            </div>
                            <div class="row">


                                <div class="col-6">
                                    <div class="card-title">
                                        <label for="cardNumber">Amount</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control  text-bold-600 blue-grey" name="p_amount" placeholder="Amount" onkeypress="return isNumber(event)" id="p_amount" onkeyup="update_pay_pos()" inputmode="numeric">
                                            <span class="input-group-addon"><i class="icon icon-cash"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card-title">
                                        <label for="cardNumber">Payment Method</label>
                                        <select class="form-control" name="p_method" id="p_method">
                                            <option value="Cash">Cash</option>
                                            <option value="Card Swipe">Card Swipe</option>
                                            <option value="Bank">Bank</option>

                                        </select>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group  text-bold-600 red">
                                        <label for="amount">Balance Due </label>
                                        <input type="text" class="form-control red" name="amount" id="balance1" onkeypress="return isNumber(event)" value="0.00" required="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group text-bold-600 text-g">
                                        <label for="b_change">Change</label>
                                        <input type="text" class="form-control green" name="b_change" id="change_p" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group text-bold-600 text-g">
                                    <label for="account_p">Account</label>

                                    <select name="p_account" id="p_account" class="form-control">
                                        <option value="1">Sales Account / 123456</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-success btn-lg btn-block mb-1" type="submit" id="pos_basic_pay" data-type="4"><i class="fa fa-arrow-circle-o-right"></i> Pay now </button>
                                    <button class="btn btn-info btn-lg btn-block" type="submit" id="pos_basic_print" data-type="4"><i class="fa fa-print"></i> Pay now + Print</button>
                                </div>
                            </div>

                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>


                            <!-- shipping -->


                        </div>
                        <!-- Modal Footer -->

                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content ">

                    <!-- Modal Header -->
                    <div class="modal-header">

                        <h4 class="modal-title">Your Register</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only"> Close</span>
                        </button>

                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="text-center m-1">Active - <span id="r_date">2022-12-08 07:59:12</span></div>


                        <div class="row">
                            <div class="col-6">
                                <div class="form-group  text-bold-600 green">
                                    <label for="amount">Cash (AED)
                                    </label>
                                    <input type="number" class="form-control green" id="r_cash" value="0.00" readonly="">
                                </div>
                            </div>
                            <div class="col-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 blue">
                                    <label for="b_change blue">Card</label>
                                    <input type="number" class="form-control blue" id="r_card" value="0" readonly="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group  text-bold-600 indigo">
                                    <label for="amount">Bank </label>
                                    <input type="number" class="form-control indigo" id="r_bank" value="0.00" readonly="">
                                </div>
                            </div>
                            <div class="col-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 red">
                                    <label for="b_change">Change(-)</label>
                                    <input type="number" class="form-control red" id="r_change" value="0" readonly="">
                                </div>
                            </div>
                        </div>


                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>


                        <!-- shipping -->


                    </div>
                    <!-- Modal Footer -->


                </div>
            </div>
        </div>
        <div class="modal fade" id="close_register" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content ">
                    <!-- Modal Header -->
                    <div class="modal-header">

                        <h4 class="modal-title"> CloseYour Register</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only"> Close</span>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <a href="http://103.179.143.245/pos-uae//register/close" class="btn btn-danger btn-lg btn-block" type="submit"><i class="icon icon-arrow-circle-o-right"></i> Yes</a>
                            </div>
                            <div class="col-4"></div>
                        </div>

                    </div>
                    <!-- Modal Footer -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="stock_alert" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content ">

                    <!-- Modal Header -->
                    <div class="modal-header">

                        <h4 class="modal-title">Stock Alert !</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only"> Close</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <div class="row p-1">
                            <div class="alert alert-danger mb-2" role="alert">
                                <strong>Oh snap!</strong> Create a new purchase order for this product or edit the stock of item!
                            </div>
                        </div>

                    </div>
                    <!-- Modal Footer -->


                </div>
            </div>
        </div>


        <!-- my own model -->
        <div class="modal fade" id="idModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="idModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Invoice Updated Successfully</p>
                        <p class="text-center">

                            <button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>

                        </p>
                    </div>

                </div>
            </div>
        </div>
        <!-- end of my own model -->

    </div>
</div>
</div>
@endsection

@push('after-scripts')

<script src="{{asset('assets/js/pos-js/vendors.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/pos-js/jquery.sticky.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/pos-js/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('assets/js/pos-js/raphael-min.js')}}"></script>
<script src="{{asset('assets/js/pos-js/morris.min.js')}}"></script>
<script src="{{asset('assets/js/pos-js/jquery.bootstrap-touchspin.min.js')}}"></script>

<script type="text/javascript">
    var baseurl = '';
    var crsf_token = 'g_7783';
    var crsf_hash = 'e6aad62b3f5af01bb633ca3d4c26f525';
</script>
<script src="{{asset('assets/js/pos-js/mousetrap.min.js')}}"></script>
<script src="{{asset('assets/js/pos-js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/pos-js/accounting.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    accounting.settings = {
        number: {
            precision: 2,
            thousand: ',',
            decimal: '.'
        }
    };
    var two_fixed = 2;
</script>
<script src="{{asset('assets/js/pos-js/unslider-min.js')}}"></script>
<script src="{{asset('assets/js/pos-js/horizontal-timeline.js')}}"></script>
<script src="{{asset('assets/js/pos-js/app-menu.js')}}"></script>
<script src="{{asset('assets/js/pos-js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/pos-js/breadcrumbs-with-stats.js')}}"></script>
<script src="{{asset('assets/js/pos-js/jquery-ui.js')}}"></script>
<script src="{{asset('assets/js/pos-js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
    var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');
</script>
<script src="{{asset('assets/js/pos-js/custom.js')}}"></script>
<script src="{{asset('assets/js/pos-js/basic.js')}}"></script>
<script src="{{asset('assets/js/pos-js/control.js')}}"></script>
<script src="{{asset('assets/js/pos-js/chat-application.js')}}"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script type="text/javascript">
    // function serachProducts() {
    //     $.ajax({
    //         url: baseurl + 'search_products/pos_search',
    //         dataType: 'html',
    //         method: 'POST',
    //         data: 'cid=' + $('#categories').val() + '&wid=' + $('#warehouses option:selected').val() + '&' + crsf_token + '=' + crsf_hash,
    //         success: function(data) {
    //             $('#pos_item').html(data);
    //         }
    //     });
    // }


    $('#categories').on('change', function() {
        var category_id = $(this).val();
        $.ajax({
            url: "{{url('search-category-wise-items')}}",
            dataType: 'JSON',
            method: 'POST',
            data: {
                category_id: category_id,
                "_token": $('#token').val(),
            },
            success: function(data) {
                let discount = 0,
                    tax = 17,
                    stock = 105;
                let html = '<div class="row match-height">';

                for (let i = 0; i < data.length; i++) {
                    html += '<div class="col-3 border mb-1 "><div class="rounded"><a id="posp' + i + '" class="select_pos_item btn btn-outline-light-blue round" data-name="' + data[i].ItemName + '" data-price="' + data[i].SellingPrice + '" data-tax="' + tax + '" data-discount="' + discount + '" data-pcode="' + data[i].ItemCode + '" data-pid="' + data[i].ItemID + '" data-stock="' + stock + '" data-unit="" data-serial=""><img class="round" src="images/items/' + data[i].ItemImage + '" style="max-height: 100%;max-width: 100%"><div class="text-xs-center text"><small style="white-space: pre-wrap;">' + data[i].ItemName + '</small></div></a></div></div>';

                    stock = stock + 105;

                }
                html += '</div>';

                $('#pos_item').html(html);
            }
        });

    });

    $('.update_invoice').on('click', function(e) {
        e.preventDefault();
        let data_form = document.getElementById("data_form");
        let fd = new FormData(data_form);
        var data = {};
        $("#data_form").serializeArray().map(function(x) {
            data[x.name] = x.value;
        });

        $.ajax({
            url: "{{url('update-pos-invoice')}}",
            dataType: 'JSON',
            method: 'POST',
            data: $(data_form).serialize(),
            beforeSend: function() {
                $(".update_invoice").attr('disable', true);
                $('#idModal').modal('show', {
                    backdrop: 'static'
                });
            },
            success: function(data) {
                if (data == "success") {
                    $(".update_invoice").attr('disable', false);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            }
        });

    });



    serachProducts();

    function update_register() {
        $.ajax({
            url: baseurl + 'register/status',
            dataType: 'json',
            success: function(data) {
                $('#r_cash').val(data.cash);
                $('#r_card').val(data.card);
                $('#r_bank').val(data.bank);
                $('#r_change').val(data.change);
                $('#r_date').text(data.date);
            }
        });
    }

    function searchServices() {
        $.ajax({
            url: baseurl + 'search_products/services_search',
            dataType: 'html',
            method: 'POST',
            data: 'cid=' + $('#ser_categories').val() + '&' + crsf_token + '=' + crsf_hash,
            success: function(data) {
                $('#pos_service').html(data);
            }
        });
    }

    update_register();
    $(".possubmit").on("click", function(e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });

    $("#items_radio").on("click", function(e) {
        $('#items_radio').prop('checked', 'checked');
        $("#search_bar").val('');
        $("#categories").val('0');
        $("#services_div").hide();
        $("#items_div").show();
        serachProducts();
    });

    $("#services_radio").on("click", function(e) {
        $('#services_radio').prop('checked', 'checked');
        $("#search_bar").val('');
        $("#categories").val('0');
        $("#items_div").hide();
        $("#services_div").show();
        searchServices();
    });


    $(".possubmit2").on("click", function(e) {
        e.preventDefault();
        $('#card_total').val(Number($('#invoiceyoghtml').val()));
    });
    $(".possubmit3").on("click", function(e) {
        e.preventDefault();
        var roundoff = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        $('#b_total').html(' AED ' + accounting.formatNumber(roundoff));
        var s_role = 'r_5';
        if (s_role == 'r_6') {
            $('#p_amount').val(0);
            $('#balance1').val(accounting.formatNumber(roundoff));
        } else {
            $('#p_amount').val(accounting.formatNumber(roundoff));
            $('#balance1').val(0);
        }
    });

    function update_pay_pos() {

        var am_pos = accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal);
        var ttl_pos = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        var due = parseFloat(ttl_pos - am_pos).toFixed(2);
        if (due >= 0) {
            $('#balance1').val(accounting.formatNumber(due));
            $('#change_p').val(0);
        } else {
            due = due * (-1)
            $('#balance1').val(0);
            $('#change_p').val(accounting.formatNumber(due));
        }
    }

    $('#pos_card_pay').on("click", function(e) {
        e.preventDefault();
        $('#cardPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({
            scrollTop: $('#notify').offset().top - 100
        }, 1000);
        var o_data = $("#data_form").serialize() + '&' + $("#card_data").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        update_register();
    });
    $('#pos_basic_pay').on("click", function(e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({
            scrollTop: $('#notify').offset().top - 100
        }, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type') + '&account=' + $("#p_account option:selected").val() + '&employee=' + $("#employee option:selected").val();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        setTimeout(
            function() {
                update_register();
            }, 3000);
    });
    $('#pos_basic_print').on("click", function(e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({
            scrollTop: $('body').offset().top - 100
        }, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type') + '&printnow=1' + '&account=' + $("#p_account option:selected").val() + '&employee=' + $("#employee option:selected").val();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        setTimeout(
            function() {
                update_register();
            }, 3000);
    });
</script>
<!-- Vendor libraries -->
<script type="text/javascript">
    var $form = $('#payment-form');
    $form.on('submit', payWithCard);

    /* If you're using Stripe for payments */
    function payWithCard(e) {
        e.preventDefault();
        /* Visual feedback */
        $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>')
            .prop('disabled', true);
        jQuery.ajax({
            url: 'http://103.179.143.245/pos-uae/billing/process_card',
            type: 'POST',
            data: $('#payment-form').serialize(),
            dataType: 'json',
            success: function(data) {
                $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").animate({
                    scrollTop: $('#notify').offset().top
                }, 1000);
            },
            error: function() {
                $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                /* Show Stripe errors on the form */
                $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                $form.find('.payment-errors').closest('.row').show();
                $form.find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                    .prop('disabled', true);
                $("#notify .message").html("<strong>Error</strong>: Please try again!");
            }
        });
    }

    $(document).ready(function() {
        Mousetrap.bind('alt+x', function() {
            $('#search_bar').focus();
        });
        Mousetrap.bind('alt+f', function() {
            $('#service_search_bar').focus();
        });

        Mousetrap.bind('alt+c', function() {
            $('#pos-customer-box').focus();
        });
        Mousetrap.bind('alt+z', function() {
            $('.possubmit2').click();
        });
        Mousetrap.bind('alt+n', function() {
            window.location.href = "http://103.179.143.245/pos-uae/pos_invoices/create";
        });
        Mousetrap.bind('alt+q', function() {
            $('#posp0').click();
            $('#search_bar').val('');
        });
        Mousetrap.bind('alt+s', function() {
            if ($('#basicPay').hasClass('in')) {
                $('#pos_basic_print').click();
            } else {
                $('.possubmit3').click();
            }
        });
        $('#search_bar').keypress(function(event) {
            if (event.keyCode == 13) {
                setTimeout(
                    function() {
                        $('#posp0').click();
                        $('#search_bar').val('');
                    }, 700);

            }
        });

        $('#search_bar').keyup(function(event) {
            var query = $(this).val();
            var category_id = $('#categories').val();
            $.ajax({
                url: "{{url('search-specific-items')}}",
                dataType: 'JSON',
                method: 'GET',
                data: {
                    query: query,
                    category_id: category_id,
                    "_token": $('#token').val(),
                },
                success: function(data) {
                    let discount = 0,
                        tax = 17,
                        stock = 105;
                    let html = '<div class="row match-height">';

                    for (let i = 0; i < data.length; i++) {
                        html += '<div class="col-3 border mb-1 "><div class="rounded"><a id="posp' + i + '" class="select_pos_item btn btn-outline-light-blue round" data-name="' + data[i].ItemName + '" data-price="' + data[i].SellingPrice + '" data-tax="' + tax + '" data-discount="' + discount + '" data-pcode="' + data[i].ItemCode + '" data-pid="' + data[i].ItemID + '" data-stock="' + stock + '" data-unit="" data-serial=""><img class="round" src="images/items/' + data[i].ItemImage + '" style="max-height: 100%;max-width: 100%"><div class="text-xs-center text"><small style="white-space: pre-wrap;">' + data[i].ItemName + '</small></div></a></div></div>';

                        stock = stock + 105;

                    }
                    html += '</div>';

                    $('#pos_item').html(html);
                }
            });

        });

        $('#sel_customer').select2();
        $('#employee').select2();

        $('#sel_customer').change(function(event) {
            var customer = $(this).val();
            customer = customer.split(',');
            var cid = customer[0];
            var cname = customer[1];
            var discount = customer[2];
            PselectCustomer(cid, cname, discount);

        });


    });
</script><!-- BEGIN VENDOR JS-->
<script type="text/javascript">
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: 'dd-mm-yyyy'
    });
    $('[data-toggle="datepicker"]').datepicker('setDate', '10-12-2022');
    $('#sdate').datepicker({
        autoHide: true,
        format: 'dd-mm-yyyy'
    });
    $('#sdate').datepicker('setDate', '10-11-2022');
    $('.date30').datepicker({
        autoHide: true,
        format: 'dd-mm-yyyy'
    });
    $('.date30').datepicker('setDate', '10-11-2022');
</script>
<script type="text/javascript">
    $.ajax({
        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function(data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);
        },
        error: function(data) {
            $('#response').html('Error')
        }
    });
    if (localStorage.show == 'no') {
        $("#pos0").fadeOut();
        $("body").css('padding-top', '0rem');
        $(".content-wrapper").css('padding-top', '0rem');
        $('#hide_header').attr('id', 'show_header');
    }
    $(document).on('click', "#show_header", function(e) {
        $("#pos0").fadeIn();
        $("body").css('padding-top', '4rem');
        $(".content-wrapper").css('padding-top', '1rem');
        localStorage.setItem("show", "yes");
        $(this).attr('id', 'hide_header');
    });
    $(document).on('click', "#hide_header", function(e) {
        $("#pos0").fadeOut();
        $("body").css('padding-top', '0rem');
        $(".content-wrapper").css('padding-top', '0rem');
        $(this).attr('id', 'show_header');
        localStorage.setItem("show", "no");
    });
</script>


@push