@extends('template.tmp')




@section('content')

<style>
    .doubleUnderline {
    text-decoration:underline;
    border-bottom: 1px solid #000;
}
</style>

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
                    <h5 class="mb-1 text-center">Trial Balance</h5>
                    <h5 class="mb-1 text-center">From: {{dateformatreport($from)}} TO: {{dateformatreport($to)}} </h5>
                    <br><br>
                    <div class="table-responsive">
                        <table class="table table-sm m-0">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>ACCOUNT</th>
                                    <th>ACCOUNT CODE</th>
                                    <th>NET DEBIT</th>
                                    <th>NET CREDIT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- level 1 -->
                                <?php
                                $Gsum_dr = 0;
                                $Gsum_cr = 0;
                                ?>
                                @foreach($coaName as $value)
                                <?php
                                $code = $value->CODE;
                                // first loop
                                $chartofaccountr = DB::select("SELECT CODE,ChartOfAccountID,ChartOfAccountName from chartofaccount where  CODE = '$code'  and right(ChartOfAccountID,4)=0000 and right(ChartOfAccountID,5)!=00000");


                                ?>
                                <tr class="bg-secondary  bg-soft">
                                    <td>{{$value->ChartOfAccountID}}</td>
                                    <td>
                                        <strong>{{$value->ChartOfAccountName}}</strong>
                                    </td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <!-- level 2 -->
                                <?php 

                               $sum_dr = 0;
                                $sum_cr = 0;

                                 ?>
                                @foreach($chartofaccountr as $value1)

                                <?php
                                $code1 = $value1->CODE;
                                $ChartOfAccountID = $value1->ChartOfAccountID;
                                // $chartofaccount3 = DB::select("SELECT CODE,ChartOfAccountID,ChartOfAccountName from chartofaccount where  CODE = '$code1' and right(ChartOfAccountID,4)!=0000 and right(ChartOfAccountID,5)!=00000  ");
                                // substr($request->ChartOfAccountID, 0, 1) . '%')
                                // dd(substr($value1->ChartOfAccountID,-4));
                                $zeros = substr($value1->ChartOfAccountID, -4);
                                // dd($zeros);
                                $chartofaccount3 = DB::table('v_journal')->whereBetween('date', array($from, $to))->select('ChartOfAccountID', 'ChartOfAccountName',  DB::raw('sum(if(ISNULL(Dr),0,Dr)) - sum(if(ISNULL(Cr),0,Cr)) as Balance'), DB::raw('if(sum(if(ISNULL(Dr),0,Dr)) - sum(if(ISNULL(Cr),0,Cr))>=0,sum(if(ISNULL(Dr),0,Dr)) - sum(if(ISNULL(Cr),0,Cr)),0) as Debit'), DB::raw('if(sum(if(ISNULL(Dr),0,Dr)) - sum(if(ISNULL(Cr),0,Cr))<0,sum(if(ISNULL(Dr),0,Dr)) - sum(if(ISNULL(Cr),0,Cr)),0) as Credit'))->where('ChartOfAccountID', 'like', substr($value1->ChartOfAccountID, 0, 2) . '%')->where(DB::raw('right(ChartOfAccountID,4)'), '!=', 0000)->groupBy('ChartOfAccountID', 'ChartOfAccountName')->get();


                           

                                ?>

                               

                                <tr class="bg-success bg-soft">

                                    @foreach($chartofaccount3 as $check)

                                     <?php  
                                      if(substr($check->ChartOfAccountID, 0, 2) == substr($value1->ChartOfAccountID, 0, 2))   
                                      { 
                                    ?>


                                    <td>{{$value1->ChartOfAccountID}}</td>
                                    <td style="text-indent: 3%;"> <strong><i><u>{{$value1->ChartOfAccountName}}</u></i></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <?php  } ?>
                                    @break;
                                    @endforeach

                                    
                                </tr>
                              

                                <!-- level3 -->
                                
                                @foreach($chartofaccount3 as $value3)
                                <?php
                                $dr1 = abs($value3->Debit) == '0' ? ' ' : abs($value3->Debit);
                                $cr1 = abs($value3->Credit) == '0' ? ' ' : abs($value3->Credit);

                                $dr2 = number_format((float)$dr1, 2, '.', '');
                                $cr2 = number_format((float)$cr1, 2, '.', '');
                                $dr3 = $dr2 == '0' ? ' ' : $dr2;
                                $cr3 = $cr2 == '0' ? ' ' : $cr2;
                                ?>
                                <tr>

                                    <td>{{$value3->ChartOfAccountID}}</td>
                                    <td style="text-indent: 6%;">{{$value3->ChartOfAccountName}}</td>
                                    <td>{{$value1->CODE}}</td>


                                    <td>{{ $dr3 }}</td>
                                    <td>{{$cr3}}</td>
                                     
                                </tr>

                                <?php
                                $sum_dr += abs($value3->Debit);
                                $Gsum_dr += abs($value3->Debit);
                                $sum_cr += abs($value3->Credit);
                                $Gsum_cr += abs($value3->Credit);
                                ?>

                                @endforeach

                                
                                 <!-- <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                     <th>{{$sum_dr=='0' ? '0.0' : $sum_dr}}</th>
                                    <th>{{$sum_cr=='0' ? '0.0' : $sum_cr}}</th> 



                                </tr>  -->
                                <!-- level3 -->
                                @endforeach



                                <!-- level 2 -->
                                 <tr>
                                    <td></td>
                                    <td>Total of {{$value->ChartOfAccountName}}</td>
                                    <td></td>
                                    <td>{{$sum_dr}}</td>
                                    <td>{{$sum_cr}}</td>
                                </tr>
                                @endforeach
                                <!-- level 1 -->
                                

                                <tr>
                                    <th>Net Profit/Loss</th>
                                    <th></th>
                                    <th></th>
                                    <th>{{$Gsum_dr=='0' ? '0.0' : $Gsum_dr}}</th>
                                    <th>{{$Gsum_cr=='0' ? '0.0' : $Gsum_cr}}</th>

                                </tr>

                                 <tr class="bg-secondary bg-soft">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><span class="doubleUnderline">{{($Gsum_dr=='0' ? '0.0' : $Gsum_dr)-$Gsum_cr=='0' ? '0.0' : $Gsum_cr}}</span></th>
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