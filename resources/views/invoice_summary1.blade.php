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
  <table style="width: 100%;">
    <tr>
      <td colspan="2"><div align="center" class="style1"> {{session::get('CompanyName')}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong> INVOICE SUMMARY SALEMAN WISE</strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
    <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
   
  
  <table class="table  table-sm">
  <thead style="display: table-header-group;">
   <tr class="bg-light">
     <th width="5%" bgcolor="#CCCCCC"><div align="center"><strong>S#</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>PARTY/SUPPLIER</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>SALEMAN</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>SUBTOTAL</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>TAX</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>DISCOUNT</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>GRAND</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>PAID</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>BALANCE</strong></div></th>
        
   </tr>
  </thead>
  <tbody>
 
   @foreach ($invoice_summary as $key => $value)
    
    
   <tbody>
      <tr>
      
      <td><div align="center">{{$key+1}}</div></td>
      <td>{{$value->PartyName}}</td>
      <td>{{$value->FullName}}</td>
      <td>{{$value->SubTotal}}</td>
      <td>{{$value->Tax}}</td>
      <td>{{$value->DiscountAmount}}</td>
      <td>{{$value->GrandTotal}}</td>
      <td>{{$value->Paid}}</td>
      <td>{{$value->Balance}}</td>
    


    </tr>
   </tbody>
@endforeach
    <tr>
     
 <td></td>
 <td></td>
 <td></td>
 <td></td>
 
   
 <td>{{number_format($invoice_total[0]->Tax,2)}}</td>
 <td>{{number_format($invoice_total[0]->Discount,2)}}</td>
 <td>{{number_format($invoice_total[0]->GrandTotal,2)}}</td>
 <td>{{number_format($invoice_total[0]->Paid,2)}}</td>
 <td>{{number_format($invoice_total[0]->Balance,2)}}</td>
       
      
      
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