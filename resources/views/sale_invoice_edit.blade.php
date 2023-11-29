@extends('template.tmp')
@section('title', $pagetitle)

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- <script src="{{asset('assets/invoice/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/jquery-ui.min.js')}}"></script>
<script src="js/ajax.js"></script> -->
<!-- 
<script src="{{asset('assets/invoice/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/bootstrap-datepicker.js')}}"></script>  -->


<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<!-- multipe image upload  -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="multiple/dist/imageuploadify.min.css" rel="stylesheet">

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
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
    -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;

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
    border-color: transparent transparent #adb5bd transparent!important;
    border-width: 0 6px 6px 6px!important
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
    border: 1px solid #ced4da!important
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
.select2-result-repository__forks, .select2-result-repository__stargazers, .select2-result-repository__watchers {
    display: inline-block;
    font-size: 11px;
    margin-right: 1em;
    color: #adb5bd
}
.select2-result-repository__forks .fa, .select2-result-repository__stargazers .fa, .select2-result-repository__watchers .fa {
    margin-right: 4px
}
.select2-result-repository__forks .fa.fa-flash::before, .select2-result-repository__stargazers .fa.fa-flash::before, .select2-result-repository__watchers .fa.fa-flash::before {
    content: "\f0e7";
    font-family: 'Font Awesome 5 Free'
}
.select2-results__option--highlighted .select2-result-repository__forks, .select2-results__option--highlighted .select2-result-repository__stargazers, .select2-results__option--highlighted .select2-result-repository__watchers {
    color: rgba(255, 255, 255, .8)
}
.select2-result-repository__meta {
    overflow: hidden
}

</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->

            <!-- enctype="multipart/form-data" -->
            <form action="{{URL('/SaleInvoiceUpdate')}}" method="post">
                <input type="hidden" name="InvoiceMasterID" value="{{$invoice_master[0]->InvoiceMasterID}}">


                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">


                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Customer </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="PartyID" id="PartyID" class="form-select select2 mt-5" name="PartyID" required="">
                                            <?php foreach ($party as $key => $value) : ?>
                                                <option value="{{$value->PartyID}}" {{($value->PartyID== $invoice_master[0]->PartyID) ? 'selected=selected':'' }}>{{$value->PartyName}}</option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-1 row " id="WalkinCustomer">
                                    <div class="col-sm-3">
                                        <label class="col-form-label text-danger" for="password">or Walkin Customer </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="WalkinCustomerName" value="{{$invoice_master[0]->WalkinCustomerName}}" placeholder="Walkin cusomter" id="1WalkinCustomerName">

                                    </div>
                                </div>



                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Salesperson </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="UserID" id="UserID" class="form-select">
                                            <option value="">Select</option>
                                            <?php foreach ($user as $key => $value) : ?>
                                                <option value="{{$value->UserID}}" {{($value->UserID== $invoice_master[0]->UserID) ? 'selected=selected':'' }}>{{$value->FullName}}</option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Subject </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="first-name" class="form-control" name="Subject" placeholder="Let your customer know what this invoice is for" value="{{$invoice_master[0]->Subject}}">

                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Tax</label><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="left" title="Use this option after creating complete Invoice."></i>
                                    </div>

                                    <div class="col-sm-9">
                                        <select name="UserI D" id="seletedVal" class="form-select" onchange="GetSelectedTextValue(this)">
                                        <?php foreach ($tax as $key => $valueX1) : ?>
                                                        <option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option>
                                                    <?php endforeach ?>

                                        </select>
                                    </div>
                                </div>
