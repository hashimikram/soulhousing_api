<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medication extends Model
{
    use HasFactory;

    public function patients()
    {
        return $this->belongsTo(patient::class,'patient_id');
    }
}
