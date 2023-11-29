@extends('template.tmp')

@section('title', $pagetitle)
 

@section('content')



<div class="main-content">

 <div class="page-content">
 <div class="container-fluid">
  <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-print-block d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"> </h4>
                                        
 
                                </div>
                            </div>
                        </div>
 @if (session('error'))

 <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                    
                   {{ Session::get('error') }}  
                </div>

@endif

 @if (count($errors) > 0)
                                 
                            <div >
                <div class="alert alert-danger p-1   border-3">
                   <p class="font-weight-bold"> There were some problems with your input.</p>
                    <ul>
                        
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
                </div>
 
            @endif

            
            
  <div class="card">
      <div class="card-body">
       
<style type="text/css">
<!--
.style1 {font-size: 25px}
-->
</style>
<div class="pcs-template-body">
    <table style="width:100%;table-layout: fixed;">
      <tbody>
        <tr>
          <td style="vertical-align: top; width:50%;">
            <div><span class="style1 pcs-entity-title"><strong>{{$company[0]->Name}} </strong></span></div>
            
            {{$company[0]->Address}}</td>

          <td style="vertical-align: top; text-align:right;width:50%;">
            
            <span class="pcs-entity-title style1">{{$company[0]->DebitNoteTitle}} </span><span class="style1"><br>
            <b>DEBIT NOTE # {{$invoice_master[0]->InvoiceNo}}</b></span>          </td>
        </tr>
      </tbody>
  </table>


     <table style="width:100%;margin-top:30px;table-layout:fixed;">
      <tbody><tr>
      <td style="width:60%;vertical-align:bottom;word-wrap: break-word;">
         <div style="clear:both;width:50%;margin-top: 20px;">
             <label style="font-size: 10pt;" class="pcs-label" id="tmp_shipping_address_label">Supplier</label>
            <br>
            <span style="white-space: pre-wrap;" id="tmp_shipping_address"><strong><span class="pcs-customer-name" id="zb-pdf-customer-detail"><a href="#">{{$invoice_master[0]->SupplierName}}</a></span></strong>
{{$invoice_master[0]->Address}}
{{$invoice_master[0]->Phone}}
{{$invoice_master[0]->Email}}

</span>
         </div>

      </td>
      <td align="right" style="vertical-align:bottom;width: 40%;">
        <table style="float:right;table-layout: fixed;word-wrap: break-word;width: 100%;" border="0" cellspacing="0" cellpadding="0">
                 <tbody>

                     <tr>
                         <td style="text-align:right;padding:5px 10px 5px 0px;font-size:10pt;">
                            <span class="pcs-label"> Date :</span>
                        </td>
                        <td style="text-align:right;">
                            <span id="tmp_entity_date">{{$invoice_master[0]->Date}}</span>
                        </td>
                    </tr>
                    <tr>
                         <td style="text-align:right;padding:5px 10px 5px 0px;font-size: 10pt;">
                            <span class="pcs-label">Due Date# :</span>
                      </td>
                      <td style="text-align:right;">
                          <span id="tmp_ref_number">{{$invoice_master[0]->DueDate}}</span>
                      </td>
                    </tr>
                    <tr>
                         <td style="text-align:right;padding:5px 10px 5px 0px;font-size: 10pt;">
                            <span class="pcs-label">Ref# :</span>
                      </td>
                      <td style="text-align:right;">
                          <span id="tmp_ref_number">{{$invoice_master[0]->ReferenceNo}}</span>
                      </td>
                    </tr>



                 </tbody>
          </table>
      </td>
      </tr>
     </tbody></table>

