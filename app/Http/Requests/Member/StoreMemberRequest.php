<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use App\Enums\EnumOptions;

class StoreMemberRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName'        => 'required|max:255',
            'lastName'         => 'required|max:255',
            'dniType'          => ['required', Rule::in(EnumOptions::getValues())],
            'dni'              => 'required|unique:members,dni',
            'address'          => 'nullable',
            'cellphone1'       => 'nullable',
            'cellphone2'       => 'nullable',
            'phone'            => 'nullable',
            'birthday'         => 'nullable',
            'email'            => 'nullable|email|unique:members,email',
            'memberPositionId' => 'required|exists:memberPositions,id',
            'organizationId'   => 'required|exists:organizations,id',
        ];
    }
}
