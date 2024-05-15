<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;

    public function medication()
    {
        return $this->hasMany(medication::class,'patient_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function problems(){
        return $this->hasMany(Problem::class,'patient_id');
    }
}
