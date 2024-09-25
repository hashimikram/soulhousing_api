<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'first_name',
        'middle_name',
        'last_name',
        'social_security_no',
        'medical_no',
        'age',
        'gender',
        'date_of_birth',
        'referral_source_1',
        'organization',
        'financial_class',
        'fin_class_name',
        'doctor_name',
        'account_no',
        'admit_date',
        'disch_date',
        'pre_admit_date',
        'nursing_station',
        'email',
        'other_contact_name',
        'other_contact_address',
        'other_contact_country',
        'other_contact_city',
        'other_contact_state',
        'other_contact_phone_no',
        'other_contact_cell',
        'relationship',
        'medical_dependency',
        'city',
        'state',
        'language',
        'phone_no',
        'zip_code',
        'country',
        'address',
        'facility_id',
        'profile_pic',
        'mrn_no',
        'other_email'
    ];

    public function medications()
    {
        return $this->hasMany(medication::class)->where('status', 'active');
    }

    public function encounters()
    {
        return $this->hasMany(PatientEncounter::class, 'patient_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function problems()
    {
        return $this->hasMany(Problem::class, 'patient_id');
    }


    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }


    public function admission()
    {
        return $this->hasOne(AdmissionDischarge::class)->where('status', '1');
    }

    public function allergies()
    {
        return $this->hasMany(Allergy::class);
    }


    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }

    public function room()
    {
        return $this->hasOneThrough(room::class, bed::class, 'patient_id', 'id', 'id', 'room_id');
    }

    public function floor()
    {
        return $this->hasOneThrough(floor::class, room::class, 'id', 'id', 'id', 'floor_id');
    }

    public function role()
    {
        return $this->belongsTo(RoleUser::class, 'user_id');
    }

    public function bed()
    {
        return $this->hasOne(bed::class, 'patient_id', 'id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class);
    }

    public function scheduling()
    {
        return $this->hasMany(scheduling::class, 'patient_id');
    }
}