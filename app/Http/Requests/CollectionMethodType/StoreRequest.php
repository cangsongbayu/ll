<?php

namespace App\Http\Requests\CollectionMethodType;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'payment_type_ids' => [
                'required',
                'array',
            ],
            'name' => [
                'unique:App\Models\CollectionMethodType,name',
                'required',
                'string',
                'max:255',
            ],
            'sort' => [
                'required',
                'integer',
                'db_smallint:unsigned',
            ],
            'data' => [
                'required',
            ],
        ];
    }
}
