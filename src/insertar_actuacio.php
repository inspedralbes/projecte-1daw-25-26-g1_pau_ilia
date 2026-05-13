<?php
include_once "conneccion.php";
require_once 'logger.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_inc = $_POST["id_incidencia"]; 
    $accion = $_POST["accion"]; 

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
        VALUES (?, ?, ?, ?, ?, ?)");

    $sentencia_insrt->bind_param("ississ", 
        $id_inc,      
        $descripcion, 
        $date,        
        $tecnic_id,   
        $temp,        
        $isVisible    
    );
    $sentencia_insrt->execute();

    if ($accion === "cerrar") {
        $estado_final = "Finalitzat";
        $stmt_close = $mysqli->prepare("UPDATE incidencies SET estado = ?, data_finalitzacio = ? WHERE id = ?");
        $stmt_close->bind_param("ssi", $estado_final, $date, $id_inc);
        $stmt_close->execute();
        
        header("Location: todas_incidencias.php");
        exit;

    } else {
        if ($incidencia["estado"] == "Registrat") {
            $valor_estat = "En Proces";
            $stmt_proc = $mysqli->prepare("UPDATE incidencies SET estado = ? WHERE id = ?");
            $stmt_proc->bind_param("si", $valor_estat, $id_inc);
            $stmt_proc->execute();
        }
        
        header("Location: incidencia.php?id=" . $id_inc); 
        exit;
    }

} else {
    exit("Accés no permès.");
}
?>