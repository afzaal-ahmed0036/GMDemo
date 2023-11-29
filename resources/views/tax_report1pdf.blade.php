<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{$pagetitle}}</title>
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
      <td colspan="2"><div align="center" class="style1">{{$company[0]->Name}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>TAX REPORT </strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
	  <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
    <?php 
            $SubTotal=0;
            $Tax=0;
            $GrandTotal=0;
             ?>
  <table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <tr>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>DATE</strong></div></td>
      <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>INVOICE#</strong></div></td>
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>REF # </strong></div></td>
      <td width="30%" bgcolor="#CCCCCC"><div align="center"><strong>CUSTOMER</strong></div></td>
      
      <td width="8%" bgcolor="#CCCCCC"><div align="center"><strong>SUBTOTAL</strong></div></td>
      <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>TAX </strong></div></td>
       <td width="9%" bgcolor="#CCCCCC"><div align="right"><strong>GRAND TOTAL </strong></div></td>
    </tr>
   @foreach ($invoice_master as $key => $value)
   	 

      <?php  $SubTotal = $SubTotal + $value->SubTotal;
    $Tax = $Tax + $value->Tax;
    $GrandTotal = $GrandTotal + $value->GrandTotal;

    ?>
    
    <tr>
      <td><div align="center">{{dateformatman($value->Date)}}</div></td>
      <td><div align="center">{{$value->InvoiceNo}}</div></td>
      <td>{{$value->ReferenceNo}}</td>
      <td>{{$value->PartyName}}</td>
       <td><div align="center">{{number_format($value->SubTotal,2)}}</div></td>
      <td><div align="right">{{number_format($value->Tax,2)}}</div></td>
      <td><div align="right">{{number_format($value->GrandTotal,2)}}</div></td>
      
    </tr>
@endforeach
<tr>
      <td></td>
      <td></td>
      <td><strong> </strong></td>
      <td><strong>Total</strong></td>
      <td><div align="center">{{number_format($SubTotal,2)}}</div></td>
      <td><div align="right">{{number_format($Tax,2)}}</div></td>
      <td><div align="right">{{number_format($GrandTotal,2)}}</div></td>
      
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>