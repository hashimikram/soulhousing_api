<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Set this to your roles table name

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }


    public function roleUsers()
    {
        return $this->hasMany(RoleUser::class, 'role_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
