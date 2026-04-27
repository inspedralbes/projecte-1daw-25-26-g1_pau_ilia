<?php
include_once "conneccion.php";

$title = $_POST["title"];
$date = $_POST["date"];
$departament = $_POST["departament"];
$descripcion = $_POST["descripcion"];
$sentencia = $mysqli->prepare("INSERT INTO incidencies
(title, descripcio, departament_id, data_incidencia)
VALUES
(?, ?, ?, ?)");
$sentencia->bind_param("ssis", $title, $descripcion, $departament, $date);
$sentencia->execute();
$id = $mysqli->insert_id; 

header("Location: ticket.php?id=" . $id);
exit;
?>

