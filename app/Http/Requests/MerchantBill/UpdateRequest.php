<?php

namespace App\Http\Requests\MerchantBill;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\BillTypeEnum;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $merchantBill = $this->route('merchant_bill');

        return [
            'merchant_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Merchant,id',
            ],
            'type' => [
                'filled',
                'integer',
                'db_smallint:unsigned',
                new Enum(BillTypeEnum::class),
            ],
            'currency_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Currency,id',
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
                'prohibited'
            ],
            'note' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
