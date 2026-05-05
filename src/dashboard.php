<?php
require_once 'logger.php';

require_once 'conneccion.php'; 

$logs = $coleccionLogs->find()->toArray(); 


?>
<!DOCTYPE html>
<html lang="ca">
<head>
</head>
<body>

    <?php foreach ($logs as $log) : ?>
        <p><?php

            $fecha = $log['timestamp']->toDateTime()->format('d/m/Y H:i:s');
            echo "Visitó: " . $log['url'] . " el " . $fecha . " desde IP: " . $log["ip"] . " Con metodo: " . $log["metodo"] . " y navegador: " . $log["navegador"] . "<br>";?>
        </p>
    <?php endforeach; ?>


    </body>
</html>