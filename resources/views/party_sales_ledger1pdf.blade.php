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

<script type="text/php">
    if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("helvetica", "bold");
        $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
</script> 

          @if(count($journal)>0) </p>
        <table width="100%" border="1" align="center" cellpadding="3" style="border-collapse: collapse;">
          <tbody><thead>
          <th bgcolor="#CCCCCC"  ><div align="center">DATE</div></th>
          <th bgcolor="#CCCCCC"   ><div align="center">Customer</div></th>
          <th bgcolor="#CCCCCC"   ><div align="center">VHNO</div></th>
           <th bgcolor="#CCCCCC"  ><div align="center"> </div></th>
           <th bgcolor="#CCCCCC"  ><div align="center">Description</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">DR</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">CR</div></th>
          <th bgcolor="#CCCCCC"  ><div align="center">Balance</div></th>
           </thead>
          </tbody>
          <tbody>
            <tr> 
  <td><div align="center"></div></td>
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
           <td  ><div align="center">{{$value->PartyID}}</div></td>
           <td  ><div align="center">{{$value->VHNO}}</div></td>
           <td ><div align="center">{{($value->ChartOfAccountID!=110400) ? $value->ChartOfAccountName : '' }}</div></td>
           <td align="center" >{{$value->Narration}}{{($value->ChartOfAccountID==110400) ? 'SALES' : '' }}</td>
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


@if($value->ChartOfAccountID==410100)

<?php 

$invoice_detail = DB::table('v_invoice_detail')->where('InvoiceMasterID',$value->InvoiceMasterID)->get();
//410100 -> SALES
 ?>

           <tr>
             <td></td>
             <td></td>
             <td></td>
             <td >
               
               <table border="0" width="100%" cellpadding="0" cellspacing="0">
 
             @foreach ($invoice_detail as $key =>$value1)
                 <tr>
                    <td align="left" style="font-size: 8pt;" >{{$value1->ItemName}} {{$value1->Qty}} Qty x {{$value1->Rate}} Rate ={{$value1->Total}}</td>
                  
                 
                 </tr>
                 @endforeach

               </table>

             </td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
           </tr>

@endif



           @endforeach 




          <tr  class="table-active">
              
           <td></td>
            <td><div align="center"><strong>TOTAL</strong></div></td>
            <td  ></td>
            <td  ></td>
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