<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Merchant;
use App\Models\MerchantPrepayment;
use App\Models\MerchantRate;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Agent;
use App\Models\SupplierRate;
use App\Models\SupplierBill;
use App\Observers\AgentObserver;
use App\Observers\CurrencyObserver;
use App\Observers\DepositObserver;
use App\Observers\MerchantObserver;
use App\Observers\MerchantPrepaymentObserver;
use App\Observers\MerchantRateObserver;
use App\Observers\SupplierObserver;
use App\Observers\SupplierRateObserver;
use App\Observers\SupplierBillObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        User::class => [UserObserver::class],
        Agent::class => [AgentObserver::class],
        Merchant::class => [MerchantObserver::class],
        Currency::class => [CurrencyObserver::class],
        MerchantPrepayment::class => [MerchantPrepaymentObserver::class],
        Deposit::class => [DepositObserver::class],
        MerchantRate::class => [MerchantRateObserver::class],
        Supplier::class => [SupplierObserver::class],
        SupplierRate::class => [SupplierRateObserver::class],
        Transaction::class => [TransactionObserver::class],
        SupplierBill::class =>[SupplierBillObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
