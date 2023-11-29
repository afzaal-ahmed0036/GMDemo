<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>DAILY EXPENSE</title>
</head>

<body>
    <div align="center">
        <h3 class="text-capitalize">{{ $company[0]->Name }}</h3>
        <p><strong>DAILY EXPENSE</strong></p>

        <div align="left">From {{ request()->StartDate }} TO {{ request()->EndDate }} </div>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td width="25" bgcolor="#CCCCCC"><strong>CH OF ACCOUNT </strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>DESCRIPTION</strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>INVOICE/REF</strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>SUPPLIER</strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>DEBIT</strong></td>
            </tr>

            <?php

            $total_expense = 0;
            $total_income = 0;

            ?>

            @foreach ($journal_expense as $value)
                <?php

                $total_expense = $total_expense + $value->GrantTotal;
                    $chartAcc = DB::table('chartofaccount')->select('ChartOfAccountName')->where('ChartOfAccountID', $value->ChartOfAccountID)->first();
                ?>
                <tr>
                    <td width="25">{{ $chartAcc->ChartOfAccountName }}</td>
                    <td width="25">{{ $value->ReferenceNo }}</td>
                    <td width="25">{{ $value->ExpenseNo }}</td>
                    <td width="25">{{ $value->SupplierID }}</td>
                    <td width="25">
                        <div align="right">{{ number_format($value->GrantTotal, 2) }}</div>
                    </td>

                </tr>
            @endforeach

            <tr>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25"><strong>TOTAL</strong></td>
                <td width="25">
                    <div align="right">{{ number_format($total_expense, 2) }}</div>
                </td>
            </tr>
        </table>
        <p><strong>DAILY CASH</strong></p>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">

            <tr>
                <td width="25" bgcolor="#CCCCCC"><strong>CH OF ACCOUNT </strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>DESCRIPTION</strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>INVOICE/REF</strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>PARTY</strong></td>
                <td width="25" bgcolor="#CCCCCC"><strong>CREDIT</strong></td>
            </tr>


            @foreach ($journal_income as $value)
                <?php

                $total_income = $total_income + $value->GrandTotal;

                ?>

                <tr>
                    <td width="25">Sales</td>
                    <td width="25">{{ $value->DescriptionNotes }}</td>
                    <td width="25">{{ $value->InvoiceNo }}</td>
                    <td width="25">{{ $value->party->PartyName }}</td>
                    <td width="25">
                        <div align="right">{{ number_format($value->GrandTotal, 2) }}</div>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25"><strong>TOTAL</strong></td>
                <td width="25">
                    <div align="right">{{ number_format($total_income, 2) }}</div>
                </td>
            </tr>
            <tr>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25"><strong>EXPENSE</strong></td>
                <td width="25">
                    <div align="right">{{ number_format($total_expense, 2) }}</div>
                </td>
            </tr>
            <tr>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25"><strong>BALANCE</strong></td>
                <td width="25">
                    <div align="right">{{ number_format($total_income - $total_expense, 2) }}</div>
                </td>
            </tr>
            <tr>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25"><strong>PREVIOUS BALANCE </strong></td>
                <td width="25">
                    <div align="right">{{ number_format($sql[0]->Balance, 2) }}</div>
                </td>
            </tr>
            <tr>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25">&nbsp;</td>
                <td width="25"><strong>TOTAL</strong></td>
                <td width="25">
                    <div align="right">{{ number_format($sql[0]->Balance + ($total_income - $total_expense), 2) }}</div>
                </td>
            </tr>
        </table>
        <p></p>
        <p>&nbsp; </p>
    </div>
</body>

</html>
