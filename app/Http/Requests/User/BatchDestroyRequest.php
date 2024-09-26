<?php

namespace App\Http\Requests\User;

use App\Exceptions\InvalidRequestException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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

    /**
     * Prepare the data for validation.
     *
     * @return void
     * @throws InvalidRequestException
     */
    protected function prepareForValidation(): void
    {
        $this->decodeHashids();
    }
}
