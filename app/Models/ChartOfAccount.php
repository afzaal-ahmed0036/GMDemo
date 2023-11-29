<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;
    protected $table ='chartofaccount';
    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'ChartOfAccountID';
}
