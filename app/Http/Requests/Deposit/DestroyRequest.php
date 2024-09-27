<?php

namespace App\Http\Requests\Deposit;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class DestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

        ];
    }
}
