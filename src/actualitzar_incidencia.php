<?php
$mysqli = include_once "conneccion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_incidencia'];
    $camp = $_POST['camp_a_actualitzar'];
    
    if ($camp === 'prioritat') {
        $valor = $_POST['valor_prioritat'];
        $stmt = $mysqli->prepare("UPDATE incidencies SET prioritat = ? WHERE id = ?");
        $stmt->bind_param("si", $valor, $id);
    } else {
        $valor = $_POST['valor_tipus'];
        $stmt = $mysqli->prepare("UPDATE incidencies SET tipus_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $valor, $id);
    }

    $stmt->execute();
    header("Location: todas_incidencias.php");
}
?>