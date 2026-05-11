<?php
include_once "conneccion.php";
require_once 'logger.php';

if (!isset($_GET["id"])) {
    exit("ID no proporcionado");
}



$id = $_GET["id"];
$sentencia = $mysqli->prepare("DELETE FROM incidencies WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();

header("Location: todas_incidencias.php");







if (!$incidencia) {
    exit("No hay resultados para ese ID");
}

?>

