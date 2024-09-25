<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function admissions()
    {
        return $this->hasMany(AdmissionDischarge::class, 'facility_id');
    }

    public function patients()
    {
        return $this->hasMany(patient::class, 'facility_id');
    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function operation()
    {
        return $this->hasMany(Operation::class);
    }

    public function encounters()
    {
        return $this->hasMany(PatientEncounter::class, 'location');
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function scheduling()
    {
        return $this->hasMany(scheduling::class, 'facility_id');
    }


}
