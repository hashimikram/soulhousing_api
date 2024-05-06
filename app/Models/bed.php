<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bed extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'patient_id',
        'comments',
        'bed_no',
        'occupied_at',
        'booked_till',
        'status'
    ];

    public function room()
    {
        return $this->belongsTo(room::class);
    }

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }
}
