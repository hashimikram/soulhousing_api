<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEncounter extends Model
{
    use HasFactory;
    protected $fillable=[
        'patient_id',
        'signed_at',
        'encounter_type',
        'encounter_template',
        'reason',
    ];
}
