<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

use App\Models\Visit;
use App\Traits\Uuid;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Uuid, SoftDeletes;

    protected $table        = 'users';
    protected $keyType      = 'uuid';
    public    $incrementing = false;

    protected $fillable = [
        'firstName',
        'lastName',
        'photo',
        'cellphone',
        'email',
        'dniType',
        'dni',
        'active',
        'visitsPerDay'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'sellerId');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'sellerId');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'createdBy');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveyId');
    }

    public function is_admin()
    {
        return Self::getRoleNames()[0] == "Admin" ? true : false;
    }

    //Accesor que retorna el nombre completo del usuario, pero no lo estoy usando.
    // protected function fullName():Attribute
    // {
    //     return new Attribute(
    //         get: fn() => $this->getAttribute('firstName') . ' ' . $this->getAttribute('lastName')
    //     );
    // }

}
