<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function details()
    {
        return $this->hasOne(userDetail::class, 'user_id');
    }

    public function beds()
    {
        return $this->hasOne(bed::class);
    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function operation()
    {
        return $this->hasMany(Operation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function userDetail()
    {
        return $this->hasOne(userDetail::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function patients()
    {
        return $this->hasMany(patient::class);
    }

    public function providerEncounters()
    {
        return $this->hasMany(PatientEncounter::class, 'provider_id');
    }

    public function providerPatientEncounters()
    {
        return $this->hasMany(PatientEncounter::class, 'provider_id_patient');
    }

    public function signedEncounters()
    {
        return $this->hasMany(PatientEncounter::class, 'signed_by');
    }

    public function admission()
    {
        return $this->hasMany(AdmissionDischarge::class, 'provider_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
