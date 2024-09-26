<?php

namespace App\Http\Requests\Agent;

use App\Http\Requests\FormRequest;
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
        $agent = $this->route('agent');

        return [
            'name' => [
                "unique:App\Models\Agent,name,$agent->id",
                'filled',
                'string',
                'max:255',
            ],
            'username' => [
                "unique:App\Models\Agent,username,$agent->id",
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
            'allowed_ip_addresses' => [
                'nullable',
                'string',
                'max:255',
                'regex:' . config('regex.allowed_ip_addresses'),
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
