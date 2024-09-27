<?php

namespace App\Http\Requests\Deposit;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Enums\SettingKeyEnum;
use App\Http\Requests\FormRequest;
use App\Models\Setting;

class StoreRequest extends FormRequest
{
    protected string $allowedDepositableTypes;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->allowedDepositableTypes = Setting::getAllowedDepositableTypes();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'depositable_type' => [
                'required',
                'string',
                'max:255',
                'in:' . $this->allowedDepositableTypes
            ],
            'depositable_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
            ],
            'currency_id' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                'exists:App\Models\Currency,id',
            ],
            'amount' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6',
            ],
            'exchange_rate' => [
                'required',
                'numeric',
                'decimal:0,6',
                'db_decimal:20,6:unsigned',
            ],
            'base_currency_id' => [
                'prohibited',
            ],
            'note' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];

        if ($this->has('depositable_type') && $this->has('depositable_id')) {
            $morphMap = Relation::morphMap();
            $depositableType = $this->input('depositable_type');
            $depositableTypeClass = $morphMap[$depositableType] ?? null;

            if (!is_null($depositableTypeClass)) {
                $rules['depositable_id'][] = "exists:{$depositableTypeClass},id,deleted_at,NULL";
            }
        }

        return $rules;
    }
}
