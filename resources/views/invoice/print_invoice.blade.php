<!DOCTYPE html>
    <html>

    <head>
          <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="#" />
    <title>Invoice Print</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 7px 0;width: 50%;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media  print {
            * {
                font-size:12px;
                line-height: 20px;
            }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            @page  { margin: 1.5cm 0.5cm 0.5cm; }
            @page:first { margin-top: 0.5cm; }
            /*tbody::after {
                content: ''; display: block;
                page-break-after: always;
                page-break-inside: avoid;
                page-break-before: avoid;
            }*/
        }
    </style>
    </head>

    <body>
<?php
            $myNumber = "$lims_sale_data->GrandTotal";
            $percentToGet = 4;
            $percentInDecimal = $percentToGet / 100;
            $percent = $percentInDecimal * $myNumber;
            $percent2 = $myNumber + $percent;
            $percentx = number_format($percent, 2);
            // echo $percent2;
            //calculate due amount
            $paid_amount=$lims_sale_data->Paid;
            $total_amount=$lims_sale_data->GrandTotal;
            $due_amount= $total_amount - $paid_amount;
            // echo $due_amount;
            ?>
        <div style="max-width:400px;margin:0 auto">
            @if (preg_match('~[0-9]~', url()->previous()))
                @php $url = '../../pos'; @endphp
            @else
                @php $url = url()->previous(); @endphp
            @endif
            <div class="hidden-print">
                <div class="row">
                <div class="col-sm-4"><a href="{{URL('/create-invoice')}}" class="btn btn-info"><i class="fa fa-arrow-left"></i>
                                {{ trans('file.Back') }}</a></div>
                <div class="col-sm-4"><button style="margin-right: 260px !important;" onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i>
                                {{ trans('file.Print') }}</button></div>
                <div class="col-sm-4">

                    @if($lims_sale_data->ReferenceNo ==$lims_sale_data->Tax)

                  @else

                  <form class="form-horizontal" method="Post" action="{{ route('admin.extra_tax')}}">
                      @csrf
                      @method('PUT')
                      <input style="display: none;" type="text" name="grand_total" value=<?php echo $percent2 ?> class="form-control">
                      <input style="display: none;" class="d-none" type="text" name="sale_id" value="{{$lims_sale_data->InvoiceMasterID}}" class="form-control">
                      <input style="display: none;" class="d-none" type="text" name="extra_tax" value="{{$lims_sale_data->ReferenceNo}}" class="form-control">
                      <!-- <button class="btn btn-info" style="width: 100%;">Charge Extra</button> -->
                  </form>
                  @endif

                </div>
            </div>


            </div>

            <div id="receipt-data"><br>
                <div class="centered">
                    @if (@$general_setting->site_logo)
                        <img src="{{ url('public/logo', $general_setting->site_logo) }}" height="200" width="300"
                            style="margin:10px 0;">
                    @endif

                    <h2>{{ $company->Name }}</h2>

                    <p>{{ trans('file.Address') }}: {{ $company->Address }}
                        <br>{{ trans('file.Phone Number') }}: {{ $company->Contact }}
                    </p>
                </div>
                <p>{{ trans('file.Date') }}: {{ $lims_sale_data->Date }}<br>
                   Invoice no: {{ $lims_sale_data->ReferenceNo }}<br>
                    {{ trans('file.customer') }}: {{ $lims_customer_data->PartyName }}<br>
                    {{ trans('Phone number') }}: {{ $lims_customer_data->Phone }}<br>
                    {{ trans('Address') }}: {{ $lims_customer_data->Address }}
                </p>
                <table class="table-data">
                    <!-- <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>RRP</th>
                            <th>Disc. Price</th>
                            <th>Tax</th>
                            <th>Qty</th>

                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <?php $total_product_tax = 0; ?>
                        @foreach ($lims_product_sale_data as $key => $product_sale_data)
                            <?php
                            $lims_product_data = \DB::table('item')->where('ItemID',$product_sale_data->ItemID)->first();
                            // if ($product_sale_data->variant_id) {
                            //     $variant_data = \App\Variant::find($product_sale_data->variant_id);
                            //     $product_name = $lims_product_data->name . ' [' . $variant_data->name . ']';
                            // } elseif ($product_sale_data->product_batch_id) {
                            //     $product_batch_data = \App\ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
                            //     $product_name = $lims_product_data->name . ' [' . trans('file.Batch No') . ':' . $product_batch_data->batch_no . ']';
                            // } else {
                                $product_name = $lims_product_data->ItemName;
                                $product_price = $lims_product_data->SellingPrice;
                                $product_code = $lims_product_data->ItemCode;
                                // $commission_name = $product_sale_data->salesman_name;
                            // }
                            ?>

                            <tr>
                                <td colspan="2">
                                    {{ $product_name }}
                                    <br>{{ $product_sale_data->Qty }} x {{ $product_price }}

                                </td>
                                <!-- <td>
                                    {{ $product_name }}<br>
                                </td>
                                <td>
                                    {{ $product_code }}
                                </td>
                                <td>
                                    {{ $product_price }}
                                </td>
                                <td>{{ number_format((float) ($product_sale_data->Total / $product_sale_data->Qty), 2, '.', '') }}


                                </td>

                                <td>
                                @if ($product_sale_data->Tax)
                                      <?php //$total_product_tax += $product_sale_data->Tax; ?>
                                        {{ $product_sale_data->Tax }}%
                                @endif
                                </td>
                                <td>
                                    {{ $product_sale_data->Qty }}
                                </td>




                                <td style="text-align:right;">
                                    {{ number_format((float) $product_sale_data->Total, 2, '.', '') }}
                                </td> -->
                            </tr>
                            {{-- <tr>
                                <td colspan="5">{{$commission_name}}</td>
                            </tr> --}}
                        @endforeach

                        <!-- <tfoot> -->
                        <tr>
                            <th colspan="6" style="text-align:left">{{ trans('file.Total') }}</th>
                            <th style="text-align:right">
                                {{ number_format((float) $lims_sale_data->GrandTotal, 2, '.', '') - $lims_sale_data->Tax }}</th>
                        </tr>

                          @if($lims_sale_data->ReferenceNo ==$lims_sale_data->Tax)
                           <tr>
                            <th colspan="6" style="text-align:left">Extra Tax</th>
                            <th style="text-align:right">
                                4%(<?php echo( $percentx)?>)</th>
                        </tr>

                    @else

                    @endif



                        @if (@$general_setting->invoice_format == 'gst' && @$general_setting->state == 1)
                            <tr>
                                <td colspan="6">IGST</td>
                                <td style="text-align:right">{{ number_format((float) $total_product_tax, 2, '.', '') }}
                                </td>
                            </tr>
                        @elseif(@$general_setting->invoice_format == 'gst' && @$general_setting->state == 2)
                            <tr>
                                <td colspan="6">SGST</td>
                                <td style="text-align:right">
                                    {{ number_format((float) ($total_product_tax / 2), 2, '.', '') }}</td>
                            </tr>
                            <tr>
                                <td colspan="6">CGST</td>
                                <td style="text-align:right">
                                    {{ number_format((float) ($total_product_tax / 2), 2, '.', '') }}</td>
                            </tr>
                        @endif
                        @if ($lims_sale_data->Tax)
                            <tr>
                                <th colspan="6" style="text-align:left">{{ trans('file.Order Tax') }}</th>
                                <th style="text-align:right">
                                    {{ number_format((float) $lims_sale_data->Tax, 2, '.', '') }}</th>
                            </tr>
                        @endif
                        @if ($lims_sale_data->DiscountAmount)
                            <tr>
                                <th colspan="6" style="text-align:left">{{ trans('file.Order Discount') }}</th>
                                <th style="text-align:right">
                                    {{ number_format((float) $lims_sale_data->DiscountAmount, 2, '.', '') }}</th>
                            </tr>
                        @endif
                        @if (@$lims_sale_data->coupon_discount)
                            <tr>
                                <th colspan="6" style="text-align:left">{{ trans('file.Coupon Discount') }}</th>
                                <th style="text-align:right">
                                    {{ number_format((float) $lims_sale_data->coupon_discount, 2, '.', '') }}</th>
                            </tr>
                        @endif
                        @if ($lims_sale_data->Shipping)
                            <tr>
                                <th colspan="6" style="text-align:left">{{ trans('Shipping Charges') }}</th>
                                <th style="text-align:right">
                                    {{ number_format((float) $lims_sale_data->Shipping, 2, '.', '') }}</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="6" style="text-align:left">{{ trans('file.grand total') }}</th>
                            <th style="text-align:right">
                                {{ number_format((float) $lims_sale_data->GrandTotal, 2, '.', '') }}</th>
                        </tr>
                        <tr>
                            <th colspan="6" style="text-align:left">Due Amount</th>
                            <th style="text-align:right">
                                <?php echo($due_amount)?></th>
                        </tr>
                        {{-- <tr>
                            @if (@$general_setting->currency_position == 'prefix')
                                <th class="centered" colspan="6">{{ trans('file.In Words') }}:
                                    <span>{{ config('currency') }}</span>
                                    <span>{{ str_replace('-', ' ', $numberInWords) }}</span></th>
                            @else
                                <th class="centered" colspan="6">{{ trans('file.In Words') }}:
                                    <span>{{ str_replace('-', ' ', $numberInWords) }}</span>
                                    <span>{{ config('currency') }}</span></th>
                            @endif
                        </tr> --}}
                    </tbody>
                    <!-- </tfoot> -->
                </table>
                <table>
                    <tbody>
                        @foreach ($lims_payment_data as $payment_data)
                            <tr style="background-color:#ddd;">
                                <td style="padding: 5px;width:30%">{{ trans('file.Paid By') }}:
                                    {{ $payment_data->PayingMethod }}</td>
                                <td style="padding: 5px;width:40%">Paid amount:
                                    {{ number_format((float) $payment_data->Amount, 2, '.', '') }}</td>
                                <td style="padding: 5px;width:30%">{{ trans('file.Change') }}:
                                    {{ number_format((float) $payment_data->Change, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        <!--<tr>-->
                        <!--    <td class="centered" colspan="5">-->
                        <!--        {{ trans('file.Thank you for shopping with us. Please come again') }}</td>-->
                        <!--</tr>-->
                        @if($lims_sale_data->ReferenceNo ==$lims_sale_data->Tax)
                    <tr>
                        <td class="centered" colspan="3"><strong>4% extra tax will be chaged for non-filers</strong></td>
                    </tr>
                    @else

                    @endif
                        <tr>
                            <td class="centered" colspan="5">
                                <?php echo '<img style="height: 25px; width: 160px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_sale_data->ReferenceNo, 'C128') . '" width="300" alt="barcode"   />'; ?>
                                <br>
                                <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($lims_sale_data->ReferenceNo, 'QRCODE') . '" alt="barcode"   />'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <div class="centered" style="margin:30px 0 50px">
                <small>{{ trans('file.Invoice Generated By') }} {{ @$general_setting->site_title }}.
                {{ trans('file.Developed By') }} LionCoders</strong></small>
            </div> -->
            </div>
        </div>

        <script type="text/javascript">
            localStorage.clear();

            function auto_print() {
                window.print()
            }
            setTimeout(auto_print, 1000);
        </script>

    </body>

    </html>
