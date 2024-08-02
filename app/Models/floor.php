<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class floor extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'floor_name'
    ];

    public function rooms()
    {
        return $this->hasMany(room::class);
    }

    public function beds()
    {
        return $this->hasManyThrough(bed::class, room::class);
    }
}
