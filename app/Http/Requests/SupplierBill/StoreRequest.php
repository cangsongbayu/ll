<?php

namespace App\Http\Requests\SupplierBill;

use App\Enums\BillTypeEnum;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
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
            'supplier_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
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