<div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Item Rates Are </label> 
                                    </div>

                                    <div class="col-sm-9">
                                      <select name="TaxType" id="TaxType" class="form-select">
 <option value="TaxInclusive" {{('TaxInclusive'== $invoice_master[0]->TaxType) ? 'selected=selected':'' }} >Tax Inclusive</option>
 <option value="TaxExclusive" {{('TaxExclusive'== $invoice_master[0]->TaxType) ? 'selected=selected':'' }} >Tax Exclusive</option>
 </select>
                                    </div>
                                </div>

                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="warehouse">Warehouse</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                                            @foreach($lims_warehouse_list as $warehouse)
                                                <option value="{{$warehouse->id}}" {{@$invoice_master[0]->WarehouseID == $warehouse->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Invoice Type </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="InvoiceType" id="InvoiceType" class="form-select">
                                                <?php foreach ($invoice_type as $key => $value) : ?>
                                                    <option value="{{$value->InvoiceType}}" {{($value->InvoiceType== $invoice_master[0]->InvoiceType) ? 'selected=selected':'' }}>{{$value->InvoiceType}}</option>
                                                <?php endforeach ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Invoice # </label>
                                        </div>
                                        <div class="col-sm-9 pt-2 fw-bold">



                                            <div id="invoict_type"> <input type="text" name="InvoiceNo" id="InvoiceNo" autocomplete="off" class="form-control" value="{{$invoice_master[0]->InvoiceNo}}"></div>


                                        </div>


                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="email-id">Date</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group" id="datepicker21">
                                                <input type="text" name="Date" autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="{{$invoice_master[0]->Date}}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="contact-info">Due Date</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="input-group" id="datepicker22">
                                                <input type="text" name="DueDate" autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{$invoice_master[0]->DueDate}}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Ref (L.P.O) # </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="ReferenceNo" autocomplete="off" class="form-control" value="{{$invoice_master[0]->ReferenceNo}}">

                                        </div>
                                    </div>
                                </div>
                                <div class=" mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label text-danger" for="password">Payment Mode </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="PaymentMode" id="PaymentMode" class="form-select">
                                            <option value="Cash" {{($invoice_master[0]->PaymentMode=='Cash') ? 'selected' : ''}}>Cash</option>
                                            <option value="Cheque" {{($invoice_master[0]->PaymentMode=='Cheque') ? 'selected' : ''}}>Cheque</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-12" id="paymentdetails">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Cheque Details </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="PaymentDetails" class="form-control " value="{{$invoice_master[0]->PaymentDetails}}">

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>




                        <hr class="invoice-spacing">

                        <div class='text-center'>

                        </div>
                        <div class='row'>
                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                <table>
                                    <thead>
                                        <tr class=" borde-1 border-light " style="height: 40px;">
                                            <th width="1%" class="text-center"><input id="check_all" type="checkbox" /></th>
                                            <th width="1%">ITEM DETAILS </th>
 
                                            <th width="1%">QUANTITY</th>
                                            <th width="2%">RATE</th>
                                            <th width="2%">DISCOUNT</th>
                                            <th width="2%">Value for Tax</th>
                                            <th width="2%">Tax</th>
                                            <th width="2%">Tax Val</th>

                                            <th width="4%">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($invoice_detail as $key => $value1)
                                        <?php $no = $key + 1; ?>
                                       

                                        <tr class="p-3">
                                            <td class="p-1"><input class="case" type="checkbox" /></td>
                                            <td valign="top">

                                                <select name="ItemID0[]" id="ItemID0_{{$no}}" class="item form-select form-control-sm   changesNoo select2"  onchange="km(this.value,<?php echo $no; ?>);" style="width: 300px !important;">
                                                    <option value="">select</option>
                                                    @foreach ($items as $key => $value)
                                                    <option value="{{$value->ItemID}}" {{($value->ItemID== $value1->ItemID) ? 'selected=selected':'' }}>{{$value->ItemName}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="ItemID[]" id="ItemID_{{$no}}" value="{{$value1->ItemID}}">
                                                 

                                                  <textarea name="Description[]" id="Description[]" rows="2" class="form-control" style="width: 300px !important;">{{$value1->Description}}</textarea>


                                            </td>
                                            


                                            <td valign="top">
                                                <input type="number" name="Qty[]" id="Qty_{{$no}}" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Qty}}">
                                            </td>

                                            <td valign="top">
                                                <input type="number" name="Price[]" id="Price_{{$no}}" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Rate}}">
                                            </td>

  <td valign="top">


                                            <div class="input-group">
                                                <input type="text" name="Discount[]" id="Discount_{{$no}}" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Discount}}"  >
                                               <span >
                                               <!-- <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Salesperson </label>
                                    </div> -->
                                                <div class="col-sm-9 input-group">
                                                    <select name="DiscountType[]" id="DiscountType_{{$no}}" class="form-select  changesNo bg-light"  >
                                                         
                                                        <option  value="1" {{($value1->DiscountType==1) ? 'selected=selected':'' }}>%</option>
                                                        <option  value="2" {{($value1->DiscountType==2) ? 'selected=selected':'' }}>{{session::get('Currency')}}</option>
                                                    
                                                    </select>
                                                    <input type="hidden" name="DiscountAmountItem[]"  id="DiscountAmount_{{$no}}" value="{{$value1->DiscountAmountItem}}">
                                                </div>
                                               </span>
                                             
                                            </div>


                                        </td>
                                        <td valign="top">
                                          <input type="number" name="Gross[]" id="Gross_{{$no}}" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Gross}}">                                            </td>
                                            <td valign="top">
                                                
                                                <select name="Tax[]" id="TaxID_{{$no}}" class="form-control changesNo tax exclusive_cal" required="">
                                                    <?php foreach ($tax as $key => $valueX2) : ?>
                                                        <option value="{{$valueX2->TaxPer}}"  {{($valueX2->TaxPer== $value1->TaxPer) ? 'selected=selected':'' }}  >{{$valueX2->Description}}</option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                            <td valign="top">
                                                <input type="number" name="TaxVal[]" value="{{$value1->Tax}}" id="TaxVal_{{$no}}" class=" form-control totalLinePrice2" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                            </td>
                                            




                                            <td valign="top">
                                                <input type="number" name="ItemTotal[]" id="ItemTotal_{{$no}}" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Total}}">
                                            </td>
                                        </tr>



                                        @endforeach
                                        <!-- end of for each -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-1 mb-2" style="margin-left: 29px;">
                            <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                <button class="btn btn-danger delete" type="button"><i class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                                <button class="btn btn-success addmore" type="button"><i class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

                            </div>

                            <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                <div id="result"></div>

                            </div>
                            <br>

                        </div>


                        <div class="row mt-4">

                            <div class="col-lg-8 col-12  ">
                                <h6>Customer Notes: </h6>


                                <textarea class="form-control" rows='5' name="CustomerNotes" id="note" placeholder="">{{$invoice_master[0]->CustomerNotes}}</textarea>

                                <label for="" class="mt-2">Description</label>
                                <textarea class="form-control" rows='5' name="DescriptionNotes" id="note" placeholder="Description notes if any.">{{$invoice_master[0]->DescriptionNotes}}</textarea>


                                <iframe src="{{URL('/Attachment')}}" width="100%" height="40%" border="0" scrolling="yes" style="overflow: hidden;"></iframe>



                                <div class="mt-2"><button type="submit" class="btn btn-success w-md float-right">Save</button>
                                    <a href="{{URL('/Estimate')}}" class="btn btn-secondary w-md float-right">Cancel</a>

                                </div>


                            </div>


                            <div class="col-lg-4 col-12 ">
                                <!-- <input type="text" class="form-control" id="TotalTaxAmount" name="TaxTotal" placeholder="TaxTotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"> -->
                                <form class="form-inline">
                                <div class="form-group mt-1">
                                        <label>Grand Total Tax: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" class="form-control" id="grandtotaltax" name="grandtotaltax" placeholder="Subtotal" value="{{$invoice_master[0]->Tax}}" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group mt-1">
                                        <label>Sub Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" class="form-control" id="subTotal" name="SubTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->SubTotal}}">
                                        </div>
                                    </div>
                                    <div class="form-group mt-1">
                                        <label>Discount: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">%</span>

                                            <input type="text" class="form-control" id="discountper" name="DiscountPer" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->DiscountPer}}">

                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" name="DiscountAmount" class="form-control" id="discountAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->DiscountAmount}}">
                                        </div>
                                    </div>



                                    <div class="form-group mt-1">

                                        <label>Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" name="Total" id="Total" class="form-control" step="0.01" id="totalafterdisc"   placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->Total}}">
                                        </div>
                                    </div>
                                    <div class="form-group mt-1 d-none">
                                        <label>Tax: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">%</span>

                                            <input type="text" class="form-control" id="taxpercentage" name="Taxpercentage" placeholder="tax %" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->TaxPer}}">

                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" name="TaxpercentageAmount" class="form-control" id="taxpercentageAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->Tax}}">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1 d-none">

                                        <label>Shipping: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" name="Shipping" class="form-control" step="0.01" id="shipping" placeholder="Grand Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->Shipping}}">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1">

                                        <label>Grand Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" name="Grandtotal" class="form-control" step="0.01" id="Grandtotal" placeholder="Grand Total"   onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="{{$invoice_master[0]->GrandTotal}}">
                                        </div>
                                    </div>



                                    <div class="form-group mt-1 d-none">
                                        <label>Amount Paid: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" class="form-control" id="amountPaid" name="amountPaid" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$invoice_master[0]->Paid}}">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1 d-none">

                                        <label>Amount Due: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" class="form-control amountDue" name="amountDue" id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$invoice_master[0]->Balance}}">
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div>



                        </div>


                    </div>
                </div>
        </div>





        </form>


    </div>
