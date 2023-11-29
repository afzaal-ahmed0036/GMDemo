@extends('tmp')
@section('title', $pagetitle)

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <script src="{{asset('assets/invoice/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/invoice/js/bootstrap-datepicker.js')}}"></script> -->
<!-- <script src="js/ajax.js"></script> -->
<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Credit Notes</h4>




          </div>
        </div>
      </div>
      <!-- enctype="multipart/form-data" -->
      <form action="{{URL('/SaleInvoiceSave')}}" enctype="multipart/form-data" method="post">


        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">


        <div class="card shadow-sm">
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Customer</label>
                  </div>
                  <div class="col-sm-9">
                    <select name="PartyID" id="PartyID" class="form-select select2 mt-5" name="PartyID" required="">
                      <?php foreach ($party as $key => $value) : ?>
                        <option value="{{$value->PartyID}}">{{$value->PartyName}}</option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Salesperson </label>
                  </div>
                  <div class="col-sm-9">
                    <select name="UserID" id="UserID" class="form-select">
                      <option value="">Select</option>
                      <?php foreach ($user as $key => $value) : ?>
                        <option value="{{$value->UserID}}">{{$value->FullName}}</option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Subject </label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="first-name" class="form-control" name="Subject" value="" placeholder="Let your customer know what this invoice is for">

                  </div>
                </div>
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Upload File </label>
                  </div>
                  <div class="col-sm-9">
                  <input type="file" class="form-control-file" name="file[]" id="file" multiple="">

                   

                  </div>
                </div>


              </div>
              <div class="col-md-6">
                <div class="col-12">
                  <div class="mb-1 row">
                    <div class="col-sm-3">
                      <label class="col-form-label text-danger" for="first-name">Invoice #</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="first-name" class="form-control" name="InvoiceNo" value="INV-{{$vhno[0]->VHNO}}">
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
                        <input type="text" name="Date" autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker21" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
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
                        <input type="text" name="DueDate" autocomplete="off" class="form-control" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" data-date-container="#datepicker22" data-provide="datepicker" data-date-autoclose="true" value="{{date('Y-m-d')}}">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1 row">
                    <div class="col-sm-3">
                      <label class="col-form-label" for="password">Reference No </label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" name="ReferenceNo" autocomplete="off" class="form-control">

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
                <table>
                  <thead>
                    <tr class="bg-light borde-1 border-light " style="height: 40px;">
                      <th width="2%" class="p-1"><input id="check_all" type="checkbox" /></th>
                      <th width="15%">ITEM DETAILS </th>

                      <th width="15%">QUANTITY</th>
                      <th width="15%">RATE</th>
                      <th width="15%">Tax</th>
                      <th width="10%">AMOUNT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="p-3">
                      <td class="p-1 bg-light borde-1 border-light"><input class="case" type="checkbox" /></td>
                      <td>

                        <!-- <select name="ItemID0[]" id="ItemID0_1" class="item form-select form-control-sm   changesNoo ">
                          <option value="">select</option>
                          @foreach ($items as $key => $value)
                          <option value="{{$value->ItemID}}">{{$value->ItemName}}</option>
                          @endforeach
                        </select> -->

                        <input name="ItemID0[]" data-type="productCode" id="ItemID0_1" placeholder="Please type product code and select..." class="item form-control tags autocomplete_txt " />







                        <input type="hidden" name="ItemID[]" id="ItemID2_1" class="autocomplete_txt">
                      </td>


                      <td>
                        <input type="number" name="Qty[]" id="Qty_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="1">
                      </td>

                      <td>
                        <input type="number" name="Price[]" id="Price_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                      </td>

                      <!-- Tax -->

                      <td>
                        <select name="Tax[]" id="TaxID_1" class="form-control changesNo tax" required="">
                          <?php foreach ($tax as $key => $valueX1) : ?>
                            <option value="{{$valueX1->taxValue}}">{{$valueX1->taxName}}</option>
                          <?php endforeach ?>
                        </select>
                      </td>
                      <td>
                        <input type="number" name="ItemTotal[]" id="ItemTotal_1" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row mt-1 mb-2" style="margin-left: 29px;">
              <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                <button class="btn btn-danger delete" type="button"><i class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                <button class="btn btn-success addmore" type="button"><i class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

              </div>

              <div class='col-xs-5 col-sm-3 col-md-3 col-lg-3  '>
                <div id="result"></div>

              </div>
              <br>

            </div>


            <div class="row mt-4">

              <div class="col-lg-8 col-12  ">
                <h6>Customer Notes: </h6>


                <textarea class="form-control" rows='5' name="CustomerNotes" id="note" placeholder="">Thanks for your business.</textarea>




                <div class="mt-2"><button type="submit" class="btn btn-success w-md float-right">Save</button>
                  <a href="{{URL('/CreditNote')}}" class="btn btn-secondary w-md float-right">Cancel</a>

                </div>


              </div>
              <div class="col-lg-4 col-12 ">
                <form class="form-inline">

                  <div class="form-group mt-1">

                    <label>Shipping: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">PKR</span>
                      <input type="number" name="Shipping" class="form-control" step="0.01" id="shipping" value="0" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                    </div>
                  </div>

                  <div class="form-group mt-1">
                    <label>Sub Total: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">PKR</span>

                      <input type="text" class="form-control" id="subTotal" name="SubTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                    </div>
                  </div>
                  <div class="form-group mt-1">
                    <label>Discount: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">%</span>

                      <input type="text" class="form-control" id="discountper" name="DiscountPer" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">

                      <span class="input-group-text bg-light">PKR</span>

                      <input type="text" name="DiscountAmount" class="form-control" id="discountAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                    </div>
                  </div>

                  <div class="form-group mt-1 d-none">

                    <label>Total: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">PKR</span>
                      <input type="number" name="Total" class="form-control" step="0.01" id="totalafterdisc" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                    </div>
                  </div>

                  <div class="form-group mt-1">
                    <label>Tax: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">%</span>

                      <input type="text" class="form-control" id="taxpercentage" name="Taxpercentage" placeholder="tax %" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">

                      <span class="input-group-text bg-light">PKR</span>

                      <input type="text" name="TaxpercentageAmount" class="form-control" id="taxpercentageAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                    </div>
                  </div>

                  <div class="form-group mt-1">

                    <label>Grand Total: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">PKR</span>
                      <input type="number" name="Grandtotal" class="form-control" step="0.01" id="grandtotal" placeholder="Grand Total" readonly onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                    </div>
                  </div>


                  <div class="form-group mt-1">
                    <label>Amount Paid: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">PKR</span>
                      <input type="number" class="form-control" id="amountPaid" name="amountPaid" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0">
                    </div>
                  </div>

                  <div class="form-group mt-1">

                    <label>Amount Due: &nbsp;</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light">PKR</span>
                      <input type="number" class="form-control amountDue" name="amountDue" id="amountDue" placeholder="Amount Due" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                    </div>
                  </div>

              </div>


            </div>
            <div>



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


  </div>
