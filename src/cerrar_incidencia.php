<?php
include_once "conneccion.php";

if (!isset($_GET["id"])) {
    exit("ID no proporcionado");
}



$id = $_GET["id"];
$valor_estado = "Finalitzat";
$sentencia = $mysqli->prepare("UPDATE incidencies SET estado = ? WHERE id = ?");
$sentencia->bind_param("si", $valor_estado, $id);
$sentencia->execute();

header("Location: todas_incidencias.php");
