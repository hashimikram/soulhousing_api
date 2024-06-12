<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vital extends Model
{
    protected $fillable = [
        'provider_id',
        'patient_id',
        'date',
        'weight_lbs',
        'weight_oz',
        'weight_kg',
        'height_ft',
        'height_in',
        'height_cm',
        'bmi_kg',
        'bmi_in',
        'bsa_cm2',
        'waist_cm',
        'systolic',
        'diastolic',
        'position',
        'cuff_size',
        'cuff_location',
        'cuff_time',
        'fasting',
        'postprandial',
        'fasting_blood_sugar',
        'blood_sugar_time',
        'pulse_result',
        'pulse_rhythm',
        'pulse_time',
        'body_temp_result_f',
        'body_temp_result_c',
        'body_temp_method',
        'body_temp_time',
        'respiration_result',
        'respiration_pattern',
        'respiration_time',
        'saturation',
        'oxygenation_method',
        'device',
        'oxygen_source_1',
        'oxygenation_time_1',
        'inhaled_o2_concentration',
        'oxygen_flow',
        'oxygen_source_2',
        'oxygenation_time_2',
        'peak_flow',
        'oxygenation_time_3',
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        'office_test_oxygen_source_1',
        'office_test_date_1',
        'office_test_oxygen_source_2',
        'office_test_date_2',
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        'office_test_blood_group',
        'blood_group_date',
        'office_test_pain_scale',
        'pain_scale_date',
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        'almi',
        'muscle_mass',
        'fat_mass',
        'hand_grip',
        'VO2MAX'
<<<<<<< HEAD
=======
=======
>>>>>>> e38328c8e344df74e0aaed970b850148fd6f728b
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
    ];
    use HasFactory;
}
