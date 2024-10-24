<?php

namespace App\Http\Requests\PaymentServiceProvider;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

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
                'unique:App\Models\PaymentServiceProvider,name',
                'required',
                'string',
                'max:255',
            ],
            'is_open_for_business' => [
                'required',
                'boolean',
            ],
        ];
    }
}
