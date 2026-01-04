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

// Temporary route for email preview
Route::get('/email-preview', function () {
    return view('vendor.notifications.email', [
        'greeting' => '¡Hola!',
        'introLines' => ['Esta es una línea de introducción de prueba.', 'Aquí puedes ver cómo luce el texto.'],
        'actionText' => 'Verificar Correo',
        'actionUrl' => '#',
        'level' => 'primary',
        'outroLines' => ['Gracias por usar nuestra aplicación.', 'Si tienes dudas, contáctanos.'],
        'salutation' => 'Saludos, Estupendo Equipo',
        'displayableActionUrl' => 'http://localhost/verify',
    ]);
});
