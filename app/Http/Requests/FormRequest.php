<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidRequestException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use Vinkla\Hashids\Facades\Hashids;

abstract class FormRequest extends IlluminateFormRequest
{
    protected function getValidatorInstance(): Validator
    {
        $validator = parent::getValidatorInstance();

        $rules = collect($validator->getRules())->map(function ($fieldRules) {
            return array_merge(['bail'], (array)$fieldRules);
        })->toArray();

        $validator->setRules($rules);

        return $validator;
    }

    /**
     * @throws InvalidRequestException
     */
    protected function decodeHashids(): void
    {
        if ($this->has('ids')) {
            $ids = $this->input('ids');
            if (!is_array($ids)) {
                throw new InvalidRequestException();
            }

            foreach ($ids as $id) {
                if (!is_string($id)) {
                    throw new InvalidRequestException();
                }
            }

            $this->merge([
                'ids' => collect($ids)
                    ->map(function ($hashedId) {
                        $decoded = Hashids::decode($hashedId);
                        return $decoded[0] ?? null;
                    })
                    ->filter()
                    ->values()
                    ->toArray()
            ]);
        }
    }
}
