<?php

namespace App\Http\Requests\Deposit;

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
        $deposit = $this->route('deposit');

        return [
            'depositable_type' => [
                'filled',
                'string',
                'max:255',
            ],
            'depositable_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
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
                'db_decimal:20,6:unsigned',
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
