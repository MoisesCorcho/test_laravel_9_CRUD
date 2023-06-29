<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use App\Enums\EnumOptions;

use App\Models\User;
use App\Http\Controllers\BaseController;
class UpdateUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $baseController = new BaseController();
        $user   = User::query()->where('id', request()->id)->first();

        if (is_null($user)) {
            return [];
        }

        return [
            'firstName'     => 'required|max:255',
            'lastName'      => 'required|max:255',
            'photo'         => 'nullable',
            'cellphone'     => 'nullable',
            'email'         => 'nullable|email|unique:users,email,'. request()->id,
            'dniType'       => ['nullable', Rule::in(EnumOptions::getValues())],
            'dni'           => 'nullable|unique:users,dni,'. request()->id,
            'active'        => 'nullable',
            'visitsPerDay'  => 'nullable|integer|min:5',
            'password'      => 'nullable',
            'role_id'       => 'nullable|exists:roles,id'
        ];
    }
}
