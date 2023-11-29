@extends('tmp')
@section('title', $pagetitle)

@section('content')
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Noto+Serif:400,700">
<!-- Bootstrap core CSS -->
<link href="{{asset('assets/invoice/css/jquery-ui.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/invoice/css/datepicker.css')}}" rel="stylesheet">
<link href="{{asset('assets/invoice/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/invoice/css/style.css')}}" rel="stylesheet">


<!-- Custom styles for this template -->
<link href="{{asset('assets/invoice/css/sticky-footer-navbar.css')}}" rel="stylesheet">
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="{{asset('assets/invoice/js/ie.js')}}"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/pickers/form-flat-pickr.min.css')}}">
<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">


<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">

<!-- BEGIN: Page CSS-->
<!-- END: Page CSS-->
<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
<!-- END: Custom CSS-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<style type="text/css">

.form-control
{
border-radius: 0 !important;


}

.select2
{
border-radius: 0 !important;
width: 250px !important;

}


.swal2-popup {
font-size: 0.8rem;
font-weight: inherit;
color: #5E5873;
}


</style>



<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Voucher</h4>
            <div class="page-title-right ">
              
              
            </div>
            
            
            
          </div>
        </div>
      </div>
      <div  >
        <div  >
          <!-- enctype="multipart/form-data" -->
<form action="{{URL('/PettyCashUpdate')}}" method="post"> 

 
      <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">

 
 <div class="card shadow-sm">
     <div class="card-body">
     
 

<div class="row">
 
    <!-- <img src="{{asset('assets/images/logo/ft.png')}}" alt=""> -->


 
<div class="col-6">
 

 
<textarea name="Narration_mst" id="Narration" cols="30" rows="5" class="form-control " placeholder="Narration">{{$pettycash_master[0]->Narration}}</textarea>
<div class="clearfix mt-1"></div>
 
 
</div>
 
   <div class="col-6">


    <div class="row">
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="first-name">Petty Voucher #</label>
                  </div>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" name="PettyVoucher" id="PettyVoucher" value="{{$pettycash_master[0]->PettyVoucher}}">
                     <input type="hidden" name="PettyMstID" value="{{$pettycash_master[0]->PettyMstID}}"
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Chart of Acc</label>
                  </div>
                  <div class="col-sm-9">
                   <select class="form-select changesNooo" name="ChartOfAcc" id="ChartOfAcc">
   <?php foreach ($chartofaccount as $key => $value): ?>
     <option value="{{$value->ChartOfAccountID}}" {{($value->ChartOfAccountID== $pettycash_master[0]->ChOfAcc) ? 'selected=selected':'' }}
 >{{$value->ChartOfAccountName}}</option>
   <?php endforeach ?>
</select> 
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="email-id">Date</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text"  name="VHDate" id="VHDate"class="form-control invoice-edit-input date-picker flatpickr-input active" readonly="readonly"  value="{{$pettycash_master[0]->Date}}"  >
                  </div>
                </div>
              </div>
           
              


              
               
              
              
             
            </div>
    


  </div>
