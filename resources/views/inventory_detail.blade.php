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
                                    <h4 class="mb-sm-0 font-size-18"> </h4>
                                         
        <!-- <a href="{{URL('/PartyListPDF')}}" class="btn btn-success" target="_blank">View PDF</a> -->

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
      <td colspan="2"><div align="center" class="style1">{{$company[0]->Name}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>Inventory Detail </strong></div></td>
    </tr>
    <tr>
      <td width="50%">DATED: {{date('d-m-Y')}}</td>
      <td width="50%" align="right"> From {{$startdate}} TO {{$enddate}}</td>
    </tr>
  </table>
       

<?php 
            $TotalSaleReturn=0;
            $TotalQtyIn=0;
            $TotalQtyOut=0;
           


             ?>
  <table width="100%" class="table table-striped table-sm" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <thead>
    <tr>
      <th width="5%" bgcolor="#CCCCCC"><div align="center"><strong>S#</strong></div></th>
      <th width="40%" bgcolor="#CCCCCC"><div align="left"><strong>ITEM NAME#</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>INVOICE # </strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>Sale Return</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>QTY IN</strong></div></th>
      
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>QTY OUT</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="right"><strong>BALANCE</strong></div></th>
       
    </tr>
    </thead>
   @foreach ($inventory as $key => $value)
     


<?php 

$TotalSaleReturn = $TotalSaleReturn + $value->SaleReturn;
$TotalQtyIn = $TotalQtyIn + $value->QtyIn;
$TotalQtyOut = $TotalQtyOut + $value->QtyOut;



 ?>
      
    
    <tr>
      <td><div align="center">{{$key+1}}</div></td>
      <td><div align="left">{{$value->ItemName}}  </div></td>
      
      
       <td><div align="center">{{$value->InvoiceNo}}</div></td>
       <td ><div align="center"> <a target="_blank" href="{{URL('/CreditNoteViewPDF/'.$value->InvoiceMasterID)}}">{{  ($value->SaleReturn==0) ? '-' : number_format($value->SaleReturn) }}</a></div></td>
       
       <td><div align="center"> <a target="_blank" href="{{URL('/BillViewPDF/'.$value->InvoiceMasterID)}}">{{      ($value->QtyIn==0) ? '-' : number_format($value->QtyIn)    }}</a></div></td>

       <td><div align="center"> <a target="_blank" href="{{URL('/SaleInvoiceViewPDF/'.$value->InvoiceMasterID)}}">{{      ($value->QtyOut==0) ? '-' : number_format($value->QtyOut)    }} </a></div></td>
       <td><div align="center"> {{number_format(($value->QtyIn+$value->SaleReturn)-$value->QtyOut)}}</div></td>
      
       
    </tr>
@endforeach

<tr class="text-dange bg bg-warning">
  <td></td>
  <td>Total</td>
  <td></td>
  <td align="center">{{number_format($TotalSaleReturn)}}</td>
  <td align="center">{{number_format($TotalQtyIn)}}</td>
  <td align="center">{{number_format($TotalQtyOut)}}</td>
  <td align="center">{{number_format(($TotalQtyIn+$TotalSaleReturn)-$TotalQtyOut)}}</td>
  
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