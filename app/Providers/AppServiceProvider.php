<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $migrator = app('migrator');
        $baseMigrationPath = database_path('migrations');

        // Registrar todas las subcarpetas de database/migrations
        foreach (File::directories($baseMigrationPath) as $dir) {
            $migrator->path($dir);
        }
    }
}
