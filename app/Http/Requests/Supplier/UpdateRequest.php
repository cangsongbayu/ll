<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\FormRequest;
use App\Models\Supplier;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $supplier = $this->route('supplier');

        return [
            'parent_id' => [
                'nullable',
                'integer',
                'db_integer:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
                function ($attr, $value, $fail) use ($supplier) {
                    // 有上级的情况才需要检查
                    if (!is_null($value)) {
                        // 上级不能是自己
                        if ($value === $supplier->id) {
                            return $fail(__('validation.node_must_not_be_a_self'));
                        }
                        // 上级不能是自己的后代节点
                        $parent = Supplier::find($value);
                        if ($parent->isDescendantOf($supplier)) {
                            return $fail(__('validation.node_must_not_be_a_descendant'));
                        }
                    }
                    return true;
                }
            ],
            'name' => [
                "unique:App\Models\Supplier,name,$supplier->id",
                'filled',
                'string',
                'max:255',
            ],
            'username' => [
                "unique:App\Models\Supplier,username,$supplier->id",
                'filled',
                'string',
                'max:255',
            ],
            'password' => [
                'filled',
                'string',
                'max:255',
            ],
            'max_token_count' => [
                'filled',
                'integer',
                'between:1,100'
            ],
            'is_enable_tfa' => [
                'filled',
                'boolean',
                Rule::in([false, 0]),
            ],
            'is_open_for_business' => [
                'filled',
                'boolean',
            ],
        ];
    }
}
