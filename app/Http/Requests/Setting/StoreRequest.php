<?php

namespace App\Http\Requests\Setting;

use App\Enums\SettingCategoryEnum;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

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
            'key' => [
                'unique:App\Models\Setting,key',
                'required',
                'string',
                'max:255',
            ],
            'value' => [
                'nullable',
                'string',
                'max:255',
            ],
            'category' => [
                'required',
                'numeric',
                'db_bigint:unsigned',
                new Enum(SettingCategoryEnum::class),
            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
