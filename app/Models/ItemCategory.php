<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;
    protected $table = 'item_category';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'ItemCategoryID';
}
