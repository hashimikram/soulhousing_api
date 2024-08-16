<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wound extends Model
{
    protected $fillable = [
        'provider_id',
        'patient_id',
        'encounter_id',
        'right_dp',
        'right_pt',
        'left_dp',
        'left_pt',
        'right_temp',
        'left_temp',
        'right_hair',
        'left_hair',
        'right_prick',
        'left_prick',
        'right_touch',
        'left_touch',
        'right_mono',
        'left_mono',
        'other_factor',
        'patient_education'
    ];

    public function details()
    {
        return $this->hasMany(WoundDetail::class);
    }

    use HasFactory;
}