</div>
</div>


<script>
    /**
     * Site : http:www.smarttutorials.net
     * @author muni
     */

    //adds extra table rows
   var i = $('table tr').length;
 
    $(".addmore").on('click', function() {
         
        html = '<tr class= borde-1 border-light">';
        html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';
        html += '<td><select name="ItemID0[]" id="ItemID0_' + i + '"  style="width: 300px !important;" class="form-select select2  changesNoo" onchange="km(this.value,' + i + ');" > <option value="">select</option>}@foreach ($items as $key => $value) <option value="{{$value->ItemID}}|{{$value->Percentage}}">{{$value->ItemCode}}-{{$value->ItemName}}-{{$value->Percentage}}</option>@endforeach</select><input type="hidden" name="ItemID[]" id="ItemID_' + i + '"> <textarea name="Description[]" id="Description[]" rows="2" class="form-control" style="width: 300px !important;"></textarea></td>';



         html += '<td valign="top"><input type="text" name="Qty[]" id="Qty_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';

        html += '<td valign="top"><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
        html += '<td valign="top"><div class="input-group"><input type="text" name="Discount[]" id="Discount_' + i + '" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0"><span ><div class="col-sm-9 input-group"><select name="DiscountType[]" id="DiscountType_' + i + '" class="form-select  changesNo bg-light"  ><option  value="1">%</option><option  value="2">{{session::get('Currency')}}</option></select><input type="hidden" name="DiscountAmountItem[]" value="0" id="DiscountAmount_' + i + '"></div></span></div></td>';

        html += '<td  valign="top"> <input type="number" name="Gross[]" id="Gross_' + i + '" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">  </td>';

        html += '<td  valign="top"><select name="Tax[]" id="TaxID_' + i + '" class="form-control changesNo exclusive_cal bg-light"><?php foreach ($tax as $key => $valueX1) : ?><option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option><?php endforeach ?></select></td>';


        html += '<td  valign="top"><input type="number" name="TaxVal[]" id="TaxVal_' + i + '" class=" form-control totalLinePrice2 "autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0"></td>';




        html += '<td  valign="top"><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';

        html += '</tr>';
         i++;
        $('table').append(html);
        $('.select2', 'table').select2();
        

 

    });





    //to check all checkboxes
    $(document).on('change', '#check_all', function() {
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });

 


    function km(v, id) {

        // alert(v+id);

        id_arr = 'ItemID0_' + id;
        id = id_arr.split("_");

        val = $('#ItemID0_' + id[1]).val().split("|");


        // alert($('#ItemID0_'+id[1]).val());
        $('#ItemID_' + id[1]).val(val[0]);

        // alert('val done');

        var data = <?php echo $item; ?>;
        // console.log(data);

        // console.log( "readaay!" );

        var data = <?php echo $item; ?> // this is dynamic data in json_encode(); from controller

        // console.log($('#ItemID_' + id[1]).val());


        var item_idd = $('#ItemID_' + id[1]).val();
        // console.log(item_idd);
        var index = -1;
        var val = parseInt(item_idd);
        var json = data.find(function(item, i) {
            if (item.ItemID === val) {
                index = i + 1;
                return i + 1;
            }
        });
            



        
        $('#Price_' + id[1]).val(json["SellingPrice"]);
        $('#TaxID_' + id[1]).val(json["Percentage"]);

        var Qty = $('#Qty_' + id[1]).val();
        var Price = $('#Price_' + id[1]).val();
        var QtyRate = parseFloat(Price) * parseFloat(Qty);


      
        var DiscountType = $('#DiscountType_' + id[1]).val();



        var Discount = $('#Discount_' + id[1]).val();




       if(DiscountType==1)
       {


        var DiscountCalculated=  (parseFloat(QtyRate) * parseFloat(Discount) / 100  );
       }
       else
       {
        var DiscountCalculated= parseFloat(Discount) ;
       }
      
         $('#DiscountAmount_' + id[1]).val( DiscountCalculated   );


        var Gross=  parseFloat(QtyRate)-parseFloat(DiscountCalculated);

         $('#Gross_' + id[1]).val( Gross   );

       
 var TaxID = $('#TaxID_' + id[1]).val();

  var TaxCalculation =  ((parseFloat(Gross)* parseFloat(TaxID))/100).toFixed(2);

  $('#TaxVal_' + id[1]).val( (TaxCalculation ).toFixed(2)  );


var ItemTotal = parseFloat(Gross)-parseFloat(TaxCalculation);

  $('#ItemTotal_' + id[1]).val( ItemTotal   ); 



 var grandtotaltax = 0;

$('.totalLinePrice2').each(function() {
            if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
        });

$('#grandtotaltax').val(parseFloat(grandtotaltax).toFixed(2));


   subTotal = 0;
        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });


