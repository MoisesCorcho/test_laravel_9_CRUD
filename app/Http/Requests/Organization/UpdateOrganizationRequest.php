<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Organization;
use App\Http\Controllers\BaseController;
class UpdateOrganizationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $baseController = new BaseController();
        $organization   = Organization::query()->where('id', request()->id)->first();

        if (is_null($organization)) {
            return [];
        }

        return [
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'nit'         => 'required|unique:organizations,nit,'. request()->id,
            'address'     => 'nullable',
            'cellphone'   => 'nullable',
            'phone'       => 'nullable',
            'email'       => 'email|unique:organizations,email,'. request()->id,
            'city'        => 'nullable',
            'sellerId'    => 'required|exists:users,id'
        ];
    }
}
