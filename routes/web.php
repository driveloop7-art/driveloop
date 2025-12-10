<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

require __DIR__.'/breeze/routes.php';
require __DIR__.'/breeze/auth.php';

foreach (glob(app_path('Modules/*/routes.php')) as $route) {
    require $route;
}