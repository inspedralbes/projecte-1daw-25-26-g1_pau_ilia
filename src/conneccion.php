<?php
$host = "db";
$usuario = "dev_user";
$contrasenia = "dev_password";
$base_de_datos = "gi3p_db";
$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);

if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;