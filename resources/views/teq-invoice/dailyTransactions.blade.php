<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <style type="text/css">
        <!--
        .style1 {
            font-size: 18px;
            font-weight: bold;
        }

        body,
        td,
        th {
            font-size: 13px;
        }
        -->
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="2">
                <div align="center" class="style1">{{ $company->Name }} </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div align="center"> Todays Invoices
                </div>
            </td>
        </tr>
        <tr>
            <td width="50%">Dated: {{ date('d-m-Y') }}</td>
            <td width="50%">&nbsp;</td>
        </tr>
    </table>
    <p>
        <?php
        $DrTotal = 0;
        $CrTotal = 0;

        ?>
        @if (count($invoice_masters) > 0)
    </p>
    <table width="100%" border="1" align="center" cellpadding="3" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <th bgcolor="#CCCCCC">
                    <div align="center">Invoice #</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">Customer Name</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">Customer Phone</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">Total</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">SubTotal</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">Tax</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">Shipping</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">Discount</div>
                </th>
                <th bgcolor="#CCCCCC">
                    <div align="center">GrandTotal</div>
                </th>
            </tr>
        </tbody>
        @php
            $subTotalSum = 0;
            $TotalSum = 0;
            $ShippingSum = 0;
            $GrandTotalSum = 0;
            $taxSum = 0;
            $discountSum = 0;

        @endphp
        <tbody>
            @foreach ($invoice_masters as $key => $value)
                <tr>
                    <td>
                        <div align="center">{{ $value->InvoiceNo }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->party != null ? $value->party->PartyName : '' }}</div>
                    </td>

                    <td>
                        <div align="center">
                            {{ $value->party->Mobile != null ? $value->party->Mobile : $value->party->Phone }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->Total }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->SubTotal }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->Tax == null ? '0' : $value->Tax }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->Shipping == null ? '0' : $value->Shipping }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->DiscountAmount == null ? '0' : $value->DiscountAmount }}</div>
                    </td>
                    <td>
                        <div align="center">{{ $value->GrandTotal }}</div>
                    </td>
                </tr>
                @php
                    $subTotalSum = $subTotalSum + $value->SubTotal;
                    $TotalSum = $TotalSum + $value->Total;
                    $ShippingSum = $ShippingSum + $value->Shipping;
                    $taxSum = $taxSum + $value->Tax;
                    $discountSum = $discountSum + $value->DiscountAmount;
                    $GrandTotalSum = $GrandTotalSum + $value->GrandTotal;
                @endphp
            @endforeach
            <tr class="table-active">
                <td colspan="3" align="center"><strong>TOTAL:</strong></td>
                <td>
                    <div align="center">{{ $TotalSum }}</div>
                </td>
                <td>
                    <div align="center">{{ $subTotalSum }}</div>
                </td>
                <td>
                    <div align="center">{{ $taxSum }}</div>
                </td>
                <td>
                    <div align="center">{{ $ShippingSum }}</div>
                </td>
                <td>
                    <div align="center">{{ $discountSum }}</div>
                </td>
                <td>
                    <div align="center">{{ $GrandTotalSum }}</div>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p class=" text-danger">No data found</p>
    @endif


</body>

</html>
