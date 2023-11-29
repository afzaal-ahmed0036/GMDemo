<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishType extends Model
{
    protected $fillable = ['dish_id','type','price','image','code'];
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function dish_recipe()
    {
        return $this->hasMany(DishRecipe::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function invoices()
    {
        return $this->hasMany(InvoiceDishDetail::class);
    }

}
