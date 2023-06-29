<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
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
            'title'            => 'required|string',
            'status'           => 'required|boolean',
            'description'      => 'nullable|string',
            'createdBy'        => 'exists:users,id',
            'questions'        => 'array'
        ];
    }
}
