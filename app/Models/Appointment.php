<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'appointments';

    protected $dates = [
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'finish_time',
    ];

    protected $fillable = [
        'price',
        'comments',
        'client_id',
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'employee_id',
        'finish_time',
    ];

    public function client()
    {
        return $this->belongsTo(Party::class, 'client_id');
    }

    public function saleperson()
    {
        return $this->belongsTo(SalePerson::class, 'employee_id');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
