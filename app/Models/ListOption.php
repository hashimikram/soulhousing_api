<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListOption extends Model
{
    use HasFactory;

    public function problemsWithType()
    {
        return $this->hasMany(Problem::class, 'type_id');
    }

    public function problemsWithChronicity()
    {
        return $this->hasMany(Problem::class, 'chronicity_id');
    }

    public function problemsWithSeverity()
    {
        return $this->hasMany(Problem::class, 'severity_id');
    }

    public function problemsWithStatus()
    {
        return $this->hasMany(Problem::class, 'status_id');
    }



    public function allergyWithType()
    {
        return $this->hasMany(Allergy::class, 'allergy_type');
    }

    public function allergyWithSeverity()
    {
        return $this->hasMany(Allergy::class, 'severity');
    }

    public function allergyWithReaction()
    {
        return $this->hasMany(Allergy::class, 'reaction');
    }
}
