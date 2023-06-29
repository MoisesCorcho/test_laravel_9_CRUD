<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Survey;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $table = 'surveyQuestions';

    protected $fillable = [
        'type',
        'question',
        'description',
        'tableType',
        'data',
        'surveyId',
        'questionOfThingsToDo'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveyId');
    }

}
