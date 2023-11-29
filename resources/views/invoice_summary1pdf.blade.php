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
      <td colspan="2"><div align="center"><strong> INVOICE SUMMARY SALEMAN WISE</strong></div></td>
    </tr>
    <tr>
      <td width="50%">From {{request()->StartDate}} TO {{request()->EndDate}}</td>
	  <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
   
  
  <table width="100%" border="1" style="border-collapse: collapse;">
  <thead style="display: table-header-group;">
   <tr>
     <th width="5%" bgcolor="#CCCCCC"><div align="center"><strong>S#</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>PARTY/SUPPLIER</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>SALEMAN</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>SUBTOTAL</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>TAX</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>DISCOUNT</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>GRAND</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>PAID</strong></div></th>
      <th width="15%" bgcolor="#CCCCCC"><div align="left"><strong>BALANCE</strong></div></th>
      
   </tr>
  </thead>
  <tbody>
   @foreach ($invoice_summary as $key => $value)
    
    
   <tbody>
      <tr>
      
      <td><div align="center">{{$key+1}}</div></td>
      <td>{{$value->PartyName}}</td>
      <td>{{$value->FullName}}</td>
      <td>{{$value->SubTotal}}</td>
      <td>{{$value->Tax}}</td>
      <td>{{$value->DiscountAmount}}</td>
      <td>{{$value->GrandTotal}}</td>
      <td>{{$value->Paid}}</td>
      <td>{{$value->Balance}}</td>
    


    </tr>
   </tbody>
@endforeach
    <tr>
     
 <td></td>
 <td></td>
 <td></td>
 <td></td>
 
   
 <td>{{number_format($invoice_total[0]->Tax,2)}}</td>
 <td>{{number_format($invoice_total[0]->Discount,2)}}</td>
 <td>{{number_format($invoice_total[0]->GrandTotal,2)}}</td>
 <td>{{number_format($invoice_total[0]->Paid,2)}}</td>
 <td>{{number_format($invoice_total[0]->Balance,2)}}</td>
       
      
      
   </tr>

    

   
  </tbody>
</table>
</div>
</body>
</html>