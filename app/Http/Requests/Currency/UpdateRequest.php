<?php

namespace App\Http\Requests\Currency;

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
        $currency = $this->route('currency');

        return [
            'code' => [
                "unique:App\Models\Currency,code,$currency->id",
                'filled',
                'string',
                'max:3',
            ],
            'name' => [
                'filled',
                'string',
                'max:255',
            ],
            'symbol' => [
                'filled',
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
