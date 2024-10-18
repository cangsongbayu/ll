<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $order = $this->route('order');

        return [
            'payment_type_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'payment_channel_id' => [
                'filled',
                'numeric',
                'db_bigint:unsigned',
            ],
            'merchant_id' => [
                'filled',
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
                'filled',
                'string',
                'max:255',
            ],
            'out_trade_no' => [
                'filled',
                'string',
                'max:255',
            ],
            'status' => [
                'filled',
                'integer',
                'db_smallint:unsigned',
            ],
            'amount' => [
                'filled',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'paid_amount' => [
                'filled',
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
