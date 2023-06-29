<?php

namespace App\Traits;

use Illuminate\Support\Str;

Trait Uuid
{
    protected static function boot()
    {
        parent::boot();

        static::creating( function ($model) {
            if( empty($model->id)){
                $model->id = Str::uuid();
            }
        });
    }
}
