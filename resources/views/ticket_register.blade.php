@extends('tmp')

@section('title', $pagetitle)
 

@section('content')

 
 
<div class="main-content">

 <div class="page-content">
 <div class="container-fluid">
            
  <div class="card shadow-sm">
      <div class="card-body">
          <!-- enctype="multipart/form-data" -->
          <form action="{{URL('/TicketRegister1')}}" method="post" name="form1" id="form1"> {{csrf_field()}} 

 
            
                <div class="col-md-4">
                <label for="basicpill-firstname-input">Invoice Type</label>
             <div class="mb-1">
                 <select name="InvoiceTypeID" id="" class="  form-select" id="select2-basic">
                 <?php foreach ($invoice_type as $key => $value): ?>
                  <option value="{{$value->InvoiceTypeID}}">{{$value->InvoiceType}}</option>
                <?php endforeach ?>
                  <option value="-1" selected="">Both</option>
             
              </select>
              </div>
               </div>

          


            
              <div class="col-md-4">
             <div class="mb-1">
                <label for="basicpill-firstname-input">Supplier</label>
                 <select name="SupplierID" id="" class="select2 form-select" id="select2-basic">
                <option value="0">All</option>
               <?php foreach ($supplier as $key => $value): ?>
                  <option value="{{$value->SupplierID}}">{{$value->SupplierName}}</option>
                  
                <?php endforeach ?>
              </select>
              </div>
               </div>
            

              <div class="col-md-4">
             <div class="mb-1">
                <label for="basicpill-firstname-input">Select Activity</label>
                 <select name="ItemID" id="" class="select2 form-select" id="select2-basic">
                <option value="0">All</option>
               <?php foreach ($item as $key => $value): ?>
                  <option value="{{$value->ItemID}}">{{$value->ItemCode}}-{{$value->ItemName}}</option>
                  
                <?php endforeach ?>
              </select>
              </div>
               </div>
            


              <div class="col-md-4">
             <div class="mb-0">
                <label for="basicpill-firstname-input">Saleman</label>
                 <select name="UserID" id="" class="select2 form-select" id="select2-basic">
                <option value="0">All</option>
               <?php foreach ($user as $key => $value): ?>
                  <option value="{{$value->UserID}}">{{$value->FullName}}</option>
                  
                <?php endforeach ?>
              </select>
              </div>
               </div>
            
 

             

                <div class="col-md-4"> 
                   <label class="col-form-label" for="email-id">From Date</label>
                 <div class="input-group" id="datepicker21">
  <input type="text" name="StartDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-

container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="2022-01-01">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
              </div>

                <div class="col-md-4"> 
                   <label class="col-form-label" for="email-id">To Date</label>
               <div class="input-group" id="datepicker22">
  <input type="text" name="EndDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-

container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
              </div>


              
              
         
      </div>
      <div class="card-footer bg-light">
        <button type="submit" class="btn btn-success w-lg float-right" id="online">Submit</button>
        <button type="submit" class="btn btn-success w-lg float-right" id="pdf">PDF</button>
                   <a href="{{URL('/')}}" class="btn btn-secondary w-lg float-right">Cancel</a>
      </div>
  </div>
   </form>
  </div>
</div>

        </div>
      </div>
    </div>
    <!-- END: Content-->
 
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>
  $('#pdf').click(function(){
     
   $('#form1').attr('action', '{{URL("/TicketRegister1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


  $('#online').click(function(){
     
   $('#form1').attr('action', '{{URL("/TicketRegister1")}}');
       $('#form1').attr('target', '_parent');


});


</script>
  @endsection