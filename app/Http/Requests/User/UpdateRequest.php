<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;
use App\Models\User;
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
        $user = $this->route('user');

        return [
            'name' => [
                'filled',
                'string',
                'max:255',
                "unique:App\Models\User,name,{$user->id}",
            ],
            'username' => [
                'filled',
                'string',
                'max:255',
                "unique:App\Models\User,username,{$user->id}",
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
                'in:false,0',
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
