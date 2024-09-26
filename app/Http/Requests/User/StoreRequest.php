<?php

namespace App\Http\Requests\User;

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
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:App\Models\User,name',
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:App\Models\User,username',
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
                Rule::in([false, 0])
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'is_enable_tfa.in' => '禁止手动开启 :attribute，否则会导致用户无法登录',
        ];
    }
}
