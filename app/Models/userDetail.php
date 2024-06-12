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
=======
<<<<<<< HEAD
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102

    public function comment()
    {
        return $this->hasMany(Comment::class,'user_id');
    }
<<<<<<< HEAD
=======
=======
>>>>>>> e38328c8e344df74e0aaed970b850148fd6f728b
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
}