$('#subTotal').val(parseFloat(subTotal).toFixed(2));


alert(subTotal);

    TaxIncExc();



        calculateTotal();

        if (isNaN($('#discountAmount').val())) {
            $('#discountAmount').val(0);
        }

        calculatediscount();
        calculateTotal();
 TaxIncExc();


    }

    // end of function

    //deletes the selected table rows
    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
        calculatediscount();
        calculateTotal();
    });


    //price change
    $(document).on('change blur ', '.changesNo', function() {

     singlerowcalculation($(this).attr('id'));


           
    });

    //////////

function singlerowcalculation(idd)
{   
      
       id_arr = idd;
        id = id_arr.split("_");

        Qty = $('#Qty_' + id[1]).val();

        TaxPer = $('#TaxID_' + id[1]).val();

        Price = $('#Price_' + id[1]).val();


        var Qty = $('#Qty_' + id[1]).val();
        var Price = $('#Price_' + id[1]).val();
        var QtyRate = parseFloat(Price) * parseFloat(Qty);
 
        var DiscountType = $('#DiscountType_' + id[1]).val();

        var Discount = $('#Discount_' + id[1]).val();

       if(DiscountType==1)
       {


        var DiscountCalculated=  (parseFloat(QtyRate) * parseFloat(Discount) / 100  ).toFixed(2);
       }
       else
       {
        var DiscountCalculated= parseFloat(Discount) ;
       }
      
         $('#DiscountAmount_' + id[1]).val( DiscountCalculated   );


        var Gross=  (parseFloat(QtyRate)-parseFloat(DiscountCalculated)).toFixed(2);

         $('#Gross_' + id[1]).val( Gross   );

       
 var TaxID = $('#TaxID_' + id[1]).val();

 var TaxCalculation =  ((parseFloat(Gross)* parseFloat(TaxID))/100).toFixed(2);

  $('#TaxVal_' + id[1]).val( TaxCalculation   );


  $('#ItemTotal_' + id[1]).val( Gross    ); 

        var grandtotaltax = 0;

$('.totalLinePrice2').each(function() {
            if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
        });

$('#grandtotaltax').val(parseFloat(grandtotaltax).toFixed(2));



 

subTotal = 0;
        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });


