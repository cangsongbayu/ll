<?php

namespace App\Http\Requests\SupplierRate;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\SupplierRate;
use App\Models\MerchantRate;
use App\Models\Supplier;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $maxRate = MerchantRate::min('platform_rate');

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
                'db_decimal:7,6,unsigned',
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
            $rules['rate'][] = function($attr, $value, $fail) use ($maxRate) {
                $errors = $this->validator->errors();
                if ($errors->hasAny('payment_type_id', 'supplier_id')) {
                    // 跳过检查
                    return true;
                }

                if (is_null($maxRate)) {
                    return $fail('平台实际费率 未设置。');
                }
                if (bccomp($value, $maxRate, 6) > 0) {
                    return $fail('供应商费率 不能大于平台实际费率：' . $maxRate) . '。';
                }

                // 检查是否高于上级费率
                $supplier = Supplier::find($this->input('supplier_id'));
                dd($supplier->parent);
//                if ($supplier->parent_id) {
//
//                }

                return true;
            };
        }

        return $rules;
    }
}
