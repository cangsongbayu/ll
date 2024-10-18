<?php

namespace App\Http\Requests\Order;

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
            'payment_type_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'payment_channel_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'merchant_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'supplier_id' => [
                'nullable',
                'numeric',
                'db_bigint:unsigned',
            ],
            'collection_method_id' => [
                'nullable',
                'numeric',
                'db_bigint:unsigned',
            ],
            'trade_no' => [
                'required',
                'string',
                'max:255',
            ],
            'out_trade_no' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                'integer',
                'db_smallint:unsigned',
            ],
            'amount' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'paid_amount' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'paid_at' => [
                'nullable',
            ],
            'cancel_at' => [
                'nullable',
            ],
        ];
    }
}
