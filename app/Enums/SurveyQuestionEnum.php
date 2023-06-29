<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum SurveyQuestionEnum: string
{
    case TYPE_TEXT     = 'text';
    case TYPE_TEXTAREA = 'textarea';
    case TYPE_SELECT   = 'select';
    case TYPE_RADIO    = 'radio';
    case TYPE_CHECKBOX = 'checkbox';
    case TYPE_DATE     = 'date';

    public static function getValues(): collection
    {
        return collect(self::cases())->pluck('value');
    }
}
