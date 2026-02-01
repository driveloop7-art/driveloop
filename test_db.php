<?php
try {
    $dsn = 'mysql:host=127.0.0.1;port=3306;dbname=laravel';
    $pdo = new PDO($dsn, 'root', '');
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
