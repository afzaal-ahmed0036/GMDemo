@extends('template.tmp')
@section('title', $pagetitle)
@push('after-styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <!-- multipe image upload  -->
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="multiple/dist/imageuploadify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
@endpush
@section('content')
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
                <form action="{{ URL('/ExpenseSave') }}" method="post">
                    <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
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
                                                required>
                                                <option value="">Select</option>
                                                <?php foreach ($supplier as $key => $value) : ?>
                                                <option value="{{ $value->SupplierID }}" {{ old('SupplierID') == $value->SupplierID ? 'selected' : '' }}>{{ $value->SupplierName }}</option>
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
                                                value="" placeholder="Walkin cusomter" id="1WalkinCustomerName">
                                        </div>
                                    </div> --}}
                                    <div class="mb-1 row">
                                        <div class="col-sm-3">
                                            <label class="col-form-label" for="password">Paid Through </label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select required name="ChartOfAccountID_From" id="ChartOfAccountID_From"
                                                class="form-select form-control-sm select2" style="width: 100% !important;">
                                                <option value="">select</option>
                                                @foreach ($items as $key => $value)
                                                    <option value="{{ $value->ChartOfAccountID }}" {{ old('ChartOfAccountID_From') == $value->ChartOfAccountID ? 'selected' : '' }}>
                                                        {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Ref # </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" name="ReferenceNo" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 row d-none">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="col-12">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Expense #
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <div id="invoict_type"> <input type="text" readonly name="ExpenseNo"
                                                        autocomplete="off" class="form-control"
                                                        value="EXP-{{ $vhno[0]->VHNO }}"></div>
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
                                                        value="{{ date('Y-m-d') }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="paymentdetails">
                                        <div class="mb-1 row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label text-danger" for="password">Cheque Details
                                                </label>
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
                                    <table>
                                        <thead>
                                            <tr class="bg-light borde-1 border-light " style="height: 40px;">
                                                <th width="2%" class="text-center"><input id="check_all"
                                                        type="checkbox" /></th>
                                                <th width="1%">EXPENSE ACCOUNT </th>
                                                <th width="10%">NOTES </th>
                                                <th width="4%" class="d-none">RATE</th>
                                                <th width="4%">Tax</th>
                                                <th width="4%">Tax Val</th>
                                                <th width="4%">AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="p-3">
                                                <td class="p-1 bg-light borde-1 border-light text-center"><input
                                                        class="case" type="checkbox" /></td>
                                                <td>
                                                    <select name="ItemID0[]" id="ItemID0_1"
                                                        class="item form-select form-control-sm select2   changesNoo "
                                                        onchange="km(this.value,1);" style="width: 300px !important;"
                                                        required>
                                                        <option value="">select</option>
                                                        @foreach ($items as $key => $value)
                                                            <option value="{{ $value->ChartOfAccountID }}">
                                                                {{ $value->ChartOfAccountID }}-{{ $value->ChartOfAccountName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="ChartOfAccountID[]" id="ItemID_1">
                                                </td>
                                                <td>
                                                    <input type="text" name="Description[]" id="Description_1"
                                                        class=" form-control ">
                                                </td>
                                                <td class="d-none">
                                                    <input type="number" name="Qty[]" id="Qty_1"
                                                        class=" form-control changesNo" autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01" value="1">
                                                </td>
                                                <td class="d-none">
                                                    <input type="number" name="Price[]" id="Price_1"
                                                        class=" form-control changesNo" autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01" value="1">
                                                </td>
                                                <td>
                                                    <select name="Tax[]" id="TaxID_1"
                                                        class="form-select changesNo tax exclusive_cal" required="">
                                                        <?php foreach ($tax as $key => $valueX1) : ?>
                                                        <option value="{{ $valueX1->TaxPer }}">
                                                            {{ $valueX1->Description }}</option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" readonly name="TaxVal[]" id="TaxVal_1"
                                                        class=" form-control totalLinePrice2 tax" autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01">
                                                </td>
                                                <td>
                                                    <input type="number" name="ItemTotal[]" id="ItemTotal_1"
                                                        class=" form-control totalLinePrice " autocomplete="off"
                                                        onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                        onpaste="return false;" step="0.01" required>
                                                </td>
                                            </tr>
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
                                    <label for="" class="mt-2">Description</label>
                                    <textarea class="form-control" rows='5' name="DescriptionNotes" id="note"
                                        placeholder="Description notes if any."></textarea>
                                    <br>
                                    <iframe src="{{ URL('/Attachment') }}" width="100%" height="40%" border="0"
                                        scrolling="yes" style="overflow: hidden;"></iframe>

                                    <div class="mt-2"><button type="submit"
                                            class="btn btn-success w-md float-right">Save</button>
                                        <a href="{{ URL('/Expense') }}"
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
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Sub Total1: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" class="form-control" id="subTotal"
                                                    name="SubTotal" placeholder="Subtotal"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Discount: &nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">%</span>

                                                <input type="text" class="form-control" value="0"
                                                    id="discountper" name="DiscountPer" placeholder="Tax"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">

                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>

                                                <input type="text" name="DiscountAmount" class="form-control"
                                                    id="discountAmount" onkeypress="return IsNumeric(event);"
                                                    ondrop="return false;" onpaste="return false;" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Total: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Total" class="form-control" step="0.01"
                                                    id="totalafterdisc" readonly placeholder="Total"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Tax: &nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">%</span>
                                                <input type="text" class="form-control" id="taxpercentage"
                                                    name="Taxpercentage" placeholder="tax %"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="text" name="TaxpercentageAmount" class="form-control"
                                                    id="taxpercentageAmount" onkeypress="return IsNumeric(event);"
                                                    ondrop="return false;" onpaste="return false;" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Shipping: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" name="Shipping" class="form-control"
                                                    step="0.01" id="shipping" placeholder="Grand Total"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" value="0">
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
                                                    onpaste="return false;" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Amount Paid: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" class="form-control" id="amountPaid"
                                                    name="amountPaid" placeholder="Amount Paid"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" step="0.01" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group mt-1 d-none">
                                            <label>Amount Due: &nbsp;</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text bg-light">{{ session::get('Currency') }}</span>
                                                <input type="number" class="form-control amountDue" name="amountDue"
                                                    id="amountDue" placeholder="Amount Due"
                                                    onkeypress="return IsNumeric(event);" ondrop="return false;"
                                                    onpaste="return false;" step="0.01">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @endsection
        @push('after-scripts')
            <script>
                $('input[name=tax_action]').change(function(e) {
                    $('.exclusive_cal').val(e.target.value)
                });
                var i = $('table tr').length;
                $(".addmore").on('click', function() {
                    html = '<tr class="  border-1 border-light">';
                    html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';
                    html += '<td><select required name="ItemID0[]" id="ItemID0_' + i +
                        '"  style="width: 300px !important;" class="form-select select2 changesNoo" onchange="km(this.value,' +
                        i +
                        ');" > <option value="">select</option>}@foreach ($items as $key => $value) <option value="{{ $value->ChartOfAccountID }}|{{ $value->ChartOfAccountName }}">{{ $value->ChartOfAccountName }}</option>@endforeach</select><input type="hidden" name="ChartOfAccountID[]" id="ItemID_' +
                        i + '"></td>';
                    html += '  <td><input type="text" name="Description[]" id="Description_' + i +
                        '" class=" form-control " ></td>';
                    html += '<td class="d-none";><input type="text" name="Qty[]" id="Qty_' + i +
                        '" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';
                    html += '<td class="d-none"><input type="text" name="Price[]" id="Price_' + i +
                        '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';
                    html += '<td><select name="Tax[]" id="TaxID_' + i +
                        '" class="form-select changesNo exclusive_cal"><?php foreach ($tax as $key => $valueX1) : ?><option value="{{ $valueX1->TaxPer }}">{{ $valueX1->Description }}</option><?php endforeach ?></select></td>';
                    html += '<td><input readonly type="number" name="TaxVal[]" id="TaxVal_' + i +
                        '" class=" form-control totalLinePrice2 tax "autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"></td>';
                    html += '<td><input required type="text" name="ItemTotal[]" id="ItemTotal_' + i +
                        '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';

                    html += '</tr>';
                    $('table').append(html);
                    $('.select2', 'table').select2();
                    i++;

                });
                $(document).on('change', '#check_all', function() {
                    $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
                });

                function km(v, id) {
                    id_arr = 'ItemID0_' + id;
                    id = id_arr.split("_");
                    val = $('#ItemID0_' + id[1]).val().split("|");
                    $('#ItemID_' + id[1]).val(val[0]);
                    calculateTotal();
                    if (isNaN($('#discountAmount').val())) {
                        $('#discountAmount').val(0);
                    }
                    calculatediscount();
                    calculateTotal();
                }
                $(document).on('keyup blur select', '.changesNoo123', function() {
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
                    $('#ItemTotal_' + id[1]).val((parseFloat(json["SellingPrice"]) * parseFloat($('#Qty_' + id[1]).val()))
                        .toFixed(2));
                    calculateTotal();
                    if (isNaN($('#discountAmount').val())) {
                        $('#discountAmount').val(0);
                    }
                    calculatediscount();
                    calculateTotal();
                });
                $(".delete").on('click', function() {
                    $('.case:checkbox:checked').parents("tr").remove();
                    $('#check_all').prop("checked", false);
                    calculateTotal();
                });
                //price change
                $(document).on('change', '.changesNo', function() {
                    // alert('here');
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    Qty = $('#Qty_' + id[1]).val();
                    TaxPer = $('#TaxID_' + id[1]).val();
                    Price = $('#ItemTotal_' + id[1]).val();
                    TotalPrice = parseFloat(Qty) * parseFloat(Price);
                    // alert(TotalPrice);
                    TotalTaxPer = (parseFloat(TaxPer) / 100) * parseFloat(TotalPrice);
                    ItemTotal = parseFloat(TotalPrice) + parseFloat(TotalTaxPer);
                    $('#TaxVal_' + id[1]).val(TotalTaxPer);
                    // alert(ItemTotal);
                    calculatediscount();
                    calculateTotal();
                });
                $(document).on('change keyup blur', '.totalLinePrice', function() {
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    total = $('#ItemTotal_' + id[1]).val();
                    taxper = $('#TaxID_' + id[1]).val();
                    tax = (total * taxper) / 100;
                    $('#TaxVal_' + id[1]).val(tax);
                    taxtotal = 0;
                    $('.tax').each(function() {
                        if ($(this).val() != '') taxtotal += parseFloat($(this).val());
                    });
                    $('#grandtotaltax').val(taxtotal);
                    gtotal = 0;
                    $('.totalLinePrice').each(function() {
                        if ($(this).val() != '') gtotal += parseFloat($(this).val());
                    });
                    $('#grandtotal').val(gtotal);
                    calculateTotal();
                });
                $(document).on('change', '.changesNoo', function() {
                    id_arr = $(this).attr('id');
                    id = id_arr.split("_");
                    val = $('#ItemID0_' + id[1]).val().split("|");
                    $('#ItemID_' + id[1]).val(val[0]);
                    calculatediscount();
                });

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
                    } else {
                        $('#discountper').val(0);
                        $('#DiscountAmount').val(0);
                        total = subTotal;
                        $('#totalafterdisc').val(total.toFixed(2));
                    }
                }
                $(document).on('blur', '#discountAmount', function() {
                    calculatediscountper();
                });

                function calculatediscountper() {
                    subTotal = 0;
                    $('.totalLinePrice').each(function() {
                        if ($(this).val() != '') subTotal += parseFloat($(this).val());
                    });
                    subTotal = parseFloat($('#subTotal').val());
                    discountAmount = $('#discountAmount').val();
                    if (discountAmount != '' && typeof(discountAmount) != "undefined") {
                        discountper = (parseFloat(discountAmount) / parseFloat(subTotal)) * 100;
                        $('#discountper').val(parseFloat(discountper.toFixed(2)));
                        total = subTotal - discountAmount;
                        $('#totalafterdisc').val(total.toFixed(2));
                    } else {
                        $('#discountper').val(0);
                        $('#discountper').val(0);
                        total = subTotal;
                        $('#totalafterdisc').val(total.toFixed(2));
                    }
                }
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
                    console.log(grandtotaltax);
                    discountper = $('#discountper').val();
                    if (discountper != '' && typeof(discountper) != "undefined") {}
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
                $(function() {
                    $('#WalkinCustomer').hide();
                    $('#PartyID').change(function() {
                        if (this.options[this.selectedIndex].value == '1') {
                            $('#WalkinCustomer').show();
                            $('#1WalkinCustomerName').focus();

                        } else {
                            $('#WalkinCustomer').hide();
                            $('#1WalkinCustomerName').val(0);
                        }
                    });
                });
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

                function ajax_balance(SupplierID) {
                    $('#result').prepend('')
                    $('#result').prepend('<img id="theImg" src="{{ asset('assets/images/ajax.gif') }}" />');
                    var SupplierID = SupplierID;
                    if (SupplierID != "") {
                        $.ajax({
                            url: "{{ URL('/Ajax_Balance') }}",
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
                $("#InvoiceType").change(function() {
                    var InvoiceType = $('#InvoiceType').val();
                    if (InvoiceType != "") {
                        $.ajax({
                            url: "{{ URL('/ajax_invoice_vhno') }}",
                            type: "POST",
                            data: {
                                "_token": $("#csrf").val(),
                                InvoiceType: InvoiceType,
                            },
                            cache: false,
                            success: function(data) {
                                $('#invoict_type').html(data);
                            }
                        });
                    }
                });

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
        @endpush
