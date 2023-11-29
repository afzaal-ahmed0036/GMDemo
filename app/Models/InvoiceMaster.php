<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceMaster extends Model
{
    use HasFactory;
    protected $table = 'invoice_master';
    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'InvoiceMasterID';



    public function party(){
        return $this->belongsTo(Party::class, 'PartyID');
    }

    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class, 'InvoiceMasterID');
    }
}
