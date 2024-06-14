<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncounterNoteSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',
        'patient_id',
        'encounter_id',
        'section_title',
        'section_slug',
        'section_text',
        'sorting_order',
    ];
}
