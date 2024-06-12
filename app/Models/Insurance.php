<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $fillable = [
        'provider_id',
        'patient_id',
        'insurance_name',
        'policy_no',
        'subscriber',
        'subscriber_relation',
        'insurance_type',
    ];
}
