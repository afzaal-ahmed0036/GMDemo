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
      <td colspan="2"><div align="center" class="style1">{{session::get('CompanyName')}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>OUTSTANDING INVOICES </strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"></div></td>
    </tr>
    <tr>
      <td width="50%">DATED: {{date('d-m-Y')}}</td>
      <td width="50%"><div align="right">From {{request()->StartDate}} TO {{request()->EndDate}}</div></td>
    </tr>
  </table>
  <table class="table table-striped table-sm">
    <tr>
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>INV#</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>REF#</strong></div></td>
      <td width="30%" bgcolor="#CCCCCC"><div align="LEFT"><strong>PARTY</strong></div></td>
      <td width="12%" bgcolor="#CCCCCC"><div align="center"><strong>DATE </strong></div></td>
       <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>BILL</strong></div></td>
       <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>PAID</strong></div></td>
      <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>BALANCE</strong></div></td>
    </tr>
    <?php $GrandTotal=0; ?>
   @foreach ($invoice as $key => $value)
    
    {{ $GrandTotal = $GrandTotal + $value->BALANCE  }}

    
    <tr>
       <td><div align="center">{{$value->InvoiceNo}}</div></td>
       <td><div align="center">{{$value->ReferenceNo}}</div></td>
      <td><div align="LEFT">{{$value->PartyName}}</div></td>
      <td><div align="center">{{$value->Date}}</div></td>
      
        <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
        <td><div align="right">{{number_format($value->PAID,2)}}</div></td>
       <td><div align="right">{{number_format($value->BALANCE,2)}}</div></td>
    </tr>
  @endforeach
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
       <td><div align="center"><strong>TOTAL</strong></div></td>
      <td><div align="right">{{number_format($GrandTotal,2)}}</div></td>
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