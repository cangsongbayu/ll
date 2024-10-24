<?php

namespace App\Http\Requests\MerchantRate;

use App\Http\Requests\FormRequest;
use App\Models\Merchant;
use App\Models\SupplierRate;

class BaseRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'rate' => '商户费率',
            'platform_rate' => '实际费率',
        ];
    }

    public function validatePlatformRate($attribute, $value, $fail)
    {
        $errors = $this->validator->errors();
        if ($errors->hasAny('payment_type_id')) {
            // 跳过检查
            return true;
        }
        $paymentTypeId = $this->input('payment_type_id');
        $minRate = SupplierRate::where('payment_type_id', $paymentTypeId)->max('rate');
        if (bccomp($value, $minRate, 6) < 0) {
            return $fail('实际费率 不能低于供应商费率。');
        }
        return true;
    }

    public function withValidator($validator): void
    {
        $validator->after(function($validator) {
            $merchantRate = $this->route('merchant_rate');
            $merchantId = is_null($merchantRate) ? $this->input('merchant_id') : $merchantRate->merchant_id;


            
            if ($merchantId) {
                $merchant = Merchant::find($merchantId);
                if (!is_null($merchant) && !$merchant->agent()->exists()) {
                    if ($this->has('platform_rate') && $this->has('rate')) {
                        if (bccomp($this->input('platform_rate'), $this->input('rate'), 6) !== 0) {
                            // 如果商户没有代理，则不能设置回扣
                            $validator->errors()->add('rebate', '商户未设置代理，不能设置回扣。');
                        }
                    }
                }
            }
        });
    }
}
