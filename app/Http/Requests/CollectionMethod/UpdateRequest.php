<?php

namespace App\Http\Requests\CollectionMethod;

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
        $collectionMethod = $this->route('collection_method');

        return [
            'collection_method_type_id' => [
                'prohibited'
            ],
            'payment_type_id' => [
                'prohibited'
            ],
            'supplier_id' => [
                'prohibited'
            ],
            'name' => [
                "unique:App\Models\CollectionMethod,name,$collectionMethod->id",
                'filled',
                'string',
                'max:255',
            ],
            'daily_limit' => [
                'filled',
                'numeric',
                'decimal:0,2',
                'db_decimal:10,2,unsigned',
            ],
            'daily_transaction_limit' => [
                'filled',
                'integer',
                'db_integer:unsigned',
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
            'data' => [
                'filled',
            ],
        ];
    }
}
