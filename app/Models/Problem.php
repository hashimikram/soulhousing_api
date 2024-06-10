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

    public function type()
    {
        return $this->belongsTo(ListOption::class, 'type_id');
    }

    public function chronicity()
    {
        return $this->belongsTo(ListOption::class, 'chronicity_id');
    }

    public function severity()
    {
        return $this->belongsTo(ListOption::class, 'severity_id');
    }

    public function status()
    {
        return $this->belongsTo(ListOption::class, 'status_id');
    }
<<<<<<< HEAD
=======

    public function patients()
    {
        return $this->belongsTo(patient::class, 'patient_id');
    }
>>>>>>> e38328c8e344df74e0aaed970b850148fd6f728b
}
