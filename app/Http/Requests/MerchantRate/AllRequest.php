<?php

namespace App\Http\Requests\MerchantRate;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @property mixed $ids
 */
class AllRequest extends FormRequest
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
            'merchant_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Merchant,id',
            ],
        ];
    }
}
