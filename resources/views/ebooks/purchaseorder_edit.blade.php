@extends('template.tmp')
@section('title', 'Purchase Order')

@section('content')

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <!-- start page title -->

      <!-- enctype="multipart/form-data" -->
      <form action="{{URL('/PurchaseOrderUpdate')}}" method="post">


        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
        <input type="hidden" name="PurchaseOrderMasterID" value="{{$purchaseorder_master[0]->PurchaseOrderMasterID}}">

        <div class="card shadow-sm">
          <div class="card-body">

            <div class="row">
              <div class="col-md-6">
                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Supplier </label>
                  </div>
                  <div class="col-sm-9">
                    <select name="SupplierID" id="SupplierID" class="form-select select2 mt-5" name="SupplierID" required="">
                      <?php foreach ($supplier as $key => $value) : ?>
                        <option value="{{$value->SupplierID}}" {{($value->SupplierID== $purchaseorder_master[0]->SupplierID) ? 'selected=selected':'' }}>{{$value->SupplierName}}</option>
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
                        <option value="{{$value->UserID}}" {{($value->UserID== $purchaseorder_master[0]->UserID) ? 'selected=selected':'' }}>{{$value->FullName}}</option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="mb-1 row">
                  <div class="col-sm-3">
                    <label class="col-form-label" for="password">Subject </label>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" id="first-name" class="form-control" name="Subject" value="{{ $purchaseorder_master[0]->Subject }}" placeholder="Let your customer know what this invoice is for">

                  </div>
                </div>


              </div>
              <div class="col-md-6">
                <div class="col-12">
                  <div class="mb-1 row">
                    <div class="col-sm-3">
                      <label class="col-form-label text-danger" for="first-name">P Order #</label>
                    </div>
                    <div class="col-sm-9">
                      <input type="text" id="first-name" class="form-control" name="PurchaseOrderNo" value="{{ $purchaseorder_master[0]->PON}}">
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
                      <th width="1%">Item</th>
                      <th width="15%">Description</th>
                      <th width="5%">Quantity</th>
                      <th width="4%">RATE</th>
                      <th width="4%">Tax</th>
                      <th width="4%">Tax Val</th>

                      <th width="4%">AMOUNT</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($purchaseorder_detail as $key => $value1)
                    <?php $no = $key + 1; ?>
                    <tr class="p-3">
                      <td class="p-1"><input class="case" type="checkbox" /></td>
                      <td>

                        <select name="ItemID0[]" id="ItemID0_{{$no}}" class="item form-select form-control-sm   changesNoo select2" onchange="km(this.value,1);" style="width: 300px !important;">
                          <option value="">select</option>
                          @foreach ($items as $key => $value)
                          <option value="{{$value->ItemID}}" {{($value->ItemID== $value1->ItemID) ? 'selected=selected':'' }}>{{$value->ItemName}}</option>
                          @endforeach
                        </select>
                        <input type="hidden" name="ItemID[]" id="ItemID_{{$no}}" value="{{$value1->ItemID}}">
                      </td>
                      <td><input type="text" name="Description[]" id="Description_{{$no}}" class=" form-control " value="{{$value1->Description}}"></td>


                      <td>
                        <input type="number" name="Qty[]" id="Qty_{{$no}}" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Qty}}">
                      </td>

                      <td>
                        <input type="number" name="Price[]" id="Price_{{$no}}" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Rate}}">
                      </td>


                      <td>
                        <select name="Tax[]" id="TaxID_{{$no}}" class="form-control changesNo tax exclusive_cal" required="">
                          <?php foreach ($tax as $key => $valueX1) : ?>
                            <option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option>
                          <?php endforeach ?>
                        </select>
                      </td>
                      <td>
                        <input type="number" name="TaxVal[]" value="{{$value1->Tax}}" id="TaxVal_{{$no}}" class=" form-control totalLinePrice2" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                      </td>





                      <td>
                        <input type="number" name="ItemTotal[]" id="ItemTotal_{{$no}}" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="{{$value1->Amount}}">
                      </td>
                    </tr>
                    @endforeach

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
                <h6>Purchase Note: </h6>


                <textarea class="form-control" rows='5' name="PONotes" id="note" placeholder="">{{ $purchaseorder_master[0]->PONotes }}</textarea>

                <br>
                <iframe src="{{URL('/Attachment')}}" width="100%" height="40%" border="0" scrolling="yes" style="overflow: hidden;"></iframe>


                <div class="mt-2"><button type="submit" class="btn btn-success w-md float-right">Save</button>
                  <a href="{{URL('/Bill')}}" class="btn btn-secondary w-md float-right">Cancel</a>

                </div>


              </div>






            </div>
          </div>
        </div>
@endsection

