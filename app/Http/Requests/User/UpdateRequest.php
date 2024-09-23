<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    protected ?User $user = null;
    protected string $table;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $this->resolveModel();
        return [
            'name' => [
                'filled',
                'string',
                'max:255',
                Rule::unique($this->table, 'name')->ignore($this->user->id),
            ],
            'username' => [
                'filled',
                'string',
                'max:255',
                Rule::unique($this->table, 'username')->ignore($this->user->id),
            ],
            'password' => [
                'filled',
                'string',
                'max:255',
            ],
            'max_token_count' => [
                'filled',
                'integer',
                "between:0,{$this->signedTinyIntMax}",
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

    /**
     * 解析当前修改的模型
     */
    public function resolveModel(): void
    {
        if (is_null($this->user)) {
            $this->user = $this->route('user');
            if (!($this->user instanceof User)) {
                abort(404);
            }
            $this->table = $this->user->getTable();
        }
    }
}
