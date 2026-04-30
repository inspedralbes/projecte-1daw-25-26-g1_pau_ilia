<?php
$mysqli = include_once "conneccion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_incidencia'];

    if (isset($_POST['bulk_update'])) {
        $prioritat = $_POST['valor_prioritat'];
        $tipus_id = $_POST['valor_tipus'];
        $tecnic_id = $_POST['valor_tecnics'];

        $stmt = $mysqli->prepare("UPDATE incidencies SET prioritat = ?, tipus_id = ?, tecnic_id = ? WHERE id = ?");
        $stmt->bind_param("siii", $prioritat, $tipus_id, $tecnic_id, $id);
        $stmt->execute();
        
        $stmt_act = $mysqli->prepare("UPDATE actuacions SET tecnic_id = ? WHERE incidencia_id = ?");
        $stmt_act->bind_param("ii", $tecnic_id, $id);
        $stmt_act->execute();

        header("Location: incidencia.php?id=" . $id);
        exit();
    } 
    
    else {
        $camp = $_POST['camp_a_actualitzar'];
        
        if ($camp === 'prioritat') {
            $valor = $_POST['valor_prioritat'];
            $stmt = $mysqli->prepare("UPDATE incidencies SET prioritat = ? WHERE id = ?");
            $stmt->bind_param("si", $valor, $id);
        } else if ($camp === 'tipus'){
            $valor = $_POST['valor_tipus'];
            $stmt = $mysqli->prepare("UPDATE incidencies SET tipus_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $valor, $id);
        } else if ($camp === 'tecnics'){
            $valor = $_POST['valor_tecnics'];
            $mysqli->query("UPDATE incidencies SET tecnic_id = $valor WHERE id = $id");
            $stmt = $mysqli->prepare("UPDATE actuacions SET tecnic_id = ? WHERE incidencia_id = ?");
            $stmt->bind_param("ii", $valor, $id);
        }

        $stmt->execute();
        header("Location: todas_incidencias.php");
        exit();
    }
}
?>