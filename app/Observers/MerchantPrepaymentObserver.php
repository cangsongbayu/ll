<?php

namespace App\Observers;

use App\Helpers\OrderNumberGenerator;
use App\Models\MerchantPrepayment;
use App\Models\Currency;

class MerchantPrepaymentObserver
{
    public function creating(MerchantPrepayment $merchantPrepayment): void
    {
        $merchantPrepayment->base_currency_id = Currency::where('is_base_currency', true)->value('id');
        $merchantPrepayment->trade_no = OrderNumberGenerator::generate();
        $merchantPrepayment->base_amount = bcmul($merchantPrepayment->amount, $merchantPrepayment->exchange_rate, 6);
    }

    /**
     * Handle the MerchantPrepayment "created" event.
     */
    public function created(MerchantPrepayment $merchantPrepayment): void
    {
        //
        $merchantPrepayment->merchant()->increment('prepayment', $merchantPrepayment->base_amount);
    }

    /**
     * Handle the MerchantPrepayment "updated" event.
     */
    public function updated(MerchantPrepayment $merchantPrepayment): void
    {
        //
    }

    /**
     * Handle the MerchantPrepayment "deleted" event.
     */
    public function deleted(MerchantPrepayment $merchantPrepayment): void
    {
        //
    }

    /**
     * Handle the MerchantPrepayment "restored" event.
     */
    public function restored(MerchantPrepayment $merchantPrepayment): void
    {
        //
    }

    /**
     * Handle the MerchantPrepayment "force deleted" event.
     */
    public function forceDeleted(MerchantPrepayment $merchantPrepayment): void
    {
        //
    }
}
