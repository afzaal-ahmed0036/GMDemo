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
            <h4 class="mb-sm-0 font-size-18">Record Payment</h4>
             
             
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
      
      
      <div class="row">
        
        <div class="card">
        <div class="card-body">
          
      
         <!-- form start -->

<!-- enctype="multipart/form-data" -->
  <form action="{{URL('/PaymentSave')}}" enctype="multipart/form-data" method="post"> {{csrf_field()}} 

         

         
               

<div class="col-md-8">
  

                 <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Party</label>
                   <div class="col-sm-9">
                   <select name="PartyID" id="PartyID" class="form-select select2">
                       <option value="0">Select</option>
                       @foreach($party as $value)
                       <option value="{{$value->PartyID}}">{{$value->PartyName}}</option>
                      @endforeach
                  </select>
                   </div> 

</div>
                   


                    <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Amount Received</label>
                   <div class="col-sm-9">
                   <div class="input-group">
                   <div class="input-group-text">{{session::get('Currency')}}</div>
                   <input type="text" class="form-control" id="PaymentAmount" name="PaymentAmount" readonly="" >
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
                       <?php foreach ($payment_mode as $key => $value): ?>
                         <option value="{{$value->PaymentMode}}">{{$value->PaymentMode}}</option>
                      
                      <?php endforeach ?>
                  </select>
                   </div>
                   </div>


                    <div class="row mb-4">
                   <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Deposit To</label>
                   <div class="col-sm-9">
                      <select name="ChartOfAccountID"  class="form-select select2">
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
<div id="invoices" > </div>


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

         <!-- form ends -->
            
 

      </div>


      </div>
     
      
    </div>
  </div>
</div>
</div>
</div>
@endsection

@push('after-scripts')

<script>


$(document).on(' click','.check',function(){


var paid = parseFloat($('#PaymentAmount').val());
var amountdue = parseFloat($('#AmountDue').text());

// alert(paid + '--'+ amountdue);

tot = 0; 
  $('.payment1').each(function(){
    if($(this).val() != '' ) tot += parseFloat( $(this).val() );
  });

 

  
if(paid == tot )
{

   toastr["success"]("Paid and total are equal");
  // toastr["success"]("Extra payment will be adjusted against party advance");

  

    if(paid > amountdue )
    {
      

      // extra payment

toastr["error"]("Payment received is more than amount due..");
        




      var payment = $('#PaymentAmount').val();
    var total = $('#AmountDue').text();

    var result = (parseFloat(payment) - parseFloat(total)).toFixed(2);



$('#excess').text( result ) ;
$('#received').text( payment ) ;
$('#amountused').text( total ) ;



      // return false;
    }
    else
    {




var payment = $('#PaymentAmount').val();
var total = $('#AmountDue').text();

var result = (parseFloat(payment) - parseFloat(total)).toFixed(2);



$('#received').text( payment ) ;
$('#amountused').text( payment ) ;
 $('#excess').text( '0.00' ) ;
// alert('payment less then invoice');
toastr["success"]("payment less then invoice 255");
// return false;

    }

  
}  

else
{
  // alert('payment is not equal ');
  toastr["error"]("Payment received against invoice are not equal");
   //return false;
}

});
 

// assign data to div below payment boxes





 

$(document).on(' keyup','.payment1',function(){


 payment1 = 0; 
  $('.payment1').each(function(){
    if($(this).val() != '' ) payment1 += parseFloat( $(this).val() );
  });
  $('#paymenttotal').val( payment1.toFixed(2) );
  $('#PaymentAmount').val( payment1.toFixed(2) );
  
});




$(document).on(' blur','#PaymentAmount',function(){


   var paid = parseFloat($('#PaymentAmount').val());
var amountdue = parseFloat($('#AmountDue').text());
var total = parseFloat($('#AmountDue').text());


 if(paid > amountdue )
    {
      // alert('amount is extra');
toastr["error"]("Amount is more then due invoices");
      

    var result = (parseFloat(paid) - parseFloat(amountdue)).toFixed(2);



$('#excess').text( result ) ;
$('#received').text( paid ) ;
$('#amountused').text( total ) ;



      return false;
    }
    else
    {




var payment = $('#PaymentAmount').val();
var total = $('#AmountDue').text();

var result = (parseFloat(payment) - parseFloat(total)).toFixed(2);



$('#received').text( payment ) ;
$('#amountused').text( payment ) ;
 $('#excess').text( '0.00' ) ;
// alert('payment less then invoice');
// toastr["success"]("amount is extra then due amount");

return false;

    }



});






   
    $("#PartyID").change(function(){
      
       // alert({{Session::token()}});

    
      
      var PartyID = $('#PartyID').val();

        // console.log(PartyID);
       if(PartyID>0  ){
        /*  $("#butsave").attr("disabled", "disabled"); */
         // alert($('#PartyID').val());
         // alert('next stage if else');
       // console.log(PartyID);

 


            $.ajax({

              url: "{{URL('/Ajax_PartyInvoices')}}/"+PartyID,
              type: "get",
              data: {
                  // _token: 43DeWyo3MzTaTYdg5iqACJ2nPyPwCa7NZO9KClYa,
                  "_token": "{{ csrf_token() }}",
                    PartyID: PartyID,
                 
              },
              cache: false,
               
              success: function(data){
            
 
                // alert(data.success);
                    $('#invoices').html(data);
           
                 
                  
              }
          });




      }
      else{
          alert('Please Select Party...');
      }
  });
</script>
       





 

@endpush