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
        'plan_name',
        'effective_date',
        'effective_date_end',
        'policy_number',
        'group_number',
        'subscriber_employee',
        'se_address',
        'se_address_2',
        'se_city',
        'se_state',
        'se_zip_code',
        'se_country',
        'relationship',
        'subscriber',
        'date_of_birth',
        'gender',
        's_s',
        'subscriber_address',
        'subscriber_address2',
        'city',
        'state',
        'zip_code',
        'country',
        'subscriber_phone',
        'co_pay',
        'accept_assignment',
        'secondary_medicare_type',
    ];



}
