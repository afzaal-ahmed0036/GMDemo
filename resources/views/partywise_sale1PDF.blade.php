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
      <td colspan="2"><div align="center" class="style1">{{session::get('CompanyName')}}</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>PARTYWISE SALE (-) SALES RETURN </strong></div></td>
    </tr>
     <tr>
    <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}} </td>
    <td width="50%"><div align="right">Dated : {{date('d-m-Y')}}</div></td>
  </tr>
  </table>
  <table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <thead style="display: table-header-group;">
    <tr>
     <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>S.NO</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>INVOICE#</strong></div></td>
      <td width="50%" bgcolor="#CCCCCC"><div align="center"><strong>PARTY NAME</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>TOTAL </strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>DISCOUNT</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="right"><strong> TAX</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>TOTAL </strong></div></td>
    </tr>
  <?php 

$DiscountAmount=0;
$Tax=0;
$Shipping=0;
$GrandTotal=0;
$SubTotal=0;

 ?>
   @foreach ($party_wise as $key => $value)
     <?php 

$DiscountAmount  =  $DiscountAmount + $value->DiscountAmount;
$Tax  = $Tax+ $value->Tax;
$Shipping  = $Shipping +  $value->Shipping ;
$GrandTotal  = $GrandTotal+ $value->GrandTotal;
$SubTotal  = $SubTotal+ $value->SubTotal;

 ?> 
    
  <tr>
      <td><div align="center">{{$key+1}}.</div></td>
       <td><div align="center">{{$value->InvoiceNo}}</div></td>
       <td><div align="left">{{$value->PartyName}}</div></td>
      <td><div align="right">{{number_format($value->SubTotal,2)}}</div></td>
       <td><div align="right">{{number_format($value->DiscountAmount,2)}}</div></td>
      <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
      <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
    </tr>
@endforeach
 <tr>
     
       <td colspan="3"><div align="right"><STRONG>TOTAL</STRONG></div></td>
      <td><div align="right"><strong>{{number_format($SubTotal,2)}}</strong></div></td>
       <td><div align="right"><strong>{{number_format($DiscountAmount,2)}}</strong></div></td>
      <td><div align="right"><strong>{{number_format($Tax,2)}}</strong></div></td>
      <td><div align="right"><strong>{{number_format($GrandTotal,2)}}</strong></div></td>
       
    </tr>
  </table> 
  <p>&nbsp;</p>
</div>
</body>
</html>