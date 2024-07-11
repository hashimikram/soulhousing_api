<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncounterTemplate extends Model
{
    protected $casts = [
        'encounter_template' => 'array',
    ];
    use HasFactory;
}