$('#subTotal').val(parseFloat(subTotal).toFixed(2));


 console.log(subTotal);

     TaxIncExc();




}

// 

function TaxIncExc()
{
        var TaxType = $('#TaxType').val();
        // var subTotal = $('#subTotal').val();
        var DiscountAmount = $('#discountAmount').val();
        var grandtotaltax = 0;

      


                var table_lenght = $('table tr').length - 1;
 
                
                var Qty = 0
                var Price = 0;
                var TaxVal = 0;
                var Gross = 0;
                for (let i = 1; i <= table_lenght; i++) {
                   
                    Qty = $('#Qty_' + i).val();
                    Price = $('#Price_' + i).val();
                    TaxVal = $('#TaxVal_' + i).val();
                    Gross = $('#Gross_' + i).val();

                  $('#ItemTotal_' + i).val(  parseFloat (Gross)  );   

                }    



        $('.totalLinePrice2').each(function() {
        if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
        });

        subTotal = 0;
        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });


 

                if(TaxType =='TaxInclusive')
                {

                           subTotal1 = parseFloat(subTotal)-parseFloat(TaxVal);
                              $('#subTotal').val(parseFloat(subTotal).toFixed(2));   

                          var Total =  parseFloat(subTotal)-parseFloat(DiscountAmount).toFixed(2);

                         $('#Total').val(parseFloat(Total));  
                         $('#Grandtotal').val(parseFloat(Total));  

                }
                else
                {
                   
                    $('#subTotal').val(parseFloat(subTotal));    

                    var Total =  parseFloat(subTotal)-parseFloat(DiscountAmount).toFixed(2);
                    var Grandtotal =  ((parseFloat(Total)+parseFloat(grandtotaltax))).toFixed(2);
                    
                 
                    $('#Total').val(Total);  
                    $('#Grandtotal').val(Grandtotal);  

                }

}
    

    $(document).on('change', '.changesNoo', function() {



        id_arr = $(this).attr('id');
        id = id_arr.split("_");

        val = $('#ItemID0_' + id[1]).val().split("|");


        // alert($('#ItemID0_'+id[1]).val());
        $('#ItemID_' + id[1]).val(val[0]);


        calculatediscount();

    });

    ////////////////////////////////////////////

   function calculatediscount() {
        
        subTotal = parseFloat($('#subTotal').val());

grandtotaltax = $('#grandtotaltax').val();
        discountper = $('#discountper').val();
         
        if (discountper != '' && typeof(discountper) != "undefined") {
            discountamount = parseFloat(subTotal) * (parseFloat(discountper) / 100);

            $('#discountAmount').val(parseFloat(discountamount.toFixed(2)));
            total = parseFloat(subTotal).toFixed(2) - parseFloat(discountamount).toFixed(2);
            $('#Total').val(total.toFixed(2));
            $('#Grandtotal').val(parseFloat(total)+parseFloat(grandtotaltax));


        } else {
            $('#discountper').val(0);
            // alert('dd');
            $('#DiscountAmount').val(0);
            total = (subTotal).toFixed(2);
             

        }
  $('#Grandtotal').val(total+parseFloat($('#grandtotaltax').val()));
 
    }



    $(document).on('blur', '#discountAmount', function() {


        calculatediscountper();
       

    });

    function calculatediscountper() {
 
        subTotal = parseFloat($('#subTotal').val());


        discountAmount = $('#discountAmount').val();
        // totalafterdisc = $('#totalAftertax').val();
        // console.log('testing'.totalAftertax);
        if (discountAmount != '' && typeof(discountAmount) != "undefined") {
            discountper = (parseFloat(discountAmount) / parseFloat(subTotal)) * 100;

            $('#discountper').val(parseFloat(discountper.toFixed(2)));

            total = subTotal - discountAmount;

            $('#Total').val(total.toFixed(2));
            // $('#grandtotal').val(total.toFixed(2));

        } else {
            $('#discountper').val(0);
            // alert('dd');
            // $('#discountper').val(0);
            total = subTotal;
            $('#Total').val(total.toFixed(2));

        }

        $('#Grandtotal').val(total+parseFloat($('#grandtotaltax').val()));
 
    }

    //////////////////

    // discount percentage
    $(document).on(' blur ', '#discountper', function() {
        calculatediscount();
       

    });
    $(document).on('change keyup blur   onclick', '#taxpercentage', function() {
        calculateTotal();
    });


    $(document).on('change keyup blur   onclick', '#shipping', function() {
        calculateTotal();
    });



    //total price calculation 
    function calculateTotal() {

        // grand_tax = 0;

        
        subTotal = $('#subTotal').val();
        grandtotaltax=$('#grandtotaltax').val();      
        discountAmount = $('#discountAmount').val();
        Total = parseFloat(subTotal)-parseFloat(discountAmount);
        Grandtotal = parseFloat(Total) + parseFloat(grandtotaltax);

        $('#Total').val(Total);
        $('#Grandtotal').val(Grandtotal);


 
    }




    $(document).on('change keyup blur', '#amountPaid', function() {
        calculateAmountDue();
    });

    //due amount calculation
    function calculateAmountDue() {
        amountPaid = $('#amountPaid').val();
        total = $('#grandtotal').val();
        if (amountPaid != '' && typeof(amountPaid) != "undefined") {
            amountDue = parseFloat(total) - parseFloat(amountPaid);
            $('.amountDue').val(amountDue.toFixed(2));
        } else {
            total = parseFloat(total).toFixed(2);
            $('.amountDue').val(total);
        }
    }


    //It restrict the non-numbers
    var specialKeys = new Array();
    specialKeys.push(8, 46); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        // console.log(keyCode);
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    }

    //datepicker
    $(function() {
        $.fn.datepicker.defaults.format = "dd-mm-yyyy";
        $('#invoiceDate').datepicker({
            startDate: '-3d',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true
        });
    });
