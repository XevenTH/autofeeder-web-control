<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MqttService;

class MqttServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MqttService::class, function ($app) {
            return new MqttService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
