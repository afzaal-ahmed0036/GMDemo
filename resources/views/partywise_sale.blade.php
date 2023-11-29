@extends('template.tmp')

@section('title', $pagetitle)
 

@section('content')

<div class="main-content">

 <div class="page-content">
 <div class="container-fluid">
<div class="row">
  <div class="col-12">
  
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

            
  <div class="card shadow-sm">
      <div class="card-body">
          <!-- enctype="multipart/form-data" -->
          <form action="{{URL('/PartyWiseSale1')}}" method="post" name="form1" id="form1"> {{csrf_field()}} 

 
            
              <!--   <div class="col-md-4">
                <label for="basicpill-firstname-input">Invoice Type</label>
             <div class="mb-1">
                 <select name="InvoiceTypeID" id="" class="select2 form-select" id="select2-basic">
                 <?php foreach ($invoice_type as $key => $value): ?>
                  <option value="{{$value->InvoiceTypeID}}">{{$value->InvoiceType}}</option>
                <?php endforeach ?>
                  <option value="both" selected="">Both</option>
             
              </select>
              </div>
               </div>
 -->
          


            
              <div class="col-md-4">
             <div class="mb-0">
                <label for="basicpill-firstname-input">Supplier</label>
                 <select name="PartyID" id="" class="select2 form-select" id="select2-basic">
                <option value="0">Select</option>
               <?php foreach ($party as $key => $value): ?>
                  <option value="{{$value->PartyID}}">{{$value->PartyName}}</option>
                  
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
        <button type="submit" class="btn btn-success w-lg float-right">Submit</button>
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
@endsection

@push('after-scripts')
<script>
  $('#pdf').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyWiseSale1PDF")}}');
   $('#form1').attr('target', '_blank');
   $('#form1').submit();

});


  $('#online').click(function(){
     
   $('#form1').attr('action', '{{URL("/PartyWiseSale1")}}');
    

});


</script>
  @endpush