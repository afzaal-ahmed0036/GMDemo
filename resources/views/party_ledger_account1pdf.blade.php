<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{$pagetitle}}</title>
    <style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
body,td,th {
	font-size: 13px;
}
-->
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="center" class="style1">{{session::get('CompanyName')}}</div>

<div align="center" >{{$company[0]->Address}}</div>
<div align="center" >TRN : {{$company[0]->TRN}}</div>
    </td>
  </tr>
  <tr>
    <td colspan="2"><div align="center" class="style1">{{$party[0]->PartyName}} </div><div align="center">Ledger Account</div><div align="center">TRN : {{$party[0]->TRN}}</div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">Contact : {{$party[0]->Phone}}</div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">From {{dateformatman(session::get('StartDate'))}} To {{dateformatman(session::get('EndDate'))}}
    </div></td>
  </tr>
  <tr>
    <td width="50%">Dated: {{date('d-m-Y')}}</td>
    <td width="50%">&nbsp;</td>
  </tr>
</table>
        <p>
          <?php 
            $DrTotal=0;
            $CrTotal=0;
          
		       ?>
          @if(count($journal)>0) </p>
        <table width="100%" border="1" align="center" cellpadding="3" style="border-collapse: collapse;">
          <tbody><tr>
          <th bgcolor="#CCCCCC"  ><div align="center">DATE</div></th>
          <th bgcolor="#CCCCCC"   ><div align="center">PARTICULAR</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">VOUCHER TYPE</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">VOUCHER #</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">DR</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">CR</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">Balance</div></th>
           </tr>
          </tbody>
          <tbody>
            <tr> 
  <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center">Opending Balance</div></td>
            <td><div align="right"></div></td>
            <td><div align="right"></div></td>
            <td  ><div align="right">{{$sql[0]->Balance}}</div></td>
			</tr>
          @foreach ($journal as $key =>$value)
           <tr>
           <td  ><div align="center">{{dateformatman($value->Date)}}</div></td>
           <td  ><div align="center">TO Sales</div></td>
           <td ><div align="center">Sales</div></td>
           <td align="center">{{$value->VHNO}}</td>
           <td  > <div align="right">{{($value->Dr==0) ? '' : number_format($value->Dr,2)}}</div></td>
           <td  > <div align="right">{{($value->Cr==0) ? '' : number_format($value->Cr,2)}}</div></td>
           <td  >
               

               <div align="right">
                 <?php 

if(!isset($balance)) { 

             $balance  =  $sql[0]->Balance + ($value->Dr-$value->Cr);
             $DrTotal = $DrTotal+$value->Dr;
             $CrTotal = $CrTotal+$value->Cr;
             echo $balance;


}
else
{
  $balance = $balance + ($value->Dr-$value->Cr);
  $DrTotal = $DrTotal+$value->Dr;
             $CrTotal = $CrTotal+$value->Cr;
  echo $balance;
}
              ?>
             {{($balance>0) ? "DR" : "CR"}} </div></td>
           </tr>
           @endforeach   
          <tr  class="table-active">
              
           <td></td>
           <td></td>
           <td align="center">TOTAL</td>
            <td  ></td>
           <td  ><div align="right">{{number_format($DrTotal,2)}}</div></td>
           <td  ><div align="right">{{number_format($CrTotal,2)}}</div></td>
            
            <td  > <div align="right"></div></td>
          </tr>
           </tbody>
</table>
           @else
             <p class=" text-danger">No data found</p>
           @endif
		   
		   
</body>
</html>