</script>

<!-- <script src="{{asset('assets/js/jquery-3.6.0.js')}}" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->

<script type="text/javascript">
    //<![CDATA[


    $(function() {
        $('#WalkinCustomer').hide();
        $('#PartyID').change(function() {

            if (this.options[this.selectedIndex].value == '1') {
                // alert('dd');

                $('#WalkinCustomer').show();
                $('#1WalkinCustomerName').focus();

            } else {
                $('#WalkinCustomer').hide();
                $('#1WalkinCustomerName').val(0);
            }
        });
    });


    //]]>
</script>
<script type="text/javascript">
    //<![CDATA[


    $(function() {
        $('#paymentdetails').hide();
        $('#PaymentMode').change(function() {

            if (this.options[this.selectedIndex].value == 'Cheque') {
                // alert('dd');

                $('#paymentdetails').show();
                $('#PaymentDetails').focus();

            } else {
                $('#paymentdetails').hide();
                $('#PaymentDetails').val('');
            }
        });
    });


    //]]>
</script>
<!-- ajax trigger -->
<script>
    function ajax_balance(SupplierID) {

        // alert($("#csrf").val());

        $('#result').prepend('')
        $('#result').prepend('<img id="theImg" src="{{asset('
            assets / images / ajax.gif ')}}" />')

        var SupplierID = SupplierID;

        // alert(SupplierID);
        if (SupplierID != "") {
            /*  $("#butsave").attr("disabled", "disabled"); */
            // alert(SupplierID);
            $.ajax({
                url: "{{URL('/Ajax_Balance')}}",
                type: "POST",
                data: {
                    _token: $("#csrf").val(),
                    SupplierID: SupplierID,

                },
                cache: false,
                success: function(data) {



                    $('#result').html(data);



                }
            });
        } else {
            alert('Please Select Branch');
        }




    }
