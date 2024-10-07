<?php

namespace App\Http\Requests\Authenticate;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\FormRequest;

class RepassRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'current_password' => [
                'required',
                'string',
                'max:255',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
