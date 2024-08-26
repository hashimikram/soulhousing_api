<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

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


}
