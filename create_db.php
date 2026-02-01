<?php
try {
    $dsn = 'mysql:host=127.0.0.1;port=3306';
    $pdo = new PDO($dsn, 'root', '');
    $pdo->exec("CREATE DATABASE IF NOT EXISTS laravel;");
    echo "Base de datos 'laravel' creada exitosamente o ya existía.";
} catch (PDOException $e) {
    echo "Error al crear la base de datos: " . $e->getMessage();
}
