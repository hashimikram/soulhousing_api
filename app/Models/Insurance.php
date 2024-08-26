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
        'group_name',
        'policy_no',
        'policy',
        'policy_holder',
        'address',
        'state',
        'city',
        'zip_code',
        'ins_phone',
        'policy_holder_dob',
        'age',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
