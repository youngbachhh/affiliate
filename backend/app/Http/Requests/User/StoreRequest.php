<?php

namespace App\Http\Requests\User;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'email_verified_at' => [
                'nullable',
                'date',
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
            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, ApiResponse::error($validator->errors(), 422));
    }

    public function messages(): array {
        return [
            'required' => 'The :attribute field is required.',
        ];
    }

    public function attributes()
    {
        return parent::attributes();
    }
}
