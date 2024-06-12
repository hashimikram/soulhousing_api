<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncounterNoteSection extends Model
{
    use HasFactory;
<<<<<<< HEAD

=======
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
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