</script>

<script>
    $(function() {
    
          var InvoiceType = $('#InvoiceType').val();

        // console.log(InvoiceType);
        if (InvoiceType != "") {
            /*  $("#butsave").attr("disabled", "disabled"); */
            // alert('next stage if else');
            // console.log(InvoiceType);

            $.ajax({

                url: "{{URL('/ajax_invoice_vhno')}}",
                type: "POST",
                data: {
                    // _token: p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu,
                    "_token": $("#csrf").val(),
                    InvoiceType: InvoiceType,

                },
                cache: false,

                success: function(data) {

                    // alert(data.success);
                    $('#invoict_type').html(data);



                }
            });
        }


});

</script>



<script>
    
    $("#TaxType").change(function() {

       TaxIncExc();

    });






</script>
 



<script>
    $("#InvoiceType").change(function() {

        // alert(p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu);

        var InvoiceType = $('#InvoiceType').val();

        // console.log(InvoiceType);
        if (InvoiceType != "") {
            /*  $("#butsave").attr("disabled", "disabled"); */
            // alert('next stage if else');
            // console.log(InvoiceType);

            $.ajax({

                url: "{{URL('/ajax_invoice_vhno')}}",
                type: "POST",
                data: {
                    // _token: p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu,
                    "_token": $("#csrf").val(),
                    InvoiceType: InvoiceType,

                },
                cache: false,

                success: function(data) {

                    // alert(data.success);
                    $('#invoict_type').html(data);



                }
            });
        }

    });
