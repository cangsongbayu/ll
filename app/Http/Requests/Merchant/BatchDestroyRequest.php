<?php

namespace App\Http\Requests\Merchant;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class BatchDestroyRequest extends FormRequest
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
            'ids' => [
                'required',
                'array',
            ],
        ];
    }
}
