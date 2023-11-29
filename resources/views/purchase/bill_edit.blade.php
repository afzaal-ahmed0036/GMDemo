@extends('template.tmp')
@section('title', $pagetitle)

@section('content')

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
                <form action="{{ URL('/BillUpdate') }}" method="post">
                    <input type="hidden" name="InvoiceMasterID" value="{{ $invoice_master->InvoiceMasterID }}">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Supplier </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="SupplierID" id="SupplierID" class="form-select select2 mt-5"
                                                name="SupplierID" required>
                                                <?php foreach ($supplier as $key => $value) : ?>
                                                <option value="{{ $value->SupplierID }}"
                                                    {{ $value->SupplierID == $invoice_master->SupplierID ? 'selected=selected' : '' }}>
                                                    {{ $value->SupplierName }}</option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>


                                    {{-- <div class="mb-1 row " id="WalkinCustomer">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">or Walkin Customer
                                            </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="WalkinCustomerName"
                                                value="{{ $invoice_master->WalkinCustomerName }}"
                                                placeholder="Walkin cusomter" id="1WalkinCustomerName">

                                        </div>
                                    </div> --}}



                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Sales Person </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="UserID" id="UserID" class="form-select">
                                                <option value="">Select</option>
                                                <?php foreach ($user as $key => $value) : ?>
                                                <option value="{{ $value->UserID }}"
                                                    {{ $value->UserID == $invoice_master->UserID ? 'selected=selected' : '' }}>
                                                    {{ $value->FullName }}</option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Subject </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="first-name" class="form-control" name="Subject"
                                                placeholder="Let your customer know what this invoice is for"
                                                value="{{ $invoice_master->Subject }}">

                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Tax</label><i
                                                class="fa fa-info-circle" data-toggle="tooltip" data-placement="left"
                                                title="Use this option after creating complete Invoice."></i>
                                        </div>

                                        <div class="col-sm-9">
                                            <select name="UserI D" id="seletedVal" class="form-select"
                                                onchange="GetSelectedTextValue(this)">
                                                <?php foreach ($tax as $key => $valueX1) : ?>
                                                <option value="{{ $valueX1->TaxPer }}">{{ $valueX1->Description }}
                                                </option>
                                                <?php endforeach ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="warehouse">Warehouse</label>
                                        </div>

                                        <div class="col-sm-9">
                                            <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                                                @foreach ($lims_warehouse_list as $warehouse)
                                                    <option value="{{ $warehouse->id }}"
                                                        {{ @$invoice_master->WarehouseID == $warehouse->id ? 'selected' : '' }}>
                                                        {{ $warehouse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="col-12">

                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Bill # </label>
                                            </div>
                                            <div class="col-sm-9 pt-2 fw-bold">
                                                <div id="invoict_type"> <input readonly type="text" name="InvoiceNo"
                                                        id="InvoiceNo" autocomplete="off" class="form-control"
                                                        value="{{ $invoice_master->InvoiceNo }}"></div>
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
                                                    <input type="text" name="Date" autocomplete="off"
                                                        class="form-control" placeholder="yyyy-mm-dd"
                                                        data-date-format="yyyy-mm-dd" data-date-container="#datepicker21"
                                                        data-provide="datepicker" data-date-autoclose="true"
                                                        value="{{ \Carbon\Carbon::parse($invoice_master->Date)->format('Y-m-d') }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="contact-info">Due
                                                    Date</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="input-group" id="datepicker22">
                                                    <input type="text" name="DueDate" autocomplete="off"
                                                        class="form-control" placeholder="yyyy-mm-dd"
                                                        data-date-format="yyyy-mm-dd" data-date-container="#datepicker22"
                                                        data-provide="datepicker" data-date-autoclose="true"
                                                        value="{{ $invoice_master->DueDate }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Ref (L.P.O) #
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="ReferenceNo" autocomplete="off"
                                                    class="form-control" value="{{ $invoice_master->ReferenceNo }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class=" mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label text-danger" for="password">Payment Mode </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select name="PaymentMode" id="PaymentMode" class="form-select">
                                                <option value="Cash"
                                                    {{ $invoice_master->PaymentMode == 'Cash' ? 'selected' : '' }}>Cash
                                                </option>
                                                <option value="Cheque"
                                                    {{ $invoice_master->PaymentMode == 'Cheque' ? 'selected' : '' }}>
                                                    Cheque</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-12" id="paymentdetails">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Cheque Details
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="PaymentDetails" class="form-control "
                                                    value="{{ $invoice_master->PaymentDetails }}">

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
                                            <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                                <th width="2%" class="text-center"><input id="check_all"
                                                        type="checkbox" /></th>
                                                <th width="2%">ITEM DETAILS </th>
                                                <th width="10%">DESCRIPTION </th>

                                                <th width="4%">QUANTITY</th>
                                                <th width="4%">RATE</th>
                                                <th width="4%" class="d-none">Tax</th>
                                                <th width="4%" class="d-none">Tax Val</th>
                                                <th width="4%">AMOUNT</th>
                                                <th width="4%">Selling Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($invoice_detail as $key => $value1)
                                                <?php $no = $key + 1; ?>
                                                <tr class="p-3">
                                                    <td class="p-1"><input class="case" type="checkbox" /></td>
                                                    <td>

                                                        <select name="ItemID0[]" id="ItemID0_{{ $no }}"
                                                            class="item form-select form-control-sm changesNoo select2"
                                                            onchange="km(this.value,{{ $no }});"
                                                            style="width: 300px !important;">
                                                            <option value="">select</option>
                                                            @foreach ($items as $key => $value)
                                                                <option value="{{ $value->ItemID }}"
                                                                    {{ $value->ItemID == $value1->ItemID ? 'selected=selected' : '' }}>
                                                                    {{ $value->ItemCode }}-{{ $value->ItemName }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="ItemID[]"
                                                            id="ItemID_{{ $no }}"
                                                            value="{{ $value1->ItemID }}">
                                                    </td>
                                                    <td><input type="text" name="Description[]" id="Description_1"
                                                            class=" form-control " value="{{ $value1->Description }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="Qty[]"
                                                            id="Qty_{{ $no }}" class=" form-control changesNo"
                                                            autocomplete="off" onkeypress="return IsNumeric(event);"
                                                            ondrop="return false;" onpaste="return false;" step="0.01"
                                                            value="{{ $value1->Qty }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="Price[]"
                                                            id="Price_{{ $no }}"
                                                            class=" form-control changesNo" autocomplete="off"
                                                            onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                            onpaste="return false;" step="0.01"
                                                            value="{{ $value1->Rate }}">
                                                    </td>
                                                    <td class="d-none">
                                                        <select name="Tax[]" id="TaxID_{{ $no }}"
                                                            class="form-control changesNo tax exclusive_cal"
                                                            required="">
                                                            <?php foreach ($tax as $key => $valueX1) : ?>
                                                            <option value="{{ $valueX1->TaxPer }}"
                                                                {{ $valueX1->TaxPer == $value1->TaxPer ? 'selected=selected' : '' }}>
                                                                {{ $valueX1->Description }}</option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </td>
                                                    <td class="d-none">
                                                        <input type="number" name="TaxVal[]"
                                                            value="{{ $value1->Tax }}" id="TaxVal_{{ $no }}"
                                                            class=" form-control totalLinePrice2" autocomplete="off"
                                                            onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                            onpaste="return false;" step="0.01">

                                                    </td>
                                                    <td>
                                                        <input type="number" name="ItemTotal[]"
                                                            id="ItemTotal_{{ $no }}"
                                                            class=" form-control totalLinePrice " autocomplete="off"
                                                            onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                            onpaste="return false;" step="0.01"
                                                            value="{{ $value1->Total }}">
                                                    </td>
                                                    <td>
                                                        <input required type="number" name="sellingPrice[]"
                                                            id="sellingPrice_1" class=" form-control" autocomplete="off"
                                                            onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                            onpaste="return false;" step="0.01"
                                                            value="{{ $value1->selling_price }}">
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
                                    <button class="btn btn-danger delete" type="button"><i
                                            class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                                    <button class="btn btn-success addmore" type="button"><i
                                            class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

                                </div>

                                <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                                    <div id="result"></div>

                                </div>
                                <br>

                            </div>


                            <div class="row mt-4">

                                <div class="col-lg-8 col-12  ">
                                    <h6>Customer Notes: </h6>
                                    <textarea class="form-control" rows='5' name="CustomerNotes" id="note" placeholder="">{{ $invoice_master->CustomerNotes }}</textarea>

                                    <label for="" class="mt-2">Description</label>
                                    <textarea class="form-control" rows='5' name="DescriptionNotes" id="note"
                                        placeholder="Description notes if any.">{{ $invoice_master->DescriptionNotes }}</textarea>
                                    <br>
                                    <iframe src="{{ URL('/Attachment') }}" width="100%" height="40%" border="0"
                                        scrolling="yes" style="overflow: hidden;"></iframe>
                                    <div class="mt-2"><button type="submit"
                                            class="btn btn-success w-md float-right">Save</button>
                                        <a href="{{ URL('/Bill') }}"
                                            class="btn btn-secondary w-md float-right">Cancel</a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 ">
                                    <form class="form-inline">
                                        <div class="form-group mt-1">
                                            <label>Grand Total Tax: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" class="form-control" id="grandtotaltax"
                                                    name="grandtotaltax" placeholder="Subtotal"
                                                    value="{{ $invoice_master->Tax }}"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label>Sub Total1: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" class="form-control" id="subTotal"
                                                    name="SubTotal" placeholder="Subtotal"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="{{ $invoice_master->SubTotal }}">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label>Discount: &nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">%</span>

                                                <input type="text" class="form-control" id="discountper"
                                                    name="DiscountPer" placeholder="Tax"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="{{ $invoice_master->DiscountPer }}">

                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" name="DiscountAmount" class="form-control"
                                                    id="discountAmount" onkeypress="return IsNumeric(event);"
                                                    ondrop="return false;" onpaste="return false;"
                                                    value="{{ $invoice_master->DiscountAmount }}">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1">

                                            <label>Total: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Total" class="form-control" step="0.01"
                                                    id="totalafterdisc" readonly placeholder="Total"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="{{ $invoice_master->Total }}">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Tax: &nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">%</span>

                                                <input type="text" class="form-control" id="taxpercentage"
                                                    name="Taxpercentage" placeholder="tax %"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="{{ $invoice_master->TaxPer }}">

                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" name="TaxpercentageAmount" class="form-control"
                                                    id="taxpercentageAmount" onkeypress="return IsNumeric(event);"
                                                    ondrop="return false;" onpaste="return false;"
                                                    value="{{ $invoice_master->Tax }}">
                                            </div>
                                        </div>

                                        <div class="form-group mt-1">

                                            <label>Shipping: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Shipping" class="form-control"
                                                    step="0.01" id="shipping" placeholder="Grand Total"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="{{ $invoice_master->Shipping }}">
                                            </div>
                                        </div>

                                        <div class="form-group mt-1">

                                            <label>Grand Total: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Grandtotal" class="form-control"
                                                    step="0.01" id="grandtotal" placeholder="Grand Total" readonly
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="{{ $invoice_master->GrandTotal }}">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1">
                                            <label>Amount Paid: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" class="form-control" id="amountPaid"
                                                    name="amountPaid" placeholder="Amount Paid"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" step="0.01"
                                                    value="{{ $invoice_master->Paid }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group mt-1">

                                            <label>Amount Due: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" class="form-control amountDue" name="amountDue"
                                                    id="amountDue" placeholder="Amount Due"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" step="0.01"
                                                    value="{{ $invoice_master->Balance }}" readonly>
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

@endsection

@push('after-scripts')
    <script>
        /**
         * Site : http:www.smarttutorials.net
         * @author muni
         */

        //adds extra table rows
        var i = $('table tr').length;
        $(".addmore").on('click', function() {
            html = '<tr class="bg-light borde-1 border-light ">';
            html += '<td class="p-1"><input class="case" type="checkbox"/></td>';
            html += '<td><select name="ItemID0[]" id="ItemID0_' + i +
                '" class="form-select changesNoo select2" onchange="km(this.value,' + i +
                ');" style="width: 300px !important;"> <option value="">select</option>}@foreach ($items as $key => $value) <option value="{{ $value->ItemID }}|{{ $value->Percentage }}">{{ $value->ItemCode }}-{{ $value->ItemName }}</option>@endforeach</select><input type="hidden" name="ItemID[]" id="ItemID_' +
                i + '"></td>';



            html += '  <td><input type="text" name="Description[]" id="Description_' + i +
                '" class=" form-control " ></td>';
            html += '<td><input type="text" name="Qty[]" id="Qty_' + i +
                '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';

            html += '<td><input type="text" name="Price[]" id="Price_' + i +
                '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';


            html += '<td class="d-none"><select name="Tax[]" id="TaxID_' + i +
                '" class="form-control changesNo exclusive_cal"><?php foreach ($tax as $key => $valueX1) : ?><option value="{{ $valueX1->TaxPer }}">{{ $valueX1->Description }}</option><?php endforeach ?></select></td>';


            html += '<td class="d-none"><input type="number" name="TaxVal[]" id="TaxVal_' + i +
                '" class=" form-control totalLinePrice2 "autocomplete="off"    onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"></td>';


            html += '<td><input type="text" name="ItemTotal[]" id="ItemTotal_' + i +
                '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
            html += '<td><input required type="text" name="sellingPrice[]" id="sellingPrice_' + i +
                '" class="form-control" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
            html += '</tr>';
            i++;
            $('table').append(html);
            $('.select2', 'table').select2();



            // var data=<?php //echo $item;
            ?>
            // // var data=JSON.parse({{ $item }});

            // let country = data.find(value => value.ItemCode === "AP");
            // // => {name: "Albania", code: "AL"}
            // console.log(country);
            // console.log(country["ItemCode"]);

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




            // $('#Qty_' + id[1]).val(1);
            $('#Price_' + id[1]).val(json["SellingPrice"]);
            $('#TaxID_' + id[1]).val(json["Percentage"]);
            $('#TaxVal_' + id[1]).val(((parseFloat(json["Percentage"])) / 100) * (parseFloat(json["SellingPrice"])));


            $('#ItemTotal_' + id[1]).val(((parseFloat(json["SellingPrice"]) * parseFloat($('#Qty_' + id[1]).val())) + (((
                parseFloat(json["Percentage"])) / 100) * (parseFloat(json["SellingPrice"])))).toFixed(2));



            calculateTotal();

            if (isNaN($('#discountAmount').val())) {
                $('#discountAmount').val(0);
            }

            calculatediscount();
            calculateTotal();



        }





        $(document).on('  keyup blur select', '.changesNoo', function() {
            // $('.changesNoo').on('click change', function() {
            id_arr = $(this).attr('id');
            id = id_arr.split("_");


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


            $('#Qty_' + id[1]).val(1);
            $('#Price_' + id[1]).val(json["SellingPrice"]);

            $('#ItemTotal_' + id[1]).val((parseFloat(json["SellingPrice"]) * parseFloat($('#Qty_' + id[1]).val()))
                .toFixed(2));
            calculateTotal();

            if (isNaN($('#discountAmount').val())) {
                $('#discountAmount').val(0);
            }

        });
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
        $(document).on('change keyup blur', '.changesNo', function() {

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

        //////////

        $(document).on(' blur', '.totalLinePrice', function() {



            id_arr = $(this).attr('id');
            id = id_arr.split("_");



            total = $('#total_' + id[1]).val();








            Profit = (parseFloat(total) - parseFloat(Fare)).toFixed(2);




            $('#Service_' + id[1]).val(parseFloat(Profit) - (parseFloat(Profit / 100) * parseFloat(Tax)).toFixed(
                2));

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
                alert('dd');
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
            var pretotal = 0;
            $('.totalLinePrice').each(function() {
                if ($(this).val() != '') subTotal += parseFloat($(this).val());
            });


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


    <script type="text/javascript">
        //<![CDATA[


        $(function() {
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



    <script>
        $(function() {
            var selectedPaymentMode = $('#PaymentMode').val();
            if (selectedPaymentMode == 'Cheque') {
                $('#paymentdetails').show();

            } else {
                $('#paymentdetails').hide();
            }
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
        $("#InvoiceType").change(function() {

            // alert({{ Session::token() }});

            var InvoiceType = $('#InvoiceType').val();
            var InvoiceNo = $('#InvoiceNo').val();

            // console.log(InvoiceType);
            if (InvoiceType != "") {
                /*  $("#butsave").attr("disabled", "disabled"); */
                // alert('next stage if else');
                // console.log(InvoiceType);

                $.ajax({

                    url: "{{ URL('/ajax_invoice_vhno') }}",
                    type: "POST",
                    data: {
                        // _token: {{ Session::token() }},
                        "_token": "{{ csrf_token() }}",
                        InvoiceType: InvoiceType,
                        InvoiceNo: InvoiceNo,

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



                    var grandtotal = (parseFloat(grandsum) + parseFloat(taxamount) + parseFloat(shipping)) - parseFloat(
                        discountamount);
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
@endpush
