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
      <td colspan="2"><div align="center"><strong>SALEMAN WISE REPORT </strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
    <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
  <table class="table table-bordered table-sm">
    <tr class="bg-light">
      <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>VHNO</strong></div></td>
      <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>DATE</strong></div></td>
      <td width="30%" bgcolor="#CCCCCC"><div align="left"><strong>PARTY</strong></div></td>
       <td width="3%" bgcolor="#CCCCCC"><div align="center"><strong>TAX </strong></div></td>
       
      <td width="3%" bgcolor="#CCCCCC"><div align="center"><strong>DISCOUNT </strong></div></td>
     
      <td width="9%" bgcolor="#CCCCCC"><div align="center"><strong>GRAND TOTAL </strong></div></td>
    </tr>
   @foreach ($invoice_master as $key => $value)
    
    
    <tr>
      <td><div align="center">{{$value->InvoiceNo}}</div></td>
      <td><div align="center">{{dateformatman($value->Date)}}</div></td>
      <td>{{$value->PartyName}}</td>
       <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
      <td><div align="right">{{number_format($value->DiscountAmount,2)}}</div></td>
      
      
      <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
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