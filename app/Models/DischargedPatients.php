<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DischargedPatients extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'patient_id',
        'admission_id',
        'date_of_discharge',
        'acknowledgment_of_discharge',
        'release_of_liability',
        'acknowledgment_of_receipt_of_belongings_and_medication',
        'belongings',
        'medications',
        'patient_signature',
        'staff_witness_signature',
        'patient_signature_date',
        'staff_signature_date',
    ];
}
