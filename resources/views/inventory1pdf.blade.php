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
      <td colspan="2"><div align="center"><strong>Stock Inventory </strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{dateformatman2(request()->StartDate)}} To {{dateformatman2(request()->EndDate)}}</td>
	  <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
    <?php 
            $TotalSaleReturn=0;
            $TotalQtyIn=0;
            $TotalQtyOut=0;
           


             ?>
  <table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;">
    <thead>
    <tr>
      <th width="5%" bgcolor="#CCCCCC"><div align="center"><strong>S#</strong></div></th>
      <th width="70%" bgcolor="#CCCCCC"><div align="left"><strong>ITEM NAME#</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>UNIT </strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>Sale Return</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>QTY IN</strong></div></th>
      
      <th width="15%" bgcolor="#CCCCCC"><div align="center"><strong>QTY OUT</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="right"><strong>BALANCE</strong></div></th>
       
    </tr>
    </thead>
   @foreach ($inventory as $key => $value)
   	 


<?php 

$TotalSaleReturn = $TotalSaleReturn + $value->SaleReturn;
$TotalQtyIn = $TotalQtyIn + $value->QtyIn;
$TotalQtyOut = $TotalQtyOut + $value->QtyOut;



 ?>
      
    
    <tr>
      <td><div align="center">{{$key+1}}</div></td>
      <td><div align="left">{{$value->ItemName}}</div></td>
      
      
       <td><div align="center">{{$value->UnitName}}</div></td>
       <td ><div align="center">{{      ($value->SaleReturn==0) ? '-' : number_format($value->SaleReturn)    }}</div></td>
       <td><div align="center">{{      ($value->QtyIn==0) ? '-' : number_format($value->QtyIn)    }}</div></td>
       <td><div align="center">{{      ($value->QtyOut==0) ? '-' : number_format($value->QtyOut)    }}</div></td>
       <td><div align="center"> {{number_format(($value->QtyIn+$value->SaleReturn)-$value->QtyOut)}}</div></td>
      
       
    </tr>
@endforeach

<tr>
  <td></td>
  <td>Total</td>
  <td></td>
  <td align="center">{{number_format($TotalSaleReturn)}}</td>
  <td align="center">{{number_format($TotalQtyIn)}}</td>
  <td align="center">{{number_format($TotalQtyOut)}}</td>
  <td align="center">{{number_format(($TotalQtyIn+$TotalSaleReturn)-$TotalQtyOut)}}</td>
  
 </tr>




 
  </table>
  <p>&nbsp;</p>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <th width="50%" scope="col">...................................................................</th>
      <th width="50%" scope="col">...................................................................</th>
    </tr>
    <tr>
      <td width="50%"><div align="center">Supervisor Name </div></td>
      <td width="50%"><div align="center">Date</div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>