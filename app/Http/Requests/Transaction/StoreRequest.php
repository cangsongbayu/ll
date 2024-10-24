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
            ],
            'payee_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
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
