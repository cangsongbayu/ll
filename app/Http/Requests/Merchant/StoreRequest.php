<?php

namespace App\Http\Requests\Merchant;

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
                'unique:App\Models\Merchant,name',
                'required',
                'string',
                'max:255',
            ],
            'username' => [
                'unique:App\Models\Merchant,username',
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
            'allowed_ip_addresses' => [
                'nullable',
                'string',
                'max:255',
                'regex:' . config('regex.allowed_ip_addresses'),
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
            'agent_id' => [
                'nullable',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Agent,id,deleted_at,NULL',
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
