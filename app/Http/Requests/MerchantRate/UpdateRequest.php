<?php

namespace App\Http\Requests\MerchantRate;

use App\Http\Requests\FormRequest;
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
        $merchantRate = $this->route('merchant_rate');

        return [
            'payment_type_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\PaymentType,id',
            ],
            'merchant_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Merchant,id,deleted_at,NULL',
            ],
            'rate' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'between:0,1',
            ],
            'platform_rate' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'between:0,1',
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
        ];
    }
}
