<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum EnumOptions: string
{
    case CC  = 'cc';
    case NIT = 'nit';

    public static function getValues(): Collection
    {
        return collect(self::cases())->pluck('value');
    }
}
