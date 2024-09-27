<?php

namespace App\Observers;

use App\Helpers\OrderNumberGenerator;
use App\Models\Currency;
use App\Models\Deposit;

class DepositObserver
{
    public function creating(Deposit $deposit): void
    {
        $deposit->base_currency_id = Currency::where('is_base_currency', true)->value('id');
        $deposit->trade_no = OrderNumberGenerator::generate();
        $deposit->base_amount = bcmul($deposit->amount, $deposit->exchange_rate, 6);
    }

    /**
     * Handle the Deposit "created" event.
     */
    public function created(Deposit $deposit): void
    {
        //
        $deposit->depositable()->increment('deposit', $deposit->base_amount);
    }

    /**
     * Handle the Deposit "updated" event.
     */
    public function updated(Deposit $deposit): void
    {
        //
    }

    /**
     * Handle the Deposit "deleted" event.
     */
    public function deleted(Deposit $deposit): void
    {
        //
    }

    /**
     * Handle the Deposit "restored" event.
     */
    public function restored(Deposit $deposit): void
    {
        //
    }

    /**
     * Handle the Deposit "force deleted" event.
     */
    public function forceDeleted(Deposit $deposit): void
    {
        //
    }
}
