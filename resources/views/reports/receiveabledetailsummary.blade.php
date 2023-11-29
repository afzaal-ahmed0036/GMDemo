@extends('template.tmp')




@section('content')



<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">



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




            <div class="card">
                <div class="card-body">
                    <h3 class=" mb-1 text-center">{{$company[0]->Name}}</h3>
                    <h5 class="mb-1 text-center">Receiveable Detail Summary</h5>
                    <h5 class="mb-1 text-center">From:  To: </h5>
                    <br><br>
                    <?php
                    $gsum_dr = 0;
                    $gsum_cr = 0;
                    ?>
                    <div class="table-responsive">
                      
                        <table class="table table-striped table-sm m-0 dataTable no-footer">
                         
                            <thead>
                                <tr class="bg bg-light">
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Transaction Type</th>
                                    <th>Total(BCY)</th>
                                    <th>Total(FCY)</th>
                                    <th>Balance(BCY)</th>
                                    <th>Balance(FCY)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $value)
                                <tr>

                                    <td>{{$value->PartyName}}</td>
                                    <td>{{$value->Date}}</td>
                                    <td>{{$value->InvoiceNo}}</td>
                                    <td>{{$value->ReferenceNo}}</td>
                                    <?php
                                    $Status2 = $value->Balance == '0' ? 'Paid' : 'Unpaid';
                                    ?>
                                    <td style="color: #0619ff;">{{$Status2}}</td>
                                    <td>Invoice</td>
                                    <td>{{$value->total}}</td>
                                    <td>{{$value->total}}</td>
                                    <td>{{$value->Balance}}</td>
                                    <td>{{$value->Balance}}</td>
                                

                                </tr>
                                @endforeach
                               


                            </tbody>
                        </table>
                       
                        

                        
                        
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- END: Content-->

@endsection