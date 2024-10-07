<?php

namespace App\Http\Requests\SupplierRate;

use App\Http\Requests\FormRequest;

class BaseRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'rate' => '供应商费率',
        ];
    }
}
