<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoundDetails extends Model
{
    protected $fillable = [
        'provider_id',
        'patient_id',
        'encounter_id',
        'wound_id',
        'location',
        'width',
        'type',
        'width_cm',
        'length_cm',
        'depth_cm',
        'area_cm',
        'exudate_amount',
        'exudate_type',
        'granulation_tissue',
        'wound_edges',
        'epithelialization',
        'clinical_signs_of_infection',
        'fibrous_tissue',
        'necrotic_tissue',
        'wound_bed',
        'undermining',
        'tunneling',
        'sinus_tract_cm',
        'exposed_structure',
        'periwound_color',
        'pain_level',
        'infection',
        'wound_duration',
        'status',
        'stage',
        'images',
    ];

    public function wound()
    {
        return $this->belongsTo(Wound::class);
    }

    use HasFactory;
}
