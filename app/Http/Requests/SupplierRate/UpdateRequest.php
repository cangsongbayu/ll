<?php

namespace App\Http\Requests\SupplierRate;

use App\Models\SupplierRate;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $supplierRate = $this->route('supplier_rate');

        $rules = [
            'payment_type_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'supplier_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
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

        if ($this->has('payment_type_id') && $this->has('supplier_id')) {
            $rules['payment_type_id'][] = function($attr, $value, $fail) use ($supplierRate) {
                $exists = SupplierRate::where('supplier_id', $this->input('supplier_id'))
                    ->where('payment_type_id', $this->input('payment_type_id'))
                    ->where('id', '<>', $supplierRate->id)
                    ->exists();
                if ($exists) {
                    return $fail('供应商费率 已经存在。');
                }
                return true;
            };
        }

        return $rules;
    }
}