<?php

namespace App\Observers;

use App\Helpers\OrderNumberGenerator;
use App\Models\Currency;
use App\Models\SupplierBill;

class SupplierBillObserver
{
    public function creating(SupplierBill $supplierBill): void
    {
        $supplierBill->base_currency_id = Currency::where('is_base_currency', true)->value('id');
        $supplierBill->trade_no = OrderNumberGenerator::generate();
        $supplierBill->base_amount = bcmul($supplierBill->amount, $supplierBill->exchange_rate, 6);
    }

    /**
     * Handle the SupplierBill "created" event.
     */
    public function created(SupplierBill $supplierBill): void
    {
        //
        $supplierBill->supplier()->increment('balance', $supplierBill->base_amount);
    }

    /**
     * Handle the SupplierBill "updated" event.
     */
    public function updated(SupplierBill $supplierBill): void
    {
        //
    }

    /**
     * Handle the SupplierBill "deleted" event.
     */
    public function deleted(SupplierBill $supplierBill): void
    {
        //
    }

    /**
     * Handle the SupplierBill "restored" event.
     */
    public function restored(SupplierBill $supplierBill): void
    {
        //
    }

    /**
     * Handle the SupplierBill "force deleted" event.
     */
    public function forceDeleted(SupplierBill $supplierBill): void
    {
        //
    }
}
