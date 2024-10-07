<?php

namespace App\Observers;

use App\Models\MerchantRate;

class MerchantRateObserver
{
    public function creating(MerchantRate $merchantRate): void
    {
        $merchantRate->rebate = bcsub($merchantRate->rate, $merchantRate->platform_rate, 6);
        // 如果商户没有代理，实际费率应 = 商户费率
        if (is_null($merchantRate->merchant->agent_id)) {
            $merchantRate->platform_rate = $merchantRate->rate;
        }
    }

    /**
     * Handle the MerchantRate "created" event.
     */
    public function created(MerchantRate $merchantRate): void
    {
        //
    }

    public function updating(MerchantRate $merchantRate): void
    {
        if ($merchantRate->isDirty('rate') || $merchantRate->isDirty('platform_rate')) {
            $merchantRate->rebate = bcsub($merchantRate->rate, $merchantRate->platform_rate, 6);
        }
    }

    /**
     * Handle the MerchantRate "updated" event.
     */
    public function updated(MerchantRate $merchantRate): void
    {
        //
    }

    /**
     * Handle the MerchantRate "deleted" event.
     */
    public function deleted(MerchantRate $merchantRate): void
    {
        //
    }

    /**
     * Handle the MerchantRate "restored" event.
     */
    public function restored(MerchantRate $merchantRate): void
    {
        //
    }

    /**
     * Handle the MerchantRate "force deleted" event.
     */
    public function forceDeleted(MerchantRate $merchantRate): void
    {
        //
    }
}