</div>



    <hr class="invoice-spacing">
       
    <div class='text-center'>
      
    </div>
        <div class='row'>
          <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <table   style="border-collapse: collapse;" cellspacing="0" cellpadding="0">
          <thead>
            <tr class="bg-light borde-1 border-light "  style="height: 40px;">
              <th width="2%" class="p-1"><input id="check_all"  type="checkbox"/></th>
              <th width="10%">Account</th>
               <th width="10%">Narration</th>
              
              
              <th width="5%">Invoice</th>
              <th width="5%">Ref No</th>
              <th width="5%">Debit</th>
             </tr>
          </thead>
          <tbody>
            <?php foreach ($pettycash_detail as $key => $value1): ?>

              <?php $no = $key+1;


               ?>
              
            
            <tr  class="bg-light border-1 border-light" >
              <td class=" bg-light border-1 border-light"><input class="case" type="checkbox" style="margin-left: 15px;" /></td>
              <td>

                 <select name="ChartOfAcc2[]" id="ItemID0_{{$no}}" class="form-select form-control-sm   ">
                  @foreach ($chartofaccount as $key => $value) 
                    <option value="{{$value->ChartOfAccountID}}" {{($value->ChartOfAccountID== $value1->ChOfAcc) ? 'selected=selected':'' }}>{{$value->ChartOfAccountName}}</option>
                  @endforeach
                 </select>
               </td>
              

                <td>
                  <input type="text" name="Narration[]" id="RefNo_{{$no}}" class="form-control      " autocomplete="off"  value="{{$value1->Narration}}" >
                </td>

                
             
              <td>
                <input type="number" name="Invoice[]" id="OPVAT_{{$no}}" class=" form-control  " autocomplete="off"  value="{{$value1->Invoice}}">
              </td>
              <td>
                <input type="number" name="RefNo[]" id="IPVAT_{{$no}}" class=" form-control  " autocomplete="off"  value="{{$value1->RefNo}}"  >
              </td>
               
              
              
              
              <td>
                <input type="number" name="Debit[]" id="debit_{{$no}}" class=" form-control changesNo totalLinePricee" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"  value="{{$value1->Debit}}"  >
              </td>
               
            </tr>

            <?php endforeach ?>
          </tbody>

            <tfooter>
            <tr class="bg-light border-1 border-light "  style="height: 40px;">
              <th width="2%" > </th>
              <th width="10%">  </th>
               <th width="10%"> </th>
              
              
              <th width="5%"> </th>
              <th width="5%"> </th>
              <th width="5%"><input type="text"  name="TotalDebit" readonly="" class=" form-control " id="sum_dr"> </th>
             </tr>
          </tfooter>


        </table>
          </div>
        </div>
        <div class="row mt-1 " style="margin-left: 29px;">
          <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  ' >
            <button class="btn btn-danger delete" type="button"><i class="mdi mdi-playlist-remove align-middle font-medium-3 me-25"></i>Delete</button>
            <button class="btn btn-success addmore" type="button"><i class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

          </div>

           <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  ' >
          <div id="result"></div>

          </div>
          <br>
        
        </div>


        <div >


      
        </div>


        
        
          
        
  <!--  <div class='row'>
          <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
            <div class="well text-center">
          <h2>Back TO Tutorial: <a href="#"> Invoice System </a> </h2>
        </div>
          </div>
        </div>   -->
  
               
      
    </div>
     </div>
 </div>
 
      
         
       
     

<div class="card-footer bg-light"> <div  ><button type="submit" id="submit" class="btn btn-primary w-lg float-right">Update</button>
  <a href="{{URL('/PettyCash')}}"   class="btn btn-secondary w-md float-right">Cancel</a>
             

       </div></div>

      </div>

      <!-- card end -->
  </div>
   </form>
  </div>
</div>

        </div> 
      </div>
    </div>
    <!-- END: Content-->

     <script src="{{asset('assets/invoice/js/jquery-1.11.2.min.js')}}"></script>
    <script src="{{asset('assets/invoice/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/invoice/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/invoice/js/bootstrap-datepicker.js')}}"></script>
    <!-- <script src="js/ajax.js"></script> -->

    <script>
      
      /**
 * Site : http:www.smarttutorials.net
 * @author muni
 */
        
//adds extra table rows
var i=$('table tr').length;
$(".addmore").on('click',function(){
  html = '<tr class="bg-light border-1 border-light ">';
  html += '<td ><input class="case" type="checkbox" style="margin-left: 15px;" /></td>';
  html += '<td><select name="ChartOfAcc2[]" id="ItemID0_1" class="form-select form-control-sm   ">@foreach ($chartofaccount as $key => $value)         <option value="{{$value->ChartOfAccountID}}">{{$value->ChartOfAccountName}}</option>  @endforeach       </select></td>';



  // html += '<td><select name="ItemID[]" id="ItemID_'+i+'" class="form-select changesNoo"><option value="">Select Item</option><option value="">b</option></select></td>';
   html += '<td><input type="text" name="Narration[]" id="RefNo_'+i+'" class="form-control changesNo" ></td>';
 
   html += '<td><input type="text" name="Invoice[]" id="OPVAT_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="RefNo[]" id="IPVAT_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="number" name="Debit[]" id="debit_'+i+'" class=" form-control changesNo totalLinePricee" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"  ></td>';
   html += '</tr>';
  $('table').append(html);
  i++;
});

//to check all checkboxes
$(document).on('change','#check_all',function(){
  $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
  $('.case:checkbox:checked').parents("tr").remove();
  $('#check_all').prop("checked", false); 
  calculateTotal();
});


