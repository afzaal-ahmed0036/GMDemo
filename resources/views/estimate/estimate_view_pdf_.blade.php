<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{{$pagetitle}}</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
@page { margin: 25px; }
  
 .footer {
                position: fixed; 
                bottom: 300px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                line-height: 35px;
            }
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td width="50%"><img src="{{URL('/documents/'.$company[0]->Logo)}}" width="188" height="104" /></td>
    <td width="50%" valign="top"><div align="right"><strong>{{$company[0]->Name}}</strong><br />
      {{$company[0]->Address}}<br />
      Contact:{{$company[0]->Contact}}<br />
      TRN:{{$company[0]->TRN}}<br />
    </div></td>
  </tr>
  <tr>
    <td height="45" colspan="2"><div align="center">
      <h3>ESTIMATE</h3>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>Bill To </td>
      </tr>
      <tr>
        <td><strong>{{$estimate[0]->PartyName}} - {{$estimate[0]->WalkinCustomerName}}</strong><br />
          Address: {{$estimate[0]->Address}}<br />
          Phone: {{$estimate[0]->Phone}}<br />
          TRN: {{$estimate[0]->TRN}}<br />          </td>
      </tr>
    </table></td>
    <td valign="bottom">
      <table width="75%"   align="right" cellpadding="0" cellspacing="0"  style="border: 0.01em solid #ccc">
        <tr  >
          <td width="50%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Estimate No  # </td>
          <td width="50%" style="border: 0.01em solid #ccc">{{$estimate[0]->EstimateNo}}</td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Date</td>
          <td width="50%" style="border: 0.01em solid #ccc">{{dateformatman($estimate[0]->EstimateDate)}}</td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Expiry Date </td>
          <td width="50%" style="border: 0.01em solid #ccc">{{dateformatman($estimate[0]->ExpiryDate)}}</td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Ref # </td>
          <td width="50%" style="border: 0.01em solid #ccc">{{$estimate[0]->ReferenceNo}}</td>
        </tr>
        
      </table>
      <p>&nbsp;</p>
    <p>&nbsp;</p>    </td></tr>
  <tr>
    <td colspan="2" valign="top"><strong>Subject:</strong></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">Description</td>
  </tr>
  <tr>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<table width="100%"   align="right" cellpadding="0" cellspacing="0"   style="border: 0.01em solid #ccc">
      <tr bgcolor="#CCCCCC">
        <th height="20" ><div align="center"><strong>S#</strong></div></th>
        <th height="20" ><strong>Item  </strong></th>
        <th height="20" ><strong>Description</strong></th>
        <th height="20" ><div align="center"><strong>Qty</strong></div></th>
        <th height="20" ><div align="center"><strong>Rate</strong></div></th>
        <th height="20" ><div align="center"><strong>Amount</strong></div></th>
      </tr>
     
@foreach($estimate_detail as $key => $value)
      <tr >
        <td height="20"  style="border: 0.01em solid #ccc" ><div align="center">{{$key+1}}</div></td>
        <td height="20" style="border: 0.01em solid #ccc" >{{$value->ItemName}}</td>
        <td height="20" style="border: 0.01em solid #ccc" >{{$value->Description}}</td>
        <td height="20" style="border: 0.01em solid #ccc" ><div align="center">{{$value->Qty}}</div></td>
        <td height="20"  style="border: 0.01em solid #ccc" ><div align="center">{{number_format($value->Rate,2)}}</div></td>
        <td height="20" style="border: 0.01em solid #ccc" ><div align="right">{{number_format($value->Total,2)}}</div></td>
      </tr>
@endforeach
 
<?php  for($i = 10; $i>=count($estimate_detail);$i--) { ?>

    <tr >
        <td height="20"  style="border: 0.01em solid #ccc" ><div align="center"></div></td>
        <td height="20" style="border: 0.01em solid #ccc" ></td>
        <td height="20" style="border: 0.01em solid #ccc" ></td>
        <td height="20" style="border: 0.01em solid #ccc" ><div align="center"></div></td>
        <td height="20"  style="border: 0.01em solid #ccc" ><div align="center"></div></td>
        <td height="20" style="border: 0.01em solid #ccc" ><div align="right"></div></td>
      </tr>

<?php } ?>


    </table></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="footer" >
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"  >
      <tr>
        <td><strong>Customer Notes:</strong> </td>
      </tr>
      <tr>
        <td>{{$estimate[0]->CustomerNotes}}</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Description Notes: </strong></td>
      </tr>
      <tr>
        <td>{{$estimate[0]->DescriptionNotes}}</td>
      </tr>
    </table></td>
    <td valign="top"><table width="85%"  align="right" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border: 0.01em solid #ccc; ">
      <tr>
        <td width="49%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Sub Total </td>
        <td width="51%" style="border: 0.01em solid #ccc"><div align="right">{{number_format($estimate[0]->SubTotal,2)}}</div></td>
      </tr>
      <tr>
        <td width="49%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Tax @ {{$estimate[0]->TaxPer}} % </td>
        <td width="51%" style="border: 0.01em solid #ccc"><div align="right">{{number_format($estimate[0]->Tax,2)}}</div></td>
      </tr>
      <tr>
        <td width="49%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Total</td>
        <td width="51%" style="border: 0.01em solid #ccc"><div align="right">{{number_format($estimate[0]->Total,2)}}</div></td>
      </tr>
      <tr>
        <td width="49%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Discount {{$estimate[0]->DiscountPer}} % </td>
        <td width="51%" style="border: 0.01em solid #ccc"><div align="right">{{number_format($estimate[0]->Discount,2)}}</div></td>
      </tr>
      <tr>
        <td width="49%" bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Shipping</td>
        <td width="51%" style="border: 0.01em solid #ccc"><div align="right">{{number_format($estimate[0]->Shipping,2)}}</div></td>
      </tr>
      <tr>
        <td bgcolor="#E2E2E2" style="border: 0.01em solid #ccc">Grand Total </td>
        <td style="border: 0.01em solid #ccc"><div align="right">{{number_format($estimate[0]->GrandTotal,2)}}</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><br />
        <strong>In words </strong>: <em>{{ucwords(convert_number_to_words($estimate[0]->GrandTotal))}} only/-</em></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><div align="right">
      <p><img src="{{URL('/documents/'.$company[0]->Signature)}}" width="200"  /></p>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
