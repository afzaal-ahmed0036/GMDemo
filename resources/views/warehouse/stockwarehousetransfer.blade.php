@extends('tmp')
@section('title', $pagetitle)

@section('page-styles')

<style>
    .invalid-feedback {
        display: block !important;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }

    .is-hide {
        display: none;
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<!-- multipe image upload  -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="multiple/dist/imageuploadify.min.css" rel="stylesheet">

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">


<style>
    .edit_footer {
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
@endsection
@section('content')

<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>
<!-- SPEND CODE ENDS HERE -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <form action="{{route('warehouse.stock-warehouse-transfer')}}" method="post" name="form1" id="form1">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="alert alert-danger" role="alert" style="display:none">
                                <strong>Oh snap!</strong> Change a few things up and try submitting again.
                            </div>
                            <div class="alert alert-success" role="alert" style="display:none">
                                <strong>Success !</strong> Selected item has been transfered to warehouse.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="password">From Ware House </label>
                                    </div>
                                    <div class="col-sm-9">


                                        <select name="from_warehouse_id" id="from_warehouse_id" class="select2 form-select mt-5 my_class" onchange="getValue(this);" data-id='shah'>
                                            <option value="">All WareHouses</option>
                                            @foreach ($warehouses as $key => $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="warehouseid" id="warehouseid" value="">

                                    </div>
                                </div>

                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="">{{trans('file.Select Product')}}</label>
                                    </div>

                                    <div class="col-sm-9">
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="col-12">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">To Ware House </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <div id="invoict_type">

                                                <select name="to_warehouse_id" id="to_warehouse_id" class="select2 form-select my_class" id="select2-basic">
                                                    <option value="">All WareHouses</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="invoice-spacing">

                            <div class='text-center'>

                            </div>
                            <!-- <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table>
                                        <thead>
                                            <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                                <th width="1%" class="text-center"> </th>
                                                <th width="10%">ITEM DETAILS</th>
                                                <th width="4%">Stock Quantity</th>
                                                <th width="4%">Enter Quantity</th>
                                                <th width="4%">Action</th>
                                            </tr>
                                        </thead>


                                        <tbody class="form-group">
                                        </tbody>
                                    </table>
                                </div>
                            </div> -->


                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <h5>{{trans('file.Order Table')}} *</h5>
                                    <div class="table-responsive mt-3">
                                        <table id="myTable" class="table table-hover order-list">
                                            <thead>
                                                <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                                    <th>{{trans('file.name')}}</th>
                                                    <th>{{trans('file.Code')}}</th>
                                                    <th>Stock Quantity</th>
                                                    <th>{{trans('file.Quantity')}}</th>
                                                    <!--<th>{{trans('file.Net Unit Price')}}</th>
                                                    <th>{{trans('file.Discount')}}</th>
                                                    <th>{{trans('file.Tax')}}</th> 
                                                    <th>{{trans('file.Subtotal')}}</th>-->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- ENTER NEW TABLE -->
                            <div class="row mt-4">
                                <div class="col-lg-8 col-12  ">
                                    <button type="submit" class="btn btn-success w-lg float-right" id="submit">Transfer Products</button>
                                    <button type="reset" class="btn btn-secondary w-lg float-right" id="submit">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('page-scripts')

<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/keyboard/js/jquery.keyboard.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/keyboard/js/jquery.keyboard.extension-autocomplete.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
<!-- Custom stylesheet - for your changes-->
<script type="text/javascript">
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

    function getWareHouseProducts(warehouseId) {
        let url = "{{route('sale.getproduct',':warehouseId')}}";
        route = url.replace(':warehouseId', warehouseId);
        $.ajax({
            url: route,
            type: "GET",
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {},
            success: function(data) {
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
                        product_qty[index] = product_qty[index] + exist_qty[pos];
                        exist_code.splice(pos, 1);
                        exist_qty.splice(pos, 1);
                    }
                    lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
                });
                $.each(exist_code, function(index) {
                    product_type.push(exist_type[index]);
                    product_code.push(exist_code[index]);
                    product_qty.push(exist_qty[index]);
                });
                $("#overlay").fadeOut(300);


            }
        }); // DONE ENDS HERE
    }
    $(document).ready(function() {
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

        // code here
    });

    function productSearch(data) {
        var warehouseid = $('#warehouseid').val();
        let url = "{{route('warehouse.getproductdetais',[':warehouseid'])}}";
        route   = url.replace(':warehouseid', warehouseid);
        //route   = route.replace(':product_id', data);
         
        //var url = "{{route('product_sale.search')}}?warehouseid=" + warehouseid;
        $.ajax({
            type: 'GET',
            url: route,
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
                    cols += '<td>' + data[0] + '</td>';
                    cols += '<td>' + data[1] + '</td>';
                    cols += '<td>' + data[12] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[' + data[9] + ']" value="1" step="any" required/></td>';
                    //cols += '<td class="net_unit_price"></td>';
                    //cols += '<td class="discount">0.00</td>';
                    if (data[13] == 'dishItem') {
                        cols += '<input type="hidden" class="itemType" name="itemType[' + data[9] + ']" value="dish"/>';
                    } else {
                        cols += '<input type="hidden" class="itemType" name="itemType[' + data[9] + ']" value="pos"/>';
                    }

                    cols += '<td><button type="button" class="edit-product btn btn-link" > <i class="dripicons-trash"></i></button></td>';
                    newRow.append(cols);
                    $("table.order-list tbody").prepend(newRow);
                    rowindex = newRow.index();
                    pos = product_code.indexOf(data[1]);
                }
            }
        });
    }


    function checkQuantity(sale_qty, flag) {
        var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
        pos = product_code.indexOf(row_product_code);
        if (product_type[pos] == 'standard') {
            var operator = unit_operator[rowindex].split(',');
            var operation_value = unit_operation_value[rowindex].split(',');
            if (operator[0] == '*')
                total_qty = sale_qty * operation_value[0];
            else if (operator[0] == '/')
                total_qty = sale_qty / operation_value[0];
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


    //Delete product
    $("table.order-list tbody").on("click", ".edit-product", function(event) {
        rowindex = $(this).closest('tr').index();
        $(this).closest("tr").remove();
    });




    (function() { // Create the event handler on the document ready event, as we know then that the DOM document that was initially loaded
        // will be rendered about now.
        document.addEventListener('DOMContentLoaded', function() { // Get each of the elements

        });
    })();
    $(document).ready(function() {

        $(document).on('change keyup blur ', '.changesQuantityNo', function() {
            id_arr = $(this).attr('id');
            id = id_arr.split("_");
            var qty = $(this).val();
            var quantity = parseInt($('.stock_quantity_' + id[1]).text());
            var stockQuantity = parseInt(quantity) + (-parseInt(qty));
            $('.remaining_quantity_' + id[1]).text(stockQuantity);
            console.log(quantity);
        });

        var limit = 5; //Set limit for input fields
        var group = $(".form-group"); //Input Field Group
        var add_button = $(".add_input"); //Add input field button 
        //Action for add input button click
        $(add_button).click(function(e) {
            e.preventDefault();
            getProductDetails(group);
        });
        //Action for remove input button click
        $(group).on("click", ".remove_field", function(e) {
            e.preventDefault();
            $(this).closest("tr").remove();
            $(this).parent('tr').remove();
            console.log('shah');
        });

        $(document).ajaxSend(function() {
            $("#overlay").fadeIn(300);
        });

        $(document).ajaxComplete(function() {
            $("#overlay").fadeOut(300);
        });

        $(document).ajaxStop(function() {
            $("#overlay").fadeOut(300);
        });

    });

    function getValue(option) {
        var warehouseId = option.value;
        $('#warehouseid').val(warehouseId);
        var fetchwarehouses = "{{route('warehouse.fetchwarehouses',':warehouseId')}}";
        routes = fetchwarehouses.replace(':warehouseId', warehouseId);
        getWareHouseProducts(warehouseId);
        $.ajax({
            url: routes,
            type: "GET",
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {},
            success: function(response) {
                var html = '<option vale="">Please Select Warehouse</option>';
                $.each(response['warehouses'], function(key, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#to_warehouse_id').html(html);
                /*  if (response['products'].length !== 0) {
                     var product = '<option vale="">Please Chose Item</option>';
                     $.each(response['products'], function(key, value) {
                         product += '<option value="' + value.ItemID + '">' + value.ItemName + '</option>';

                     });
                 } else {
                     var product = '<option vale="">No Items Found.</option>';
                 }
                 $('#ItemID').html(product); */
            }
        });
    }


    function getProductDetails(group) {
        var product_id = $('#ItemID').val();
        var warehouseid = $('#warehouseid').val();

        var cartValue = new Object(); // Empty object
        localStorage.setItem("cartValue", JSON.stringify(cartValue));

        let url = "{{route('warehouse.getproductdetais',[':warehouseid',':product_id'])}}";
        route = url.replace(':warehouseid', warehouseid);
        route = route.replace(':product_id', product_id);
        $.ajax({
            url: route,
            type: "GET",
            dataType: 'html',
            processData: false,
            contentType: false,
            beforeSend: function() {}
        }).done(function(response) {
            $(group).append(response); //add input field
            var cartValue = localStorage.getItem('cartValue');
            var cartValue = JSON.parse(cartValue);
            console.log(typeof cartValue);
            if (cartValue === null) {
                console.log(cartValue);
                // Variable is null
            } else {
                // Variable is not null
            }



        }); // DONE ENDS HERE
    }

    function getProductValue(option) {
        var product_id = option.value;
        var warehouseid = $('#warehouseid').val();
        let url = "{{route('warehouse.checkqty',[':warehouseid',':product_id'])}}";
        route = url.replace(':warehouseid', warehouseid);
        route = route.replace(':product_id', product_id);
        $.ajax({
            url: route,
            type: "GET",
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function() {}
        }).done(function(response) {
            $('#qty').val(response.qty);
            // Set the maximum value to 20
            $("#qty").attr("max", response.qty);
        }); // DONE ENDS HERE
    }

    $('#form1').submit(function(event) {
        // Stop form from submitting normally
        event.preventDefault();
        // Get form data
        // var formData = $(this).serialize();
        let formData = new FormData(this);
        let url = "{{route('warehouse.stock-warehouse-transfer')}}";
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#submit").attr('disabled', true);
            },
            success: function(response) {
                $("#submit").attr('disabled', false);
                $('.alert-danger').hide();
                if (response) {
                    $('.alert-success').show();
                    $(':input', '#form1')
                        .not(':button, :submit, :reset, :hidden')
                        .val('')
                        .removeAttr('checked')
                        .removeAttr('selected');

                    setTimeout(function() {
                        $("#overlay").fadeOut(300);
                        $('.alert-success').hide();
                        location.reload(true);
                    }, 3000);
                }
                //Handle success response
            }
        }).fail(function(jqXHR, textStatus) {
            $("#submit").attr('disabled', false);
            var alert_danger = '';
            $.each(jqXHR.responseJSON.errors, function(field_name, error) {
                // $(document).find('[name=' + field_name + ']').after('<div class="invalid-feedback">' + error + '</div>');
                alert_danger += error + '<br/>';
            });
            $('.alert-danger').show();
            $('.alert-danger').html(alert_danger);
            // console.log(jqXHR);
            //onsole.log(textStatus);

            //showing validation errors here? and how to show?
        });



    });
</script>



@endsection