var prices = ["S10_1678|1969 Harley Davidson Ultimate Chopper|48.81","S10_1949|1952 Alpine Renault 1300|98.58"];

 

 
 


////////////////////////////////////////////

$(document).on('change keyup blur','.changesNo',function(){
  calculateTotal();
});

//total price calculation 
function calculateTotal(){

var sum_dr=0;
$.each($('.totalLinePricee'),function() {

   if ($(this).val().length == 0) {
  
   }
   else
   {
        sum_dr += parseInt($(this).val());  





     
   }
});

 //alert(sum);
  $("#sum_dr").val(sum_dr); // display in div in html


  

  
  
}




 

 


//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}

//datepicker
$(function () {
  $.fn.datepicker.defaults.format = "dd-mm-yyyy";
    $('#invoiceDate').datepicker({
        startDate: '-3d',
        autoclose: true,
        clearBtn: true,
        todayHighlight: true
    });
});




    </script>

     <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

 <script>
   // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
 </script>

<!-- ajax trigger -->
 <script>
 

////////////////////////////////////////////
///voucher trigger
 


$(document).on('change','#VHDate',function(){


   

  vhdate = $('#VHDate').val();
 
dm = vhdate.split("-");
 
  ajax_vhno();

 
});
 
$(document).ready(function() {
     id_arr = $('#InvoiceType1').val();
 
  id = id_arr.split("-");

 // alert($('#VHNO').val());


// alert($('#ItemID0_'+id[1]).val());
$('#VoucherType').val( id[0]  );
$('#VoucherCode').val( id[1]+$('#Voucher').val()  );
}); 
   

// ajax vhno


function ajax_vhno()
{

       
       var VHDate = dm[0]+dm[1];


 
     // alert(id[1]+id[0]);
        
        /*  $("#butsave").attr("disabled", "disabled"); */
        // alert(SupplierID);
        
          $.ajax({
              url: "{{URL('/Ajax_PVHNO')}}",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                   
                   VocherCode: 'PCV',
                   VHDate: VHDate,
                 
              },
              cache: false,
              success: function(data){
            

              
                    $('#vhno_div').html(data);
    
              }
          });
      
}

function ajax_vhno1()
{

       // onload php date will work not boostrap picker
       var VHDate = {{date('Ym')}};


 
     // alert(id[1]+id[0]);
        
        /*  $("#butsave").attr("disabled", "disabled"); */
        // alert(SupplierID);
        
          $.ajax({
              url: "{{URL('/Ajax_PVHNO')}}",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                    VocherCode: 'PCV',
                   VHDate: VHDate,
                 
              },
              cache: false,
              success: function(data){
            

              
                    $('#vhno_div').html(data);
    
              }
          });
      
}

$(document).ready(function() {


  ajax_vhno1();
  calculateTotal();


    
 
  $(function () {
    /*selecting datepiker language*/
    flatpickr.localize(flatpickr.l10ns.en);
    /*declaring return datepicker*/
   
    /*declaring outbound datepicker*/
    $("#VHDate").flatpickr(
      {
        altInput: true,
        altFormat: "Y-m-d",
        dateFormat: "Y-m-d",
        disableMobile: "true",
        minDate: "",
        maxDate: new Date().fp_incr(365),
        defaultDate: "{{$pettycash_master[0]->Date}}",
         /* setting initial date of return picker to the one selected in 
        outbound*/
        onChange: function (dateStr, dateObj) {
          FLATPICKER_RITORNO.set("minDate", dateObj);
          FLATPICKER_RITORNO.setDate(dateObj);
        }
      });
  });
 

});


// end ajax vhno
 


 
  
 
</script>
 
<script src="{{asset('assets/js/scripts/forms/form-select2.min.js')}}"></script>
 


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <script src="{{asset('assets/js/scripts/forms/form-repeater.min.js')}}"></script>

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('assets/js/core/app-menu.min.js')}}"></script>
    <script src="{{asset('assets/js/core/app.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/customizer.min.js')}}"></script>
    <!-- END: Theme JS-->
 
    <!-- BEGIN: Page JS-->
    <script src="{{asset('assets/js/scripts/pages/app-invoice.min.js')}}"></script>
    <!-- END: Page JS-->


  @endsection