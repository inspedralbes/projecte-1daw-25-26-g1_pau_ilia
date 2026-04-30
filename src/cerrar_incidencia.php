<?php
include_once "conneccion.php";

if (!isset($_GET["id"])) {
    exit("ID no proporcionado");
}



$id = $_GET["id"];
$valor_estado = "Finalitzat";
$date = date("Y-m-d H:i:s");
$sentencia = $mysqli->prepare("UPDATE incidencies SET estado = ? WHERE id = ?");
$sentencia->bind_param("si", $valor_estado, $id);
$sentencia->execute();
$sentencia = $mysqli->prepare("UPDATE incidencies SET data_finalitzacio = ? WHERE id = ?");
$sentencia->bind_param("si", $date, $id);
$sentencia->execute();

header("Location: todas_incidencias.php");
