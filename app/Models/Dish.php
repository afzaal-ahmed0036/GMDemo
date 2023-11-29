<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = ['name','description','image_thumbnail','status'];
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function dish_types()
    {
        return $this->hasMany(DishType::class);
    }

    public function dish_images()
    {
        return $this->hasMany(DishImage::class);
    }

    public function dish_recipes()
    {
        return $this->hasMany(DishRecipe::class);
    }
}
