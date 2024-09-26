<?php

namespace App\Http\Requests\Currency;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'unique:App\Models\Currency,code',
                'required',
                'string',
                'max:3',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'symbol' => [
                'required',
                'string',
                'max:10',
            ],
            'is_base_currency' => [
                'prohibited',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => '货币代码',
            'name' => '货币名称',
            'symbol' => '货币符号',
        ];
    }
}
