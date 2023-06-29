<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surveys';

    protected $fillable = [
        'title',
        'status',
        'description',
        'createdBy',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class, 'surveyId');
    }

    public function sellers()
    {
        return $this->hasMany(User::class, 'surveyId');
    }
}
