@extends('template.tmp')

@section('title', $pagetitle)
 

@section('content')

 
 
 
  
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
<div class="main-content">

 <div class="page-content">
 <div class="container-fluid">




    <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Party Ledger</h4>
                                          
                                  

                                </div>
                            </div>
                        </div>
            
  <div class="card shadow-sm">
      <div class="card-body">
          <!-- enctype="multipart/form-data" -->
          <form action="{{URL('/PartyLedger1')}}" method="post" name="form1" id="form1"> {{csrf_field()}} 

 
            
                <div class="col-md-4">
                <label for="basicpill-firstname-input">Party Name</label>
             <div class="mb-2">
                 <select name="PartyID" id="" class="select2 form-select"  required="" >
                <option value="">Select</option>
                <?php foreach ($party as $key => $value): ?>
                  <option value="{{$value->PartyID}}">{{$value->PartyName}}</option>
                  
                <?php endforeach ?>
             
              </select>
              </div>
               </div>

                <div class="col-md-4">
             <div class="mb-1">
                <label for="basicpill-firstname-input">Chart of Account</label>
                 <select name="ChartOfAccountID[]" id="" class="select2 form-select " data-placeholder="Choose ...">
                <?php foreach ($chartofaccount as $key => $value): ?>
                  <option value="{{$value->ChartOfAccountID}}">{{$value->ChartOfAccountID}}-{{$value->ChartOfAccountName}}</option>
                  
                <?php endforeach ?>
              </select>
              </div>
               </div>
            
 

            
              <div class="col-md-4">
             <div class="mb-0">
                <label for="basicpill-firstname-input">Voucher Type</label>
                 <select name="VoucherTypeID" id="" class="select2 form-select"  >
                <option value="" selected="">ALL</option>
               <?php foreach ($voucher_type as $key => $value): ?>
                  <option value="{{$value->VoucherTypeID}}">{{$value->VoucherCode}}-{{$value->VoucherTypeName}}</option>
                  
                <?php endforeach ?>
              </select>
              </div>
               </div>
            
 
<style>
  .datepicker {
  z-index:1001 !important;
}
</style>
             

 
              <div class="col-md-4"> 
                   <label class="col-form-label" for="email-id">Start Date</label>
                 <div class="input-group" id="datepicker21">
  <input type="text" name="StartDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="2022-01-01">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
              </div>

                <div class="col-md-4"> 
                   <label class="col-form-label" for="email-id">End Date</label>
               <div class="input-group" id="datepicker22">
  <input type="text" name="EndDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
              </div>

 
  
 
              
              
         
      </div>
      <div class="card-footer bg-light  ">
        <button type="submit" class="btn btn-success w-lg float-right" id="online">Submit</button>
        <button type="submit" class="btn btn-success w-lg float-right" id="pdf">PDF</button>
        <button type="submit" class="btn btn-secondary w-lg float-right" id="PartySalesLedger2PDF">Party Ledger with Sale Details</button>
        <button type="submit" class="btn btn-success w-lg float-right" id="PartySalesLedger1PDF">Detail Sales Ledger</button>
        <button type="submit" class="btn btn-success w-lg float-right" id="PartyLedgerAccount1PDF">Party Ledger Account with Amount</button>
       </div>
  </div>
   </form>
 

        </div>
      </div>
    </div>

 

@endsection

@push('after-scripts')

<script>
  $('#pdf').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyLedger1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


  $('#PartySalesLedger1PDF').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartySalesLedger1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


    $('#PartyLedger2PDF').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartySalesLedger1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});

 $('#PartyLedgerAccount').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartySalesLedger1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


 $('#PartyLedgerAccount1PDF').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyLedgerAccount1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


 $('#PartySalesLedger2PDF').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartySalesLedger2PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});



  $('#online').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyLedger1")}}');
    

});


</script>

<script>
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
      });

</script>
  @endpush