@push('after-scripts') 

        <script>
          /**
           * Site : http:www.smarttutorials.net
           * @author muni
           */

          //adds extra table rows
          var i = $('table tr').length;
          $(".addmore").on('click', function() {
            html = '<tr class="bg-light borde-1 border-light">';
            html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';
            html += '<td><select name="ItemID0[]" id="ItemID0_' + i + '"  style="width: 300px !important;" class="form-select select2 changesNoo" onchange="km(this.value,' + i + ');" > <option value="">select</option>}@foreach ($items as $key => $value) <option value="{{$value->ItemID}}|{{$value->Percentage}}">{{$value->ItemCode}}-{{$value->ItemName}}-{{$value->Percentage}}</option>@endforeach</select><input type="hidden" name="ItemID[]" id="ItemID_' + i + '"></td>';



            html += '  <td><input type="text" name="Description[]" id="Description_' + i + '" class=" form-control " ></td>';
            html += '<td><input type="text" name="Qty[]" id="Qty_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';

            html += '<td><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';

            html += '<td><select name="Tax[]" id="TaxID_' + i + '" class="form-control changesNo exclusive_cal"><?php foreach ($tax as $key => $valueX1) : ?><option value="{{$valueX1->TaxPer}}">{{$valueX1->Description}}</option><?php endforeach ?></select></td>';


            html += '<td><input type="number" name="TaxVal[]" id="TaxVal_' + i + '" class=" form-control totalLinePrice2 "autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01"></td>';




            html += '<td><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';

            html += '</tr>';
            $('table').append(html);
            $('.select2', 'table').select2();
            i++;


          });


          $(".delete").on('click', function() {
            $('.case:checkbox:checked').parents("tr").remove();
            $('#check_all').prop("checked", false);
            calculateTotal();
          });

          function km(v, id) {

            id_arr = 'ItemID0_' + id;
            id = id_arr.split("_");

            val = $('#ItemID0_' + id[1]).val().split("|");


            // alert($('#ItemID0_'+id[1]).val());
            $('#ItemID_' + id[1]).val(val[0]);



            // alert('val done');




            var data = <?php echo $items; ?>;
            // console.log(data);


            // console.log( "readaay!" );


            var data = <?php echo $items; ?> // this is dynamic data in json_encode(); from controller


            // console.log($('#ItemID_' + id[1]).val());


            var item_idd = $('#ItemID_' + id[1]).val();
            // console.log(item_idd);
            var index = -1;
            var val = parseInt(item_idd);
            var json = data.find(function(item, i) {
              if (item.ItemID === val) {
                index = i + 1;
                return i + 1;
              }
            });



            $('#Qty_' + id[1]).val(1);
            $('#Price_' + id[1]).val(json["SellingPrice"]);
            $('#TaxID_' + id[1]).val(json["Percentage"]);
            $('#TaxVal_' + id[1]).val(((parseFloat(json["Percentage"])) / 100) * (parseFloat(json["SellingPrice"])));


            $('#ItemTotal_' + id[1]).val(((parseFloat(json["SellingPrice"]) * parseFloat($('#Qty_' + id[1]).val())) + (((parseFloat(json["Percentage"])) / 100) * (parseFloat(json["SellingPrice"])))).toFixed(2));





            if (isNaN($('#discountAmount').val())) {
              $('#discountAmount').val(0);
            }


            calculateTotal();

          }
          //price change
          $(document).on('change keyup blur ', '.changesNo', function() {

            id_arr = $(this).attr('id');
            id = id_arr.split("_");

            Qty = $('#Qty_' + id[1]).val();

            TaxPer = $('#TaxID_' + id[1]).val();

            Price = $('#Price_' + id[1]).val();

            TotalPrice = parseFloat(Qty) * parseFloat(Price);

            TotalTaxPer = (parseFloat(TaxPer) / 100) * parseFloat(TotalPrice);


            ItemTotal = parseFloat(TotalPrice) + parseFloat(TotalTaxPer);



            $('#ItemTotal_' + id[1]).val(ItemTotal);
            $('#TaxVal_' + id[1]).val(parseFloat(TotalTaxPer));
            calculateTotal();
          });
          //total price calculation 
          function calculateTotal() {

            // grand_tax = 0;
            grand_tax = 0;
            subTotal = 0;
            total = 0;
            total2 = 0;
            sumtax = 0;
            gt = 0;
            grandtotaltax = 0;
            var pretotal = 0;


            $('.totalLinePrice2').each(function() {
              if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
            });

            $('#grandtotaltax').val(grandtotaltax.toFixed(2));
            console.log(grandtotaltax);
            discountper = $('#discountper').val();


          }
        </script>


        <!-- END: Content-->

        @endpush