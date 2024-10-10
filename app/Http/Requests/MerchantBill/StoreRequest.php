<?php

namespace App\Http\Requests\MerchantBill;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\BillTypeEnum;
use Illuminate\Validation\Rules\Enum;

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
            'merchant_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Merchant,id,deleted_at,NULL',
            ],
            'type' => [
                'required',
                'integer',
                'db_smallint:unsigned',
                new Enum(BillTypeEnum::class),
            ],
            'currency_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Currency,id'
            ],
            'amount' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'exchange_rate' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6,unsigned',
            ],
            'base_currency_id' => [
                'prohibited',
            ],
            'note' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
