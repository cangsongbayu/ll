<?php

namespace App\Http\Requests\Authenticate;

use App\Rules\ValidTFACode;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyTFARequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tfa_code' => [
                'required',
                'string',
                'size:6',
                new ValidTFACode(),
            ],
        ];
    }
}
