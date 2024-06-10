<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userDetail extends Model
{
    use HasFactory;

    public function profile()
    {
        return $this->belongsTo(User::class,'user_id');
    }
<<<<<<< HEAD

    public function comment()
    {
        return $this->hasMany(Comment::class,'user_id');
    }
=======
>>>>>>> e38328c8e344df74e0aaed970b850148fd6f728b
}
