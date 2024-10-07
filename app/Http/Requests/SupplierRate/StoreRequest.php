<?php

namespace App\Http\Requests\SupplierRate;

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
            'rate' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:7,6,unsigned',
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
        ];
    }
}
