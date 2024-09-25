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
        'facility_id',
        'auth_date',
        'group_name',
        'member_id',
        'authorization_no',
        'state',
        'ins_phone',
        'policy_holder_dob',
        'age',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
