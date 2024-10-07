<?php

namespace App\Http\Requests\Supplier;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

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
            'parent_id' => [
                'nullable',
                'integer',
                'db_integer:unsigned',
                'exists:App\Models\Supplier,id,deleted_at,NULL',
            ],
            'name' => [
                'unique:App\Models\Supplier,name',
                'required',
                'string',
                'max:255',
            ],
            'username' => [
                'unique:App\Models\Supplier,username',
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
            'max_token_count' => [
                'required',
                'integer',
                'between:1,100'
            ],
            'is_enable_tfa' => [
                'required',
                'boolean',
                Rule::in([false, 0]),
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
        ];
    }
}
