<?php

namespace App\Http\Requests\PaymentServiceProvider;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            config('app.page_size_name') => [
                'integer',
                'between:1,' . config('app.max_page_size'),
            ],
            config('app.page_name') => [
                'integer',
                'min:1',
            ],
        ];
    }
}
