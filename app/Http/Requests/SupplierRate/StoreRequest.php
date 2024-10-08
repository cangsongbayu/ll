<?php

namespace App\Http\Requests\SupplierRate;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\SupplierRate;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'payment_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\PaymentType,id',
            ],
            'supplier_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
            ],
            'rate' => [
                'required',
                'numeric',
                'decimal:0,6',
                'between:0,1'
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
        ];

        if ($this->has('payment_type_id') && $this->has('supplier_id')) {
            $rules['payment_type_id'][] = function($attr, $value, $fail) {
                $exists = SupplierRate::where('supplier_id', $this->input('supplier_id'))
                    ->where('payment_type_id', $this->input('payment_type_id'))
                    ->exists();
                if ($exists) {
                    return $fail('供应商费率 已经存在。');
                }
                return true;
            };
            $rules['rate'][] = $this->validateRate(...);
        }

        return $rules;
    }
}
