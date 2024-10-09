<?php

namespace App\Http\Requests\CollectionMethod;

use App\Http\Requests\FormRequest;
use App\Models\CollectionMethodType;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreRequest extends FormRequest
{
    private CollectionMethodType $collectionMethodType;

    public function getCollectionMethodType(): CollectionMethodType
    {
        return $this->collectionMethodType;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        // 获取动态规则
        $dynamicRules = [];
        if ($this->has('collection_method_type_id')) {
            $collectionMethodType = CollectionMethodType::find($this->input('collection_method_type_id'));
            if (!is_null($collectionMethodType)) {
                $this->collectionMethodType = $collectionMethodType;
                $dynamicRules = collect($collectionMethodType->data['fields'] ?? [])
                    ->pluck('rules.laravel.store', 'name')
                    ->filter()
                    ->toArray();
            }
        }

        return [
            ...$dynamicRules,
            'collection_method_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\CollectionMethodType,id'
            ],
            'payment_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\PaymentType,id'
            ],
            'supplier_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL'
            ],
            'name' => [
                'unique:App\Models\CollectionMethod,name',
                'required',
                'string',
                'max:255',
            ],
            'daily_limit' => [
                'required',
                'numeric',
                'decimal:0,2',
                'db_decimal:10,2,unsigned',
            ],
            'daily_transaction_limit' => [
                'required',
                'integer',
                'db_integer:unsigned',
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
        ];
    }
}
