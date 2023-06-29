<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Member;
use App\Traits\Uuid;

class MemberPosition extends Model
{
    use HasFactory, Uuid;

    protected $table        = 'memberPositions';
    protected $keyType      = 'uuid';
    public    $incrementing = false;

}
