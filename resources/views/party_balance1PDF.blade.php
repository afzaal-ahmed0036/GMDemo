<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Party List</title>
    <style type="text/css">
<!--
.style1 {font-size: 20px}
body,td,th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}
-->
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
	

<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><div align="center" class="style1">
        <div align="center">{{session::get('CompanyName')}} </div>
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>PARTYWISE BALANCE </strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">{{(request()->ReportType=='C') ? 'Creditor Customers' : 'Debitor Customers' }}</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
      <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    </tr>
  </table>
</div>
<table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <tr>
      <td width="6%" bgcolor="#CCCCCC"><div align="center"><strong>S.NO</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>Party</strong></div></td>
      <td width="52%" bgcolor="#CCCCCC"><div align="center"><strong>NAME</strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="center"><strong>DEBIT</strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="center"><strong> CREDIT </strong></div></td>
      <td width="16%" bgcolor="#CCCCCC"><div align="right"><strong>BALANCE</strong></div></td>
      
    </tr>
   @foreach ($party as $key => $value)
   	
    
    <tr>
      <td><div align="center">{{$key+1}}.</div></td>
      <td><div align="center">{{$value->PartyID}}</div></td>
      <td><div align="left">{{$value->PartyName}}</div></td>
      <td><div align="center">{{number_format($value->Dr,2)}}</div></td>
      <td><div align="right">{{number_format($value->Cr,2)}}</div></td>
      <td><div align="right">{{number_format($value->Dr-$value->Cr,2)}}</div></td>
    </tr>
@endforeach
</table>
  <p>&nbsp;</p>
</body>
</html>