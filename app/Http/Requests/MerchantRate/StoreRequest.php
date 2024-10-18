<?php

namespace App\Http\Requests\MerchantRate;

use App\Models\MerchantRate;
use App\Models\SupplierRate;
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
        $rules = [
            'payment_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\PaymentType,id',
            ],
            'merchant_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Merchant,id,deleted_at,NULL',
            ],
            'rate' => [
                'required',
                'numeric',
                'decimal:0,6',
                'between:0,1',
                'gte:platform_rate',
            ],
            'platform_rate' => [
                'required',
                'numeric',
                'decimal:0,6',
                'between:0,1',
                'lte:rate',
                $this->validatePlatformRate(...),
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
            'valid_amount' => [
                'required',
                'string',
                'max:255',
                'regex:' . config('regex.valid_amount'),
            ],
        ];

        if ($this->has('payment_type_id') && $this->has('merchant_id')) {
            $rules['payment_type_id'][] = function($attr, $value, $fail) {
                $exists = MerchantRate::where('merchant_id', $this->input('merchant_id'))
                    ->where('payment_type_id', $this->input('payment_type_id'))
                    ->withTrashed()
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
