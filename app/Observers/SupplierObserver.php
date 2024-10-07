<?php

namespace App\Observers;

use App\Models\Supplier;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function created(Supplier $supplier): void
    {
        //
    }

    public function updating(Supplier $supplier): void
    {
        // 确保用户关闭双因素认证时，清空双因素认证相关字段
        if ($supplier->isDirty('is_enable_tfa') && !$supplier->is_enable_tfa) {
            $supplier->tfa_secret = null;
            Supplier::deleteTokens($supplier->id);
        }

        // 如果用户修改了密码，删除用户的所有 token
        if ($supplier->isDirty('password')) {
            Supplier::deleteTokens($supplier->id);
        }
    }

    /**
     * Handle the Supplier "updated" event.
     */
    public function updated(Supplier $supplier): void
    {
        //
    }

    /**
     * Handle the Supplier "deleted" event.
     */
    public function deleted(Supplier $supplier): void
    {
        //
        Supplier::deleteTokens($supplier->id);
    }

    /**
     * Handle the Supplier "restored" event.
     */
    public function restored(Supplier $supplier): void
    {
        //
    }

    /**
     * Handle the Supplier "force deleted" event.
     */
    public function forceDeleted(Supplier $supplier): void
    {
        //
    }
}
