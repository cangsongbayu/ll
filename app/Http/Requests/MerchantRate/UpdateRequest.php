<?php

namespace App\Http\Requests\MerchantRate;

use App\Http\Requests\FormRequest;
use App\Models\MerchantRate;
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

        $rules = [
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

        if ($this->has('payment_type_id') && $this->has('merchant_id')) {
            $rules['payment_type_id'][] = function($attr, $value, $fail) use ($merchantRate) {
                $exists = MerchantRate::where('merchant_id', $this->input('merchant_id'))
                    ->where('payment_type_id', $this->input('payment_type_id'))
                    ->where('id', '<>', $merchantRate->id)
                    ->exists();
                if ($exists) {
                    return $fail('商户费率 已经存在。');
                }
                return true;
            };
        }

        return $rules;
    }
}
