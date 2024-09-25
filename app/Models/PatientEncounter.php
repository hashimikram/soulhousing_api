<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientEncounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'signed_at',
        'encounter_type',
        'encounter_template',
        'reason',
        'location',
        'specialty',
        'encounter_date',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function encounter_notes()
    {
        return $this->hasMany(EncounterNoteSection::class, 'encounter_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'location');
    }

    public function providerPatient()
    {
        return $this->belongsTo(User::class, 'provider_id_patient');
    }

    public function patient()
    {
        return $this->belongsTo(patient::class, 'patient_id');
    }

    public function signedBy()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function encounterType()
    {
        return $this->belongsTo(ListOption::class, 'encounter_type');
    }

    public function specialty_type()
    {
        return $this->belongsTo(ListOption::class, 'specialty');
    }

    public function parentEncounter()
    {
        return $this->belongsTo(PatientEncounter::class, 'parent_encounter');
    }
}
