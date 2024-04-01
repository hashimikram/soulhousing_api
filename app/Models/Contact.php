<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'provider_id',
        'patient_id',
        'type',
        'title',
        'first_name',
        'middle_name',
        'date_of_birth',
        'relationship',
        'email',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'home_phone',
        'work_phone',
        'mobile_number',
        'fax',
        'method_of_contact',
        'support_contact',
        'from_date',
        'to_date',
        'status',
        'indefinitely',
        'power_of_attorney',
        'from_date2',
        'to_date2',
        'status2',
        'indefinitely2',
        'power_of_attorney2',
        'from_date3',
        'to_date3',
        'status3',
        'indefinitely3',
    ];
    use HasFactory;
}
