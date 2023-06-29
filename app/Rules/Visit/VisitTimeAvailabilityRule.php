<?php

namespace App\Rules\Visit;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Visit;
use Carbon\Carbon;

class VisitTimeAvailabilityRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return Visit::isTimeAvailable(
            request()->visitDate,
            $value,
            request()->endTime,
            request()->sellerId,
            request()->rescheduledDate
        );
    }


    public function message()
    {
        return 'Ya hay una cita agendada a esta hora.';
    }
}
