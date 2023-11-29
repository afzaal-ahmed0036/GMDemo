<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable =[

        "base_unit", "child_unit", "unit_value" ,"status"
    ];

    public function item()
    {
        return $this->hasMany('App\Models\Item', 'UnitID');
    }

}
