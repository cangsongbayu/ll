<?php

namespace App\Observers;

use App\Models\SupplierRate;
use Illuminate\Support\Facades\DB;

class SupplierRateObserver
{
    /**
     * Handle the SupplierRate "created" event.
     */
    public function created(SupplierRate $supplierRate): void
    {
        //
    }

    public function updating(SupplierRate $supplierRate): void
    {
        if ($supplierRate->isDirty('rate')) {
            $oldRate = $supplierRate->getOriginal('rate');
            $newRate = $supplierRate->rate;

            if (bccomp($oldRate, $newRate, 6) > 0) {
                // 计算差值
                $diff = bcsub($oldRate, $newRate, 6);
                // 获取所有后代 ID
                $list = $supplierRate->supplier->descendants()->withTrashed()->pluck('id');
                SupplierRate::withTrashed()
                    ->where('payment_type_id', $supplierRate->payment_type_id)
                    ->whereIn('supplier_id', $list)
                    ->update([
                        'rate' => DB::raw("GREATEST(rate - {$diff}, 0)")
                    ]);
            }
        }
    }

    /**
     * Handle the SupplierRate "updated" event.
     */
    public function updated(SupplierRate $supplierRate): void
    {
        //
    }

    /**
     * Handle the SupplierRate "deleted" event.
     */
    public function deleted(SupplierRate $supplierRate): void
    {
        //
    }

    /**
     * Handle the SupplierRate "restored" event.
     */
    public function restored(SupplierRate $supplierRate): void
    {
        //
    }

    /**
     * Handle the SupplierRate "force deleted" event.
     */
    public function forceDeleted(SupplierRate $supplierRate): void
    {
        //
    }
}
