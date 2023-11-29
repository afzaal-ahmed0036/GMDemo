@extends('template.tmp')
@section('title', 'Invoice Listing')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @php
                    // dd(session()->get('error'));
                @endphp
                @if (session()->has('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                        <strong>{{ session()->get('error') }} </strong>
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
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Invoice Listing</h4>

                            <div class="page-title-right">
                                <a href="{{ url('/create-voucher') }}" target="_blank" class="btn btn-primary">Create
                                    Invoice</a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Invoices</h4>
                                <table id="sale-table"
                                    class="table sale-list datatable table-hover dt-responsive nowrap w-100 table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Invoice No</th>
                                            <th scope="col">Customer Name</th>
                                            <!-- <th scope="col">Invoice Date</th> -->
                                            <!-- <th scope="col">Total Tax</th> -->
                                            <th scope="col">Payment Status</th>
                                            <th scope="col">Grand Total</th>
                                            <th scope="col">Paid</th>
                                            <th scope="col">Due</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->

                <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                    class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Payment') }}</h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close" class="close"><span
                                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('sale.add-payment') }}" method="POST" class="payment-form">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="balance">
                                        <div class="col-md-6">
                                            <label>{{ trans('file.Recieved Amount') }} *</label>
                                            <input type="text" name="paying_amount" class="form-control numkey"
                                                step="any" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>{{ trans('file.Paying Amount') }} *</label>
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                step="any" required>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>{{ trans('file.Change') }} : </label>
                                            <p class="change ml-2">0.00</p>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>{{ trans('file.Paid By') }}</label>
                                            <select name="paid_by_id" class="form-control">
                                                <option value="1">Cash</option>
                                                <option value="2">Gift Card</option>
                                                <option value="3">Credit Card</option>
                                                <option value="4">Cheque</option>
                                                <option value="5">Paypal</option>
                                                <option value="6">Deposit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group mt-2">
                                        <div class="card-element" class="form-control">
                                        </div>
                                        <div class="card-errors" role="alert"></div>
                                    </div>
                                    <div id="cheque">
                                        <div class="form-group">
                                            <label>{{ trans('file.Cheque Number') }} *</label>
                                            <input type="text" name="cheque_no" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ trans('file.Payment Note') }}</label>
                                        <textarea rows="3" class="form-control" name="payment_note"></textarea>
                                    </div>

                                    <input type="hidden" name="InvoiceMasterID">
                                    <br>
                                    <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ADD PAYMENT MODAL ENDS HERE -->
                <div id="cancel_Order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" class="modal fade text-left">
                    <div role="document" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 id="exampleModalLabel" class="modal-title">Cancel Order</h5>
                                <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                    class="close pt-2 btn btn-sm btn-danger"><span aria-hidden="true"><i
                                            class="dripicons-cross"></i></span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('cancelOrder') }}" method="POST" class="cancelOrder-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h2 class="text-danger">Are You Sure??</h2>
                                            <h4 class="text-danger">You Want to Cancel The Order!!</h4>
                                            <strong class="text-info">This Step cannot be reverted</strong>
                                        </div>
                                    </div>
                                    <input type="hidden" id="cancelInvoiceMasterID" name="InvoiceMasterID">
                                    <br>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button style="margin-right: 10px;" type="submit"
                                                class="btn btn-success mr-2">Yes, Cancel The Order</button>
                                            <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                                class="close btn btn-primary"><span
                                                    aria-hidden="true">Close</span></button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
    @endsection

    @push('after-scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.datatable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "pageLength": 50,
                    "ajax": "{{ url('invoice-listing') }}",
                    "columns": [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            "data": "InvoiceNo"
                        },
                        {
                            "data": "WalkinCustomerName"
                        },
                        // { "data": "Tax" },
                        {
                            "data": "payment_status",
                            name: 'payment_status'
                        },
                        {
                            "data": "GrandTotal"
                        },
                        {
                            "data": "Paid"
                        },
                        {
                            "data": "Balance"
                        },
                        {
                            "data": "action"
                        }
                    ]

                });

                //ADD PAYMENT SCRIPT STARTS HERE.
                $(document).on("click", "table.sale-list tbody .add-payment", function() {
                    $("#cheque").hide();
                    $(".gift-card").hide();
                    $(".card-element").hide();
                    $('select[name="paid_by_id"]').val(1);
                    //$('.selectpicker').selectpicker('refresh');
                    rowindex = $(this).closest('tr').index();

                    deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit')
                        .val();
                    var sale_id = $(this).data('id').toString();
                    var balance = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                        'td:nth-child(7)').text();
                    balance = parseFloat(balance.replace(/,/g, ''));
                    $('input[name="paying_amount"]').val(balance);
                    $('#add-payment input[name="balance"]').val(balance);
                    $('input[name="amount"]').val(balance);
                    $('input[name="InvoiceMasterID"]').val(sale_id);
                });
                $(document).on("click", "table.sale-list tbody .cancel-order", function() {
                    var sale_id = $(this).data('id').toString();
                    $('#cancelInvoiceMasterID').val(sale_id);
                });


                $('select[name="paid_by_id"]').on("change", function() {
                    var id = $(this).val();
                    $('input[name="cheque_no"]').attr('required', false);
                    $('#add-payment select[name="gift_card_id"]').attr('required', false);
                    $(".payment-form").off("submit");
                    if (id == 2) {
                        $(".gift-card").show();
                        $(".card-element").hide();
                        $("#cheque").hide();
                        $('#add-payment select[name="gift_card_id"]').attr('required', true);
                    } else if (id == 3) {
                        $.getScript("public/vendor/stripe/checkout.js");
                        $(".card-element").show();
                        $(".gift-card").hide();
                        $("#cheque").hide();
                    } else if (id == 4) {
                        $("#cheque").show();
                        $(".gift-card").hide();
                        $(".card-element").hide();
                        $('input[name="cheque_no"]').attr('required', true);
                    } else if (id == 5) {
                        $(".card-element").hide();
                        $(".gift-card").hide();
                        $("#cheque").hide();
                    } else {
                        $(".card-element").hide();
                        $(".gift-card").hide();
                        $("#cheque").hide();
                        if (id == 6) {
                            if ($('#add-payment input[name="amount"]').val() > parseFloat(deposit))
                                alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
                        }
                    }
                });

                $('#add-payment select[name="gift_card_id"]').on("change", function() {
                    var id = $(this).val();
                    if (expired_date[id] < current_date)
                        alert('This card is expired!');
                    else if ($('#add-payment input[name="amount"]').val() > balance[id]) {
                        alert('Amount exceeds card balance! Gift Card balance: ' + balance[id]);
                    }
                });

                $('input[name="paying_amount"]').on("input", function() {
                    $(".change").text(parseFloat($(this).val() - $('input[name="amount"]').val()).toFixed(2));
                });

                $('input[name="amount"]').on("input", function() {
                    if ($(this).val() > parseFloat($('input[name="paying_amount"]').val())) {
                        alert('Paying amount cannot be bigger than recieved amount');
                        $(this).val('');
                    } else if ($(this).val() > parseFloat($('input[name="balance"]').val())) {
                        alert('Paying amount cannot be bigger than due amount');
                        $(this).val('');
                    }
                    $(".change").text(parseFloat($('input[name="paying_amount"]').val() - $(this).val())
                        .toFixed(2));
                    var id = $('#add-payment select[name="paid_by_id"]').val();
                    var amount = $(this).val();
                    if (id == 2) {
                        id = $('#add-payment select[name="gift_card_id"]').val();
                        if (amount > balance[id])
                            alert('Amount exceeds card balance! Gift Card balance: ' + balance[id]);
                    } else if (id == 6) {
                        if (amount > parseFloat(deposit))
                            alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
                    }
                });


            });
        </script>
    @endpush
