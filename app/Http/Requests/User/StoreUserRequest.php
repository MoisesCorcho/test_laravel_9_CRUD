<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\EnumOptions;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstName'     => 'required|max:255',
            'lastName'      => 'required|max:255',
            'photo'         => 'nullable',
            'cellphone'     => 'nullable',
            'email'         => 'nullable|email|unique:users,email',
            'dniType'       => ['required', Rule::in(EnumOptions::getValues())],
            'dni'           => 'required|unique:users,dni',
            'active'        => 'required',
            'visitsPerDay'  => 'required|integer|min:5',
            'password'      => 'required',
            'role_id'       => 'required|exists:roles,id'
        ];
    }

    public function messages()
    {
        return [];
    }


}
