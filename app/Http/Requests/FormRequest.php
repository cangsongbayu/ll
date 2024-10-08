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
        foreach ($this->all() as $key => $value) {
            if (str_ends_with($key, '_id')) {
                if (!is_string($value)) {
                    throw new InvalidRequestException();
                }
                $decoded = Hashids::decode($value);
                $this->merge([$key => $decoded[0] ?? null]);
            } else if ($key === 'ids' || str_ends_with($key, '_ids')) {
                $this->decodeHashids($key);
            } else if ($key === 'password' || $key === 'current_password') {
//                try {
                    $passwordKey = config('app.password_key');
                    // 移除 "base64:" 前缀（如果存在）
                    if (str_starts_with($passwordKey, 'base64:')) {
                        $passwordKey = substr($passwordKey, 7);
                    }
                    $encrypter = new Encrypter(base64_decode($passwordKey), 'AES-256-CBC');
                    $this->merge([$key => $encrypter->decrypt($this->input($key))]);
//                } catch (DecryptException $e) {
//                    throw new InvalidRequestException();
//                }
            }
        }
    }

    /**
     * @throws InvalidRequestException
     */
    protected function decodeHashids($key): void
    {
        $ids = $this->input($key);

        if (!is_array($ids)) {
            throw new InvalidRequestException();
        }

        foreach ($ids as $id) {
            if (!is_string($id)) {
                throw new InvalidRequestException();
            }
        }

        $this->merge([
            $key => collect($ids)
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
