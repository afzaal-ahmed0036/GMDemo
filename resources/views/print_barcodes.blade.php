@extends('template.tmp')
@section('title', 'Print BarCode')
@section('content')
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
    </style>
    <div class="main-content">
        <div class="page-content">
            <section class="forms">
                <div class="container-fluid">
                    @if (session('error'))
                        <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                            <strong>{{ Session::get('error') }} </strong>
                        </div>
                    @endif
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
                        </div>
                    @endif
                    @if (session()->has('not_permitted'))
                        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                                data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
                    @endif
                    @if (count($errors) > 0)
                        <div>
                            <div class="alert alert-danger p-1 border-1 bg-danger text-white">
                                <p class="font-weight-bold"> There were some problems with your input.</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h4>{{ trans('file.print_barcode') }}</h4>
                                </div>
                                <div class="card-body">
                                    <p class="italic">
                                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                                    </p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>{{ trans('file.add_product') }} *</label>
                                                    <div class="search-box input-group">

                                                        <button type="button" class="btn btn-secondary btn-lg"><i
                                                                class="fa fa-barcode"></i></button>
                                                        <input type="text" name="product_code_name"
                                                            id="lims_productcodeSearch"
                                                            placeholder="Please type product code and select..."
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="table-responsive mt-3">
                                                        <table id="myTable" class="table table-hover order-list">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{ trans('file.name') }}</th>
                                                                    <th>{{ trans('file.Code') }}</th>
                                                                    <th>{{ trans('file.Quantity') }}</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <input type="submit" value="{{ trans('file.submit') }}"
                                                    class="btn btn-primary" id="submit-button">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="print-barcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal fade text-left">
                    <div role="document" class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="modal_header" class="modal-title">{{ trans('file.Barcode') }}</h5>&nbsp;&nbsp;
                                <button id="print-btn" type="button" class="btn btn-default btn-sm"><i
                                        class="dripicons-print"></i> {{ trans('file.Print') }}</button>
                                <button type="button" id="close-btn" data-bs-dismiss="modal" aria-label="Close"
                                    class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <div id="label-content">
                                </div>
                            </div>
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
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/bootstrap-datepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.timepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap-select.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/keyboard/js/jquery.keyboard.js'); ?>"></script>



    <script type="text/javascript" src="<?php echo asset('vendor/keyboard/js/jquery.keyboard.extension-autocomplete.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/grasp_mobile_progress_circle-1.0.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery.cookie/jquery.cookie.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/chart.js/Chart.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/charts-custom.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/front.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/daterange/js/moment.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/daterange/js/knockout-3.4.2.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/daterange/js/daterangepicker.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/dropzone.js'); ?>"></script>

    <!-- table sorter js-->
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/pdfmake.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/vfs_fonts.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.buttons.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.bootstrap4.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.colVis.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.html5.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.print.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo asset('vendor/datatable/sum().js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.checkboxes.min.js'); ?>"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js">
    </script>
    <!-- Custom stylesheet - for your changes-->

    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #printBarcode-menu").addClass("active");
        <?php $productArray = []; ?>
        var lims_product_code = [
            @foreach ($lims_product_list_without_variant as $product)
                <?php
                $productArray[] = htmlspecialchars($product->ItemCode . ' (' . $product->ItemName . ')');
                ?>
            @endforeach
            <?php
            echo '"' . implode('","', $productArray) . '"';
            ?>
        ];
        var lims_productcodeSearch = $('#lims_productcodeSearch');
        lims_productcodeSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(lims_product_code, function(item) {
                    return matcher.test(item);
                }));
            },
            select: function(event, ui) {
                var data = ui.item.value;
                $.ajax({
                    type: 'GET',
                    url: 'products/lims_product_search',
                    data: {
                        data: data
                    },
                    success: function(data) {
                        var flag = 1;
                        $(".product-code").each(function() {
                            if ($(this).text() == data[1]) {
                                alert('duplicate input is not allowed!')
                                flag = 0;
                            }
                        });
                        $("input[name='product_code_name']").val('');
                        if (flag) {
                            console.log(data[3]);
                            var newRow = $('<tr data-imagedata="' + data[3] + '" data-price="' +
                                data[2] + '" data-promo-price="' + data[4] +
                                '" data-currency="' + data[5] + '" data-currency-position="' +
                                data[6] + '">');
                            var cols = '';
                            cols += '<td>' + data[0] + '</td>';
                            cols += '<td class="product-code">' + data[1] + '</td>';
                            cols +=
                                '<td><input type="number" class="form-control qty" name="qty[]" value="1" /></td>';
                            cols +=
                                '<td><a href="#" class="ibtnDel"><i class="bx bx-trash  align-middle me-1"></i></a></td>';

                            newRow.append(cols);
                            $("table.order-list tbody").append(newRow);
                        }
                    }
                });
            }
        });

        //Delete product
        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            rowindex = $(this).closest('tr').index();
            $(this).closest("tr").remove();
        });

        $("#submit-button").on("click", function(event) {
            var product_name = [];
            var code = [];
            var price = [];
            var promo_price = [];
            var qty = [];
            var barcode_image = [];
            var currency = [];
            var currency_position = [];
            var rownumber = $('table.order-list tbody tr:last').index();
            for (i = 0; i <= rownumber; i++) {
                /*product_name.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(1)').text());*/
                code.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(2)').text());
                /*price.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('price'));
                promo_price.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('promo-price'));
                currency.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('currency'));
                currency_position.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('currency-position'));*/
                qty.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.qty').val());
            }

            $.ajax({
                type: 'GET',
                url: 'products/lims_sticer_search',
                data: {
                    code: code,
                    qty: qty
                },
                success: function(data) {

                    window.open(data.url);

                }
            });


            //alert(code);
            //alert(qty);
            /*var htmltext = '<table class="barcodelist" style="width:378px;" cellpadding="5px" cellspacing="10px">';

            $.each(qty, function(index){
                i = 0;
                while(i < qty[index]) {
                    if(i % 6 == 0)
                        htmltext +='<tr></tr>';
                    // 36mm
                    if(paper_size == 36)
                        htmltext +='<td style="width:164px;height:88%;padding-top:7px;vertical-align:middle;text-align:center">';
                    //24mm
                    else if(paper_size == 24)
                        htmltext +='<td style="width:164px;height:100%;font-size:12px;text-align:center">';
                    //18mm
                    else if(paper_size == 18)
                        htmltext +='<td style="width:164px;height:100%;font-size:10px;text-align:center">';

                    if($('input[name="name"]').is(":checked"))
                        htmltext += product_name[index] + '<br>';

                    if(paper_size == 18)
                        htmltext += '<img style="max-width:150px;" src="data:image/png;base64,'+barcode_image[index]+'" alt="barcode" /><br>';
                    else
                        htmltext += '<img style="max-width:150px;" src="data:image/png;base64,'+barcode_image[index]+'" alt="barcode" /><br>';

                    htmltext += code[index] + '<br>';
                    if($('input[name="code"]').is(":checked"))
                        htmltext += '<strong>'+code[index]+'</strong><br>';
                    if($('input[name="promo_price"]').is(":checked")) {
                        if(currency_position[index] == 'prefix')
                            htmltext += 'Price: '+currency[index]+'<span style="text-decoration: line-through;"> '+price[index]+'</span> '+promo_price[index]+'<br>';
                        else
                            htmltext += 'Price: <span style="text-decoration: line-through;">'+price[index]+'</span> '+promo_price[index]+' '+currency[index]+'<br>';
                    }
                    else if($('input[name="price"]').is(":checked")) {
                        if(currency_position[index] == 'prefix')
                            //htmltext += 'Price: '+currency[index]+' '+price[index];
                            htmltext += 'Price: '+price[index];
                        else
                            //htmltext += 'Price: '+price[index]+' '+currency[index];
                            htmltext += 'Price: '+price[index];
                    }
                    htmltext +='</td>';
                    i++;
                }
            });
            htmltext += '</table">';*/
            //$('#label-content').html(htmltext);
            //$('#print-barcode').modal('show');

        });



        $("#print-btn").on("click", function() {
            var divToPrint = document.getElementById('print-barcode');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<style type="text/css">@media print { #modal_header { display: none } #print-btn { display: none } #close-btn { display: none } } table.barcodelist { page-break-inside:auto } table.barcodelist tr { page-break-inside:avoid; page-break-after:auto }</style><body onload="window.print()">' +
                divToPrint.innerHTML + '</body>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);
        });
    </script>
@endpush
