<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public function tweets()
    {
        return $this->hasMany(Tweet::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function user_detail()
    {
        return $this->belongsTo(userDetail::class,'user_id');
    }
}