@extends('template.tmp')
@section('title', $pagetitle)
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
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">EXPENSE RECEIPT</h4>
                            <a href="{{ URL('/Expense') }}" class="btn btn-primary w-md float-right ">Back</a>

                        </div>
                    </div>
                </div>
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-8">
                            <span class="font"><strong>
                                    <h3>{{ $company->Name }}</h3>
                                </strong>
                                TRN # {{ $company->TRN }},<br>
                                {{ $company->Address }}<br>
                                {{ $company->Contact }}<br>
                                {{ $company->Email }}
                            </span>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <img width="50%" src="{{ asset('/documents/' . $company->Logo) }}"
                                alt="description of myimage">
                        </div>
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <table class="table table-borderless">
                                        <tbody class="font">
                                            <tr>
                                                <td>Payment Date</td>
                                                <th>{{ $expense_master->Date }}</th>
                                            </tr>
                                            <tr>
                                                <td>Reference Number</td>
                                                <th>{{ $expense_master->ReferenceNo }}</th>
                                            </tr>
                                            <tr>
                                                <td>Expense No</td>
                                                <th>{{ $expense_master->ExpenseNo }}</th>
                                            </tr>

                                        </tbody>
                                    </table>
                                    Bill To:
                                    <br>
                                    <strong style="font-weight: bold;"
                                        class="font">{{ $expense_master->SupplierName }}</strong>

                                </div>
                                <div class="col-4 d-flex justify-content-end">
                                    <div class="bg-info text-center pt-4"
                                        style="height: 45%; width: 70%; margin-left: -20%;">
                                        <span class="font" style="color: white;">
                                            Amount Paid <br>
                                            {{ session::get('Currency') }} {{ $expense_master->GrantTotal }}
                                        </span>
                                    </div>

                                </div>
                            </div>
                            <hr>

                            @if (count($expense_detail) > 0)
                                <table class="table table-sm align-middle table-nowrap mb-0">
                                    <tbody>
                                        <tr class="bg-light">
                                            <th scope="col" class="col-md-1">S.No</th>
                                            <th scope="col" class="col-md-7">Expense No</th>
                                            <th scope="col" class="col-md-3">Expense Account</th>
                                            <th scope="col" class="col-md-2">Amount</th>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        @foreach ($expense_detail as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->ExpenseNo }}</td>
                                                <td>{{ $value->ChartOfAccountName }}</td>
                                                <td>{{ $value->Amount }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="font-weight-bolder">
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ $expense_master->GrantTotal }} {{ session::get('Currency') }} </td>
                                        </tr>
                                    </tbody>

                                </table>
                            @else
                                <p class=" text-danger">No data found</p>
                            @endif

                        </div>

                        <hr>

                        <div style="height: 250px;">.</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
