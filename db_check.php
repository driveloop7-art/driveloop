<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    DB::connection()->getPdo();
    echo "Conexion exitosa con Azure";
} catch (Exception $e) {
    echo "Error de conexion: " . $e->getMessage();
}
