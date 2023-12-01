<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Item Report</title>
</head>

<body>
    <div align="center">
        <h3 class="text-capitalize">{{ $company->Name }}</h3>
        <p><strong>Item Report</strong></p>

        <table width="100%" cellspacing="0" cellpadding="0">
            {{-- <tr>
                <td>
                    <div align="left"><strong>From: {{ request()->StartDate }} TO: {{ request()->EndDate }} </strong></div>
                </td>
                <td>
                    <div align="right"><strong>Remianing Stock: {{ $remaining_stock }}</strong></div>
                </td>
            </tr>
            <br> --}}
            <tr>
                @if ($item_name != null)
                    <td>
                        <div align="left"><strong>Item Name: {{ $item_name }} </strong></div>
                    </td>
                @endif
                @if ($item_code != null)
                    <td>
                        <div align="center"><strong>Item Code: {{ $item_code }} </strong></div>
                    </td>
                @endif
                <td>
                    <div align="right"><strong>Remianing Stock: {{ $remaining_stock }}</strong></div>
                </td>
            </tr>
        </table>
        <hr>
        @php

            $PGrandTotal = 0;
            $PitemTotal = 0;
            $PQty = 0;
            $SGrandTotal = 0;
            $SitemTotal = 0;
            $SQty = 0;
        @endphp
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="7">
                    <div align="center">
                        <strong>In Stock (Purchases)</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Invoice#</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Date/Time</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Method</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Cost</strong></td>
                {{-- <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Sold</strong></td> --}}
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Quantity</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Item Total</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Invoice Total</strong></td>
            </tr>
            @foreach ($purchases as $key => $value)
                @foreach ($value->invoiceDetails as $item)
                    @php
                        $PGrandTotal = $PGrandTotal + $value->GrandTotal;
                    @endphp
                    <tr>
                        <td width="25" style="text-align: center">{{ $value->InvoiceNo }}</td>
                        <td width="25" style="text-align: center">{{ $value->Date }}</td>
                        <td width="25" style="text-align: center">{{ $value->PaymentMode }}</td>
                        <td width="25" style="text-align: center">{{ number_format($item->Rate, 2) }}</td>
                        {{-- <td width="25" style="text-align: center">{{ number_format($item->Rate, 2) }}</td> --}}
                        <td width="25" style="text-align: center">{{ $item->Qty }}</td>
                        <td width="25" style="text-align: center">{{ number_format($item->Total, 2) }}</td>
                        <td width="25" style="text-align: center">{{ number_format($value->GrandTotal, 2) }}</td>
                        @php
                            $PitemTotal = $PitemTotal + $item->Total;
                            $PQty = $PQty + $item->Qty;
                        @endphp

                    </tr>
                @endforeach
            @endforeach

            <tr class="bg-light fw-bold">
                <td style="text-align: center" colspan="4"><strong>Total:</strong></td>
                <td style="text-align: center">{{ $PQty }}</td>
                <td style="text-align: center">{{ number_format($PitemTotal, 2) }}</td>
                <td style="text-align: center">{{ number_format($PGrandTotal, 2) }}</td>
            </tr>
        </table>
        <hr>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="8">
                    <div align="center">
                        <strong>Out Stock (Sales)</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Invoice#</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Date/Time</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Method</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Cost</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Sold</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Quantity</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Item Total</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Invoice Total</strong></td>
            </tr>
            @foreach ($sales as $key => $value)
                @foreach ($value->invoiceDetails as $item)
                    @php
                        $SGrandTotal = $SGrandTotal + $value->GrandTotal;
                    @endphp
                    <tr>
                        <td width="25" style="text-align: center">{{ $value->InvoiceNo }}</td>
                        <td width="25" style="text-align: center">{{ $value->Date }}</td>
                        <td width="25" style="text-align: center">{{ $value->PaymentMode }}</td>
                        <td width="25" style="text-align: center">{{ number_format($item->cost_price, 2) }}</td>
                        <td width="25" style="text-align: center">{{ number_format($item->Rate, 2) }}</td>
                        <td width="25" style="text-align: center">{{ $item->Qty }}</td>
                        <td width="25" style="text-align: center">{{ number_format($item->Total, 2) }}</td>
                        <td width="25" style="text-align: center">{{ number_format($value->GrandTotal, 2) }}</td>
                        @php
                            $SitemTotal = $SitemTotal + $item->Total;
                            $SQty = $SQty + $item->Qty;
                        @endphp

                    </tr>
                @endforeach
            @endforeach

            <tr class="bg-light fw-bold">
                <td style="text-align: center" colspan="5"><strong>Total:</strong></td>
                <td style="text-align: center">{{ $SQty }}</td>
                <td style="text-align: center">{{ number_format($SitemTotal, 2) }}</td>
                <td style="text-align: center">{{ number_format($SGrandTotal, 2) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
