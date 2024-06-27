<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


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
            'price' => [
                'required',
                'numeric',
            ],
            'quantity' => [
                'required',
                'numeric',
            ],
            'product_unit' => [
                'nullable',
                'string',
            ],
            'category_id' => [
                'required',
                'numeric',
                'exists:categories,id',
            ],
            'product_unit' => [
                'nullable',
                'string',
            ],
            'description' => [
                'required',
                'string',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
            'is_new_arrival' => [
                'nullable',
                'boolean',
            ],
            'commission_rate' => [
                'nullable',
                'numeric',
                'between:0,100',
            ],
            'discount_id' => [
                'nullable',
                'numeric',
                'exists:discounts,id',
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
