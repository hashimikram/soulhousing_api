<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionDischarge extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
