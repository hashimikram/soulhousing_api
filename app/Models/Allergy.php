<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{
    use HasFactory;

    public function allergy_type()
    {
        return $this->belongsTo(ListOption::class, 'allergy_type');
    }

    public function severity()
    {
        return $this->belongsTo(ListOption::class, 'severity');
    }

    public function reaction()
    {
        return $this->belongsTo(ListOption::class, 'reaction');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
