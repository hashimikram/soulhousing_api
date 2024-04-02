<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;
    protected $fillable=[
        'floor_id',
        'room_name',
        'no_of_beds',
    ];

    public function floor()
    {
        return $this->belongsTo(floor::class);
    }

    public function beds()
    {
        return $this->hasMany(bed::class);
    }
}

