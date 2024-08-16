<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

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
}
