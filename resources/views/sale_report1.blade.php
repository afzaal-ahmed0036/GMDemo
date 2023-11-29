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
                            <h4 class="mb-sm-0 font-size-18">Sale Report</h4>
                            <strong class="text-end">{{ session::get('CompanyName') }}</strong>
                            From {{ request()->StartDate }} to {{ request()->EndDate }}

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


                <?php
                $GrandTotal = 0;
                $Paid = 0;
                $Profit = 0;
                ?>
                <div class="card">
                    <div class="card-body">


                        @if (count($v_invoice_profit) > 0)
                            <table class="table table-sm align-middle table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Invoice#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Method</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Sold</th>
                                        <th scope="col">Invoice Total</th>
                                        <th scope="col">Paid</th>
                                        <th scope="col">Profit</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                    @foreach ($v_invoice_profit as $key => $value)
                                        <?php

                                        $GrandTotal = $GrandTotal + $value->GrandTotal;
                                        $Paid = $Paid + $value->Paid;
                                        $Profit = $Profit + $value->Profit;

                                        ?>

                                        <tr>
                                            <td class="col-md-1">{{ $key + 1 }}</td>
                                            <td class="col-md-1">{{ $value->InvoiceNo }}</td>
                                            <td class="col-md-1">{{ $value->Date }}</td>
                                            <td class="col-md-1">{{ $value->PartyName }}</td>
                                            <td class="col-md-1">{{ $value->PaymentMode }}</td>
                                            <td class="col-md-1">{{ number_format($value->Cost, 2) }}</td>
                                            <td class="col-md-1">{{ number_format($value->Sold, 2) }}</td>
                                            <td class="col-md-1">{{ number_format($value->GrandTotal, 2) }}</td>
                                            <td class="col-md-1">{{ number_format($value->Paid, 2) }}</td>
                                            <td class="col-md-1">{{ number_format($value->Profit, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr class="bg-light fw-bold">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ number_format($GrandTotal, 2) }}</td>
                                    <td>{{ number_format($Paid, 2) }}</td>
                                    <td>{{ number_format($Profit, 2) }}</td>
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
