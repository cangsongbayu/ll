<?php

namespace App\Http\Requests\PaymentType;

use App\Http\Requests\FormRequest;

class BaseRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        if ($this->has('valid_amount')) {
            $validAmount = $this->input('valid_amount');
            if (preg_match('/^[1-9]\d*~[1-9]\d*$/', $validAmount)) {
                // 区间
                list($min, $max) = explode('~', $validAmount);
                // 如果最大值小于最小值，交换
                if ($max < $min) {
                    list($min, $max) = [$max, $min];
                }
            } else if (preg_match('/^([1-9]\d*,)+[1-9]\d*$/', $validAmount)) {
                // 逗号分隔，去重，并从小到大排序
                $arr = array_unique(explode(',', $validAmount));
                sort($arr);
                $this->merge(['valid_amount' => implode(',', $arr)]);
            }
        }
    }
}
