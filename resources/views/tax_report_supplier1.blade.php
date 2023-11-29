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
            $SubTotal=0;
            $Tax=0;
            $GrandTotal=0;
             ?>
  <div class="card">
      <div class="card-body">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><div align="center" class="style1">{{$company[0]->Name}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>TAX REPORT </strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
    <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
  <table class="table table-bordered table-sm">
    <tr class="bg-light">
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>DATE</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>INVOICE#</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>REF #</strong></div></td>
      <td width="30%" bgcolor="#CCCCCC"><div align="center"><strong>CUSTOMER</strong></div></td>
      
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>SUBTOTAL</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>TAX </strong></div></td>
       <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>GRAND TOTAL </strong></div></td>
      
    </tr>
   @foreach ($invoice_master as $key => $value)
    
   <?php  $SubTotal = $SubTotal + $value->SubTotal;
    $Tax = $Tax + $value->Tax;
    $GrandTotal = $GrandTotal + $value->GrandTotal;

    ?>
    
    <tr>
      <td><div align="center">{{dateformatman($value->Date)}}</div></td>
      <td><div align="center">{{$value->InvoiceNo}}</div></td>
      <td><div align="center">{{$value->ReferenceNo}}</div></td>
      <td>{{$value->SupplierName}}</td>
       <td><div align="center">{{number_format($value->SubTotal,2)}}</div></td>
      <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
      <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
      
    </tr>
@endforeach
<tr>
      <td></td>
      <td></td>
      <td><strong> </strong></td>
      <td><strong>Total</strong></td>
      <td><div align="center"><strong>{{number_format($SubTotal,2)}}</strong></div></td>
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