<?php

namespace App\Http\Requests\Visit;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\VisitStatusEnum;
use Illuminate\Validation\Rule;

class rescheduleVisitRequest extends FormRequest
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
            'visitDate'             => [ //Aqui es donde se guardará la fecha de la visita reagendada
                'required',
                'date',
                'date_format:' . config('panel.date_format'),
                'after_or_equal:'.now('America/Bogota')->toDateString()],
            'rescheduledDate'       => [ //Aqui es donde se guardará la fecha de la visita antigua
                'nullable',
                'date_format:' . config('panel.date_format')
            ],
            'reasonForNotVisitDesc' => 'nullable',
            'status'                => ['nullable', Rule::in(VisitStatusEnum::getValues())],
            'sellerId'              => 'nullable|exists:users,id',
            'reasonForNotVisitId'   => 'nullable|exists:reasonForNotVisits,id',
            'organizationId'        => 'nullable|exists:organizations,id',
            'surveyId'              => 'nullable|exists:surveys,id',
        ];
    }
}
