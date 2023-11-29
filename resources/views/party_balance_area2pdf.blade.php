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

  @page {
                margin-top: 0.5cm;
                margin-bottom: 0.5cm;
                margin-left: 0.5cm;
                margin-right: 0.5cm;
            }

      table {
    border-left: 0.01em solid #ccc;
    border-right: 0;
    border-top: 0.01em solid #ccc;
    border-bottom: 0;
    border-collapse: collapse;
}
table td,
table th {
    border-left: 0;
    border-right: 0.01em solid #ccc;
    border-top: 0;
    border-bottom: 0.01em solid #ccc;
}  

.noborder_table {
    border-left: 0;
    border-right: 0;
    border-top: 0.;
    border-bottom: 0;
    border-collapse: collapse;
}

.noborder_table  td,
.noborder_table   th {
    border-left: 0;
    border-right: 0;
    border-top: 0;
    border-bottom: 0;
}    


-->
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
	

<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="noborder_table">
    <tr>
      <td colspan="2"><div align="center" class="style1">
        <div align="center">{{session::get('CompanyName')}} </div>
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><strong>Areawise Party Balances </strong></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">From {{dateformatman2(request()->StartDate)}} to {{dateformatman2(request()->EndDate)}}</td>
      <td width="50%"><div align="right">DATED: {{date('d-m-Y')}}</div></td>
    </tr>
  </table>
</div>
<?php 
            $GrandDrTotal=0;
            $GrandCrTotal=0;
            $GrandOpeningTotal=0;


           ?>

@foreach($city as $value1)

<span style="font-size: 16px; margin-top: 25px; color: red;"><strong>{{$value1->City}}</strong></span>


<?php 

$party = DB::table('party')->where('City',$value1->City)->get();
 ?>



 @if(count($party)>0)     
  <table width="100%"  >
    
<thead>
    <tr>
      <th width="10px" bgcolor="#CCCCCC"><div align="center"><strong>S.NO</strong></div></th>
      <th width="8%" bgcolor="#CCCCCC" ><div align="center"><strong>PARTY</strong></div></th>
      <th width="46%" bgcolor="#CCCCCC"><div align="left"><strong>NAME</strong></div></th>
      <th width="16%" bgcolor="#CCCCCC"><div align="right"><strong>O/BALANCE</strong></div></th>
      <th width="16%" bgcolor="#CCCCCC"><div align="right"><strong>DEBIT</strong></div></th>
      <th width="16%" bgcolor="#CCCCCC"><div align="right"><strong> CREDIT </strong></div></th>
      <th width="16%" bgcolor="#CCCCCC"><div align="right"><strong>BALANCE</strong></div></th>
    </tr>
</thead>
     <?php 
            $DrTotal=0;
            $CrTotal=0;
            $OpeningTotal=0;


           ?>

             
   @foreach ($party as $key => $value)
    

<?php 


$sql = DB::table('journal')
->select( DB::raw('sum(if(ISNULL(Dr),0,Dr)-if(ISNULL(Cr),0,Cr)) as Balance'))
// ->where('PartyID',$request->PartyID)
->where('PartyID',$value->PartyID)
->where('Date','<',request()->StartDate)
->where('ChartOfAccountID',110400)
 ->get();
 
$sql[0]->Balance = ($sql[0]->Balance ==null) ? '0' :  $sql[0]->Balance;



 $party1 = DB::table('journal')->select(DB::raw('sum(Dr) as Dr'),DB::raw('sum(Cr) as Cr'))
      ->whereBetween('date',array(request()->StartDate,request()->EndDate))
       ->where('PartyID',$value->PartyID)
       ->where('ChartOfAccountID',110400)
       ->get(); 

  

  $DrTotal=$DrTotal+$party1[0]->Dr;
  $CrTotal=$CrTotal+$party1[0]->Cr;
  $OpeningTotal=$OpeningTotal + $sql[0]->Balance;



  $GrandDrTotal=$GrandDrTotal+$party1[0]->Dr;
  $GrandCrTotal=$GrandCrTotal+$party1[0]->Cr;
  $GrandOpeningTotal=$GrandOpeningTotal + $sql[0]->Balance;




 ?>



    
    <tr>
      <td><div align="center">{{$key+1}}.</div></td>
      <td><div align="center">{{$value->PartyID}}</div></td>
      <td>{{$value->PartyName}}</td>
      <td><div align="right">{{number_format($sql[0]->Balance,2)}}</div></td>
      <td><div align="right">{{number_format($party1[0]->Dr,2)}}</div></td>
      <td><div align="right">{{number_format($party1[0]->Cr,2)}}</div></td>
      <td><div align="right">{{number_format(($sql[0]->Balance+$party1[0]->Dr)-$party1[0]->Cr,2)}}</div></td>
       
      </tr>
@endforeach
  
    <tr>
      <td></td>
      <td></td>
      <td><strong>TOTAL</strong></td>
      <td align="right"><strong>{{number_format($OpeningTotal,2)}}</strong></td>
      <td align="right"><strong>{{number_format($DrTotal,2)}}</strong></td>
      <td align="right"><strong>{{number_format($CrTotal,2)}}</strong></td>
      
      
      <td align="right"><strong>{{number_format(($OpeningTotal+$DrTotal)-($CrTotal),2)}}</strong></td>
    </tr>



  </table>      
  @else
<p class="text-danger">no record found</p>
  @endif


@endforeach  

  <table   border="1" width="100%">
    <tr>
      <td style="border-top: 1px dashed black;" width="29px"> </td>
      <td style="border-top: 1px dashed black;" width="47px;"></td>
      <td style="border-top: 1px dashed black;" width="283px"></td>
      <td style="border-top: 1px dashed black;" width="100px"></td>
      <td style="border-top: 1px dashed black;" width="98px"></td>
      <td style="border-top: 1px dashed black;" width="98px"></td>
      <td style="border-top: 1px dashed black;" width="65px"></td>
    </tr>
      <tr style="color: red;">
      <td width="29px"></td>
      <td width="47px"></td>
      <td width="283px"><strong>GRAND TOTAL</strong></td>
      <td width="100px" align="right"><strong>{{number_format($GrandOpeningTotal,2)}}</strong></td>
      <td width="98px" align="right"><strong>{{number_format($GrandDrTotal,2)}}</strong></td>
      <td width="98px" align="right"><strong>{{number_format($GrandCrTotal,2)}}</strong></td>
      <td width="65px" align="right"><strong>{{number_format(($GrandOpeningTotal+$GrandDrTotal)-($GrandCrTotal),2)}}</strong></td>
    </tr>
  </table>
            
  
</body>
</html>