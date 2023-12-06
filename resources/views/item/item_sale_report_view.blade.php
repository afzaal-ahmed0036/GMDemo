@extends('template.tmp')

@section('title', $pagetitle)


@section('content')



    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Item Report</h4>
                            <strong class="text-end">{{ session::get('CompanyName') }}</strong>
                            {{-- From {{ request()->StartDate }} to {{ request()->EndDate }} --}}

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                            @if ($item_name != null)
                                <div> <strong>Item Name: {{ $item_name }} </strong> </div>
                            @endif
                            @if ($item_code != null)
                                <div><strong>Item Code: {{ $item_code }} </strong> </div>
                            @endif
                            <div><strong>Remianing Stock: {{ $remaining_stock }}</strong> </div>

                        </div>
                    </div>
                </div>
                @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">

                        {{ Session::get('error') }}
                    </div>
                @endif

                @if (count($errors) > 0)

                    <div>
                        <div class="alert alert-danger p-1   border-3">
                            <p class="font-weight-bold"> There were some problems with your input.</p>
                            <ul>

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                @endif


                @php
                    $PGrandTotal = 0;
                    $PitemTotal = 0;
                    $PQty = 0;
                    $SGrandTotal = 0;
                    $SitemTotal = 0;
                    $SQty = 0;
                @endphp
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <strong class="text-info">Stock In (Purchases)</strong>
                        </div>
                        <hr>
                        @if (count($purchases) > 0)
                            <table class="table table-sm align-middle table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Invoice#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Method</th>
                                        <th scope="col">Cost</th>
                                        {{-- <th scope="col">Sold</th> --}}
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Item Total</th>
                                        <th scope="col">Invoice Total</th>

                                    </tr>
                                </tbody>
                                <tbody>
                                    @foreach ($purchases as $key => $value)
                                        @foreach ($value->invoiceDetails as $item)
                                            @php
                                                $PGrandTotal = $PGrandTotal + $value->GrandTotal;
                                            @endphp

                                            <tr>
                                                <td class="col-md-1">{{ $key + 1 }}</td>
                                                <td class="col-md-1">{{ $value->InvoiceNo }}</td>
                                                <td class="col-md-1">{{ $value->Date }}</td>
                                                <td class="col-md-1">{{ $value->PaymentMode }}</td>
                                                <td class="col-md-1">{{ number_format($item->Rate, 2) }}</td>
                                                {{-- <td class="col-md-1">{{ number_format($item->Rate, 2) }}</td> --}}
                                                <td class="col-md-1">{{ $item->Qty }}</td>
                                                <td class="col-md-1">{{ number_format($item->Total, 2) }}</td>
                                                <td class="col-md-1">{{ number_format($value->GrandTotal, 2) }}</td>
                                                @php
                                                    $PitemTotal = $PitemTotal + $item->Total;
                                                    $PQty = $PQty + $item->Qty;
                                                @endphp

                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tr class="bg-light fw-bold">
                                    {{-- <td></td> --}}
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ $PQty }}</td>
                                    <td>{{ number_format($PitemTotal, 2) }}</td>
                                    <td>{{ number_format($PGrandTotal, 2) }}</td>
                                </tr>
                            </table>
                        @else
                            <p class=" text-danger">No data found</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <strong class="text-info">Stock Out (Sales) </strong>
                        </div>
                        <hr>
                        @if (count($sales) > 0)
                            <table class="table table-sm align-middle table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Invoice#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Method</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Sold</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Item Total</th>
                                        <th scope="col">Invoice Total</th>

                                    </tr>
                                </tbody>
                                <tbody>
                                    @foreach ($sales as $key => $value)
                                        @foreach ($value->invoiceDetails as $item)
                                            @php
                                                $SGrandTotal = $SGrandTotal + $value->GrandTotal;
                                            @endphp

                                            <tr>
                                                <td class="col-md-1">{{ $key + 1 }}</td>
                                                <td class="col-md-1">{{ $value->InvoiceNo }}</td>
                                                <td class="col-md-1">{{ $value->Date }}</td>
                                                <td class="col-md-1">{{ $value->PaymentMode }}</td>
                                                <td class="col-md-1">{{ number_format($item->cost_price, 2) }}</td>
                                                <td class="col-md-1">{{ number_format($item->Rate, 2) }}</td>
                                                <td class="col-md-1">{{ $item->Qty }}</td>
                                                <td class="col-md-1">{{ number_format($item->Total, 2) }}</td>
                                                <td class="col-md-1">{{ number_format($value->GrandTotal, 2) }}</td>
                                                @php
                                                    $SitemTotal = $SitemTotal + $item->Total;
                                                    $SQty = $SQty + $item->Qty;

                                                @endphp

                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tr class="bg-light fw-bold">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ $SQty }}</td>
                                    <td>{{ number_format($SitemTotal, 2) }}</td>
                                    <td>{{ number_format($SGrandTotal, 2) }}</td>
                                </tr>
                            </table>
                        @else
                            <p class=" text-danger">No data found</p>
                        @endif


                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- END: Content-->

@endsection
