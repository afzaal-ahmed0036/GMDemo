<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $table = 'party';
    protected $primaryKey = 'PartyID';
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id', 'PartyID');
    }
    public function invoiceMaster(){
        return $this->hasMany(InvoiceMaster::class, 'PartyID');
    }
}
