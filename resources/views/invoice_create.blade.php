
<html lang="en">
  
 <meta http-equiv="content-type" content="text/html;charset=UTF-8" /> 
<head>
    
 
    <title>Invoice</title>

    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Noto+Serif:400,700"> 
    <!-- Bootstrap core CSS -->
    <link href="{{asset('assets/invoice/css/jquery-ui.min.css')}}" rel="stylesheet">
     <link href="{{asset('assets/invoice/css/datepicker.css')}}" rel="stylesheet">
    <link href="{{asset('assets/invoice/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/invoice/css/style.css')}}" rel="stylesheet">

 
   <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-extended.min.css')}}">
    <!-- Custom styles for this template -->
    <link href="{{asset('assets/invoice/css/sticky-footer-navbar.css')}}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{asset('assets/invoice/js/ie.js')}}"></script>

    
 <!-- App favicon -->
        <link rel="shortcut icon" href="{{URL('/')}}/assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="{{URL('/')}}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{URL('/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{URL('/')}}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <link href="{{URL('/')}}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
        <!-- Responsive datatable examples -->
        <link href="{{URL('/')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert-->
        <link href="{{URL('/')}}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

           <link href="{{URL('/')}}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
         <link rel="stylesheet" href="{{URL('/')}}/assets/libs/%40chenfengyuan/datepicker/datepicker.min.css">

        <link rel="stylesheet" type="text/css" href="{{URL('/')}}/assets/libs/toastr/build/toastr.min.css">

 
        <!-- Responsive datatable examples -->
 

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <style type="text/css">
      
      .form-control, .form-select
      {
        border-radius: 0 !important;
        
      }

      body {
    -moz-transform: scale(0.68, 0.68); /* Moz-browsers */
    zoom: 0.68; /* Other non-webkit browsers */
    zoom: 90%; /* Webkit browsers */
}

    </style>

    </head>

  <body  class="mt-2" >

    

    <!-- Begin page content -->
    <div class="container-fluid" class="mt-4" >


<!-- enctype="multipart/form-data" -->
<form action="{{URL('/InvoiceSave')}}" method="post"> 

 
      <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">

 
 <div class="card shadow-sm">
     <div class="card-body">
     
 

<div class="row">
  <div class="col-6"> <img src="{{asset('assets/images/logo/ft.png')}}" alt="">


<br>
<br>
<div class="col-6">
  <label for="">Invoice Type</label>
 <select class="form-select select2 " name="InvoiceTypeID" required="">
   <?php foreach ($invoice_type as $key => $value): ?>
     <option value="{{$value->InvoiceTypeID}}">{{$value->InvoiceTypeCode}}-{{$value->InvoiceType}}</option>
   <?php endforeach ?>
</select> 

<div class="clearfix mt-1"></div>
 <label for="">Party</label>

<select name="PartyID" id="PartyID" class="form-select select2 mt-5" name="PartyID" required="">
 <?php foreach ($party as $key => $value): ?>
     <option value="{{$value->PartyID}}">{{$value->PartyName}}</option>
   <?php endforeach ?>
</select>
</div>
  </div>
  <div class="col-2">  </div>
  <div class="col-4">


    <div class="row">
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="first-name">Invoice #</label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="first-name" class="form-control" name="VHNO" value="{{$vhno[0]->VHNO}}" >
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="email-id">Date</label>
                  </div>
                  <div class="col-sm-9">
                     <div class="input-group" id="datepicker21">
  <input type="text" name="Date"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="contact-info">Due Date</label>
                  </div>
                  <div class="col-sm-9">
                    <div class="input-group" id="datepicker22">
  <input type="text" name="DueDate"  autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
  <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Payment Mode </label>
                  </div>
                  <div class="col-sm-9">
                    <select name="PaymentMode" id="PaymentMode" class="form-select">
                  <option value="Cash">Cash</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="Bank Transfer">Bank Transfer</option>
           
                </select>
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
            <table    >
          <thead>
            <tr class="bg-light borde-1 border-light "  style="height: 40px;">
              <th width="2%" class="p-1"><input id="check_all"  type="checkbox"/></th>
              <th width="5%">Item</th>
              <th width="15%">Supplier</th>
              <th width="5%">Ref No</th>
              <th width="5%">Visa </th>
              <th width="10%">PAX Name</th>
              <th width="8%">PNR</th>
              <th width="5%">Sector</th>
              <th width="5%">Fare</th>
              <th width="5%">Tax%</th>
              <th width="5%">Service</th>
              <th width="5%">O/P Vat</th>
              <th width="5%">I/P VAT</th>
              <th width="6%">Tax</th>
              <th width="4%">Dis</th>
              <th width="10%">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr class="p-3">
              <td class="p-1 bg-light borde-1 border-light"><input class="case" type="checkbox"/></td>
              <td>

                 <select name="ItemID0[]" id="ItemID0_1" class="form-select form-control-sm   changesNoo">
                  @foreach ($items as $key => $value) 
                    <option value="{{$value->ItemID}}|{{$value->Percentage}}">{{$value->ItemCode}}-{{$value->ItemName}}-{{$value->Percentage}}</option>
                  @endforeach
                 </select>
                 <input type="hidden" name="ItemID[]" id="ItemID_1">
              </td>
              <td> <select name="SupplierID[]" id="SupplierID_1" class="form-select changesNo" onchange="ajax_balance(this.value);">
                   @foreach ($supplier as $key => $value) 
                    <option value="{{$value->SupplierID}}">{{$value->SupplierName}}</option>
                  @endforeach
                 </select>

                </td>

                <td>
                  <input type="text" name="RefNo[]" id="RefNo_1" class="form-control      " autocomplete="off"   >
                </td>

                <td>
                  <input type="text" name="VisaType[]" id="VisaType_1" class="   form-control  " autocomplete="off"  >
                </td>
                <td>
                  <input type="text" name="PaxName[]" id="PaxName_1" class=" form-control  " autocomplete="off"  >
                </td>
                <td>
                  <input type="text" name="PNR[]" id="PNR_1" class=" form-control  " autocomplete="off" >
                </td>
                <td>
                  <input type="text" name="Sector[]" id="Sector_1" class=" form-control  " autocomplete="off" >
                </td>
              <td>
                <input type="number" name="Fare[]" id="Fare_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" >
              </td>
              <td>
                <input type="number" name="Taxable[]"  id="Taxable_1" class=" form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" >
              </td>
              <td>
                <input type="number" name="Service[]" id="Service_1" class=" form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
              </td>
              <td>
                <input type="number" name="OPVAT[]" id="OPVAT_1" class=" form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
              </td>
              <td>
                <input type="number" name="IPVAT[]" id="IPVAT_1" class=" form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
              </td>
               
              
              
              
              <td>
                <input type="number" name="TaxAmount[]" id="quantity_1" class=" form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
              </td>
              <td>
                <input type="number" name="Discount[]" id="discount_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
              </td>
              <td>
                <input type="number" name="ItemTotal[]" id="total_1" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
              </td>
            </tr>


          </tbody>
        </table>
          </div>
        </div>
        <div class="row mt-1 mb-2" style="margin-left: 29px;">
          <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  ' >
            <button class="btn btn-danger delete" type="button"><i class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
            <button class="btn btn-success addmore" type="button"><i class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

          </div>

           <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  ' >
          <div id="result"></div>

          </div>
          <br>
        
        </div>


        <div class="row">
          
          <div class="col-lg-8 col-12  "><h5>Notes: </h5>
         
          
                  <textarea class="form-control" rows='5' name="remarks" id="notes" placeholder="Your Notes"></textarea> 
                  
           
         

           <div class="mt-2"><button type="submit" class="btn btn-success w-lg float-right">Save</button>
            <a href="{{URL('/Invoice')}}" class="btn btn-secondary w-lg float-right">Cancel</a>

       </div>


        </div>


          <div class="col-lg-4 col-12 ">   <form class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" class="form-control" id="subTotal" name="subTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" class="form-control" id="tax"   placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="hidden" class="form-control" id="taxAmount" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
            </div>
          </div>
          <div class="form-group">
            
            <label><h5>Total: &nbsp;</h5></label>
            <div class="input-group">
<span class="input-group-text bg-light">AED</span>              
              <input type="number" name="Total" class="form-control" step="0.01" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
            </div>
          </div>
          
          <div class="form-group mt-1">
            <label><h5>Amount Paid: &nbsp;</h5></label>
            <div class="input-group">
<span class="input-group-text bg-light">AED</span>              
              <input type="number" class="form-control" id="amountPaid"  name="amountPaid" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
            </div>
          </div>
          
          <div class="form-group mt-1">
            
            <label><H5>Amount Due: &nbsp;</H5></label>
            <div class="input-group">
<span class="input-group-text bg-light">AED</span>              
              <input type="number" class="form-control amountDue" name="amountDue"  id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
            </div>
          </div>
   
      </div></div> <div >


      
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
 
      
  
        
       
      </form>
 


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
  html = '<tr class="bg-light borde-1 border-light ">';
  html += '<td class="p-1"><input class="case" type="checkbox"/></td>';
  html += '<td><select name="ItemID0[]" id="ItemID0_'+i+'" class="form-select changesNoo"> @foreach ($items as $key => $value) <option value="{{$value->ItemID}}|{{$value->Percentage}}">{{$value->ItemCode}}-{{$value->ItemName}}-{{$value->Percentage}}</option>@endforeach</select><input type="hidden" name="ItemID[]" id="ItemID_'+i+'"></td>';



  // html += '<td><select name="ItemID[]" id="ItemID_'+i+'" class="form-select changesNoo"><option value="">Select Item</option><option value="">b</option></select></td>';
  html += '<td><select name="SupplierID[]" id="SupplierID_'+i+'"  onchange="ajax_balance(this.value);" class="js-example-basic-single form-select">@foreach ($supplier as $key => $value) <option value="{{$value->SupplierID}}">{{$value->SupplierName}}</option>@endforeach</select></td>';
  html += '<td><input type="text" name="RefNo[]" id="RefNo_'+i+'" class="form-control  " ></td>';
  html += '<td><input type="text" name="VisaType[]" id="VisaType_'+i+'" class="form-control " ></td>';
  html += '<td><input type="text" name="PaxName[]" id="PaxName_'+i+'" class="form-control " ></td>';
  html += '<td><input type="text" name="PNR[]" id="PNR_'+i+'" class="form-control " ></td>';
  html += '<td><input type="text" name="Sector[]" id="Sector_'+i+'" class="form-control " ></td>';
  html += '<td><input type="text" name="Fare[]" id="Fare_'+i+'" class="form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="Taxable[]" id="Taxable_'+i+'" class="form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="Service[]" id="Service_'+i+'" class="form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="OPVAT[]" id="OPVAT_'+i+'" class="form-control  changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="IPVAT[]" id="IPVAT_'+i+'" class="form-control  changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="TaxAmount[]" id="quantity_'+i+'" class="form-control  " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="Discount[]" id="discount_'+i+'" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
  html += '<td><input type="text" name="ItemTotal[]" id="total_'+i+'" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
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

//autocomplete script
$(document).on('focus','.autocomplete_txt',function(){
  type = $(this).data('type');
  
  if(type =='productCode' )autoTypeNo=0;
  if(type =='productName' )autoTypeNo=1;  
  
  $(this).autocomplete({
    source: function( request, response ) {  
       var array = $.map(prices, function (item) {
                 var code = item.split("|");
                 return {
                     label: code[autoTypeNo],
                     value: code[autoTypeNo],
                     data : item
                 }
             });
             //call the filter here
             response($.ui.autocomplete.filter(array, request.term));
    },
    autoFocus: true,          
    minLength: 2,
    select: function( event, ui ) {
      var names = ui.item.data.split("|");            
      id_arr = $(this).attr('id');
        id = id_arr.split("_");
      $('#itemNo_'+id[1]).val(names[0]);
      $('#itemName_'+id[1]).val(names[1]);
      $('#quantity_'+id[1]).val(1);
      $('#price_'+id[1]).val(names[2]);
      $('#total_'+id[1]).val( 1*names[2] );
      calculateTotal();
    }           
  });
});

//price change
$(document).on('change keyup blur','.changesNo',function(){

 
 

  id_arr = $(this).attr('id');
  id = id_arr.split("_");
  quantity = $('#quantity_'+id[1]).val();
  price = $('#price_'+id[1]).val();
  

  Fare = $('#Fare_'+id[1]).val();

  Taxable = $('#Taxable_'+id[1]).val();

  Service = $('#Service_'+id[1]).val();

  OPVAT = $('#OPVAT_'+id[1]).val();

  IPVAT = $('#IPVAT_'+id[1]).val();
  
  Discount = $('#discount_'+id[1]).val();

  total = $('#total_'+id[1]).val();

Tax = $('#quantity_'+id[1]).val();

 
   

  if($('#Fare_'+id[1]).val() == "")
  {
      Fare=0;
  }
   
    if($('#discount_'+id[1]).val() == "")
  {
      Discount=0;
  }

  // if($('#Taxable_'+id[1]).val() == "")
  // {
  //     Taxable=0;
  //     TaxResult =0;
  // }
  // else
  // {
  //    TaxResult = ( (parseFloat(Taxable)*parseFloat(Service))/100  ).toFixed(2);

  // }
   

  // if($('#Service_'+id[1]).val() == "")
  // {
  //     Service=0;
  // }

  if($('#OPVAT_'+id[1]).val() == "")
  {
      OPVAT=0;
  }

  if($('#IPVAT_'+id[1]).val() == "")
  {
      IPVAT=0;
  }
   

 

  if( Fare!='' && Service !='' ) 
   $('#total_'+id[1]).val( ( parseFloat(Fare)+parseFloat(Service)+parseFloat(OPVAT)+parseFloat(IPVAT)+parseFloat(Tax) -parseFloat(Discount)  ).toFixed(2) );  
  // +parseFloat(TaxResult)
  calculateTotal();
});

//////////

$(document).on(' blur','.totalLinePrice',function(){

 

  id_arr = $(this).attr('id');
  id = id_arr.split("_");

 
Fare = $('#Fare_'+id[1]).val();

  total = $('#total_'+id[1]).val();


  Tax = $('#Taxable_'+id[1]).val();





 
Profit = ( parseFloat(total)-parseFloat(Fare)).toFixed(2);

   

   if($('#Taxable_'+id[1]).val() == "")
  {
      Tax=0;
  }
$('#Service_'+id[1]).val( parseFloat(Profit) - ( parseFloat(Profit/100)*parseFloat(Tax)).toFixed(2) );

   $('#quantity_'+id[1]).val( ( parseFloat(Profit/100)*parseFloat(Tax)).toFixed(2) );
   // Profit = (parseFloat(total)-parseFloat(Fare)).toFixed(2) ;

    // Tax = ;

   // Service = (parseFloat(Proft)-parseFloat(Tax)).toFixed(2) ;

   // alert(Profit+Tax+Service);

// $('#quantity'+id[1]).val( Tax );
// $('#Service_'+id[1]).val( Service );


 
});

$(document).on('change','.changesNoo',function(){

 

  id_arr = $(this).attr('id');
  id = id_arr.split("_");

val = $('#ItemID0_'+id[1]).val().split("|");


// alert($('#ItemID0_'+id[1]).val());
$('#Taxable_'+id[1]).val( val[1]  );
$('#ItemID_'+id[1]).val( val[0]  );
  
 

 
});

////////////////////////////////////////////


$(document).on('change keyup blur','#tax',function(){
  calculateTotal();
});

//total price calculation 
function calculateTotal(){
  subTotal = 0 ; total = 0; 
  $('.totalLinePrice').each(function(){
    if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
  });
  $('#subTotal').val( subTotal.toFixed(2) );
  tax = $('#tax').val();
  if(tax != '' && typeof(tax) != "undefined" ){
    taxAmount = subTotal * ( parseFloat(tax) /100 );
    $('#taxAmount').val(taxAmount.toFixed(2));
    total = subTotal + taxAmount;
  }else{
    $('#taxAmount').val(0);
    total = subTotal;
  }
  $('#totalAftertax').val( total.toFixed(2) );
  calculateAmountDue();
}

$(document).on('change keyup blur','#amountPaid',function(){
  calculateAmountDue();
});

//due amount calculation
function calculateAmountDue(){
  amountPaid = $('#amountPaid').val();
  total = $('#totalAftertax').val();
  if(amountPaid != '' && typeof(amountPaid) != "undefined" ){
    amountDue = parseFloat(total) - parseFloat( amountPaid );
    $('.amountDue').val( amountDue.toFixed(2) );
  }else{
    total = parseFloat(total).toFixed(2);
    $('.amountDue').val( total);
  }
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

 

<!-- ajax trigger -->
 <script>
 

 
   
   function ajax_balance(SupplierID) {
      
       // alert($("#csrf").val());
 
$('#result').prepend('')
$('#result').prepend('<img id="theImg" src="{{asset('assets/images/ajax.gif')}}" />')
 
       var SupplierID = SupplierID;

       // alert(SupplierID);
       if(SupplierID!=""  ){
        /*  $("#butsave").attr("disabled", "disabled"); */
        // alert(SupplierID);
          $.ajax({
              url: "{{URL('/Ajax_Balance')}}",
              type: "POST",
              data: {
                  _token: $("#csrf").val(),
                   SupplierID: SupplierID,
                 
              },
              cache: false,
              success: function(data){
            

              
                    $('#result').html(data);
           
                 
                  
              }
          });
      }
      else{
          alert('Please Select Branch');
      }

      
      

  }
 
</script>




  </body>

   <!-- JAVASCRIPT -->
        <script src="{{URL('/')}}/assets/libs/jquery/jquery.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/node-waves/waves.min.js"></script>

        <!-- apexcharts -->
        <script src="{{URL('/')}}/assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- dashboard init -->
        <script src="{{URL('/')}}/assets/js/pages/dashboard.init.js"></script>

        <!-- form mask init -->
        <script src="{{URL('/')}}/assets/js/pages/form-mask.init.js"></script>


        <!-- App js -->
        <script src="{{URL('/')}}/assets/js/app.js"></script>

        

        <!-- form mask -->
        <script src="{{URL('/')}}/assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"></script>

        <!-- form mask init -->
 
 
        <!-- Required datatable js -->
        <script src="{{URL('/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/jszip/jszip.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="{{URL('/')}}/assets/js/pages/datatables.init.js"></script> 

        <!-- apexcharts -->
        <script src="{{URL('/')}}/assets/libs/apexcharts/apexcharts.min.js"></script>

        <script src="{{URL('/')}}/assets/js/pages/profile.init.js"></script>
        <script src="{{URL('/')}}/assets/libs/select2/js/select2.min.js"></script>
 
         <!-- init js -->
        <script src="{{URL('/')}}/assets/js/pages/ecommerce-select2.init.js"></script>

        <!-- Sweet Alerts js -->
        <script src="{{URL('/')}}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <script src="{{URL('/')}}/assets/js/pages/sweet-alerts.init.js"></script>

        <!-- form repeater js -->
        <script src="{{URL('/')}}/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

        <script src="{{URL('/')}}/assets/js/pages/form-repeater.int.js"></script>


                <script src="{{URL('/')}}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
         <script src="{{URL('/')}}/assets/libs/%40chenfengyuan/datepicker/datepicker.min.js"></script>

<script src="{{URL('/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="{{URL('/')}}/assets/js/pages/datatables.init.js"></script>

        
               <!-- Required datatable js -->
        <script src="{{URL('/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{URL('/')}}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <!-- toastr plugin -->
        <script src="{{URL('/')}}/assets/libs/toastr/build/toastr.min.js"></script>

        <!-- toastr init -->
        <script src="{{URL('/')}}/assets/js/pages/toastr.init.js"></script>

 </html>




