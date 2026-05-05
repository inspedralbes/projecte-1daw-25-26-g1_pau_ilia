<?php
include_once "conneccion.php";
require_once 'logger.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_inc = $_POST["id_incidencia"]; 
    $sentencia = $mysqli->prepare("SELECT tecnic_id, estado FROM incidencies WHERE id = ?");
    $sentencia->bind_param("i", $id_inc);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $incidencia = $resultado->fetch_assoc();
    if (!$incidencia) {
        exit("Incidencia no trobada.");
    }
    $tecnic_id = $incidencia["tecnic_id"];
    $descripcion = $_POST["descripcion"];
    $isVisible = $_POST["visible_usuari"]; 
    $temp = $_POST["temp"];
    $date = date("Y-m-d H:i:s");

    $sentencia_insrt = $mysqli->prepare("INSERT INTO actuacions
        (incidencia_id, descripcio, data_actuacio, tecnic_id, temps_minuts, visible_usuari)
        VALUES
        (?, ?, ?, ?, ?, ?)");


    $sentencia_insrt->bind_param("ississ", 
        $id_inc,      
        $descripcion, 
        $date,        
        $tecnic_id,   
        $temp,        
        $isVisible    
    );


    if($incidencia["estado"] == "Registrat"){
        $valor_estat = "En Proces";
        $stmt = $mysqli->prepare("UPDATE incidencies SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $valor_estat, $id_inc);
        $stmt->execute();
    }



    if ($sentencia_insrt->execute()) {
        header("Location: incidencia.php?id=" . $id_inc);
        exit;
    } else {
        echo "Error al insertar: " . $mysqli->error;
    }
} else {
    exit("Accés no permès.");
}
?>