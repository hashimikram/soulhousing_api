<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $fillable = [
        'provider_id',
        'patient_id',
        'diagnosis',
        'cd_description',
        'select_1',
        'select_2',
        'select_3',
        'select_4',
        'select_5',
        'comments',
        'icd10',
        'snowed',
    ];
    use HasFactory;
}
