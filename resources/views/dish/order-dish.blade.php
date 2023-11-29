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
            <form action="{{URL('/saveOrderDish')}}" method="post">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Order Dish</h3>
                    </div>
                    <div class="card-body">
                        <div class="row col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="invoice_no" value="{{$invoice_no}}" id="invoice_no" readonly class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="date" name="invoice_date" value="<?php echo date('Y-m-d'); ?>" id="invoice_date" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="dish_table_id" id="dish_table_id" class="form-select form-control-sm select2">
                                        <option value="">Select Table</option>
                                        @foreach ($dish_tables as $dish_table)
                                            <option value="{{$dish_table->id}}">{{$dish_table->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class='row'>
                            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                <table>
                                    <thead>
                                        <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                            <th width="2%" class="text-center"><input id="check_all" type="checkbox" /></th>
                                            <th width="2%">DISH</th>
                                            <th width="2%">DISH TYPE </th>
                                            <th width="2%">QUANTITY</th>
                                            <th width="4%">RATE</th>
                                           <!--  <th width="4%">Tax</th>
                                            <th width="4%">Tax Val</th> -->
                                            <th width="4%">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="p-3">
                                            <td class="p-1 bg-light borde-1 border-light text-center"><input class="case" type="checkbox" /></td>
                                            <td>
                                                <select name="dish_id" id="dish_id_1" class="dish form-select form-control-sm select2" onchange="getDishTypes(this.value,1);" style="width: 300px !important;">
                                                    <option value="">Select Dish</option>
                                                    @foreach ($dishes as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="ItemID0[]" id="ItemID0_1" class="item form-select form-control-sm select2" onchange="km(this.value,1);" style="width: 300px !important;">
                                                    <option value="">select Dish</option>
                                                </select>
                                                <input type="hidden" name="ItemID[]" id="ItemID_1">
                                            </td>
                                            <td>
                                                <input type="number" name="Qty[]" style="width: 200px !important;" id="Qty_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="1">
                                            </td>

                                            <td>
                                                <input type="number" name="Price[]" id="Price_1" class=" form-control" autocomplete="off" onkeypress="return IsNumeric(event);" style="width: 100px !important;" ondrop="return false;" onpaste="return false;" step="0.01" readonly>
                                            </td>
                                            <td class="d-none">
                                                <select name="Tax[]" id="TaxID_1" class="form-control changesNo tax exclusive_cal" required="">
                                                    @foreach ($tax as $key => $valueX1)
                                                        <option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="d-none">
                                                <input type="number" name="TaxVal[]" id="TaxVal_1" class=" form-control totalLinePrice2" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                            </td>

                                            <td>
                                                <input type="number" name="ItemTotal[]" id="ItemTotal_1" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" style="width: 270px !important;" ondrop="return false;" onpaste="return false;" step="0.01" readonly>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3 mb-2">
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

                            <div class="col-lg-6 col-12  ">
                                <div class="form-group mt-1 d-none">
                                    <label>Grand Total Tax: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                        <input type="text" class="form-control" id="grandtotaltax" name="grandtotaltax" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                    </div>
                                </div>
                                <div class="form-group mt-1">
                                    <label>Sub Total: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                        <input type="text" class="form-control" id="subTotal" name="SubTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" readonly>
                                    </div>
                                </div>
                                <div class="form-group mt-1">
                                    <label>Discount: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">%</span>

                                        <input type="text" class="form-control" value="0" id="discountper" name="DiscountPer" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">

                                        <span class="input-group-text bg-light">{{session::get('Currency')}}</span>

                                        <input type="text" name="DiscountAmount" class="form-control" id="discountAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                    </div>
                                </div>
                                <div class="form-group mt-1 d-none">

                                    <label>Shipping: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">{{session::get('Currency')}}</span>
                                        <input type="number" name="Shipping" class="form-control" step="0.01" id="shipping" placeholder="Grand Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                    </div>
                                </div>
                                <div class="mt-4"><button type="submit" class="btn btn-success w-md float-right">Save</button>
                                    <a href="{{URL('/DeliveryChallan')}}" class="btn btn-secondary w-md float-right">Cancel</a>

                                </div>


                            </div>


                            <div class="col-lg-6 col-12 ">
                                <!-- <input type="text" class="form-control" id="TotalTaxAmount" name="TaxTotal" placeholder="TaxTotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"> -->
                                    
                                    



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
        html = '<tr class="bg-light borde-1 border-light ">';
        html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';

        html += '<td><select name="dish_id" id="dish_id_' + i + '" class="dish form-select form-control-sm select2" onchange="getDishTypes(this.value,' + i + ');" style="width: 300px !important;"><option value="">Select Dish</option>@foreach ($dishes as $key => $value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></td>';

        html += '<td><select name="ItemID0[]" id="ItemID0_' + i + '"  style="width: 300px !important;" class="form-select select2 changesNoo" onchange="km(this.value,' + i + ');" > <option value="">select Dish</option></select><input type="hidden" name="ItemID[]" id="ItemID_' + i + '"></td>';

        


        html += '<td><input type="text" name="Qty[]" id="Qty_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" style="width: 200px !important;" ondrop="return false;" onpaste="return false;" value="1"></td>';

        html += '<td><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" style="width: 100px !important;" readonly ondrop="return false;" onpaste="return false;"></td>';
        
        
        html += '<td class="d-none"><select name="Tax[]" id="TaxID_' + i + '" class="form-control changesNo exclusive_cal">@foreach ($tax as $key => $valueX1)<option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option>@endforeach</select></td>';


        html += '<td class="d-none"><input type="number" name="TaxVal[]" id="TaxVal_' + i + '" class=" form-control totalLinePrice2 "autocomplete="off"         onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"></td>';


        
        html += '<td><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" style="width: 270px !important;" readonly onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
        html += '</tr>';
        i++;
        $('table').append(html);
        $('.changesNoo', 'table').select2();


    });





    //to check all checkboxes
    $(document).on('change', '#check_all', function() {
        $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
    });

    function km(v, id) {

        id_arr = 'ItemID0_' + id;
        id = id_arr.split("_");

        val = $('#ItemID0_' + id[1]).val().split("|");


        // alert($('#ItemID0_'+id[1]).val());
        $('#ItemID_' + id[1]).val(val[0]);

        var item_idd = $('#ItemID_' + id[1]).val();
        if (item_idd != "") {
            $.ajax({
                url: "{{URL('/get-dish-type-detail')}}",
                type: "POST",
                data: {
                    _token: $("#csrf").val(),
                    item_idd: item_idd,

                },
                cache: false,
                success: function(data) {
                    if(data){
                        var index = -1;
                        var val = parseInt(item_idd);
                        $.each(data , function(index, value) { 
                          if (value.id === val) {
                                index = i + 1;
                                return i + 1;
                            }
                        });


                        let percentage = 0;
                        $('#Qty_' + id[1]).val(1);
                        $('#Price_' + id[1]).val(parseFloat(data.price));
                        $('#TaxID_' + id[1]).val(percentage);
                        $('#TaxVal_' + id[1]).val(((parseFloat(percentage)) / 100) * (parseFloat(data.price)));
                        $('#ItemTotal_' + id[1]).val(((parseFloat(data.price) * parseFloat($('#Qty_' + id[1]).val())) + (((parseFloat(percentage)) / 100) * (parseFloat(data.price)))).toFixed(2));

                        calculateTotal();

                        if (isNaN($('#discountAmount').val())) {
                            $('#discountAmount').val(0);
                        }

                        calculatediscount();
                        calculateTotal();

                    }
                }
            });
        } else {
            alert('Please Select Dish Type');
        }


        }

    function getDishTypes(dish_id, id)
    {
        id_arr = 'ItemID0_' + id;
        id = id_arr.split("_");

        if (dish_id != "") {
            $.ajax({
                url: "{{URL('/get-dish-types')}}",
                type: "POST",
                data: {
                    _token: $("#csrf").val(),
                    dish_id: dish_id,

                },
                cache: false,
                success: function(data) {
                    if(data){

                        $('#ItemID0_' + id[1]).empty();
                        $('#ItemID0_' + id[1]).append('<option value="">Select Dish Type</option>');
                        $.each(data , function(index, val) { 
                          $('#ItemID0_' + id[1]).append('<option value="'+val.id+'">'+val.type+'</option>');
                        });
                    }
                }
            });
        } else {
            alert('Please Select Branch');
        }
    }






    //deletes the selected table rows
    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
        calculateTotal();
    });




    //autocomplete script
    $(document).on('focus', '.autocomplete_txt', function() {
        type = $(this).data('type');

        if (type == 'productCode') autoTypeNo = 0;
        if (type == 'productName') autoTypeNo = 1;

        $(this).autocomplete({
            source: function(request, response) {
                var array = $.map(prices, function(item) {
                    var code = item.split("|");
                    return {
                        label: code[autoTypeNo],
                        value: code[autoTypeNo],
                        data: item
                    }
                });
                //call the filter here
                response($.ui.autocomplete.filter(array, request.term));
            },
            autoFocus: true,
            minLength: 2,
            select: function(event, ui) {
                var names = ui.item.data.split("|");
                id_arr = $(this).attr('id');
                id = id_arr.split("_");
                $('#itemNo_' + id[1]).val(names[0]);
                $('#itemName_' + id[1]).val(names[1]);
                $('#quantity_' + id[1]).val(1);
                $('#price_' + id[1]).val(names[2]);
                $('#total_' + id[1]).val(1 * names[2]);
                calculateTotal();
            }
        });
    });

    //price change
    $(document).on('change keyup blur ', '.changesNo', function() {

id_arr = $(this).attr('id');
id = id_arr.split("_");

Qty = $('#Qty_' + id[1]).val();

TaxPer = $('#TaxID_' + id[1]).val();

Price = $('#Price_' + id[1]).val();

TotalPrice = parseFloat(Qty) * parseFloat(Price);

TotalTaxPer = (parseFloat(TaxPer) / 100) * parseFloat(TotalPrice);







ItemTotal = parseFloat(TotalPrice) + parseFloat(TotalTaxPer);



$('#ItemTotal_' + id[1]).val(ItemTotal);
$('#TaxVal_' + id[1]).val(parseFloat(TotalTaxPer));



calculatediscount();
calculateTotal();
});


    $(document).on(' blur', '.totalLinePrice', function() {


        id_arr = $(this).attr('id');
        id = id_arr.split("_");



        total = $('#total_' + id[1]).val();


        Profit = (parseFloat(total) - parseFloat(Fare)).toFixed(2);

        $('#Service_' + id[1]).val(parseFloat(Profit) - (parseFloat(Profit / 100) * parseFloat(Tax)).toFixed(2));

        $('#quantity_' + id[1]).val((parseFloat(Profit / 100) * parseFloat(Tax)).toFixed(2));
        // Profit = (parseFloat(total)-parseFloat(Fare)).toFixed(2) ;

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

    //////////////////

    // discount percentage
    $(document).on('change keyup blur onmouseover onclick', '#discountper', function() {
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

<script src="{{asset('assets/js/jquery-3.6.0.js')}}" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script type="text/javascript">
    //<![CDATA[


    $(function() {
        $('#WalkinCustomer').hide();
        $('#SupplierID').change(function() {

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


    $(document).on('change keyup blur onclick', '#ItemID0_1', function() {
        let dataj2 = $("#ItemID0_1").val();
        // alert($("#ItemID0_1").val());
    });

    $(document).on('change keyup blur onclick', '#ItemID0_3', function() {
        let dataj2 = $("#ItemID0_3").val();
        // alert(dataj2);
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

<!-- END: Content-->

@endsection