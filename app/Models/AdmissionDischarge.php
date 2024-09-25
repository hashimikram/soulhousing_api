<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionDischarge extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'provider_id',
        'admission_date',
        'discharge_date',
        'admission_reason',
        'discharge_reason',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(patient::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
