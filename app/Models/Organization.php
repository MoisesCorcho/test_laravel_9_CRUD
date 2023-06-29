<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Traits\Uuid;

class Organization extends Model
{
    use HasFactory, Uuid;

   //Preguntale al lucho, asi lo viste en un tutorial pero no funcionaba
    // protected $primaryKey = 'uuid';
    // protected $keyType = 'string';
    // public $incrementing = false;

    protected $table        = 'organizations';
    protected $keyType      = 'uuid';
    public    $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'nit',
        'address',
        'cellphone',
        'phone',
        'email',
        'city',
        'sellerId'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerId');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'organizationId');
    }


}
