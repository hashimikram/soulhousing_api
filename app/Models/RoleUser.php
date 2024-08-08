<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_users'; // Set this to your roles table name

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
