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
      <td colspan="2"><div align="center" class="style1">{{session::get('CompanyName')}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>SUPPLIER WISE  SALE </strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
	  <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
  <table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <tr>
      <td width="5%" bgcolor="#CCCCCC"><div align="left"><strong>S.NO</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="left"><strong>INVOICE#</strong></div></td>
      <td width="30%" bgcolor="#CCCCCC"><div align="left"><strong>SUPPLIER</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="left"><strong>REFERENCE#</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="right"><strong> TOTAL</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>TAX </strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>DISCOUNT </strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>GRAND </strong></div></td>
    </tr>
   @foreach ($invoice_master as $key => $value)
   	
    
    <tr>
       <td><div align="center">{{$key+1}}.</div></td>
      <td>{{$value->InvoiceNo}}</td>
      <td>{{$value->SupplierName}}</td>
      <td>{{$value->ReferenceNo}}</td>
       <td><div align="right">{{number_format($value->SubTotal,2)}}</div></td>
      <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
      <td><div align="right">{{number_format($value->DiscountAmount,2)}}</div></td>
      <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
    </tr>
@endforeach
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>