<?php

use Illuminate\Support\Facades\Route;



require __DIR__ . '/breeze/routes.php';
require __DIR__ . '/breeze/auth.php';
require app_path('Modules/PagoDigital/routes.php');

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}