<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'item';
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'ItemID';



    public function item()
    {
        return $this->hasMany('App\Models\DishRecipe', 'item_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'UnitID', 'id');
    }
}
