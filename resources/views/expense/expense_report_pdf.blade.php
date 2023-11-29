<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Expense Report</title>
</head>

<body>
    <div align="center">
        <h3 class="text-capitalize">{{ $company->Name }}</h3>
        <p><strong>Expense Report</strong></p>

        <div align="left">From {{ request()->StartDate }} TO {{ request()->EndDate }} </div>
        @if (count($expense_detail) > 0)
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Expense</strong></td>
                    <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Date</strong></td>
                    <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Supplier</strong></td>
                    <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Account</strong></td>
                    <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Tax</strong></td>
                    <td width="25" bgcolor="#CCCCCC" style="text-align: center"><strong>Amount</strong></td>
                </tr>
                <?php
                $AmountTotal = 0;
                $Tax = 0;
                ?>
                @foreach ($expense_detail as $key => $value)
                    <?php

                    $AmountTotal = $AmountTotal + $value->Amount;
                    $Tax = $Tax + $value->Tax;

                    ?>

                    <tr>
                        <td width="25" style="text-align: center">{{ $value->ExpenseNo }}</td>
                        <td width="25" style="text-align: center">{{ $value->Date }}</td>
                        <td width="25" style="text-align: center">{{ @$value->SupplierName }}</td>
                        <td width="25" style="text-align: center">{{ $value->ChartOfAccountName }}</td>
                        <td width="25" style="text-align: center">{{ $value->Tax }}</td>
                        <td width="25" style="text-align: center">{{ $value->Amount }}</td>
                    </tr>
                @endforeach

                <tr class="bg-light fw-bold">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">Total</td>
                    <td style="text-align: center">{{ $Tax }}</td>
                    <td style="text-align: center">{{ $AmountTotal }}</td>
                </tr>
            </table>
        @else
            <p style="color:red">No data found</p>
        @endif

    </div>
</body>

</html>
