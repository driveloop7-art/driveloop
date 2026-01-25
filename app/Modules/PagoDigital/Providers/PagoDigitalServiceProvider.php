<?php

namespace App\Modules\PagoDigital\Providers;

use Illuminate\Support\ServiceProvider;

class PagoDigitalServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
    }

    public function register(): void
    {
        //
    }
}
