<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{ 
    protected $fillable = ["PaymentReference","InvoiceMasterID","UserID","PartyID", "Amount","AmountPaidByCard", "Change","PayingMethod", "PaymentNote"];
}
