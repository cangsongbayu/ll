<?php

namespace App\Http\Requests\SupplierRate;

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

        return [
            'payment_type_id' => [
                'prohibited',
            ],
            'supplier_id' => [
                'prohibited',
            ],
            'rate' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'between:0,1',
                $this->validateRate(...),
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
        ];
    }
}
