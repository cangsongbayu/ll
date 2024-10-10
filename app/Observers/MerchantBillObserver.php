<?php

namespace App\Observers;

use App\Helpers\OrderNumberGenerator;
use App\Models\Currency;
use App\Models\MerchantBill;

class MerchantBillObserver
{
    public function creating(MerchantBill $merchantBill): void
    {
        $merchantBill->base_currency_id = Currency::where('is_base_currency', true)->value('id');
        $merchantBill->trade_no = OrderNumberGenerator::generate();
        $merchantBill->base_amount = bcmul($merchantBill->amount, $merchantBill->exchange_rate, 6);
    }

    /**
     * Handle the MerchantBill "created" event.
     */
    public function created(MerchantBill $merchantBill): void
    {
        //
        $merchantBill->merchant()->increment('balance', $merchantBill->base_amount);
    }

    /**
     * Handle the MerchantBill "updated" event.
     */
    public function updated(MerchantBill $merchantBill): void
    {
        //
    }

    /**
     * Handle the MerchantBill "deleted" event.
     */
    public function deleted(MerchantBill $merchantBill): void
    {
        //
    }

    /**
     * Handle the MerchantBill "restored" event.
     */
    public function restored(MerchantBill $merchantBill): void
    {
        //
    }

    /**
     * Handle the MerchantBill "force deleted" event.
     */
    public function forceDeleted(MerchantBill $merchantBill): void
    {
        //
    }
}
