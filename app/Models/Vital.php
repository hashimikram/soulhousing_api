<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    protected $fillable = [
        'patient_id',
       'provider_id',
        'vital_type',
        'blood_sugar',
        'time',
        'pulse_result',
        'pulse_rhythm',
        'pulse_time',
        'body_temperature_result_f',
        'body_temperature_result_c',
        'body_temperature_method',
        'body_temperature_time',
        'respiration_result',
        'respiration_pattern',
        'respiration_time',
        'oxygenation_saturation',
        'oxygenation_method',
        'oxygenation_device',
        'oxygenation_oxygen_source',
        'oxygenation_time',
        'oxygenation_inhaled_02_concentration',
        'oxygenation_oxygen_flow',
        'oxygenation_time_2',
        'oxygenation_peak_flow',
        'oxygenation_time_3',
        'office_tests',
        'office_tests_date',
        'office_tests_pain_scale',
        'office_tests_date_2',
        'office_tests_comments',
    ];
    use HasFactory;
}
