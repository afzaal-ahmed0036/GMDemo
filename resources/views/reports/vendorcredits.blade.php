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


<?php 

$company = DB::table('company')->get();
 ?>

            <div class="card">
                <div class="card-body">
                    <h3 class=" mb-1 text-center">{{$company[0]->Name}}</h3>
                    <h5 class="mb-1 text-center">Vendor Credits Details Report</h5>
                    <h5 class="mb-1 text-center">From:{{$from}}  To:{{$to}} </h5>
                    <br><br>
                    <?php
                    $sum_total = 0;
                    $sum_balance = 0;
                    ?>
                    <div class="table-responsive">
                      
                        <table class="table table-striped table-sm m-0 dataTable no-footer">
                         
                            <thead>
                                <tr class="bg bg-light">
                                   <th>Date</th>
                                   <th>Reference#</th>
                                   <th>Bill#</th>
                                   <th>Vendor Name</th>
                                   <th>Payment Made</th>
                                   <th>Note</th>
                                   <th>Paid Through</th>
                                   <th>Amount</th>
                                   <th>Amount(FCY)</th>
                                   <th>Unused Amount(BCY)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $value)
                                <tr>
                                    
                                    <td>{{$value->Date}}</td>
                                    <td>{{$value->ReferenceNo}}</td>
                                    <td>{{$value->InvoiceNo}}</td>
                                    <td>{{$value->SupplierName}}</td>
                                    <td></td>
                                    <td>{{$value->CustomerNotes}}</td>
                                    <td></td>
                                    <td>{{$value->Total}}</td>
                                    <td>{{$value->Total}}</td>
                                    <td></td>
                                   
                                    <?php
                                    $sum_total += $value->total;
                                    $sum_balance += $value->balance;
                                    ?>
                                </tr>
                                @endforeach
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo $sum_total; ?></th>
                                    <th><?php echo $sum_balance; ?></th>
                                    <th></th>
                                </tr>


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