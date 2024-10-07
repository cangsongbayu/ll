<?php

namespace App\Http\Requests\MerchantRate;

use App\Http\Requests\FormRequest;
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

    public function validatePlatformRate($attribute, $value, $fail): bool
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
}
