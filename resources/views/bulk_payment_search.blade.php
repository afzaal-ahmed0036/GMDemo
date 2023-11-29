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
                                    <h4 class="mb-sm-0 font-size-18">Parties Unpaid Invoices</h4>
                                         
 
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

            
            
 <!-- enctype="multipart/form-data" -->
 <form action="{{URL('/BulkPaymentSave')}}" method="post"> {{csrf_field()}} 
   

  <div class="card">
                                  <div class="card-header bg-secondary bg-soft  border-bottom">
                                       <div class="row">
                                         <div class="col-md-6"> Party Name : <strong>{{$party[0]->PartyName}}</strong></div>
                                         <div class="col-md-6 text-end"> <strong>From</strong> {{dateformatman(request()->StartDate)}} <strong>TO</strong> {{dateformatman(request()->EndDate)}}
                                      </div>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                     <div class="row">
                                       <div class="col-md-6"><strong>TRN # </strong>{{$party[0]->TRN}}</div>
                                       <div class="col-md-6 text-end"><strong>Balance</strong> : {{number_format($invoice_summary[0]->Balance,2)}}</div>
                                     </div>
                                    </div>
                                </div>



  <div class="card">
                                  
                                    <div class="card-body">
        <div class="col-md-8">
  

    <input type="hidden" name="PartyID" value="{{$party[0]->PartyID}}">
                   


                    <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Amount Received</label>
                   <div class="col-sm-9">
                   <div class="input-group">
                   <div class="input-group-text">{{session::get('Currency')}}</div>
                   <input type="text" class="form-control" id="PaymentAmount" name="PaymentAmount" value="{{$invoice_summary[0]->Balance}}" >
                   </div>
                   </div>
                   </div>  
              

    <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Payment Date</label>
                   <div class="col-sm-9">
                   
                     <div class="input-group" id="datepicker2">
  <input type="text" name="PaymentDate" class="form-control" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" data-date-container="#datepicker2" data-provide="datepicker" data-date-autoclose="true"  value="{{date('d/m/Y')}}">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
                   </div>
                   </div>   
              
      
        <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Payment #.</label>
                   <div class="col-sm-9">
                   <input type="text" class="form-control" id="horizontal-firstname-input" name="PaymentMasterID" value="{{$payment[0]->PaymentMasterID}}" readonly="">
                   </div>
                   </div>   
            
    <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Payment Mode</label>
                   <div class="col-sm-9">
                      <select name="PaymentMode" id="" class="form-select">
                                                <option value="Cash">Cash</option>
                      
                                               <option value="Bank Transfer">Bank Transfer</option>
                      
                                               <option value="Cheque">Cheque</option>
                      
                                               <option value="Credit Card">Credit Card</option>
                      
                                        </select>
                   </div>
                   </div> 

   <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Deposit To</label>
                   <div class="col-sm-9">
                      <select name="ChartOfAccountIDIN" id="" class="form-select" required>
                      <option value="">Select</option>
                       @foreach($chartofacc as $value)
                       <option value="{{$value->ChartOfAccountID}}"  >{{$value->ChartOfAccountName}}</option>
                       @endforeach
                  </select>
                   </div>
                   </div>


                    <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Deposit From</label>
                   <div class="col-sm-9">
                      <select name="ChartOfAccountIDFrom"  class="form-select select2">
                     <option value="">Select</option>
                       @foreach($chartofacc as $value)
                       <option value="{{$value->ChartOfAccountID}}" {{($value->ChartOfAccountID== 110400) ? 'selected=selected':'' }}>{{$value->ChartOfAccountName}}</option>
                      @endforeach   
                  </select>
                   </div>
                   </div>
     <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Reference #.</label>
                   <div class="col-sm-9">
                   <input type="text" class="form-control" id="horizontal-firstname-input" name="ReferenceNo" >
                   </div>
                   </div> 

        </div>
                                    </div>
                                </div>


    <div class="card">
      <div class="card-body">
               @if(count($invoice_master)>0)    
               <table class="table  table-sm align-middle table-nowrap mb-0">
               <tbody>
                <tr class="bg-light">
               <th scope="col">S.No</th>
               <th scope="col">Invoice#</th>
               <th scope="col">Party Name</th>
               <th scope="col">Date</th>
               <th scope="col">Tax</th>
               <th scope="col">Amount</th>
               <th scope="col">Paid</th>
               <th scope="col">Balance</th>
               </tr>
               </tbody>
               <tbody>
               @foreach ($invoice_master as $key =>$value)
                <tr>
                <td class="col-md-1">{{$key+1}}</td>
                <td class="col-md-1">{{$value->InvoiceNo}}</td>
                <td class="col-md-1">{{$value->PartyName}}</td>
                <td class="col-md-1">{{$value->Date}}</td>
                <td class="col-md-1">{{$value->Tax}}</td>
                <td class="col-md-1">{{$value->GrandTotal}}</td>
                <td class="col-md-1">{{$value->Paid}}</td>
                <td class="col-md-1"><input type="hidden" name="InvoiceNo[]" value="{{$value->InvoiceNo}}"> 
                <input type="hidden" name="InvoiceMasterID[]" value="{{$value->InvoiceMasterID}}">
                <input type="hidden" name="GrandTotal[]" value="{{$value->GrandTotal}}">


                <input type="text" name="Amount[]" value="{{$value->GrandTotal-$value->Paid}}" class="form-control form-control-sm">

              </td>
                </tr>
                @endforeach   
                </tbody>
                </table>
                @else
                  <p class=" text-danger">No data found</p>
                @endif    
      </div>
  </div>


<div class="col-md-12">
<div class="mb-3">
<label for="verticalnav-address-input">Notes (Internal use. Not visible to customer)</label>
<textarea id="verticalnav-address-input" class="form-control" rows="" name="Notes"></textarea>
</div>
</div>


<div class="col-md-4"><div class="mb-3"><label for="basicpill-firstname-input" class="pr-5">Attach File(s)
</label><br><input type="file" name="UploadSlip" id="UploadSlip"></div></div>

<hr class="mt-3 mb-3">


<div><button type="submit" class="btn btn-danger  float-right check">Save </button>
     <a href="{{URL('/')}}" class="btn btn-secondary   float-right">Cancel</a>
</div>


 </form>
  
  </div>
</div>

        </div>
      </div>
    </div>
    <!-- END: Content-->
 
  @endsection