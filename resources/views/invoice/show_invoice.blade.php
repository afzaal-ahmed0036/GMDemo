<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <style type="text/css">
        body {
            margin-top: 20px;
            color: #484b51;
        }

        .text-secondary-d1 {
            color: #728299 !important;
        }

        .page-header {
            margin: 0 0 1rem;
            padding-bottom: 1rem;
            padding-top: .5rem;
            border-bottom: 1px dotted #e2e2e2;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }

        .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }

        .brc-default-l1 {
            border-color: #dce9f0 !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -.25rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .text-grey-m2 {
            color: #888a8d !important;
        }

        .text-success-m2 {
            color: #86bd68 !important;
        }

        .font-bolder,
        .text-600 {
            font-weight: 600 !important;
        }

        .text-110 {
            font-size: 110% !important;
        }

        .text-blue {
            color: #478fcc !important;
        }

        .pb-25,
        .py-25 {
            padding-bottom: .75rem !important;
        }

        .pt-25,
        .py-25 {
            padding-top: .75rem !important;
        }

        .bgc-default-tp1 {
            background-color: rgba(121, 169, 197, .92) !important;
        }

        .bgc-default-l4,
        .bgc-h-default-l4:hover {
            background-color: #f3f8fa !important;
        }

        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120% !important;
        }

        .text-primary-m1 {
            color: #4087d4 !important;
        }

        .text-danger-m1 {
            color: #dd4949 !important;
        }

        .text-blue-m2 {
            color: #68a3d5 !important;
        }

        .text-150 {
            font-size: 150% !important;
        }

        .text-60 {
            font-size: 60% !important;
        }

        .text-grey-m1 {
            color: #7b7d81 !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }
    </style>
</head>

<body>
    <div class="page-content container">
        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                Invoice
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    No: {{ $invoice_master->InvoiceNo }}
                </small>
            </h1>

            <div class="page-tools">
                <div class="action-buttons">
                    @if ($invoice_master->sale_status != 10)
                        <a class="btn btn-success mx-1px text-95"
                            href="{{ route('voucher.print', ['id' => $invoice_master->InvoiceMasterID]) }}"
                            target="_blank" data-title="Print">
                            <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                            Print
                        </a>
                    @else
                        <h1 class="text-danger">Cancelled Order</h1>
                    @endif

                    <!-- <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">
 <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
 Export
 </a> -->
                </div>
            </div>
        </div>
        <div class="container px-0">
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
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <i class="fa fa-book fa-2x text-success-m2 mr-1"></i>
                                <span class="text-default-d3">{{ Session::get('CompanyName') }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">To:</span>
                                <span
                                    class="text-600 text-110 text-blue align-middle">{{ $invoice_master->PartyName }}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    {{ @$party->Address }}
                                </div>
                                <div class="my-1">
                                    {{ @$party->Email }}
                                </div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600">{{ @$party->Mobile }}</b></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Invoice No : </span> {{ @$invoice_master->InvoiceNo }}
                                </div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Issue Date : </span>
                                    {{ date('d/m/Y', strtotime($invoice_master->Date)) }}</div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Status : </span> <span
                                        class="">{{ $invoice_master->Balance == 0 ? 'Paid' : 'Unpaid' }}</span>
                                </div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Amount Paid : </span> <span
                                        class="">{{ $invoice_master->Paid }}</span></div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Payment Method : </span> <span
                                        class="">{{ $invoice_master->PaymentMode }}</span></div>
                                @if ($invoice_master->PaymentMode == 'Cash And Card')
                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                            class="text-600 text-90">Paid By Cash : </span> <span
                                            class="">@php
                                                $PaidByCard = $invoice_master->Paid - $payments->AmountPaidByCard;
                                            @endphp
                                            {{ $PaidByCard }}
                                        </span></div>
                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                            class="text-600 text-90">Paid By Card : </span> <span
                                            class="">{{ $payments->AmountPaidByCard }}</span></div>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">

                        <!-- or use a table instead -->

                        <div class="table-responsive">
                            <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                <thead class="bg-none bgc-default-tp1">
                                    <tr class="text-white">
                                        <th class="opacity-2">#</th>
                                        <th>Image</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        {{-- <th>Tax(%)</th> --}}
                                        <th width="140">Amount</th>
                                    </tr>
                                </thead>

                                <tbody class="text-95 text-secondary-d3">
                                    @foreach ($invoice_detail as $key => $detail)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td><img src="{{ asset('thumbnail/' . $detail->ItemImage) }}" alt=""
                                                    width="25%"></td>
                                            <td>{!! $detail->Description !!}</td>
                                            <td>{{ $detail->Qty }}</td>
                                            <td>{{ $detail->Rate }}</td>
                                            {{-- <td>{{$detail->Tax}}</td> --}}
                                            <td>{{ $detail->Total }}</td>

                                        </tr>
                                    @endforeach

                                    @foreach ($invoice_dish_detail as $key => $detail)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ ucfirst($detail->dish_type->type) }}</td>
                                            <td>{{ ucfirst($detail->dish_type->type) }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ $detail->price }}</td>
                                            {{-- <td>0.00</td> --}}
                                            <td>{{ $detail->quantity * $detail->price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="row mt-3">
                                <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                    <!-- Extra note such as company or payment information... -->
                                </div>
                                <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            SubTotal
                                        </div>
                                        <div class="col-5">
                                            <span
                                                class="text-120 text-secondary-d1">{{ $invoice_master->Total }}/-</span>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            Order Tax
                                        </div>
                                        <div class="col-5">
                                            <span
                                                class="text-110 text-secondary-d1">{{ number_format((float) $invoice_master->Tax, 2, '.', '') }}</span>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            Order Discount
                                        </div>
                                        <div class="col-5">
                                            <span
                                                class="text-110 text-secondary-d1">{{ number_format((float) $invoice_master->DiscountAmount, 2, '.', '') }}</span>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            Shipping Cost
                                        </div>
                                        <div class="col-5">
                                            <span
                                                class="text-110 text-secondary-d1">{{ number_format((float) $invoice_master->Shipping, 2, '.', '') }}</span>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-7 text-right">
                                            Total Amount
                                        </div>
                                        <div class="col-5">
                                            <span
                                                class="text-11s0 text-success-d3 opacity-2">{{ $invoice_master->GrandTotal }}/-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <div class="row">
                            <div class="col-md-2 ">


                                <a href="{{ asset('uploads/' . $invoice_master->Document1) }}" target="_blank"><img
                                        src="{{ asset('uploads/' . $invoice_master->Document1) }}" alt=""
                                        width="100%"></a>

                            </div>

                            <div class="col-md-2 ">


                                <a href="{{ asset('uploads/' . $invoice_master->Document2) }}" target="_blank"><img
                                        src="{{ asset('uploads/' . $invoice_master->Document2) }}" alt=""
                                        width="100%"></a>

                            </div>
                        </div>



                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
