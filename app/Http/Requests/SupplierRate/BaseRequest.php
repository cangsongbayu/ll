<?php

namespace App\Http\Requests\SupplierRate;

use App\Http\Requests\FormRequest;
use App\Models\MerchantRate;
use App\Models\Supplier;
use App\Models\SupplierRate;

class BaseRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'rate' => '供应商费率',
        ];
    }

    public function validateRate($attribute, $value, $fail): bool
    {
        $method = $this->method();
        $supplierRate = $this->route('supplier_rate');
        $paymentTypeId = $method === 'POST' ? $this->input('payment_type_id') : $supplierRate->payment_type_id;
        $supplierId = $method === 'POST' ? $this->input('supplier_id') : $supplierRate->supplier_id;

        $maxRate = MerchantRate::where('payment_type_id', $paymentTypeId)->min('platform_rate');

        $errors = $this->validator->errors();
        if ($method === 'POST' && $errors->hasAny('payment_type_id', 'supplier_id')) {
            // 跳过检查
            return true;
        }

        if (bccomp($value, $maxRate, 6) > 0) {
            return $fail('供应商费率 不能大于平台实际费率：' . $maxRate) . '。';
        }

        $supplier = Supplier::find($supplierId);

        // 检查是否低于下级费率
        $highestRateForDescendants = $supplier->getHighestRateForDescendants($this->input('payment_type_id'));
        if (!is_null($highestRateForDescendants) && bccomp($value, $highestRateForDescendants, 6) < 0) {
            return $fail('供应商费率 不能小于下级费率：' . $highestRateForDescendants) . '。';
        }

        // 检查是否高于上级费率
        if (is_null($supplier->parent)) {
            // 如果没有上级则跳过以下检查
            return true;
        }

        $parentRate = SupplierRate::where('supplier_id', $supplier->parent->id)->where('payment_type_id', $paymentTypeId)->value('rate');

        if (is_null($parentRate)) {
            return $fail('上级供应商费率 未设置。');
        }

        if (bccomp($value, $parentRate, 6) > 0) {
            return $fail('供应商费率 不能大于上级费率：' . $parentRate) . '。';
        }

        return true;
    }
}
