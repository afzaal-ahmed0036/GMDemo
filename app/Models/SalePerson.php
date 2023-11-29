<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePerson extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'UserID';
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id', 'UserID');
    }
}
