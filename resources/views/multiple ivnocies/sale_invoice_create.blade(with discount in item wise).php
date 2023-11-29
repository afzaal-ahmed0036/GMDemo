@extends('tmp')
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

</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->

            <!-- enctype="multipart/form-data" -->
            <form action="{{URL('/SaleInvoiceSave')}}" method="post">


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
                                        <select name="PartyID" id="PartyID" class="form-select select2 mt-5"   required="" style="width:100%;">
                                            <option value="">Select</option>
                                            <?php foreach ($party as $key => $value) : ?>
                                                <option value="{{$value->PartyID}}">{{$value->PartyName}}</option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-1 row " id="WalkinCustomer">
                                    <div class="col-sm-3">
                                        <label class="col-form-label text-danger" for="password">Walkin Customer </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="WalkinCustomerName" value="" placeholder="Walkin cusomter" id="1WalkinCustomerName" >

                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Salesperson </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="UserID" id="UserID" class="form-select select2" style="width:100%;>
                                            <option value="">Select</option>
                                            <?php foreach ($user as $key => $value) : ?>
                                                <option value="{{$value->UserID}}">{{$value->FullName}}</option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Subject </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="first-name" class="form-control" name="Subject" value="" placeholder="Let your customer know what this invoice is for">

                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Tax</label> 
                                    </div>

                                    <div class="col-sm-9">
                                        <select name="UserI D" id="seletedVal" class="form-select select2" onchange="GetSelectedTextValue(this)" style="width: 100%;">
                                        <?php foreach ($tax as $key => $valueX1) : ?>
                                                        <option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option>
                                                    <?php endforeach ?>

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
                                                    <option value="{{$value->InvoiceType}}">{{$value->InvoiceType}}</option>
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
                                        <div class="col-sm-9">
                                            <div id="invoict_type"> <input type="text" name="InvoiceNo" autocomplete="off" class="form-control" value="TAX-{{$vhno[0]->VHNO}}"></div>


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
                                                <input type="text" name="Date" autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
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
                                                <input type="text" name="DueDate" autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Ref # (L.P.O) </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="ReferenceNo" autocomplete="off" class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class=" mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label text-danger" for="password">Payment Mode </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="PaymentMode" id="PaymentMode" class="form-select select2" style="width:100%;">
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-12" id="paymentdetails">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Cheque Details </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="PaymentDetails" class="form-control ">

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
                                <table  >
                                    <thead>
                                        <tr class=" borde-1 border-light " style="height: 40px;">
                                            <th width="2%" class="text-center"><input id="check_all" type="checkbox" /></th>
                                            <th width="1%">ITEM DETAILS </th>
 
                                            <th width="4%">QUANTITY</th>
                                            <th width="4%">RATE</th>
                                            <th width="4%">DISCOUNT</th>
                                            <th width="4%">Value for Tax</th>
                                            <th width="4%">Tax</th>
                                            <th width="4%">Tax Val</th>

                                            <th width="4%">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="p-3">
                                          <td bordercolor="1" class="p-1    text-center"><input class="case" type="checkbox" /></td>

                                          <td valign="top">

                                                <select name="ItemID0[]" id="ItemID0_1" class="item form-select form-control-sm select2   changesNoo " onchange="km(this.value,1);" style="width: 300px !important;">
                                                    <option value="">select</option>
                                                    @foreach ($items as $key => $value)
                                                    <option value="{{$value->ItemID}}|5">{{$value->ItemName}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="ItemID[]" id="ItemID_1">
                                          <textarea name="Description[]" id="Description[]" rows="2" class="form-control" style="width: 300px !important;"></textarea></td>


                                             <td valign="top">
                                          <input type="number" name="Qty[]" id="Qty_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="1">                                            </td>

                                            <td valign="top">
                                          <input type="number" name="Price[]" id="Price_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">                                            </td>
                                          <td valign="top"><div class="input-group">
                                                <input type="text" name="Discount[]" id="Discount_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0">
                                               <span >
                                               <!-- <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Salesperson </label>
                                    </div> -->
                                                <div class="col-sm-9 input-group">
                                                    <select name="DiscountType[]" id="DiscountType_1" class="form-select  changesNo bg-light"  >
                                                        <!-- <option value="">Select</option> -->
                                                        <option  value="1">%</option>
                                                        <option  value="2">{{session::get('Currency')}}</option>
                                                    
                                                    </select>
                                                </div>
                                               </span>
                                             
                                            </div>


                                        </td>
                                           <td valign="top">
                                          <input type="number" name="Gross[]" id="Gross_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">                                            </td>
                                            <td valign="top">
                                                <select name="Tax[]" id="TaxID_1" class="form-control changesNo tax exclusive_cal" required="">
                                                    <?php foreach ($tax as $key => $valueX1) : ?>
                                                        <option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option>
                                                    <?php endforeach ?>
                                          </select>                                            </td>
                                            <td valign="top">
                                          <input type="number" name="TaxVal[]" id="TaxVal_1" class=" form-control totalLinePrice2" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">                                            </td>

                                            <td valign="top">
                                          <input type="number" name="ItemTotal[]" id="ItemTotal_1" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">                                            </td>
                                        </tr>
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


                                <textarea class="form-control" rows='5' name="CustomerNotes" id="note" placeholder="">Thanks for your business.</textarea>

                                <label for="" class="mt-2">Description</label>
                                <textarea class="form-control" rows='5' name="DescriptionNotes" id="note" placeholder="Description notes if any."></textarea>

                                                        <br>
                                <iframe src="{{URL('/Attachment')}}" width="100%" height="40%" border="0" scrolling="yes" style="overflow: hidden;"></iframe>

                                <div class="mt-2"><button type="submit" class="btn btn-success w-md float-right">Save</button>
                                    <a href="{{URL('/DeliveryChallan')}}" class="btn btn-secondary w-md float-right">Cancel</a>

                                </div>







                            </div>


                            <div class="col-lg-4 col-12 ">
                                <!-- <input type="text" class="form-control" id="TotalTaxAmount" name="TaxTotal" placeholder="TaxTotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"> -->
                                <form class="form-inline">
                                    <div class="form-group mt-1">
                                        <label>Grand Total Tax: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" class="form-control" id="grandtotaltax" name="grandtotaltax" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group mt-1">
                                        <label>Sub Total1: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" class="form-control" id="subTotal" name="SubTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group mt-1">
                                        <label>Discount: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">%</span>

                                            <input type="text" class="form-control" value="0" id="discountper" name="DiscountPer" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" >

                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" name="DiscountAmount" class="form-control" id="discountAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                        </div>
                                    </div>



                                    <div class="form-group mt-1">

                                        <label>Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" name="Total" class="form-control" step="0.01" id="totalafterdisc" readonly placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                        </div>
                                    </div>
                                    <div class="form-group mt-1 d-none">
                                        <label>Tax: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">%</span>

                                            <input type="text" class="form-control" id="taxpercentage" name="Taxpercentage" placeholder="tax %" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">

                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                            <input type="text" name="TaxpercentageAmount" class="form-control" id="taxpercentageAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1">

                                        <label>Shipping: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" name="Shipping" class="form-control" step="0.01" id="shipping" placeholder="Grand Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1">

                                        <label>Grand Total: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" name="Grandtotal" class="form-control" step="0.01" id="grandtotal" placeholder="Grand Total" readonly onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                        </div>
                                    </div>



                                    <div class="form-group mt-1 d-none">
                                        <label>Amount Paid: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" class="form-control" id="amountPaid" name="amountPaid" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0">
                                        </div>
                                    </div>

                                    <div class="form-group mt-1 d-none">

                                        <label>Amount Due: &nbsp;</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                            <input type="number" class="form-control amountDue" name="amountDue" id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div>



                        </div>





            </form>

            <!--  <div class='row'>
          <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <div class="well text-center">
          <h2>Back TO Tutorial: <a href="#"> Invoice System </a> </h2>
        </div>
          </div>
        </div>   -->



        </div>
    </div>
</div>




<script>
    $('input[name=tax_action]').change(function(e) {
        $('.exclusive_cal').val(e.target.value)
    })


    /**
     * Site : http:www.smarttutorials.net
     * @author muni
     */

    var i = $('table tr').length;
    $(".addmore").on('click', function() {
        html = '<tr class= borde-1 border-light">';
        html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';
        html += '<td><select name="ItemID0[]" id="ItemID0_' + i + '"  style="width: 300px !important;" class="form-select select2 changesNoo" onchange="km(this.value,' + i + ');" > <option value="">select</option>}@foreach ($items as $key => $value) <option value="{{$value->ItemID}}|{{$value->Percentage}}">{{$value->ItemCode}}-{{$value->ItemName}}-{{$value->Percentage}}</option>@endforeach</select><input type="hidden" name="ItemID[]" id="ItemID_' + i + '"> <textarea name="Description[]" id="Description[]" rows="2" class="form-control" style="width: 300px !important;"></textarea></td>';



         html += '<td><input type="text" name="Qty[]" id="Qty_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';

        html += '<td><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
        html += '<td><div class="input-group"><input type="text" name="Discount[]" id="Discount_1" class=" form-control hangesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0"><span ><!-- <div class="col-sm-3"><label class="col-form-label" for="password">Salesperson </label></div> --><div class="col-sm-9 input-group"><select name="DiscountType[]" id="DiscountType_' + i + '" class="form-select  bg-light" onchange="DiscountChange()" ><!-- <option value="">Select</option> --><option  value="1">%</option><option  value="2">{{session::get('Currency')}}</option></select></div></span>    </div></td>';

        html += '<td> <input type="number" name="Gross[]" id="Gross_' + i + '" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">  </td>';

        html += '<td><select name="Tax[]" id="TaxID_' + i + '" class="form-control changesNo exclusive_cal"><?php foreach ($tax as $key => $valueX1) : ?><option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option><?php endforeach ?></select></td>';


        html += '<td><input type="number" name="TaxVal[]" id="TaxVal_' + i + '" class=" form-control totalLinePrice2 "autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"></td>';




        html += '<td><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';

        html += '</tr>';
        $('table').append(html);
        $('.select2', 'table').select2();
        i++;



        // var data=<?php //echo $item; 
                    ?>
        // // var data=JSON.parse({{$item}});

        // let country = data.find(value => value.ItemCode === "AP");
        // // => {name: "Albania", code: "AL"}
        // console.log(country);
        // console.log(country["ItemCode"]);

    });





    //to check all checkboxes
    $(document).on('change', '#check_all', function() {
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });

    //deletes the selected table rows

    // var data=JSON.parse({{$item}});

    // let country = data.find(value => value.ItemCode === "AP");
    // // => {name: "Albania", code: "AL"}
    // console.log(country);
    // console.log(country["ItemCode"]);

    //org 
    //$(document).on('  keyup blur select','.changesNoo',function(){


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

         var Qty = $('#Qty_' + id[1]).val();
        var Price = $('#Price_' + id[1]).val();
        var QtyRate = parseFloat(Price) * parseFloat(Qty);




        
        var DiscountType = $('#DiscountType_' + id[1]).val();
        var Discount = $('#Discount_' + id[1]).val();

        if (Discount != '' && typeof(Discount) != "undefined") {


        if(DiscountType=1) // 1 is for % disount, 2 is for amount as discount
        {
            DiscountAmount = parseFloat(QtyRate) * (parseFloat(Discount) / 100);
        }
        else
        {
            DiscountAmount = (parseFloat(Discount) / parseFloat(QtyRate)) * 100;

        }


        $('#Gross_' + id[1]).val(  parseFloat(QtyRate-DiscountAmount).toFixed(2)  );

}
 





        $('#TaxID_' + id[1]).val(json["Percentage"]);


        $('#TaxVal_' + id[1]).val(((parseFloat(json["Percentage"])) / 100) * (parseFloat(json["SellingPrice"])));


        $('#ItemTotal_' + id[1]).val(((parseFloat(json["SellingPrice"]) * parseFloat($('#Qty_' + id[1]).val())) + (((parseFloat(json["Percentage"])) / 100) * (parseFloat(json["SellingPrice"])))).toFixed(2));



        calculateTotal();

        if (isNaN($('#discountAmount').val())) {
            $('#discountAmount').val(0);
        }

        calculatediscount();
        calculateTotal();



    }









    $(document).on(' keyup blur select', '.changesNoo123', function() {

        id_arr = $(this).attr('id');
        id = id_arr.split("_");


        var data = <?php echo $item; ?>;

        var data = <?php echo $item; ?> // this is dynamic data in json_encode(); from controller

        var item_idd = $('#ItemID_' + id[1]).val();

        var index = -1;
        var val = parseInt(item_idd);
        var json = data.find(function(item, i) {
            if (item.ItemID === val) {
                index = i + 1;
                return i + 1;
            }
        });

        $('#Qty_' + id[1]).val(1);
        $('#Price_' + id[1]).val(json["SellingPrice"]);



        $('#ItemTotal_' + id[1]).val((parseFloat(json["SellingPrice"]) * parseFloat($('#Qty_' + id[1]).val())).toFixed(2));



        calculateTotal();

        if (isNaN($('#discountAmount').val())) {
            $('#discountAmount').val(0);
        }

        calculatediscount();
        calculateTotal();



    });



    //deletes the selected table rows
    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
        calculateTotal();
    });




    


    //price change
    $(document).on('change keyup blur ', '.changesNo', function() {



        id_arr = $(this).attr('id');
        id = id_arr.split("_");

        Qty = $('#Qty_' + id[1]).val();

        TaxPer = $('#TaxID_' + id[1]).val();

        Price = $('#Price_' + id[1]).val();


        var Qty = $('#Qty_' + id[1]).val();
        var Price = $('#Price_' + id[1]).val();
        var QtyRate = parseFloat(Price) * parseFloat(Qty);




        
        var DiscountType = $('#DiscountType_' + id[1]).val();
        var Discount = $('#Discount_' + id[1]).val();

        if (Discount != '' && typeof(Discount) != "undefined") {


        if(DiscountType=1) // 1 is for % disount, 2 is for amount as discount
        {
            DiscountAmount = 11   ;
        }
        else

        {
            DiscountAmount = 22;

        }



        $('#Gross_' + id[1]).val( DiscountAmount   );

}
 




        TotalPrice = parseFloat(Qty) * parseFloat(Price);

        TotalTaxPer = (parseFloat(TaxPer) / 100) * parseFloat(Gross);


        ItemTotal = parseFloat(TotalPrice) + parseFloat(TotalTaxPer);


        $('#ItemTotal_' + id[1]).val(ItemTotal);
        $('#TaxVal_' + id[1]).val(parseFloat(TotalTaxPer));



       calculatediscount();
        calculateTotal();
    });

    //////////

    $(document).on(' blur', '.totalLinePrice', function() {



        id_arr = $(this).attr('id');
        id = id_arr.split("_");



        total = $('#total_' + id[1]).val();








        Profit = (parseFloat(total) - parseFloat(Fare)).toFixed(2);




        $('#Service_' + id[1]).val(parseFloat(Profit) - (parseFloat(Profit / 100) * parseFloat(Tax)).toFixed(2));

        $('#quantity_' + id[1]).val((parseFloat(Profit / 100) * parseFloat(Tax)).toFixed(2));
        // Profit = (parseFloat(total)-parseFloat(Fare)).toFixed(2) ;

        // Tax = ;

        // Service = (parseFloat(Proft)-parseFloat(Tax)).toFixed(2) ;

        // alert(Profit+Tax+Service);

        // $('#quantity'+id[1]).val( Tax );
        // $('#Service_'+id[1]).val( Service );



    });

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
        subTotal = 0;
        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });
        subTotal = parseFloat($('#subTotal').val());


        discountper = $('#discountper').val();
        // totalafterdisc = $('#totalAftertax').val();
        // console.log('testing'.totalAftertax);
        if (discountper != '' && typeof(discountper) != "undefined") {
            discountamount = parseFloat(subTotal) * (parseFloat(discountper) / 100);

            $('#discountAmount').val(parseFloat(discountamount.toFixed(2)));
            total = subTotal - discountamount;
            $('#totalafterdisc').val(total.toFixed(2));
            // $('#grandtotal').val(total.toFixed(2));

        } else {
            $('#discountper').val(0);
            // alert('dd');
            $('#DiscountAmount').val(0);
            total = subTotal;
            $('#totalafterdisc').val(total.toFixed(2));

        }

    }


    $(document).on('blur', '#discountAmount', function() {

 calculateTotal();
        calculatediscountper();
         calculateTotal();

    });

    function calculatediscountper() {
        subTotal = 0;

        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });
        subTotal = parseFloat($('#subTotal').val());


        discountAmount = $('#discountAmount').val();
        // totalafterdisc = $('#totalAftertax').val();
        // console.log('testing'.totalAftertax);
        if (discountAmount != '' && typeof(discountAmount) != "undefined") {
            discountper = (parseFloat(discountAmount) / parseFloat(subTotal)) * 100;

            $('#discountper').val(parseFloat(discountper.toFixed(2)));
            total = subTotal - discountAmount;
            $('#totalafterdisc').val(total.toFixed(2));
            // $('#grandtotal').val(total.toFixed(2));

        } else {
            $('#discountper').val(0);
            // alert('dd');
            $('#discountper').val(0);
            total = subTotal;
            $('#totalafterdisc').val(total.toFixed(2));

        }

    }

    //////////////////

    // discount percentage
    $(document).on('change keyup blur onmouseover onclick', '#discountper', function() {
         calculateTotal();
        calculatediscount();


        calculateTotal();

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
        grand_tax = 0;
        subTotal = 0;
        total = 0;
        total2 = 0;
        sumtax = 0;
        gt = 0;
        grandtotaltax = 0;
        var pretotal = 0;

        $('.totalLinePrice').each(function() {
            if ($(this).val() != '') subTotal += parseFloat($(this).val());
        });
        $('.totalLinePrice2').each(function() {
            if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
        });

        $('#grandtotaltax').val(grandtotaltax.toFixed(2));
        console.log(grandtotaltax);
        discountper = $('#discountper').val();

        if (discountper != '' && typeof(discountper) != "undefined") {

        }

        $('#subTotal').val(subTotal.toFixed(2));
        pretotal = $('#totalafterdisc').val();
        discountAmount = $('#discountAmount').val();
        tax = $('#tax').val();
        grand_tax = $('#taxpercentage').val();

        if (grand_tax != '' && typeof(grand_tax) != "undefined") {
            gt = subTotal * (parseFloat(grand_tax) / 100);

            $('#taxpercentageAmount').val(gt.toFixed(2));
            total2 = subTotal + gt - discountAmount;
        } else {
            $('#taxpercentage').val(0);
            total2 = subTotal - pretotal;
        }


        shipping = parseFloat($('#shipping').val());

        shipping_grand = shipping + total2;
        $('#grandtotal').val(shipping_grand.toFixed(2));

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


<!-- END: Content-->

@endsection