</div>
</div>


<script type="text/javascript">
  /**
   * Site : http:www.smarttutorials.net
   * @author muni
   */
  var grandTax=0;
  var overalltax=0;
  //adds extra table rows
  var i = $('table tr').length;
  $(".addmore").on('click', function() {
    html = '<tr class="bg-light borde-1 border-light ">';
    html += '<td class="p-1"><input class="case" type="checkbox"/></td>';
    html += '<td> <input name="ItemID0[]" id="ItemID_' + i + '" placeholder="Please type product code and select..." data-type="productCode" class="item form-control tags changesNoo autocomplete_txt" /><input type="hidden" name="ItemID[]" id="ItemID2_' + i + '"></td>';



    // html += '<td><select name="ItemID[]" id="ItemID_'+i+'" class="form-select changesNoo"><option value="">Select Item</option><option value="">b</option></select></td>';
    html += '<td><input type="text" name="Qty[]" id="Qty_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';

    html += '<td><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
    
    html += '<td><select name="Tax[]" id="TaxID_'+ i +'" class="form-control changesNo "><option value="0">No Tax</option><option value="5">Fbr</option><option value="10">GST</option></select></td>';

    

    html += '<td><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
    
    
    html += '</tr>';
    $('table').append(html);


    i++;



    // var data=<?php echo $item; ?>
    // // var data=JSON.parse({{$item}});

    // let country = data.find(value => value.ItemCode === "AP");
    // // => {name: "Albania", code: "AL"}
    // console.log(country);
    // console.log(country["ItemCode"]);

  });





  //to check all checkboxes
  $(document).on('change', '#check_all', function() {
    $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
  });

  //   var data = <?php echo $item; ?>;
  //   // console.log(data);


  //   // console.log( "readaay!" );


  //   var data = <?php echo $item; ?> // this is dynamic data in json_encode(); from controller





  //deletes the selected table rows
  $(".delete").on('click', function() {
    $('.case:checkbox:checked').parents("tr").remove();
    $('#check_all').prop("checked", false);
    calculateTotal();
  });


  var prices = ["S10_1678|1969 Harley Davidson Ultimate Chopper|48.81", "S10_1949|1952 Alpine Renault 1300|98.58", "S10_2016|1996 Moto Guzzi 1100i|68.99", "S10_4698|2003 Harley-Davidson Eagle Drag Bike|91.02", "S10_4757|1972 Alfa Romeo GTA|85.68", "S10_4962|1962 LanciaA Delta 16V|103.42", "S12_1099|1968 Ford Mustang|95.34", "S12_1108|2001 Ferrari Enzo|95.59", "S12_1666|1958 Setra Bus|77.9", "S12_2823|2002 Suzuki XREO|66.27", "S12_3148|1969 Corvair Monza|89.14", "S12_3380|1968 Dodge Charger|75.16", "S12_3891|1969 Ford Falcon|83.05", "S12_3990|1970 Plymouth Hemi Cuda|31.92", "S12_4473|1957 Chevy Pickup|55.7", "S12_4675|1969 Dodge Charger|58.73", "S18_1097|1940 Ford Pickup Truck|58.33", "S18_1129|1993 Mazda RX-7|83.51", "S18_1342|1937 Lincoln Berline|60.62", "S18_1367|1936 Mercedes-Benz 500K Special Roadster|24.26", "S18_1589|1965 Aston Martin DB5|65.96", "S18_1662|1980s Black Hawk Helicopter|77.27", "S18_1749|1917 Grand Touring Sedan|86.7", "S18_1889|1948 Porsche 356-A Roadster|53.9", "S18_1984|1995 Honda Civic|93.89", "S18_2238|1998 Chrysler Plymouth Prowler|101.51", "S18_2248|1911 Ford Town Car|33.3", "S18_2319|1964 Mercedes Tour Bus|74.86", "S18_2325|1932 Model A Ford J-Coupe|58.48", "S18_2432|1926 Ford Fire Engine|24.92", "S18_2581|P-51-D Mustang|49", "S18_2625|1936 Harley Davidson El Knucklehead|24.23", "S18_2795|1928 Mercedes-Benz SSK|72.56", "S18_2870|1999 Indy 500 Monte Carlo SS|56.76", "S18_2949|1913 Ford Model T Speedster|60.78", "S18_2957|1934 Ford V8 Coupe|34.35", "S18_3029|1999 Yamaha Speed Boat|51.61", "S18_3136|18th Century Vintage Horse Carriage|60.74", "S18_3140|1903 Ford Model A|68.3", "S18_3232|1992 Ferrari 360 Spider red|77.9", "S18_3233|1985 Toyota Supra|57.01", "S18_3259|Collectable Wooden Train|67.56", "S18_3278|1969 Dodge Super Bee|49.05", "S18_3320|1917 Maxwell Touring Car|57.54", "S18_3482|1976 Ford Gran Torino|73.49", "S18_3685|1948 Porsche Type 356 Roadster|62.16", "S18_3782|1957 Vespa GS150|32.95", "S18_3856|1941 Chevrolet Special Deluxe Cabriolet|64.58", "S18_4027|1970 Triumph Spitfire|91.92", "S18_4409|1932 Alfa Romeo 8C2300 Spider Sport|43.26", "S18_4522|1904 Buick Runabout|52.66", "S18_4600|1940s Ford truck|84.76", "S18_4668|1939 Cadillac Limousine|23.14", "S18_4721|1957 Corvette Convertible|69.93", "S18_4933|1957 Ford Thunderbird|34.21", "S24_1046|1970 Chevy Chevelle SS 454|49.24", "S24_1444|1970 Dodge Coronet|32.37", "S24_1578|1997 BMW R 1100 S|60.86", "S24_1628|1966 Shelby Cobra 427 S\/C|29.18", "S24_1785|1928 British Royal Navy Airplane|66.74", "S24_1937|1939 Chevrolet Deluxe Coupe|22.57", "S24_2000|1960 BSA Gold Star DBD34|37.32", "S24_2011|18th century schooner|82.34", "S24_2022|1938 Cadillac V-16 Presidential Limousine|20.61", "S24_2300|1962 Volkswagen Microbus|61.34", "S24_2360|1982 Ducati 900 Monster|47.1", "S24_2766|1949 Jaguar XK 120|47.25", "S24_2840|1958 Chevy Corvette Limited Edition|15.91", "S24_2841|1900s Vintage Bi-Plane|34.25", "S24_2887|1952 Citroen-15CV|72.82", "S24_2972|1982 Lamborghini Diablo|16.24", "S24_3151|1912 Ford Model T Delivery Wagon|46.91", "S24_3191|1969 Chevrolet Camaro Z28|50.51", "S24_3371|1971 Alpine Renault 1600s|38.58", "S24_3420|1937 Horch 930V Limousine|26.3", "S24_3432|2002 Chevy Corvette|62.11", "S24_3816|1940 Ford Delivery Sedan|48.64", "S24_3856|1956 Porsche 356A Coupe|98.3", "S24_3949|Corsair F4U ( Bird Cage)|29.34", "S24_3969|1936 Mercedes Benz 500k Roadster|21.75", "S24_4048|1992 Porsche Cayenne Turbo Silver|69.78", "S24_4258|1936 Chrysler Airflow|57.46", "S24_4278|1900s Vintage Tri-Plane|36.23", "S24_4620|1961 Chevrolet Impala|32.33"];




  //autocomplete script
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $(document).on('focus', '.autocomplete_txt', function() {

    type = $(this).data('type');

    if (type == 'productCode') autoTypeNo = 0;
    if (type == 'productName') autoTypeNo = 1;

    $(this).autocomplete({
      source: function(request, response) {
        // Fetch data
        $.ajax({
          url: "{{route('Autocomplte.getAutocomplte')}}",
          type: 'post',
          dataType: "json",
          data: {
            _token: CSRF_TOKEN,
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        });

      },

      select: function(event, ui) {
        // var names = ui.item.data.split("|");
        // alert(names);
        id_arr = $(this).attr('id');
        id = id_arr.split("_");
        // alert(id_arr);
        $('#Qty_' + id[1]).val(1);

        $('#ItemID0_' + id[1]).val(ui.item.label);


        $('#Price_' + id[1]).val(ui.item.label2);
        $('#ItemID2_' + id[1]).val(ui.item.label3);
        $('#ItemTotal_' + id[1]).val(1 * ui.item.label2);

        calculateTotal();
      }
    });
  });

 





  //price change
  $(document).on('change keyup blur', '.changesNo', function() {

    id_arr = $(this).attr('id');
    id = id_arr.split("_");

    Qty = $('#Qty_' + id[1]).val();
    
    TaxPer = $('#TaxID_' + id[1]).val();
    console.log(TaxPer);
     
    grandTax = parseFloat(TaxPer) + parseFloat(grandTax);

    // console.log(grandTax);
    
    // alert(Tax);

    Price = $('#Price_' + id[1]).val();

    TotalPrice = parseFloat(Qty) * parseFloat(Price);

    TotalTaxPer = (parseFloat(TaxPer) / 100) * parseFloat(TotalPrice);
    
    overalltax= (parseFloat(TotalTaxPer)) +  (parseFloat(overalltax));

    console.log(overalltax);


    ItemTotal = parseFloat(TotalPrice) + parseFloat(TotalTaxPer);

    // console.log('tax grand value'+grandTax );

    $('#ItemTotal_' + id[1]).val(ItemTotal);





    console.log('new line');
    // console.log('qty=');

    // console.log(Qty);

    // console.log('price');


    // console.log(Price);


    // console.log('---');



    // console.log('----total price');
    // console.log(TotalPrice);

    // console.log('total price');
    // console.log(TotalPrice);

    // console.log('grand item total');
    // console.log(ItemTotal);


    calculateTotal();
  });


  //////////

  $(document).on(' blur', '.totalLinePrice', function() {



    id_arr = $(this).attr('id');
    id = id_arr.split("_");


    Fare = $('#Fare_' + id[1]).val();

    total = $('#total_' + id[1]).val();


    Tax = $('#Taxable_' + id[1]).val();






    Profit = (parseFloat(total) - parseFloat(Fare)).toFixed(2);



    if ($('#Taxable_' + id[1]).val() == "") {
      Tax = 0;
    }
    $('#Service_' + id[1]).val(parseFloat(Profit) - (parseFloat(Profit / 100) * parseFloat(Tax)).toFixed(2));

    $('#quantity_' + id[1]).val((parseFloat(Profit / 100) * parseFloat(Ta0x)).toFixed(2));
    // Profit = (parseFloat(total)-parseFloat(Fare)).toFixed(2) ;

    // Tax = ;

    // Service = (parseFloat(Proft)-parseFloat(Tax)).toFixed(2) ;

    // alert(Profit+Tax+Service);

    // $('#quantity'+id[1]).val( Tax );
    // $('#Service_'+id[1]).val( Service );



  });

  $(document).on('change', '.changesNoo', function() {



    id_arr = $(this).attr('id');
    id = id_arr.split("_");

    val = $('#ItemID0_' + id[1]).val().split("|");


    // alert($('#ItemID0_'+id[1]).val());
    $('#Taxable_' + id[1]).val(val[1]);
    $('#ItemID_' + id[1]).val(val[0]);




  });
  // shipping charges






  ////////////////////////////////////////////
  $(document).on('change keyup blur onmouseover onclick', '#discountper', function() {
    subTotal = 0;
    $('.totalLinePrice').each(function() {
      if ($(this).val() != '') subTotal += parseFloat($(this).val());
    });
    subTotal = parseFloat($('#subTotal').val());
    

    discountper = $('#discountper').val();
    // totalafterdisc = $('#totalAftertax').val();
    // console.log('testing'.totalAftertax);
    if (discountper != '' && typeof(discountper) != "undefined") {
      discountamount = parseFloat(subTotal) * (parseFloat(discountper) / 100);

      $('#discountAmount').val(parseFloat(discountamount.toFixed(2)));
      total = subTotal - discountamount;
      $('#totalafterdisc').val(total.toFixed(2));
      // $('#grandtotal').val(total.toFixed(2));

    } else {
      $('#discountper').val(0);
      total = subTotal;
      $('#totalafterdisc').val(total.toFixed(2));

    }



    calculateTotal();

  });
  $(document).on('change keyup blur onmouseover onclick', '#taxpercentage', function() {
    calculateTotal();
  });
  $(document).on('change keyup blur onmouseover onclick', '#shipping', function() {

    calculateTotal();
  });

  function calculateTotal() {

    var shippping = 0;
    grand_tax = 0;
    subTotal = 0;
    total = 0;
    total2 = 0;
    sumtax = 0;
    gt = 0;
    var pretotal = 0;
    $('.totalLinePrice').each(function() {
      if ($(this).val() != '') subTotal += parseFloat($(this).val());
    });


    $('#subTotal').val(subTotal.toFixed(2));
    pretotal = $('#totalafterdisc').val();
    discountAmount = $('#discountAmount').val();
    tax = $('#tax').val();
    grand_tax = $('#taxpercentage').val();

    if (grand_tax != '' && typeof(grand_tax) != "undefined") {
      gt = subTotal * (parseFloat(grand_tax) / 100);

      $('#taxpercentageAmount').val(gt.toFixed(2));
      total2 = subTotal + gt - discountAmount;
    } else {
      $('#taxpercentage').val(0);
      total2 = subTotal - pretotal;
    }

    shippping = $('#shipping').val();
    total2 = parseFloat(total2) + parseFloat(shippping);
    // alert(total3);
    $('#grandtotal').val(total2.toFixed(2));

    calculateAmountDue();
  }



  $(document).on('change keyup blur', '#amountPaid', function() {
    calculateAmountDue();
  });

  //due amount calculation
  function calculateAmountDue() {
    amountPaid = $('#amountPaid').val();
    total = $('#grandtotal').val();
    if (amountPaid != '' && typeof(amountPaid) != "undefined") {
      amountDue = parseFloat(total) - parseFloat(amountPaid);
      $('.amountDue').val(amountDue.toFixed(2));
    } else {
      total = parseFloat(total).toFixed(2);
      $('.amountDue').val(total);
    }
  }


  //It restrict the non-numbers
  var specialKeys = new Array();
  specialKeys.push(8, 46); //Backspace
  function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log(keyCode);
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
  }

  //datepicker
  $(function() {
    $.fn.datepicker.defaults.format = "dd-mm-yyyy";
    $('#invoiceDate').datepicker({
      startDate: '-3d',
      autoclose: true,
      clearBtn: true,
      todayHighlight: true
    });
  });
</script>

<!-- <script src="{{asset('assets/js/jquery-3.6.0.js')}}" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->



<!-- ajax trigger -->
<script>
  $("#usama").change(function() {
    var searchdata = $('#usama').val();
    // alert(searchdata);
    $.ajax({
      url: "{{URL('/getAutocomplte')}}",
      type: "POST",
      data: {
        _token: $("#csrf").val(),
        searchdata: searchdata,

      },
      cache: false,
      success: function(data) {

        // $('#vhno_div').html(data);
        console.log(data);


        // var sub_array = [];
        // for (let i = 0; i < res.count; i++) {


        //     sub_array.push(res.data[i].ItemName,"|", res.data[i].ItemID, res.data[i].ItemName,"|", res.data[i].SellingPrice,); 


        // }

        // console.log(sub_array);
























      }
    });


  });
 
</script>

<!-- <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script> -->

<!-- END: Content-->

@endsection