<?php

namespace App\Http\Requests\Authenticate;

use App\Exceptions\InvalidRequestException;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\FormRequest;
/**
 * @property mixed $login_type
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     * @throws InvalidRequestException
     */
    public function rules(): array
    {
        // 如果没有提交登录类型或提供了不存在的登录类型则视为无效请求
        if ($this->missing('login_type') || !array_key_exists($this->login_type, config('auth.providers'))) {
            throw new InvalidRequestException();
        }

        $loginName = config("auth.providers.{$this->login_type}.login_name");

        return [
            $loginName => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
