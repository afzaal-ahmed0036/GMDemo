<?php

$chartofaccount = DB::table('chartofaccount')->get();


?>

@foreach($chartofaccount as $value)

<optgroup label="Eastern Time Zone" >
<option value="CT" >Connecticut</option>                                                   
</optgroup>

@endforeach