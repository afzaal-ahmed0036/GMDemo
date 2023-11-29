<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table ='invoice_detail';
    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'InvoiceDetailID';

}
