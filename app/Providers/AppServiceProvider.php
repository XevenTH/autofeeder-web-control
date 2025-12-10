<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Services\MqttService;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MqttService::class, function (Application $app) {
            return new MqttService();
        });
    }

    // /**
    //  * Bootstrap any application services.
    //  */
    // public function boot(): void
    // {
    //     //
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paginator::useBootstrap(); // here we have added code.

        // Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();

        Paginator::defaultView('vendor.pagination.custom-pagination');
    }
}
