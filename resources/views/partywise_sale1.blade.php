@extends('template.tmp')

@section('title', $pagetitle)
 

@section('content')



<div class="main-content">

 <div class="page-content">
 <div class="container-fluid">
  <!-- start page title -->
                       
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
      <td colspan="2"><div align="center" class="style1"> {{session::get('CompanyName')}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>PARTYWISE SALE (-) SALES RETURN </strong></div></td>
    </tr>
    <tr>
      <td width="50%">DATED: {{date('d-m-Y')}}</td>
      <td width="50%">&nbsp;</td>
    </tr>
  </table>
  <table  class="table table-bordered table-sm">
    <thead class="bg-light">
    <tr>
      <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>S.NO</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>INVOICE#</strong></div></td>
      <td width="50%" bgcolor="#CCCCCC"><div align="center"><strong>PARTY NAME</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>TOTAL </strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>DISCOUNT</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="right"><strong> TAX</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>GRAND TOTAL </strong></div></td>
      
    </tr>
  </thead>
  <?php 

$DiscountAmount=0;
$Tax=0;
$Shipping=0;
$GrandTotal=0;
$SubTotal=0;

 ?>
   @foreach ($party_wise as $key => $value)
     <?php 

$DiscountAmount  =  $DiscountAmount + $value->DiscountAmount;
$Tax  = $Tax+ $value->Tax;
$Shipping  = $Shipping +  $value->Shipping ;
$GrandTotal  = $GrandTotal+ $value->GrandTotal;
$SubTotal  = $SubTotal+ $value->SubTotal;

 ?> 
    
  <tr>
      <td><div align="center">{{$key+1}}.</div></td>
       <td><div align="center">{{$value->InvoiceNo}}</div></td>
       <td><div align="left">{{$value->PartyName}}</div></td>
      <td><div align="right">{{number_format($value->SubTotal,2)}}</div></td>
       <td><div align="right">{{number_format($value->DiscountAmount,2)}}</div></td>
      <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
      <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
    </tr>
@endforeach
 <tr>
     
       <td colspan="3"><div align="right"><STRONG>TOTAL</STRONG></div></td>
      <td><div align="right"><strong>{{number_format($SubTotal,2)}}</strong></div></td>
       <td><div align="right"><strong>{{number_format($DiscountAmount,2)}}</strong></div></td>
      <td><div align="right"><strong>{{number_format($Tax,2)}}</strong></div></td>
      <td><div align="right"><strong>{{number_format($GrandTotal,2)}}</strong></div></td>
       
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