<?php

namespace App\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\VisitStatusEnum;
use Illuminate\Validation\Rule;
use App\Rules\Visit\VisitTimeAvailabilityRule;

class updateVisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rescheduledDate'       => [
                    'nullable',
                    'date_format:' . config('panel.date_format'),
                    'after_or_equal:'.now('America/Bogota')->toDateString()
            ],
            'reasonForNotVisitDesc' => 'nullable',
            'status'                => ['required', Rule::in(VisitStatusEnum::getValues())],
            'sellerId'              => 'required|exists:users,id',
            'reasonForNotVisitId'   => 'nullable|exists:reasonForNotVisits,id',
            'organizationId'        => 'required|exists:organizations,id',
            'surveyId'              => 'nullable|exists:surveys,id',
        ];
    }
}
