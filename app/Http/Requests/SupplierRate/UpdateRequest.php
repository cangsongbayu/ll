<?php

namespace App\Http\Requests\SupplierRate;

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
        $supplierRate = $this->route('supplier_rate');

        return [
            'payment_type_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'supplier_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'rate' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'db_decimal:7,6,unsigned',
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
        ];
    }
}
