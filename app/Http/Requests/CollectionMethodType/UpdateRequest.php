<?php

namespace App\Http\Requests\CollectionMethodType;

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
        $collectionMethodType = $this->route('collection_method_type');

        return [
            'payment_type_ids' => [
                'filled',
                'string',
                'max:255',
                'regex:/^(\d+)(,\d+)*$|^$/',
            ],
            'name' => [
                "unique:App\Models\CollectionMethodType,name,$collectionMethodType->id",
                'filled',
                'string',
                'max:255',
            ],
            'sort' => [
                'filled',
                'integer',
                'db_smallint:unsigned',
            ],
            'data' => [
                'filled',
            ],
        ];
    }
}
