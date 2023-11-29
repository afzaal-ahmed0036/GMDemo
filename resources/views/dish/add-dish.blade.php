@extends('template.tmp')
@section('title', 'Add Single Dish')

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
    .disabled{
        pointer-events:none;
        opacity:0.6;
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
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h2>Create Single Dish</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{url('/saveSingleDish')}}" method="post" enctype="multipart/form-data">
                            <h4>Dish Detail</h4>
                            <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}"> 
                              <div class="row mt-4">
                                <div class="form-group col-md-6">
                                    <label>Dish Name <sup class="text-danger">*</sup></label>
                                     <input type="text" name="name" class="form-control" placeholder="Dish Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Price <sup class="text-danger">*</sup></label>
                                    <input type="number" name="price" placeholder="Dish Price" class="form-control" required>
                                </div>
                                  
                              </div>
                              <div class="row mt-4">
                                
                                <div class="form-group col-md-6">
                                    <label>Code <sup class="text-danger">*</sup></label>
                                    <input type="number" name="code" class="form-control" placeholder="Enter Numeric Code"  required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Thumbnail <sup class="text-danger">*</sup></label>
                                    <input type="file" name="image_thumbnail" class="form-control" accept="image/*">
                                </div>
                              </div>
                              <h4 class="mt-4">Dish Recipe</h4>

                              <div class='row'>
                                <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                    <table>
                                        <thead>
                                            <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                                <th width="1%" class="text-center"><input id="check_all" type="checkbox" /></th>
                                                <th style="width: 33.33%;">ITEM DETAILS</th>
                                                <th style="width: 33.33%;">Unit need to cook</th>
                                                <th style="width: 33.33%;">Child Unit need to cook</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="p-3">
                                                <td class="p-1 bg-light borde-1 border-light text-center"><input class="case" type="checkbox" /></td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <select name="ItemID0[]" id="ItemID0_1" class="item form-select form-control-sm select2 changesNoo" onchange="km(this.value,1);">
                                                            <option>Select Item</option>
                                                            @foreach($kitchen_items as $item)
                                                                <option value="{{$item->ItemID}}">{{$item->ItemName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="ItemID[]" id="ItemID_1">
                                                </td>

                                                <td>
                                                    <div class="input-group mb-3">
                                                      <input type="number" class="form-control changesNo" name="base_unit_amount_cooked[]" aria-label="Amount (to the nearest dollar)"step="0.01" id="unit_input_1" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required>
                                                      <div class="input-group-append">
                                                        <span class="input-group-text" id="unit_1">.00</span>
                                                      </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                      <input type="number" class="form-control changesNo" name="child_unit_amount_cooked[]" id="child_unit_input_1" step="0.01" aria-label="Amount (to the nearest dollar)" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required>
                                                      <div class="input-group-append">
                                                        <span class="input-group-text" id="childUnit_1">.00</span>
                                                      </div>
                                                    </div>
                                                </td>
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

                              <div align="right" class="mt-4">
                                    <button type="submit" class="btn btn-success">Save Dish</button>
                                
                              </div>
                              
                          </form>
                          
                    </div>
            </div>
        </div>
    </div>
</div>


<script>
    var convert_rate = 0;

    //adds extra table rows
    var i = $('table tr').length;
    $(".addmore").on('click', function() {
        html = '<tr class="bg-light borde-1 border-light ">';
        html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';

        html += '<td><div class="input-group mb-3"><select name="ItemID0[]" id="ItemID0_'+i+'" class="form-select changesNoo" onchange="km(this.value,'+i+');"> <option value="">Select</option>}@foreach ($kitchen_items as $item)<option value="{{$item->ItemID}}">{{$item->ItemName}}</option>@endforeach</select></div><input type="hidden" name="ItemID[]" id="ItemID_'+i+'"></td>';

        html += '<td><div class="input-group mb-3"><input type="number" class="form-control changesNo" name="base_unit_amount_cooked[]" aria-label="Amount (to the nearest dollar)"step="0.01" id="unit_input_'+i+'" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" <div class="input-group-append"><span class="input-group-text" id="unit_'+i+'">.00</span></div></div></td>';

        html += '<td><div class="input-group mb-3"><input type="number" class="form-control changesNo" name="child_unit_amount_cooked[]" id="child_unit_input_'+i+'" step="0.01" aria-label="Amount (to the nearest dollar)" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" required><div class="input-group-append"><span class="input-group-text" id="childUnit_'+i+'">.00</span></div></div></td>';

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
                type: 'GET',
                url: '{{url("get-unit-of-item")}}' +'/'+ item_idd,
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

                        $('#unit_' + id[1]).text(data.base_unit);
                        $('#childUnit_' + id[1]).text(data.child_unit);
                        convert_rate = data.unit_value;

                    }
                }
            });

        } else {
            alert('Please Select Dish Type');
        }

        $("#unit_input_" + id[1]).on('keyup', function () {
            if (convert_rate != 0) {
                $("#child_unit_input_" + id[1]).val($("#unit_input_" + id[1]).val() * convert_rate);
            }

        });

        $('#child_unit_input_' + id[1]).on('keyup', function () {
            if (convert_rate != 0) {
                $("#unit_input_" + id[1]).val($("#child_unit_input_" + id[1]).val() / convert_rate);
            }
        });

    }
    //deletes the selected table rows
    $(".delete").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('#check_all').prop("checked", false);
    });



    $(document).on('change', '.changesNoo', function() {


        id_arr = $(this).attr('id');
        id = id_arr.split("_");

        val = $('#ItemID0_' + id[1]).val().split("|");


        // alert($('#ItemID0_'+id[1]).val());
        $('#ItemID_' + id[1]).val(val[0]);


        

    });


    //It restrict the non-numbers
    var specialKeys = new Array();
    specialKeys.push(8, 46); //Backspace
    function IsNumeric(e) {
        var keyCode = e.which ? e.which : e.keyCode;
        // console.log(keyCode);
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    }

</script>

@endsection