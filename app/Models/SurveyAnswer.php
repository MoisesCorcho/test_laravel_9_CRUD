<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Survey;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'surveyAnswers';

    protected $fillable = [
        'date',
        'surveyId',
        'sellerId'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveyId');
    }
}
