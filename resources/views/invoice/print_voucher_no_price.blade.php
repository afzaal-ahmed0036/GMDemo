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
            cursor: pointer;
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

        tbody tr {
            border-bottom: 1px dotted #ddd;
        }

            {
            border: 0
        }

        td,
        th {
            padding: 7px 0;
            width: 50%;
        }

        table {
            width: 100%;
        }

        tfoot tr th:first-child {
            text-align: left;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        small {
            font-size: 11px;
        }

        @media print {
            * {
                font-size: 12px;
                line-height: 20px;
            }

            td,
            th {
                padding: 5px 0;
            }

            .hidden-print {
                display: none !important;
            }

            @page {
                margin: 1.5cm 0.5cm 0.5cm;
            }

            @page: first {
                margin-top: 0.5cm;
            }

            /*tbody::after {
                content: ''; display: block;
                page-break-after: always;
                page-break-inside: avoid;
                page-break-before: avoid;
            }*/

        }

        .dashed-2 {
            border: none !important;
            height: 1px !important;
            background: #000 !important;
            background: repeating-linear-gradient(90deg, #000 0px, #000 6px, transparent 6px, transparent 12px) !important;
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
    $paid_amount = $lims_sale_data->Paid;
    $total_amount = $lims_sale_data->GrandTotal;
    $due_amount = $total_amount - $paid_amount;
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
                <div class="col-sm-4"><a href="{{URL('/create-voucher')}}" class="btn btn-info"><i class="fa fa-arrow-left"></i>
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
                @if (@$company->Logo)
                <img src="{{ url('/documents', $company->Logo) }}" height="150" width="225" style="margin:10px 0;">
                @endif
                <h4 style="font-weight:bold;">{{ $company->Name }}</h4>
                <p>{{ trans('file.Address') }}: {{ $company->Address }}
                    <br>{{ trans('file.Phone Number') }}: {{ $company->Contact }}
                </p>
                <p>
                    @php
                    // Current date
                    $currentDate = date('Y-m-d');
                    $daysDifference = '';
                    // Calculate expiry date
                    $expiryDate = date('Y-m-d', strtotime('+3 days', strtotime($lims_sale_data->Date)));
                    $date1 = new DateTime($lims_sale_data->Date);
                    $date2 = new DateTime($expiryDate);

                    if(\Carbon\Carbon::parse($expiryDate)->format('Y-m-d')<$currentDate) { $daysDifference='<span style="color:#f00">Invoice is expired </span>' ; } else{ $date1=new DateTime($currentDate); $date2=new DateTime($expiryDate); $interval=$date1->diff($date2);
                        $daysDifference = $interval->days;
                        if($daysDifference == '0'){
                        $daysDifference = '<span style="font-weight:bold">Expires Today</span>';
                        }
                        else if($daysDifference == '1'){ $daysDifference = 'Expires in <span style="font-weight:bold">'.$daysDifference.'</span> Day';}
                        else {
                        $daysDifference = 'Expires in <span style="font-weight:bold">'.$daysDifference.'</span> Days';}
                        }
                        @endphp
                        RECEIPT :{{ $lims_sale_data->InvoiceNo }}<br>
                        DATE :{{ date("d/m/Y", strtotime($lims_sale_data->Date)) }}<br>
                        Customer Phone :{{ $lims_customer_data->Phone }}<br>
                        @if($lims_sale_data->DeliveryAddress == null && $lims_sale_data->driverName == null)
                        Service Type : PickUp<br>
                        @else
                        Service Type : Dilevery<br>
                        Dilvery Address : {{ $lims_sale_data->DeliveryAddress }}<br>
                        Driver Name : {{ $lims_sale_data->driverName }}<br>
                        @endif
                </p>
            </div>
            <hr class="dashed-2">
            <table class="table-data ">
                <thead>
                    <tr>
                        <th colspan="6">Name</th>
                        <!-- <th>Code</th>
                            <th>RRP</th>
                            <th>Disc. Price</th>
                            <th>Tax</th>
                            <th>Qty</th>-->

                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_product_tax = 0; ?>
                    @foreach ($lims_product_sale_data as $key => $product_sale_data)
                    @php
                    $lims_product_data = \DB::table('item')->where('ItemID',$product_sale_data->ItemID)->first();
                    $product_name      = $product_sale_data->Description;
                    if($lims_product_data->ItemCategoryID == '2')
                    {
                        $product_name      .=' ( '.$daysDifference.' )';
                    }
                    $product_price     = $lims_product_data->SellingPrice;
                    $product_code      = $lims_product_data->ItemCode;
                    if($lims_product_data->Taxable == 'Yes'){
                        $product_tax       = @$lims_product_data->Percentage;
                        if($product_tax)
                            $product_price     = $product_price + (($product_tax/100) * $product_price);
                    }
                    @endphp
                    <tr>
                        <td colspan="6" style="text-align:left"> {!! $product_name !!} <br>{{ $product_sale_data->Qty }} Qty</td>
                        <td style="text-align:right">******</td>
                    </tr>
                    @endforeach

                    @foreach ($lims_product_dish_data as $key => $product_sale_data)
                    @php
                    $lims_product_data = \DB::table('dish_types')->where('id',$product_sale_data->dish_type_id)->first();
                    $product_name      = $lims_product_data->type;
                    $product_price     = $lims_product_data->price;
                    $product_code      = $lims_product_data->code;
                    @endphp
                    <tr>
                        <td colspan="6" style="text-align:left">
                            {{ $product_name }}
                            <br>{{ $product_sale_data->quantity }}

                        </td>
                        <td style="text-align:right">
                        </td>

                    </tr>
                    @endforeach

                </tbody>


            </table>
            <table>
                <tbody>

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
                            <?php echo '<img style="height: 25px; width: 160px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_sale_data->InvoiceNo, 'C128') . '" width="300" alt="barcode"   />'; ?>
                            <!-- <br>
                                <?php //echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($lims_sale_data->InvoiceNo, 'QRCODE') . '" alt="barcode"   />';
                                ?> -->
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
