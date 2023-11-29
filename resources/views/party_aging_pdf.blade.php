<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{$pagetitle}}</title>

 <style type="text/css">

.style1 {font-size: 20px}

body,td,th {
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
}


 @page {
                margin-top: 0.5cm;
                margin-bottom: 0.5cm;
                margin-left: 0.5cm;
                margin-right: 0.5cm;
            }

 </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
	
<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><div align="center" class="style1">{{$company[0]->Name}} </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>A/R AGING REPORT  </strong></div></td>
    </tr>
    <tr>
      <td width="50%"></td>
	  <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    
    </tr>
  </table>
   
  <table width="100%" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse; border-color: #000000">
    <tr>
      <td width="5%" bgcolor="#9A9A9A"><div align="center"><strong>S#</strong></div></td>
      <td width="70%" bgcolor="#9A9A9A"><div align="left"><strong>CUSTOMERS</strong></div></td>
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>TOTAL</strong></div></td>
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>7 DAYS</strong></div></td>
      
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>15 DAYS</strong></div></td>
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>1-30 DAYS</strong></div></td>
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>31-60 DAYS</strong></div></td>
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>61-90 DAYS</strong></div></td>
      <td width="10%" bgcolor="#9A9A9A"><div align="center"><strong>90+ DAYS</strong></div></td>
      
       
    </tr>

<?php 

$Total=0;
$sevenDays=0;
$fifteenDays=0;
$thirtyDays=0;
$sixtyDays=0;
$nintyDays=0;
$nintyPlusDays=0;

?>

@foreach ($aging as $key => $value)
   	 
<?php 

$Total = $Total + $value->Total;
$Total=$Total+$value->age7Days;
$sevenDays=$sevenDays+$value->age7Days;0;
$fifteenDays=$fifteenDays+$value->age15Days;0;
$thirtyDays=$thirtyDays+$value->age30Days;0;
$sixtyDays=$sixtyDays+$value->age60Days;0;
$nintyDays=$nintyDays+$value->age90Days;0;
$nintyPlusDays=$nintyPlusDays+$value->age90plusDays;0;
 

 ?>
      
    
    <tr>
      <td><div align="center">{{$key+1}}</div></td>
      <td><div align="left">{{$value->PartyName}}</div></td>
      
      
       <td><div align="right">{{number_format($value->Total,2)}}</div></td>
       <td><div align="right">{{number_format($value->age7Days,2)}}</div></td>
       <td><div align="right">{{number_format($value->age15Days,2)}}</div></td>
       <td><div align="right">{{number_format($value->age30Days,2)}}</div></td>
       <td><div align="right">{{number_format($value->age60Days,2)}}</div></td>
       <td><div align="right">{{number_format($value->age90Days,2)}}</div></td>
       <td><div align="right">{{number_format($value->age90plusDays,2)}}</div></td>
   
      
       
    </tr>
@endforeach
 
<tr>

  <td></td>
  <td align="center"><strong>Total</strong></td>
  <td align="right">{{number_format($Total)}}</td>
  <td align="right">{{number_format($sevenDays)}}</td>
  <td align="right">{{number_format($fifteenDays)}}</td>
  <td align="right">{{number_format($thirtyDays)}}</td>
  <td align="right">{{number_format($sixtyDays)}}</td>
  <td align="right">{{number_format($nintyDays)}}</td>
  <td align="right">{{number_format($nintyPlusDays)}}</td>
  
  
</tr>



 
  </table>
   
</div>
</body>
</html>