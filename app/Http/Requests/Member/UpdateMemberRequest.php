<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use App\Enums\EnumOptions;

use App\Models\Member;
use App\Http\Controllers\BaseController;

class UpdateMemberRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $baseController = new BaseController();
        $member         = Member::query()->where('id', request()->id)->first();

        if (is_null($member)) {
            return [];
        }

        return [
            'firstName'        => 'required|max:255',
            'lastName'         => 'required|max:255',
            'dniType'          => ['required', Rule::in(EnumOptions::getValues())],
            'dni'              => 'required|unique:members,dni,'. request()->id,
            'address'          => 'nullable',
            'cellphone1'       => 'nullable',
            'cellphone2'       => 'nullable',
            'phone'            => 'nullable',
            'birthday'         => 'nullable',
            'email'            => 'nullable|email|unique:members,email,'. request()->id,
            'memberPositionId' => 'required|exists:memberPositions,id',
            'organizationId'   => 'required|exists:organizations,id',
        ];
    }

}
