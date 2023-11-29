<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishRecipe extends Model
{
    protected $fillable = ['dish_id','dish_type_id','item_id','base_unit_amount_cooked','child_unit_amount_cooked'];
    use HasFactory;

    public function dish_type()
    {
        return $this->belongsTo(DishType::class);
    }
    
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'ItemID');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
