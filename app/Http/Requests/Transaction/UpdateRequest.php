<?php

namespace App\Http\Requests\Transaction;

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
        $transaction = $this->route('transaction');

        return [
            'payer_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'payee_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'amount' => [
                'filled',
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
