<?php

namespace App\Http\Requests\MerchantRate;

use App\Http\Requests\FormRequest;

class BaseRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'rate' => '商户费率',
            'platform_rate' => '实际费率',
        ];
    }
}
