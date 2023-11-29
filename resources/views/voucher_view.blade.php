<!doctype html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>{{$pagetitle}}</title>
    <style>
        .font {
            font-family: "Poppins", sans-serif !important;

            border-collapse: separate;
            text-indent: initial;
            white-space: normal;
            line-height: normal;
            font-weight: normal;
            font-size: medium;
            font-style: normal;
            color: -internal-quirk-inherit;

        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-primary d-print-none" onclick="window.print()">Print this page</button>
        <div class="row" style="margin-left: 10%;">
           <div class="col-md-4">
                <div >
                    <img width="100%" src="{{asset('/documents/'.$company[0]->Logo)}}" alt="description of myimage">

                </div>

            </div>
            <div class="col-md-8">
                <span class="font"><strong>
                        <h3>{{$company[0]->Name}}</h3>
                    </strong>
                    TRN # {{$company[0]->TRN}},<br>
                    {{$company[0]->Address}}<br>
                    {{$company[0]->Contact}}<br>
                    {{$company[0]->Email}}

                </span>

            </div>
            <div class="col-lg-10">
                <hr>
            </div>
            <div class="mx-auto mt-4" style="width: 50%;">

                <h3 class="font text-uppercase bold font-weight-bold" style="font-size: 22px;">Payment Made</h3>
            </div>

            <div class="container">

                <div class="row">
                    <div class="col-8">
                        <table class="table table-borderless">

                            <tbody class="font">
                                <tr>
                                    <td>Payment#</td>
                                    <th>97</th>
                                </tr>
                                <tr>
                                    <td>Payment Date</td>
                                    <th>{{$voucher_master[0]->Date}}</th>
                                </tr>
                                <tr>
                                    <td>Reference Number</td>
                                    <th>{{$voucher_master[0]->Voucher}}</th>
                                </tr>
                                <tr>
                                    <td>Paid To</td>
                                    <th>{{$voucher_master[0]->PartyName}}{{$voucher_master[0]->SupplierName}}</th>
                                </tr>
                                <tr>
                                    <td>Payment Mode</td>
                                    <th>{{$voucher_master[0]->VoucherTypeName}}</th>
                                </tr>
                                <tr>
                                    <td>Paid Through</td>
                                    <th>{{$voucher_master[0]->VoucherTypeName}}</th>
                                </tr>
                            </tbody>
                        </table>
                        Paid to
                        <br>
                        <strong style="font-weight: bold; font-size: 18px;" class="font">{{$voucher_master[0]->PartyName}}{{$voucher_master[0]->SupplierName}}</strong>
                    </div>
                    <div class="col-4">
                        <?php
                        $credit = 0;
                        $debit = 0;
                        $credit =  $voucher_master[0]->Credit;
                        $debit =  $voucher_master[0]->Debit;
                        $total_val = $credit + $debit;
                        ?>
                        <div class="bg-primary text-center pt-4" style="height: 30%; width: 70%; margin-left: -20%;">
                            <span class="font" style="color: white;">
                                Amount Paid <br>
                                {{session::get('Currency')}} {{number_format($total_val,2)}}
                            </span>
                        </div>

                    </div>
              
<hr>

            </div>
            </div>
        </div>
    </div>

<br>
<br>

<div class="container">
<div class="row">
    
    <div class="col-md-12">
      <?php 


$journal = DB::table('v_journal')->where('VHNO',$voucher_master[0]->Voucher)->get();


$TotalDr=0;
$TotalCr=0;

 ?>


<table class="table table-bordered table-sm">
    <thead>
        <tr>
            <td>VHNO</td>
            <td>DATE</td>
            <td>ACCOUNT</td>
            <td>DEBIT</td>
            <td>CREDIT</td>
        </tr>
    </thead>
    <tbody>
     
@foreach($journal as $value)

<?php 

$TotalDr = $TotalDr + $value->Dr;
$TotalCr = $TotalCr + $value->Cr;

 ?>

        <tr>
            <td>{{$value->VHNO}}</td>
            <td>{{dateformatman2($value->Date)}}</td>
            <td>{{$value->ChartOfAccountName}}</td>
            <td align="right">{{$value->Dr}}</td>
            <td align="right">{{$value->Cr}}</td>
             
            
        </tr>

@endforeach
<tr>
            <td></td>
            <td></td>
            <td></td>
            <td align="right">{{$TotalDr}}</td>
            <td align="right">{{$TotalCr}}</td>
             
            
        </tr>
    </tbody>

</table>


<br>
<br>
<br>
<br>
<br>
<br>    
    </div>
</div>
</div>
















    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>