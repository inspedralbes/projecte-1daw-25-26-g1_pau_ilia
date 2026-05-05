<?php
require_once 'logger.php';

if (!function_exists('loadEnv')) {
    function loadEnv($path) {
        if (!file_exists($path)) return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . "=" . trim($value));
        }
    }
}

loadEnv(__DIR__ . '/.env');

$host = getenv('DB_HOST') ?: "db"; 
$base_de_datos = getenv('DB_NAME') ?: "gi3p_db";
$usuario = getenv('DB_USER') ?: "dev_user";
$contrasenia = getenv('DB_PASS') ?: "dev_password";

$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);

if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}

return $mysqli;