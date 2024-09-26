<?php

namespace App\Observers;

use App\Models\Currency;

class CurrencyObserver
{
    public function creating(Currency $currency): void
    {
        $currency->ensureSingleBaseCurrency();
    }
    /**
     * Handle the Currency "created" event.
     */
    public function created(Currency $currency): void
    {
        //
    }

    public function updating(Currency $currency): void
    {
        if ($currency->isDirty('is_base_currency')) {
            $currency->ensureSingleBaseCurrency();
        }
    }

    /**
     * Handle the Currency "updated" event.
     */
    public function updated(Currency $currency): void
    {
        //
    }

    /**
     * Handle the Currency "deleted" event.
     */
    public function deleted(Currency $currency): void
    {
        //
    }

    /**
     * Handle the Currency "restored" event.
     */
    public function restored(Currency $currency): void
    {
        //
    }

    /**
     * Handle the Currency "force deleted" event.
     */
    public function forceDeleted(Currency $currency): void
    {
        //
    }
}
