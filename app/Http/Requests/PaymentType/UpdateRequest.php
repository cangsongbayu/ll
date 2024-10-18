<?php

namespace App\Http\Requests\PaymentType;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $paymentType = $this->route('payment_type');

        return [
            'name' => [
                "unique:App\Models\PaymentType,name,$paymentType->id",
                'filled',
                'string',
                'max:255',
            ],
            'code' => [
                "unique:App\Models\PaymentType,code,$paymentType->id",
                'filled',
                'string',
                'max:255',
            ],
            'valid_amount' => [
                'filled',
                'string',
                'max:255',
                'regex:' . config('regex.valid_amount'),
            ],
            'order_ttl' => [
                'filled',
                'integer',
                'between:60,1800',
            ],
            'business_hours' => [
                'filled',
                'string',
                'max:255',
                'regex:' . config('regex.business_hours'),
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
        ];
    }
}
