<?php

namespace App\Enums;

use Illuminate\Support\Collection;

Enum VisitStatusEnum:string
{
    case SCHEDULED   = 'scheduled';
    case VISITED     = 'visited';
    case NOTVISITED  = 'notVisited';
    case CANCELED    = 'canceled';
    case RESCHEDULED = 'rescheduled';

    public static function getValues():Collection
    {
        return collect(self::cases())->pluck('value');
    }
}
