<?php

$signature = DB::table('company')->where('CompanyID', '1')->get();

?>
<div style="margin-top:30px; float: right;">
	<hr>
  <label style="display: table-cell;font-size: 10pt;padding-right: 5px;" class="pcs-label">Authorized Signature</label>
  <br>
  <div style="display: table-cell;">
    <img src="{{ asset('documents') }}/{{ $signature[0]->Signature }}" height="135px">
    <strong><p class="text-center"><?php echo  $signature[0]->DigitalSignature;  ?></p></strong>
  </div>

</div>

</div>