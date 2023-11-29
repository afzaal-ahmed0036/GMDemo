<h5>Unpaid Invoices</h5>

@if(count($invoice_balance) > 0)

<table class="table table-stipped table-sm " style="width: 70%;" >
  <thead>
    <tr class="bg-light ">
      <th class="col-md-3">Date</th>
      <th class="col-md-2">Invoice Number</th>
      <th class="col-md-2">Invoice Amount</th>
      <th class="col-md-2">Amount Due</th>
      <th class="col-lg-1">Payment</th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoice_balance as $key => $value)

 

    <tr id="ember2180">
      <td>{{dateformatman($value->Date)}} <br />
      Due Date:&nbsp;{{dateformatman($value->DueDate)}}</td>
      <td>{{$value->InvoiceNo}}</td>
      <td class="text-start">{{number_format($value->INVOICE,2)}}</td>
      <td class="text-start balance"><div class="balance">{{number_format($value->BALANCE,2)}}</div></td>
      <td><div align="right"><input name="Amount[]" type="text" id="ember2181" class="col-md-8 payment1 form-control form-control-sm" style="width:100%;" />
      <input name="InvoiceMasterID[]" type="hidden" id="ember2181" class="col-md-8 payment" value="{{$value->InvoiceMasterID}}" />
    </div>
      
    </td>
  </tr>
  @endforeach
  <tr>
    <td colspan="1">**List contains only SENT invoices</td>
    <td></td>
    <td class="text-start">Total</td>
    <td class="text-start"><div id="AmountDue">{{$invoice_party_balance[0]->BALANCE}}</div>
<td><input type="text" name="PaymentTotal" id="paymenttotal" style="width:100%;" class="form-control form-control-sm"></td>
    </td>
  </tr>
  <tr>
    <td colspan="5" >
      <div class="row mx-0 mt-3  " ><div class="unused-amount-zero offset-lg-7 col-lg-5 clearfix ">
        <div class="row ">
<p class="col-lg-7 text-end">Amount Received :</p> 
<p class="col-lg-5 text-end" id="received"> 0.00 </p></div> <div class="row">
<p class="col-lg-7 text-end">Amount used for Payments :</p> 
<p class="col-lg-5 text-end" id="amountused"> 0.00 </p></div> <div class="row">
<p class="col-lg-7 text-end">Amount Refunded :</p> 
<p class="col-lg-5 text-end"> 0.00 </p></div> <div class="row">
<p class="col-lg-7 text-end">   Amount in Excess: </p> 
<p class="col-lg-5 text-end" id="excess"> AED&nbsp; 0.00 </p></div></div></div>
    </td>
  </tr>
</tbody>
</table>

<input type="hidden" name="Due" value="{{$invoice_party_balance[0]->BALANCE}}">

@else


<div class="alert alert-danger" role="alert">
Sorry no unpaid invoice found
</div>

@endif