<strong>Subject:</strong><br>
{{$invoice_master[0]->Subject}}
  <table style="width:100%;margin-top:20px;table-layout:fixed;" class="pcs-itemtable" border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr style="height:32px;">
                <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 0px 5px 5px;width: 5%;text-align: center;"><strong>
      #    </strong></td>
    <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 10px 5px 20px;width: ;text-align: left;"><strong> Item &amp; Description </strong></td>
    <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 10px 5px 5px;width: 11%;text-align: right;"><strong>
      Qty    </strong></td>
    <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 10px 5px 5px;width: 11%;text-align: right;"><strong>
      Rate    </strong></td>
    <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 10px 5px 5px;width: 11%;text-align: right;"><strong>
      Tax %    </strong></td>
    <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 10px 5px 5px;width: 11%;text-align: right;"><strong>
      Tax    </strong></td>
    <td bgcolor="#CCCCCC" class="pcs-itemtable-breakword pcs-itemtable-header" id="" style="padding: 5px 10px 5px 5px;width: 120px;text-align: right;"><strong>
      Amount    </strong></td>
        </tr>
    </thead>
     <tbody class="itemBody">
          
@foreach($invoice_detail as $key => $value)

            <tr class="breakrow-inside breakrow-after">

            <td valign="top" style="padding: 10px 0 10px 5px;text-align: center;word-wrap: break-word;" class="pcs-item-row">
            {{++$key}}            </td>
            <td valign="top" style="padding: 10px 0px 10px 20px;" class="pcs-item-row">
              <div>
              <div>
                
               
                <span style="white-space: pre-wrap;word-wrap: break-word;" class="pcs-item-desc" id="tmp_item_description">{{$value->ItemName}} </span>              </div>
              </div>            </td>









                <td valign="top" style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" class="pcs-item-row">
                  <span id="tmp_item_qty">{{$value->Qty}}</span>                </td>

            <td valign="top" style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;" class="pcs-item-row">
                  <span id="tmp_item_rate">{{$value->Rate}}</span>            </td>

            <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
              <span id="tmp_item_tax_rate">{{$value->TaxPer}}</span>            </td>
            <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
              <span id="tmp_item_tax_amount">{{$value->TaxAmount}}</span>            </td>
            <td valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
              <span id="tmp_item_amount">{{$value->Total}}</span>            </td>
          </tr>

@endforeach


    </tbody>
  </table>
   <div style="width: 100%;margin-top: 1px;">
    <div style="width: 45%;padding: 3px 10px 3px 3px;font-size: 9pt;float: left;">
      <div style="white-space: pre-wrap;"></div>
    </div>
    <div style="width: 50%;float:right;">
      <table class="pcs-totals" cellspacing="0" border="0" width="100%">
        <tbody>
          



          




          <tr style="height:40px;" class="pcs-balance">
            <td valign="middle" align="right" style="padding: 5px 10px 5px 0;"><b>Total</b></td>                                          <td id="tmp_total" valign="middle" align="right" style="width:120px;;padding: 10px 10px 10px 5px;"><b>{{$invoice_master[0]->Total}}</b></td> </tr>

             <tr style="height:40px;" class="pcs-balance">
            <td valign="middle" align="right" style="padding: 5px 10px 5px 0;"><b>Paid</b></td> <td id="tmp_total" valign="middle" align="right" style="width:120px;;padding: 10px 10px 10px 5px;"><b>{{$invoice_master[0]->Paid}}</b></td> </tr>


             <tr style="height:40px;" class="pcs-balance">
            <td valign="middle" align="right" style="padding: 5px 10px 5px 0;"><b>Balance</b></td> <td id="tmp_total" valign="middle" align="right" style="width:120px;;padding: 10px 10px 10px 5px;"><b>{{$invoice_master[0]->Balance}}</b></td> </tr>


        </tbody>
      </table>
    </div>
    <div style="clear: both;"></div>
  </div>

 

 


      <div style="margin-top:30px;">
        <label style="display: table-cell;font-size: 10pt;padding-right: 5px;" class="pcs-label">Note:</label>
          <div style="display: table-cell;">
              {{$invoice_master[0]->CustomerNotes}}
              <div></div>
          </div>
      </div>
    
</div>


      </div>
  </div>
  
  </div>
</div>

        </div>
      </div>
    </div>
    <!-- END: Content-->
 
  @endsection