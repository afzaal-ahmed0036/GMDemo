@extends('template.tmp')
@section('title', 'Create Invoice')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid" data-select2-id="15">
            <!-- start page title -->

            <!-- enctype="multipart/form-data" -->
            <form action="http://localhost:1337/app9/public/SaleInvoiceSave" method="post" data-select2-id="14">


                <input type="hidden" name="_token" id="csrf" value="yv9p55GpUuBVAKlDa4YDslW3dFTHFKVpuumHKm4z">


                <div class="card shadow-sm" data-select2-id="13">
                    <div class="card-body" data-select2-id="12">


                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table>
                                    <thead>
                                        <tr class=" borde-1 border-light " style="height: 40px;">
                                            <th width="1%" class="text-center"><input id="check_all" type="checkbox"></th>
                                            <th width="1%">ITEM DETAILS </th>

                                            <th width="1%">QUANTITY</th>
                                            <th width="2%">RATE</th>
                                            <th width="2%">DISCOUNT</th>
                                            <th width="2%">Value for Tax</th>
                                            <th width="2%">Tax</th>
                                            <th width="2%">Tax Val</th>

                                            <th width="4%">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="p-3">
                                            <td bordercolor="1" class="p-1    text-center"><input class="case" type="checkbox"></td>

                                            <td valign="top">

                                                <select name="ItemID0[]" id="ItemID0_1" class="item form-select form-control-sm select2 changesNoo select2-hidden-accessible" onchange="km(this.value,1);" style="width: 300px !important;" data-select2-id="ItemID0_1" tabindex="-1" aria-hidden="true">
                                                    <option value="" data-select2-id="10">select</option>
                                                    @foreach($items as $item)
                                                    <option value="{{$item->ItemID}}" data-select2-id="{{$item->ItemID}}">{{$item->ItemName}}</option>
                                                    @endforeach
                                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="9" style="width: 300px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-ItemID0_1-container"><span class="select2-selection__rendered" id="select2-ItemID0_1-container" role="textbox" aria-readonly="true" title="16mm Golden">16mm Golden</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                <input type="hidden" name="ItemID[]" id="ItemID_1" value="26">
                                                <textarea name="Description[]" id="Description[]" rows="2" class="form-control" style="width: 300px !important;"></textarea>
                                            </td>


                                            <td valign="top">
                                                <input type="number" name="Qty[]" id="Qty_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="1">
                                            </td>

                                            <td valign="top">
                                                <input type="number" name="Price[]" id="Price_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                            </td>
                                            <td valign="top">


                                                <div class="input-group">
                                                    <input type="text" name="Discount[]" id="Discount_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0">
                                                    <span>
                                                        <!-- <div class="col-sm-3">
                                        <label class="col-form-label" for="password">Salesperson </label>
                                    </div> -->
                                                        <div class="col-sm-9 input-group">
                                                            <select name="DiscountType[]" id="DiscountType_1" class="form-select  changesNo bg-light">

                                                                <option value="1">%</option>
                                                                <option value="2">AED</option>

                                                            </select>
                                                            <input type="hidden" name="DiscountAmountItem[]" id="DiscountAmount_1" value="0">
                                                        </div>
                                                    </span>

                                                </div>


                                            </td>
                                            <td valign="top">
                                                <input type="number" name="Gross[]" id="Gross_1" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                            </td>
                                            <td valign="top">
                                                <select name="Tax[]" id="TaxID_1" required="" class="form-select  changesNo tax exclusive_cal bg-light">
                                                    <option value="0">[0%] Tax </option>
                                                    <option value="4.76">[4.76%] Tax</option>
                                                </select>
                                            </td>
                                            <td valign="top">
                                                <input type="number" name="TaxVal[]" id="TaxVal_1" class=" form-control totalLinePrice2" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0">
                                            </td>

                                            <td valign="top">
                                                <input type="number" name="ItemTotal[]" id="ItemTotal_1" class=" form-control totalLinePrice " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-1 mb-2" style="margin-left: 29px;">
                            <div class="col-xs-5 col-sm-3 col-md-3 col-lg-3  ">
                                <button class="btn btn-danger delete" type="button"><i class="bx bx-trash align-middle font-medium-3 me-25"></i>Delete</button>
                                <button class="btn btn-success addmore" type="button"><i class="bx bx-list-plus align-middle font-medium-3 me-25"></i> Add More</button>

                            </div>

                            <div class="col-xs-5 col-sm-3 col-md-3 col-lg-3  ">
                                <div id="result"></div>

                            </div>
                            <br>

                        </div>


                        <div class="row mt-4">

                            <div class="col-lg-8 col-12  ">
                                <h6>Customer Notes: </h6>


                                <textarea class="form-control" rows="5" name="CustomerNotes" id="note" placeholder="">Thanks for your business.</textarea>

                                <label for="" class="mt-2">Description</label>
                                <textarea class="form-control" rows="5" name="DescriptionNotes" id="note" placeholder="Description notes if any."></textarea>

                                <br>
                                <iframe src="./index_files/Attachment.html" width="100%" height="40%" border="0" scrolling="yes" style="overflow: hidden;"></iframe>

                                <div class="mt-2"><button type="submit" class="btn btn-success w-md float-right">Save</button>
                                    <a href="http://localhost:1337/app9/public/DeliveryChallan" class="btn btn-secondary w-md float-right">Cancel</a>

                                </div>







                            </div>


                            <div class="col-lg-4 col-12 ">
                                <!-- <input type="text" class="form-control" id="TotalTaxAmount" name="TaxTotal" placeholder="TaxTotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"> -->

                                <div class="form-group mt-1">
                                    <label>Grand Total Tax: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>

                                        <input type="text" class="form-control" id="grandtotaltax" name="grandtotaltax" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                    </div>
                                </div>
                                <div class="form-group mt-1">
                                    <label>Sub Total1: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>

                                        <input type="text" class="form-control" id="subTotal" name="SubTotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                    </div>
                                </div>
                                <div class="form-group mt-1">
                                    <label>Discount: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">%</span>

                                        <input type="text" class="form-control" value="0" id="discountper" name="DiscountPer" placeholder="Tax" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">

                                        <span class="input-group-text bg-light">AED</span>

                                        <input type="text" name="DiscountAmount" class="form-control" id="discountAmount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                    </div>
                                </div>



                                <div class="form-group mt-1">

                                    <label>Total: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>
                                        <input type="number" name="Total" id="Total" class="form-control" step="0.01" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                    </div>
                                </div>


                                <div class="form-group mt-1 d-none">

                                    <label>Shipping: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>
                                        <input type="number" name="Shipping" class="form-control" step="0.01" id="shipping" placeholder="Grand Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                    </div>
                                </div>

                                <div class="form-group mt-1">

                                    <label>Grand Total: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>
                                        <input type="number" name="Grandtotal" id="Grandtotal" class="form-control" step="0.01" placeholder="Grand Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="0">
                                    </div>
                                </div>



                                <div class="form-group mt-1 d-none">
                                    <label>Amount Paid: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>
                                        <input type="number" class="form-control" id="amountPaid" name="amountPaid" placeholder="Amount Paid" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0">
                                    </div>
                                </div>

                                <div class="form-group mt-1 d-none">

                                    <label>Amount Due: &nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">AED</span>
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
            </form>
        </div>
        @endsection

        @push('after-scripts')
        <script>
            $('input[name=tax_action]').change(function(e) {
                $('.exclusive_cal').val(e.target.value)
            })


            /**
             * Site : http:www.smarttutorials.net
             * @author muni
             */

            var i = $('table tr').length;

            $(".addmore").on('click', function() {

                html = '<tr class= borde-1 border-light">';
                html += '<td class="p-1 text-center"><input class="case" type="checkbox"/></td>';
                html += '<td><select name="ItemID0[]" id="ItemID0_' + i + '"  style="width: 300px !important;" class="form-select select2  changesNoo" onchange="km(this.value,' + i + ');" > <option value="">select</option>} <option value="22|5">-Pepsi 1 Ltr-5</option> <option value="23|">-Malaysia Silver Pkg-</option> <option value="24|">-Sales-</option> <option value="25|">-16mm Silver-</option> <option value="26|">-16mm Golden-</option> <option value="27|">-17mm Silver-</option></select><input type="hidden" name="ItemID[]" id="ItemID_' + i + '"> <textarea name="Description[]" id="Description[]" rows="2" class="form-control" style="width: 300px !important;"></textarea></td>';



                html += '<td valign="top"><input type="text" name="Qty[]" id="Qty_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="1"></td>';

                html += '<td valign="top"><input type="text" name="Price[]" id="Price_' + i + '" class="form-control changesNo " autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
                html += '<td valign="top"><div class="input-group"><input type="text" name="Discount[]" id="Discount_' + i + '" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0"><span ><div class="col-sm-9 input-group"><select name="DiscountType[]" id="DiscountType_' + i + '" class="form-select  changesNo bg-light"  ><option  value="1">%</option><option  value="2">AED</option></select><input type="hidden" name="DiscountAmountItem[]" value="0" id="DiscountAmount_' + i + '"></div></span></div></td>';

                html += '<td  valign="top"> <input type="number" name="Gross[]" id="Gross_' + i + '" class=" form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">  </td>';

                html += '<td  valign="top"><select name="Tax[]" id="TaxID_' + i + '" class="form-control changesNo exclusive_cal bg-light"><option value="0">[0%] Tax </option><option value="4.76">[4.76%] Tax</option></select></td>';


                html += '<td  valign="top"><input type="number" name="TaxVal[]" id="TaxVal_' + i + '" class=" form-control totalLinePrice2 "autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01" value="0"></td>';




                html += '<td  valign="top"><input type="text" name="ItemTotal[]" id="ItemTotal_' + i + '" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';

                html += '</tr>';
                i++;
                $('table').append(html);
                $('.changesNoo', 'table').select2();




            });





            //to check all checkboxes
            $(document).on('change', '#check_all', function() {
                $('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
            });




            function km(v, id) {

                // alert(v+id);

                id_arr = 'ItemID0_' + id;
                id = id_arr.split("_");

                val = $('#ItemID0_' + id[1]).val().split("|");


                // alert($('#ItemID0_'+id[1]).val());
                $('#ItemID_' + id[1]).val(val[0]);

                // alert('val done');

                var data = [{
                    "ItemID": 22,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "Pepsi 1 Ltr",
                    "UnitName": null,
                    "Taxable": "Yes",
                    "Percentage": 5,
                    "CostPrice": 80,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 100,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 23,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "Malaysia Silver Pkg",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 5000,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 5500,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 24,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "Sales",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 80,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 80,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 25,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "16mm Silver",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 42,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 36,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 26,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "16mm Golden",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 42,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 36,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 27,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "17mm Silver",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 56,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 48,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }];
                // console.log(data);

                // console.log( "readaay!" );

                var data = [{
                    "ItemID": 22,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "Pepsi 1 Ltr",
                    "UnitName": null,
                    "Taxable": "Yes",
                    "Percentage": 5,
                    "CostPrice": 80,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 100,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 23,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "Malaysia Silver Pkg",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 5000,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 5500,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 24,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "Sales",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 80,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 80,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 25,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "16mm Silver",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 42,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 36,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 26,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "16mm Golden",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 42,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 36,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }, {
                    "ItemID": 27,
                    "ItemType": null,
                    "ItemCode": null,
                    "ItemName": "17mm Silver",
                    "UnitName": null,
                    "Taxable": "No",
                    "Percentage": null,
                    "CostPrice": 56,
                    "CostChartofAccountID": null,
                    "CostDescription": null,
                    "SellingPrice": 48,
                    "SellingChartofAccountID": null,
                    "SellingDescription": null
                }] // this is dynamic data in json_encode(); from controller

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





                $('#Price_' + id[1]).val(json["SellingPrice"]);
                $('#TaxID_' + id[1]).val(json["Percentage"]);

                var Qty = $('#Qty_' + id[1]).val();
                var Price = $('#Price_' + id[1]).val();
                var QtyRate = parseFloat(Price) * parseFloat(Qty);



                var DiscountType = $('#DiscountType_' + id[1]).val();



                var Discount = $('#Discount_' + id[1]).val();




                if (DiscountType == 1) {


                    var DiscountCalculated = (parseFloat(QtyRate) * parseFloat(Discount) / 100);
                } else {
                    var DiscountCalculated = parseFloat(Discount);
                }

                $('#DiscountAmount_' + id[1]).val(DiscountCalculated);


                var Gross = parseFloat(QtyRate) - parseFloat(DiscountCalculated);

                $('#Gross_' + id[1]).val(Gross);


                var TaxID = $('#TaxID_' + id[1]).val();

                var TaxCalculation = ((parseFloat(Gross) * parseFloat(TaxID)) / 100).toFixed(2);

                $('#TaxVal_' + id[1]).val(TaxCalculation);


                var ItemTotal = parseFloat(Gross) - parseFloat(TaxCalculation);

                $('#ItemTotal_' + id[1]).val(ItemTotal);



                var grandtotaltax = 0;

                $('.totalLinePrice2').each(function() {
                    if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
                });

                $('#grandtotaltax').val((parseFloat(grandtotaltax)).toFixed(2));


                TaxIncExc();



                calculateTotal();

                if (isNaN($('#discountAmount').val())) {
                    $('#discountAmount').val(0);
                }

                calculatediscount();
                calculateTotal();
                TaxIncExc();


            }







            //deletes the selected table rows
            $(".delete").on('click', function() {
                $('.case:checkbox:checked').parents("tr").remove();
                $('#check_all').prop("checked", false);
                calculatediscount();
                calculateTotal();
            });







            //price change
            $(document).on('change keyup blur ', '.changesNo', function() {



                singlerowcalculation($(this).attr('id'));





                calculatediscount();
                calculateTotal();
                TaxIncExc();
            });

            //////////

            function singlerowcalculation(idd) {
                TaxIncExc();
                id_arr = idd;
                id = id_arr.split("_");

                Qty = $('#Qty_' + id[1]).val();

                TaxPer = $('#TaxID_' + id[1]).val();

                Price = $('#Price_' + id[1]).val();


                var Qty = $('#Qty_' + id[1]).val();
                var Price = $('#Price_' + id[1]).val();
                var QtyRate = parseFloat(Price) * parseFloat(Qty);





                var DiscountType = $('#DiscountType_' + id[1]).val();



                var Discount = $('#Discount_' + id[1]).val();




                if (DiscountType == 1) {


                    var DiscountCalculated = (parseFloat(QtyRate) * parseFloat(Discount) / 100);
                } else {
                    var DiscountCalculated = parseFloat(Discount);
                }

                $('#DiscountAmount_' + id[1]).val(DiscountCalculated);


                var Gross = parseFloat(QtyRate) - parseFloat(DiscountCalculated);

                $('#Gross_' + id[1]).val(Gross);


                var TaxID = $('#TaxID_' + id[1]).val();

                var TaxCalculation = (parseFloat(Gross) * parseFloat(TaxID)) / 100;

                $('#TaxVal_' + id[1]).val(TaxCalculation);


                $('#ItemTotal_' + id[1]).val(Gross - TaxCalculation);

                var grandtotaltax = 0;

                $('.totalLinePrice2').each(function() {
                    if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
                });

                $('#grandtotaltax').val(parseFloat(grandtotaltax));


                TaxIncExc();




            }

            // 

            function TaxIncExc() {
                var TaxType = $('#TaxType').val();
                // var subTotal = $('#subTotal').val();
                var DiscountAmount = $('#discountAmount').val();
                var grandtotaltax = 0;




                var table_lenght = $('table tr').length - 1;


                var Qty = 0
                var Price = 0;
                var TaxVal = 0;
                var Gross = 0;
                for (let i = 1; i <= table_lenght; i++) {

                    Qty = $('#Qty_' + i).val();
                    Price = $('#Price_' + i).val();
                    TaxVal = $('#TaxVal_' + i).val();
                    Gross = $('#Gross_' + i).val();

                    $('#ItemTotal_' + i).val(parseFloat(Gross));

                }



                $('.totalLinePrice2').each(function() {
                    if ($(this).val() != '') grandtotaltax += parseFloat($(this).val());
                });

                subTotal = 0;
                $('.totalLinePrice').each(function() {
                    if ($(this).val() != '') subTotal += parseFloat($(this).val());
                });



                if (TaxType == 'TaxInclusive') {

                    subTotal1 = parseFloat(subTotal) - parseFloat(TaxVal);
                    $('#subTotal').val(subTotal1);

                    var Total = parseFloat(subTotal1) - parseFloat(DiscountAmount).toFixed(2);

                    $('#Total').val(parseFloat(Total));
                    $('#Grandtotal').val(parseFloat(Total) + parseFloat(grandtotaltax));

                } else {

                    $('#subTotal').val(parseFloat(subTotal));

                    var Total = parseFloat(subTotal) - parseFloat(DiscountAmount).toFixed(2);
                    var Grandtotal = ((parseFloat(Total) + parseFloat(grandtotaltax))).toFixed(2);


                    $('#Total').val(Total);
                    $('#Grandtotal').val(Grandtotal);

                }

            }


            $(document).on('change', '.changesNoo', function() {



                id_arr = $(this).attr('id');
                id = id_arr.split("_");

                val = $('#ItemID0_' + id[1]).val().split("|");


                // alert($('#ItemID0_'+id[1]).val());
                $('#ItemID_' + id[1]).val(val[0]);


                calculatediscount();

            });

            ////////////////////////////////////////////

            function calculatediscount() {

                subTotal = parseFloat($('#subTotal').val());


                discountper = $('#discountper').val();

                if (discountper != '' && typeof(discountper) != "undefined") {
                    discountamount = parseFloat(subTotal) * (parseFloat(discountper) / 100);

                    $('#discountAmount').val(parseFloat(discountamount.toFixed(2)));
                    total = subTotal - discountamount;
                    $('#Total').val(total.toFixed(2));
                    $('#Grandtotal').val(total + parseFloat($('#grandtotaltax').val()));


                } else {
                    $('#discountper').val(0);
                    // alert('dd');
                    $('#DiscountAmount').val(0);
                    total = subTotal;


                }
                $('#Total').val(total.toFixed(2));
                $('#Grandtotal').val(total + parseFloat($('#grandtotaltax').val()));
            }


            $(document).on('blur', '#discountAmount', function() {


                calculatediscountper();


            });

            function calculatediscountper() {

                subTotal = parseFloat($('#subTotal').val());


                discountAmount = $('#discountAmount').val();
                // totalafterdisc = $('#totalAftertax').val();
                // console.log('testing'.totalAftertax);
                if (discountAmount != '' && typeof(discountAmount) != "undefined") {
                    discountper = (parseFloat(discountAmount) / parseFloat(subTotal)) * 100;

                    $('#discountper').val(parseFloat(discountper.toFixed(2)));

                    total = subTotal - discountAmount;
                    $('#Total').val(total.toFixed(2));
                    // $('#grandtotal').val(total.toFixed(2));

                } else {
                    $('#discountper').val(0);
                    // alert('dd');
                    // $('#discountper').val(0);
                    total = subTotal;
                    $('#Total').val(total.toFixed(2));

                }

                $('#Grandtotal').val(total + parseFloat($('#grandtotaltax').val()));

            }

            //////////////////

            // discount percentage
            $(document).on(' blur ', '#discountper', function() {
                calculatediscount();


            });
            $(document).on('change keyup blur   onclick', '#taxpercentage', function() {
                calculateTotal();
            });


            $(document).on('change keyup blur   onclick', '#shipping', function() {
                calculateTotal();
            });



            //total price calculation 
            function calculateTotal() {

                // grand_tax = 0;


                subTotal = $('#subTotal').val();
                grandtotaltax = $('#grandtotaltax').val();
                discountAmount = $('#discountAmount').val();
                Total = parseFloat(subTotal) - parseFloat(discountAmount);
                Grandtotal = parseFloat(Total) + parseFloat(grandtotaltax);

                $('#Total').val(Total);
                $('#Grandtotal').val(Grandtotal);



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
                // console.log(keyCode);
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

        <!-- <script src="http://localhost:1337/app9/public/assets/js/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->

        <script type="text/javascript">
            //<![CDATA[


            $(function() {
                $('#WalkinCustomer').hide();
                $('#PartyID').change(function() {

                    if (this.options[this.selectedIndex].value == '1') {
                        // alert('dd');

                        $('#WalkinCustomer').show();
                        $('#1WalkinCustomerName').focus();

                    } else {
                        $('#WalkinCustomer').hide();
                        $('#1WalkinCustomerName').val(0);
                    }
                });
            });


            //]]>
        </script>
        <script type="text/javascript">
            //<![CDATA[


            $(function() {
                $('#paymentdetails').hide();
                $('#PaymentMode').change(function() {

                    if (this.options[this.selectedIndex].value == 'Cheque') {
                        // alert('dd');

                        $('#paymentdetails').show();
                        $('#PaymentDetails').focus();

                    } else {
                        $('#paymentdetails').hide();
                        $('#PaymentDetails').val('');
                    }
                });
            });


            //]]>
        </script>
        <!-- ajax trigger -->
        <script>
            function ajax_balance(SupplierID) {

                // alert($("#csrf").val());

                $('#result').prepend('')
                $('#result').prepend('<img id="theImg" src="http://localhost:1337/app9/public/
                    assets / images / ajax.gif " />')

                    var SupplierID = SupplierID;

                    // alert(SupplierID);
                    if (SupplierID != "") {
                        /*  $("#butsave").attr("disabled", "disabled"); */
                        // alert(SupplierID);
                        $.ajax({
                            url: "http://localhost:1337/app9/public/Ajax_Balance",
                            type: "POST",
                            data: {
                                _token: $("#csrf").val(),
                                SupplierID: SupplierID,

                            },
                            cache: false,
                            success: function(data) {



                                $('#result').html(data);



                            }
                        });
                    } else {
                        alert('Please Select Branch');
                    }




                }
        </script>

        <script>
            $(function() {

                var InvoiceType = $('#InvoiceType').val();

                // console.log(InvoiceType);
                if (InvoiceType != "") {
                    /*  $("#butsave").attr("disabled", "disabled"); */
                    // alert('next stage if else');
                    // console.log(InvoiceType);

                    $.ajax({

                        url: "http://localhost:1337/app9/public/ajax_invoice_vhno",
                        type: "POST",
                        data: {
                            // _token: p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu,
                            "_token": $("#csrf").val(),
                            InvoiceType: InvoiceType,

                        },
                        cache: false,

                        success: function(data) {

                            // alert(data.success);
                            $('#invoict_type').html(data);



                        }
                    });
                }


            });
        </script>



        <script>
            $("#TaxType").change(function() {

                TaxIncExc();

            });
        </script>




        <script>
            $("#InvoiceType").change(function() {

                // alert(p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu);

                var InvoiceType = $('#InvoiceType').val();

                // console.log(InvoiceType);
                if (InvoiceType != "") {
                    /*  $("#butsave").attr("disabled", "disabled"); */
                    // alert('next stage if else');
                    // console.log(InvoiceType);

                    $.ajax({

                        url: "http://localhost:1337/app9/public/ajax_invoice_vhno",
                        type: "POST",
                        data: {
                            // _token: p3WhH7hWcpfbcxtNskY1ZrCROfa3dpKp3MfEJwXu,
                            "_token": $("#csrf").val(),
                            InvoiceType: InvoiceType,

                        },
                        cache: false,

                        success: function(data) {

                            // alert(data.success);
                            $('#invoict_type').html(data);



                        }
                    });
                }

            });
        </script>
        <script type="text/javascript">
            function GetSelectedTextValue(seletedVal) {
                gTotalVal = $('#grandtotal').val();
                if (gTotalVal) {


                    var txt;
                    if (confirm("Are you sure you want to update tax of complete invoice!")) {
                        txt = "You pressed OK!";

                        var TaxValue = seletedVal.value;

                        var table_lenght = $('table tr').length;
                        let discountamount = 0;


                        var grandsum = 0
                        var taxsum = 0;
                        for (let i = 1; i < table_lenght; i++) {
                            Qty = $('#Qty_' + i).val();
                            Price = $('#Price_' + i).val();


                            $('#TaxID_' + i).val(TaxValue);
                            disPerLine = parseFloat(Price) * (TaxValue / 100);
                            $('#TaxVal_' + i).val(parseFloat(disPerLine));

                            grandsum += (Qty * Price) + disPerLine;
                            taxsum += disPerLine;

                            $('#ItemTotal_' + i).val((Qty * Price) + disPerLine);

                        }
                        $('#grandtotaltax').val(parseFloat(taxsum));
                        // assigning subtotal value
                        $('#subTotal').val(parseFloat(grandsum));


                        // fetching discount percentage
                        var discountper = $('#discountper').val();
                        // calculating discount amount
                        discountamount = parseFloat(grandsum) * (parseFloat(discountper) / 100);
                        $('#discountAmount').val(parseFloat(discountamount));
                        //amount after discount
                        $('#totalafterdisc').val(parseFloat(grandsum) - parseFloat(discountamount));

                        // fetching percentage of tax
                        var taxper = $('#taxpercentage').val();
                        // calculating percentage amount
                        taxamount = parseFloat(grandsum) * (parseFloat(taxper) / 100);
                        $('#taxpercentageAmount').val(parseFloat(taxamount));

                        //calculating shiping cost
                        var shipping = $('#shipping').val();



                        var grandtotal = (parseFloat(grandsum) + parseFloat(taxamount) + parseFloat(shipping)) - parseFloat(discountamount);
                        // Calculating grandtotal
                        $('#grandtotal').val(grandtotal);
                        // alert(discountamount);
                    } else {
                        $('#seletedVal').val('select');
                    }

                } else {
                    return alert("Please create invoice first");
                }
            }
        </script>

        @endpush