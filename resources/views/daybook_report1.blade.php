@extends('template.tmp')

  

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
      <td colspan="2"><div align="center"><strong>DAY BOOK - CASH &amp; SALE </strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
    <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
  
  <table class="table table-bordered table-sm">
    <tr>
      <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <tr>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>DATE</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>INVOICE</strong></div></td>
      <td width="6%" bgcolor="#CCCCCC"><div align="center"><strong>Ref#</strong></div></td>
      <td width="15%" bgcolor="#CCCCCC"><div align="center"><strong>CLIENT</strong></div></td>
      <td width="6%" bgcolor="#CCCCCC"><div align="center"><strong>SUBTOTAL</strong></div></td>
      <td width="6%" bgcolor="#CCCCCC"><div align="center"><strong>TAX </strong></div></td>
      
      <td width="9%" bgcolor="#CCCCCC"><div align="center"><strong>GRAND TOTAL </strong></div></td>
       </tr>

       <?php 

$SubTotal=0;
$Tax=0;
$Discount=0;
$GrandTotal=0;
        ?>
   @foreach ($invoice_master as $key => $value)
    
    <?php 

$SubTotal  = $SubTotal+ $value->SubTotal; 
$Tax  =$Tax + $value->Tax; 
 $GrandTotal   = $GrandTotal+$value->GrandTotal; 

 ?>


    <tr>
      <td><div align="center">{{dateformatman($value->Date)}}</div></td>
      <td><div align="center">{{$value->InvoiceNo}}</div></td>
      <td><div align="center">{{$value->ReferenceNo}}</div></td>
      <td>{{$value->PartyName}}</td>
     <td><div align="right">{{number_format($value->SubTotal,2)}}</div></td>
      <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
       <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
       </tr>
@endforeach
  
 
@for($i=count($invoice_master); $i<$row; $i++)


  <tr>
    <td>.</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
   </tr>
@endfor
 <tr>
    <td><div align="center"><strong>TOTAL</strong></div></td>
    <td></td>
    <td></td>
    <td></td>
    <td><div align="right"><strong>{{number_format($SubTotal,2)}}</strong></div></td>
    <td><div align="right"><strong>{{number_format($Tax,2)}}</strong></div></td>
     <td><div align="right"><strong>{{number_format($GrandTotal,2)}}</strong></div></td>
   </tr>
  </table></td>
      <td valign="top"><table width="100%" border="1" cellpadding="3" cellspacing="0"  style="border-collapse:collapse;">
    <tr>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>DATE</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>VHNO</strong></div></td>
      <td width="15%" bgcolor="#CCCCCC"><div align="center"><strong>DESCRIPTION</strong></div></td>
   
        <td width="9%" bgcolor="#CCCCCC"><div align="center"><strong>RECEIPT </strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="center"><strong>PAYMENT </strong></div></td>
    </tr>

   <?php 
   
   $SumDr=0;
   $SumCr=0;
    ?> 
   @foreach ($journal as $key => $value)
    

    <?php 

$SumDr = $SumDr + $value->Dr;
$SumCr = $SumCr + $value->Cr;


     ?>

    
    <tr>
      <td><div align="center">{{$value->Date}}</div></td>
      <td><div align="center">{{$value->VHNO}}</div></td>
      
      <td>{{$value->Narration}}</td>
      <td><div align="right">{{number_format($value->Dr,2)}}</div></td>
      <td><div align="right">{{number_format($value->Cr,2)}}</div></td>
    </tr>
@endforeach


@for($i=count($journal); $i<$row; $i++)
  <tr>
    <td>.</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
@endfor
  <tr>
    <td><div align="center"><strong>TOTAL</strong></div></td>
    <td></td>
    <td></td>
    <td><div align="right"><strong>{{number_format($SumDr,2)}}</strong></div></td>
    <td><div align="right"><strong>{{number_format($SumCr,2)}}</strong></div></td>
  </table></td>
    </tr>
  </table> </td>
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