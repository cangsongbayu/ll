<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    public function updating(User $user): void
    {
        // 确保用户关闭双因素认证时，清空双因素认证相关字段
        if ($user->isDirty('is_enable_tfa') && !$user->is_enable_tfa) {
            $user->tfa_secret = null;
        }

        // 如果用户修改了密码，删除用户的所有 token
        if ($user->isDirty('password')) {
            User::deleteTokens($user->id);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
