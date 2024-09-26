<?php

namespace App\Http\Requests\MerchantPrepayment;

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
        $merchantPrepayment = $this->route()->parameter('merchant_prepayment');

        return [
            'merchant_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Merchant,id,deleted_at,NULL',
            ],
            'currency_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'amount' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'exchange_rate' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6,unsigned',
            ],
            'base_currency_id' => [
                'prohibited',
            ],
        ];
    }
}
