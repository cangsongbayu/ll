<?php

namespace App\Http\Requests\Setting;

use App\Enums\SettingCategoryEnum;
use App\Http\Requests\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $setting = $this->route('setting');

        return [
            'key' => [
                "unique:App\Models\Setting,key,$setting->id",
                'filled',
                'string',
                'max:255',
            ],
            'value' => [
                'nullable',
                'string',
                'max:255',
            ],
            'category' => [
                'filled',
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
