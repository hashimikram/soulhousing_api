<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable=[
        'provider_id',
        'patient_id',
        'title',
        'date',
    ];

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }
}
