<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable =[

        "name", "phone", "email", "address", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    	
    }

    public function product_warehouse()
    {
        return $this->hasMany('App\Models\Product_Warehouse');   
    }
}
