<?php

namespace App\Observers;

use App\Models\Merchant;

class MerchantObserver
{
    public function creating(Merchant $merchant): void
    {
        $merchant->appid = mt_rand(10000000, 99999999);
    }

    /**
     * Handle the Merchant "created" event.
     */
    public function created(Merchant $merchant): void
    {
        //
    }

    public function updating(Merchant $merchant): void
    {
        // 确保用户关闭双因素认证时，清空双因素认证相关字段
        if ($merchant->isDirty('is_enable_tfa') && !$merchant->is_enable_tfa) {
            $merchant->tfa_secret = null;
        }

        // 如果用户修改了密码，删除用户的所有 token
        if ($merchant->isDirty('password')) {
            Merchant::deleteTokens($merchant->id);
        }
    }

    /**
     * Handle the Merchant "updated" event.
     */
    public function updated(Merchant $merchant): void
    {
        //
    }

    /**
     * Handle the Merchant "deleted" event.
     */
    public function deleted(Merchant $merchant): void
    {
        //
    }

    /**
     * Handle the Merchant "restored" event.
     */
    public function restored(Merchant $merchant): void
    {
        //
    }

    /**
     * Handle the Merchant "force deleted" event.
     */
    public function forceDeleted(Merchant $merchant): void
    {
        //
    }
}
