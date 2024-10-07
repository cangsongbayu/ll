<?php

namespace App\Providers;

use App\Models\Merchant;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Relation::morphMap([
            'user' => User::class,
            'agent' => Agent::class,
            'merchant' => Merchant::class,
            'supplier' => Supplier::class,
        ]);
    }
}
