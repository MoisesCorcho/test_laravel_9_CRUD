<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Organization;
use App\Models\MemberPosition;
use App\Traits\Uuid;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Member extends Model
{
    use HasFactory, Uuid;

    protected $table     = 'members';
    protected $keyType   = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'firstName',
        'lastName',
        'dniType',
        'dni',
        'address',
        'cellphone1',
        'cellphone2',
        'phone',
        'birthday',
        'email',
        'organizationId',
        'memberPositionId'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organizationId');
    }

    public function position()
    {
        return $this->belongsTo(MemberPosition::class, 'memberPositionId');
    }
}
