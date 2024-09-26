<?php

namespace App\Http\Requests;

use App\Exceptions\InvalidRequestException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Encryption\Encrypter;
use Illuminate\Contracts\Encryption\DecryptException;

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
    protected function prepareForValidation(): void
    {
        $decodeNames = [
            'user_id',
            'agent_id',
            'merchant_id',
            'ids',
            'password',
        ];

        foreach ($decodeNames as $decodeName) {
            if ($this->has($decodeName)) {
                if ($decodeName === 'ids') {
                    $this->decodeHashids();
                } else if ($decodeName === 'password') {
                    try {
                        $key = config('app.password_key');

                        // 移除 "base64:" 前缀（如果存在）
                        if (str_starts_with($key, 'base64:')) {
                            $key = substr($key, 7);
                        }

                        $encrypter = new Encrypter(base64_decode($key), 'AES-256-CBC');
                        $this->merge([$decodeName => $encrypter->decrypt($this->input($decodeName))]);
                    } catch (DecryptException $e) {
                        throw new InvalidRequestException();
                    }
                } else {
                    $decoded = Hashids::decode($this->input($decodeName));
                    $this->merge([$decodeName => $decoded[0] ?? null]);
                }
            }
        }
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
