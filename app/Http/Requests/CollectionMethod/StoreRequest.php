<?php

namespace App\Http\Requests\CollectionMethod;

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
            'collection_method_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'payment_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'supplier_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'name' => [
                'unique:App\Models\CollectionMethod,name',
                'required',
                'string',
                'max:255',
            ],
            'daily_limit' => [
                'required',
                'numeric',
                'decimal:0,2',
                'db_decimal:10,2,unsigned',
            ],
            'daily_transaction_limit' => [
                'required',
                'integer',
                'db_integer:unsigned',
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
            'data' => [
                'required',
            ],
        ];
    }
}
