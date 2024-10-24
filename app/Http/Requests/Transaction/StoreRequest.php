<?php

namespace App\Http\Requests\Transaction;

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
            'payer_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
            ],
            'payee_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
                function ($attribute, $value, $fail) {
                    if ($value === request('payer_id')) {
                        $fail('付款人 与 收款人 不可相同.');
                    }
                },
            ],
            'amount' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'note' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
