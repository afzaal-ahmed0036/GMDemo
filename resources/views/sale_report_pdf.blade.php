<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Sales Report</title>
</head>

<body>
    <div align="center">
        <h3 class="text-capitalize">{{ $company->Name }}</h3>
        <p><strong>Sales Report</strong></p>

        <div align="left">From {{ request()->StartDate }} TO {{ request()->EndDate }} </div>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Invoice#</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Date/Time</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Customer</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Method</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Cost</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Sold</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Invoice Total</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Paid</strong></td>
                <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Profit</strong></td>
            </tr>
            <?php
            $GrandTotal = 0;
            $Paid = 0;
            $Profit = 0;
            ?>
            @foreach ($v_invoice_profit as $key => $value)
                <?php

                $GrandTotal = $GrandTotal + $value->GrandTotal;
                $Paid = $Paid + $value->Paid;
                $Profit = $Profit + $value->Profit;

                ?>
                <tr>
                    <td width="25" style="text-align: center">{{ $value->InvoiceNo }}</td>
                    <td width="25" style="text-align: center">{{ $value->Date }}</td>
                    <td width="25" style="text-align: center">{{ $value->PartyName }}</td>
                    <td width="25" style="text-align: center">{{ $value->PaymentMode }}</td>
                    <td width="25" style="text-align: center">{{ number_format($value->Cost, 2) }}</td>
                    <td width="25" style="text-align: center">{{ number_format($value->Sold, 2) }}</td>
                    <td width="25" style="text-align: center">{{ number_format($value->GrandTotal, 2) }}</td>
                    <td width="25" style="text-align: center">{{ number_format($value->Paid, 2) }}</td>
                    <td width="25" style="text-align: center">{{ number_format($value->Profit, 2) }}</td>
                </tr>
            @endforeach

            <tr class="bg-light fw-bold">
                <td style="text-align: center" colspan="6"><strong>Total:</strong></td>
                <td style="text-align: center">{{ number_format($GrandTotal, 2) }}</td>
                <td style="text-align: center">{{ number_format($Paid, 2) }}</td>
                <td style="text-align: center">{{ number_format($Profit, 2) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
