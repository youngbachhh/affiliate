<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'role_id' => [
                'required',
                'numeric',
            ],
            'referral_code' => [
                'nullable',
                'string',
                'max:255',
            ],
            'referrer_id' => [
                'nullable',
                'string',
                'exists:users,id',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:15',
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                'in:active,inactive,pending',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        return false;
    }
}
