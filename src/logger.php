<?php
require_once __DIR__ . '/coneccionmongo.php';
$url_visitada = $_SERVER['REQUEST_URI'];
$metodo_http = $_SERVER['REQUEST_METHOD'];
$ip_usuario = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconegut'; 

$coleccionLogs = $database->selectCollection('access_logs');

$logDocument = [
    'url' => $url_visitada,
    'metodo' => $metodo_http,
    'ip' => $ip_usuario,
    'navegador' => $user_agent,
    'timestamp' => new MongoDB\BSON\UTCDateTime() 
];


try {
    $coleccionLogs->insertOne($logDocument);
} catch (Exception $e) {
    error_log("Fallo al guardar log en MongoDB: " . $e->getMessage());
    $logs = []; 
}
