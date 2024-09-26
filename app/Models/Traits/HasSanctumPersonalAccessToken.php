<?php

namespace App\Models\Traits;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

trait HasSanctumPersonalAccessToken
{
    use HasApiTokens;

    /**
     * 根据用户模型的 max_token_count 属性，删除多余的 token
     *
     */
    public function deleteExcessTokens(): void
    {
        $tokenCount = $this->tokens()->count();
        if ($tokenCount > $this->max_token_count) {
            $extraTokensCount = $tokenCount - $this->max_token_count;
            $this->tokens()->oldest()->take($extraTokensCount)->delete();
        }
    }

    /**
     * 删除用户 Token
     */
    public static function deleteTokens(...$ids): void
    {
        if (blank($ids)) {
            return;
        }

        $model = new static;
        $userType = $model->getMorphClass();

        // 展平数组
        $deletes = collect($ids)->flatten()->unique()->values()->toArray();

        PersonalAccessToken::where('tokenable_type', $userType)
            ->whereIn('tokenable_id', $deletes)
            ->delete();
    }
}
