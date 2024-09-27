<?php

namespace App\Http\Requests\PaymentType;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'unique:App\Models\PaymentType,name',
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'unique:App\Models\PaymentType,slug',
                'required',
                'string',
                'max:255',
            ],
            'valid_amount' => [
                'required',
                'string',
                'max:255',
                'regex:' . config('regex.valid_amount'),
            ],
            'order_ttl' => [
                'required',
                'integer',
                'between:60,1800',
            ],
            'business_hours' => [
                'required',
                'string',
                'max:255',
                'regex:' . config('regex.business_hours'),
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
        ];
    }
}
