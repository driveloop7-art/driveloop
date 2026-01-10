<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

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

        $breezePath = resource_path('views/modules/GestionUsuario/breeze');
        View::addNamespace('breeze', $breezePath); // Agrega el namespace 'breeze' que se utiliza para llamar los componentes de breeze.
        View::addLocation($breezePath); // Agrega la ubicación para encontrar las vistas de breeze

        // Fix for missing mail namespace
        View::addNamespace('mail', resource_path('views/vendor/mail/html'));

        // View Composer for Navigation (Search Modal Brands)
        View::composer('layouts.navigation', function ($view) {
            $view->with('marcas', \App\Models\MER\Marca::all());
        });
    }
}
