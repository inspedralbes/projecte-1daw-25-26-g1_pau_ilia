<?php
require 'vendor/autoload.php'; 
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

$user = getenv('MONGODB_INITDB_ROOT_USERNAME') ?: 'user';
$pass = getenv('MONGODB_INITDB_ROOT_PASSWORD') ?: 'pass';
$host = 'mongodb'; 
$port = '27017';   
$dbName = 'gi3p_db';

$uri = "mongodb://{$user}:{$pass}@{$host}:{$port}/{$dbName}?authSource=admin";
try {
    $client = new MongoDB\Client($uri);
    
    $database = $client->selectDatabase($dbName);
    $database->command(['ping' => 1]);


} catch (Exception $e) {
    echo "Falado: " . $e->getMessage();
}





