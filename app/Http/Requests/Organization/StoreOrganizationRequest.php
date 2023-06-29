<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
class StoreOrganizationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // dd(request());
        return [
            'name'        => 'required|max:255',
            'description' => 'nullable',
            'nit'         => 'required|unique:organizations,nit',
            'address'     => 'nullable',
            'cellphone'   => 'nullable',
            'phone'       => 'nullable',
            'email'       => 'nullable|email|unique:organizations,email',
            'city'        => 'nullable',
            'sellerId'    => 'nullable|exists:users,id'
        ];
    }
}