</script>
<script type="text/javascript">
    function GetSelectedTextValue(seletedVal) {
        gTotalVal = $('#grandtotal').val();
        if (gTotalVal) {


            var txt;
            if (confirm("Are you sure you want to update tax of complete invoice!")) {
                txt = "You pressed OK!";

                var TaxValue = seletedVal.value;

                var table_lenght = $('table tr').length;
                let discountamount = 0;


                var grandsum = 0
                var taxsum = 0;
                for (let i = 1; i < table_lenght; i++) {
                    Qty = $('#Qty_' + i).val();
                    Price = $('#Price_' + i).val();


                    $('#TaxID_' + i).val(TaxValue);
                    disPerLine = parseFloat(Price) * (TaxValue / 100);
                    $('#TaxVal_' + i).val(parseFloat(disPerLine));

                    grandsum += (Qty * Price) + disPerLine;
                    taxsum += disPerLine;

                    $('#ItemTotal_' + i).val((Qty * Price) + disPerLine);

                }
                $('#grandtotaltax').val(parseFloat(taxsum));
                // assigning subtotal value
                $('#subTotal').val(parseFloat(grandsum));


                // fetching discount percentage
                var discountper = $('#discountper').val();
                // calculating discount amount
                discountamount = parseFloat(grandsum) * (parseFloat(discountper) / 100);
                $('#discountAmount').val(parseFloat(discountamount));
                //amount after discount
                $('#totalafterdisc').val(parseFloat(grandsum) - parseFloat(discountamount));

                // fetching percentage of tax
                var taxper = $('#taxpercentage').val();
                // calculating percentage amount
                taxamount = parseFloat(grandsum) * (parseFloat(taxper) / 100);
                $('#taxpercentageAmount').val(parseFloat(taxamount));

                //calculating shiping cost
                var shipping = $('#shipping').val();



                var grandtotal = (parseFloat(grandsum) + parseFloat(taxamount) + parseFloat(shipping)) - parseFloat(discountamount);
                // Calculating grandtotal
                $('#grandtotal').val(grandtotal);
                // alert(discountamount);
            } else {
                $('#seletedVal').val('select');
            }

        } else {
            return alert("Please create invoice first");
        }
    }
</script>


 <script>
   $( document ).ready(function() {
  $('body').addClass('sidebar-enable vertical-collpsed')

});
 </script>

<script src="{{asset('assets/js/myapp.js')}}" type="text/javascript"></script>

<!-- END: Content-->

@endsection