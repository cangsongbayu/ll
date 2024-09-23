<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * @method user()
 */
class ValidTFACode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $user = request()->user();
        $google2fa = app('pragmarx.google2fa');

        // 确保用户已经生成了 2FA 密钥
        if (blank($user->tfa_secret)) {
            $fail(__('validation.tfa_secret_not_generated'));
            return;
        }

        // 验证两步验证码
        $valid = $google2fa->verifyKey($user->tfa_secret, $value);
        if (!$valid) {
            $fail(__('validation.tfa_invalid', ['attribute' => __('validation.attributes.' . $attribute)]));
        }
    }
}
