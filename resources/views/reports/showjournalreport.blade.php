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
                    <h3 class=" mb-1 text-center">{{$company[0]->Name}} </h3>
                    <h5 class="mb-1 text-center">Journal Report</h5>
                    <h5 class="mb-1 text-center">From: {{$from_t}} To: {{$to_t}}</h5>
                    <br><br>
                    <?php
                    $gsum_dr = 0;
                    $gsum_cr = 0;
                    ?>
                    <div class="table-responsive">
                        @foreach($joural as $value)
                        <table class="table table-striped table-sm m-0 dataTable no-footer">
                            <?php
                            $sum_dr = 0;
                            $sum_cr = 0;


                            ?>
                            <?php

                            if ($value->INVOICE == 'INVOICE') {
                                $v_journal = DB::table('v_journal')->where('InvoiceMasterID', $value->InvoiceMasterID)->get();
                            } else {
                                $v_journal = DB::table('v_journal')->where('VoucherMstID', $value->InvoiceMasterID)->get();
                            }

                            ?>
                            <thead>
                                <tr class="bg bg-light">
                                    <th scope="row" width=80%>{{$value->Date}}- {{($value->INVOICE=='INVOICE' ? 'INVOICE' : 'BILL')}} INV#{{$value->InvoiceNo}}(Shah Corporation)</th>
                                    <th>Debit</th>
                                    <th>Credit</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($v_journal as $value1)
                                <tr>

                                    <td scope="row" width=80%>{{$value1->ChartOfAccountName}} </td>
                                    <td>{{$value1->Dr}}</td>
                                    <td>{{$value1->Cr}}</td>
                                    <?php
                                    $sum_dr += $value1->Dr;
                                    $gsum_dr += $value1->Dr;
                                    $sum_cr += $value1->Cr;
                                    $gsum_cr += $value1->Cr;
                                    ?>

                                </tr>
                                @endforeach
                                <tr>
                                    <th width=80%>Total</th>
                                    
                                    <th><a href="{{URL('/SaleInvoiceView/'.$value1->InvoiceMasterID)}}"><?php echo $sum_dr; ?></a></th>
                                    <th><a href="{{URL('/SaleInvoiceView/'.$value1->InvoiceMasterID)}}"><?php echo $sum_cr; ?></a></th>
                                   
                                </tr>


                            </tbody>
                        </table>
                        @endforeach
                        <table class="table table-striped table-sm m-0 dataTable no-footer">
                            <thead>
                                <tr>
                                    <th width=80%>Grand Total</th>
                                    <th> <?php echo $gsum_cr; ?></th>
                                    <th> <?php echo $gsum_dr; ?></th>

                                </tr>

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