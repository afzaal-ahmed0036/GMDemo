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
                                    <h4 class="mb-sm-0 font-size-18">Party Balances</h4>
                                        <strong class="text-end"><div align="center">{{(request()->ReportType=='C') ? 'Creditor Customers' : 'Debitor Customers' }}</div></strong> 
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
            $OpeningTotal=0;







             ?>
  <div class="card">
      <div class="card-body">
      @if(count($party)>0)     
  <table  class="table table-striped table-sm" >
    <tr>
      <td width="6%" bgcolor="#CCCCCC"><div align="center"><strong>S.NO</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div class="text-start"><strong>Party</strong></div></td>
      <td width="40%" bgcolor="#CCCCCC"><div align="left"><strong>NAME</strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="right"><strong>OPENING BALANCE</strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="right"><strong>DEBIT</strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="right"><strong> CREDIT </strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="right"><strong>BALANCE</strong></div></td>
    </tr>
   @foreach ($party as $key => $value)
    

<?php 


$sql = DB::table('journal')
->select( DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
// ->where('PartyID',$request->PartyID)
->where('PartyID',$value->PartyID)
->where('Date','<',request()->StartDate)
->where('ChartOfAccountID',110400)
 ->get();
 
$sql[0]->Balance = ($sql[0]->Balance ==null) ? '0' :  $sql[0]->Balance;



 $party1 = DB::table('journal')->select(DB::raw('sum(Dr) as Dr'),DB::raw('sum(Cr) as Cr'))
      ->whereBetween('date',array(request()->StartDate,request()->EndDate))
       ->where('PartyID',$value->PartyID)
       ->where('ChartOfAccountID',110400)
       ->get(); 

  

  $DrTotal=$DrTotal+$party1[0]->Dr;
  $CrTotal=$CrTotal+$party1[0]->Cr;
  $OpeningTotal=$OpeningTotal + $sql[0]->Balance;




 ?>



    
    <tr>
      <td><div align="center">{{$key+1}}.</div></td>
      <td><div align="left">{{$value->PartyID}}</div></td>
      <td>{{$value->PartyName}}</td>
      <td><div align="right">{{number_format($sql[0]->Balance,2)}}</div></td>
      <td><div align="right">{{number_format($party1[0]->Dr,2)}}</div></td>
      <td><div align="right">{{number_format($party1[0]->Cr,2)}}</div></td>
      <td><div align="right">{{number_format(($sql[0]->Balance+$party1[0]->Dr)-$party1[0]->Cr,2)}}</div></td>
       
      <td><div align="right"></div></td>
     </tr>
@endforeach
  
    <tr>
      <td></td>
      <td></td>
      <td><strong>TOTAL</strong></td>
      <td align="right"><strong>{{number_format($OpeningTotal,2)}}</strong></td>
      <td align="right"><strong>{{number_format($DrTotal,2)}}</strong></td>
      <td align="right"><strong>{{number_format($CrTotal,2)}}</strong></td>
      
      
      <td align="right"><strong>{{number_format(($OpeningTotal+$DrTotal)-($CrTotal),2)}}</strong></td>
    </tr>



  </table>      
  @else
<p class="text-danger">no record found</p>
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