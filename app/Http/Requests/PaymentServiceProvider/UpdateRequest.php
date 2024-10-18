<?php

namespace App\Http\Requests\PaymentServiceProvider;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $paymentServiceProvider = $this->route('payment_service_provider');

        return [
            'name' => [
                "unique:App\Models\PaymentServiceProvider,name,$paymentServiceProvider->id",
                'filled',
                'string',
                'max:255',
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
            'balance' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'deposit' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
        ];
    }
}
