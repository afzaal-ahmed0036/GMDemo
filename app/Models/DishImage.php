<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishImage extends Model
{
    protected $fillable = ['dish_id','title','image'];
    use HasFactory;

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
