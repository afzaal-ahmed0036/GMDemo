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
                                    <h4 class="mb-sm-0 font-size-18">VENDOR BALANCE</h4>
                                        <strong class="text-end"></strong> 
        From {{request()->StartDate}} TO {{request()->EndDate}}

                                </div>
                            </div>
                        </div>
 @if (session('error'))

 <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                    
                   {{ Session::get('error') }}  
                </div>

@endif

 @if (count($errors) > 0)
                                 
                            <div >
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
            $DrTotal=0;
            $CrTotal=0;
             ?>
  <div class="card">
      <div class="card-body">
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="center"><span class="style2">FALAK TAVEL AND TOURISM LLC </span></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center" class="style1">VENDOR BALANCE </div></td>
  </tr>
  <tr>
    <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}} </td>
    <td width="50%"><div align="right">Dated : {{date('d-m-Y')}}</div></td>
  </tr>
</table>
</p>
<?php 
  $start_date = request()->StartDate;
  $start_date1 = request()->StartDate;
    $end_date = request()->EndDate;

     ?>

<table class="table table-bordered table-sm">
  <tr>
    <td><strong>Description</strong></td>
    <td style="width:8%;"><strong>Opening Balance </strong></td>
   <?php  while (strtotime($start_date) <= strtotime($end_date)) { ?>

    <td><div align="center">
      <?php  echo date("M-Y",strtotime($start_date)); ?>
    </div></td>
    <?php $start_date = date ("Y-m-d", strtotime("+1 month", strtotime($start_date)));     } ?>
    <td><div align="right">Total</div></td>
  </tr>
 @foreach($supplier as $value)
 <?php 
 $grand=0;
  $start_date1 = request()->StartDate; 

 $sql = DB::table('journal')
            ->select( DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
            ->where('SupplierID',$value->SupplierID)
            ->where('ChartOfAccountID',210100)
              ->where('Date','<',request()->StartDate)
            // ->whereBetween('date',array($request->StartDate,$request->EndDate))

               ->get();
if(count($sql)>0){
  $opening= $sql[0]->Balance;
}
else
{
   $opening=0;
}
 
 ?>
  <tr>
    <td>{{$value->SupplierName}}</td>
    <td><div align="right">{{($sql[0]->Balance==null) ? 0 : number_format($sql[0]->Balance,2)}}</div></td>
    <?php  while (strtotime($start_date1) <= strtotime($end_date)) { ?>


      <?php 

      // start of nested loop for checking balance
$date= date("M-Y",strtotime($start_date1));
$opening_bal = DB::table('v_supplier_balance')->where('SupplierID',$value->SupplierID)->where('Date',$date)->get();
if(count($opening_bal)>0){
  $monthly= $opening_bal[0]->Balance;
}
else
{
   $monthly=0;
}
  

   if(!isset($grand))
{
$grand =  $monthly;
 }
else
{
$grand = $grand + $monthly;
 }

       ?>

        <td><div align="right">{{ (count($opening_bal)>0) ? number_format($opening_bal[0]->Balance,2) : 0    }} </div></td><?php $start_date1 = date ("Y-m-d", strtotime("+1 month", strtotime($start_date1)));     } ?>
    <td><div align="right">{{number_format($grand+$opening,2)}}</div></td>
  </tr>
  @endforeach
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