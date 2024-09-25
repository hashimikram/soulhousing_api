<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class scheduling extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(patient::class, 'patient_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

}
