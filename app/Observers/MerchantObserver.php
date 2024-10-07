<?php

namespace App\Observers;

use App\Models\Merchant;
use Illuminate\Support\Facades\DB;

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
            Merchant::deleteTokens($merchant->id);
        }

        // 如果用户修改了密码，删除用户的所有 token
        if ($merchant->isDirty('password')) {
            Merchant::deleteTokens($merchant->id);
        }

        // 如果删除了代理，将商户所有费率的平台费率值修改为与商户费率相同，返点为 0
        if ($merchant->isDirty('agent_id') && is_null($merchant->agent_id)) {
            $merchant->rates()->update([
                'platform_rate' => DB::raw('rate'),
                'rebate' => 0
            ]);
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
        Merchant::deleteTokens($merchant->id); // 删除用户的所有 token
        // 删除用户的所有费率
        $merchant->rates()->delete();
    }

    /**
     * Handle the Merchant "restored" event.
     */
    public function restored(Merchant $merchant): void
    {
        // 恢复用户的所有费率
        $merchant->rates()->onlyTrashed()->restore();
    }

    /**
     * Handle the Merchant "force deleted" event.
     */
    public function forceDeleted(Merchant $merchant): void
    {
        //
    }
}
