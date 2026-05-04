<?php
include_once "header.php";

$mysqli = include_once "conneccion.php";



function countIncidenciasAsignadas($mysqli, $id_tecnic) {
    $sentencia = $mysqli->prepare("SELECT COUNT(*) as total FROM incidencies WHERE tecnic_id = ? AND estado IN ('Registrat', 'En Proces')");
    
    $sentencia->bind_param("i", $id_tecnic);
    $sentencia->execute(); 
    $resultado = $sentencia->get_result();
    $data = $resultado->fetch_assoc();
    
    return $data['total'];
}

function countIncidenciasFinalizadas($mysqli, $id_tecnic) {
    $sentencia = $mysqli->prepare("SELECT COUNT(*) as total FROM incidencies WHERE tecnic_id = ? AND estado IN ('Finalitzat')");
    
    $sentencia->bind_param("i", $id_tecnic);
    $sentencia->execute(); 
    $resultado = $sentencia->get_result();
    $data = $resultado->fetch_assoc();
    
    return $data['total'];
}


function countAvgTime($mysqli, $id_tecnic) {
    $query = "SELECT AVG(CAST(temps_minuts AS UNSIGNED)) AS mitjana 
              FROM actuacions 
              WHERE tecnic_id = ?";
    $sentencia = $mysqli->prepare($query);
    if (!$sentencia) {
        return 0; 
    }
    $sentencia->bind_param("i", $id_tecnic);
    $sentencia->execute();
    
    $resultat = $sentencia->get_result();
    $row = $resultat->fetch_assoc();
    
    $sentencia->close();
    return $row['mitjana'] ?? 0;
}

function formatMinutes($total_minutes) {
    if (!$total_minutes || $total_minutes <= 0) {
        return "-";
    }
    $total = (int)round((float)$total_minutes);
    $hours = floor($total / 60);
    $minutes = $total % 60;
    if ($hours > 0) {
        return $hours . "h " . ($minutes > 0 ? $minutes . " min" : "");
    }
    return $minutes . " min";
}


$res_tecnics = $mysqli->query("SELECT id, nom FROM tecnics");
$tecnics = $res_tecnics->fetch_all(MYSQLI_ASSOC);
?>

<style>

    table .asign-btn{
        display: flex;
    }


    table .asign-btn .edit-btn{
        opacity: 0;
        transition: .3s;
    }

    table .asign-btn:hover .edit-btn{
        opacity: 1;
        transition: .3s;

    }

    .custom-font-size {
        font-size: 20px; 
    }

    @media (min-width: 768px) {
        .custom-font-size {
            font-size: 28px; 
        }
    }

    .custom-font-size-table {
        font-size: 14px; 
    }

    @media (min-width: 768px) {
        .custom-font-size-table {
            font-size: 18px; 
        }
    }

</style>



<div class="col m-4 table-responsive">
    <div class="d-flex justify-content-between text-center align-items-center mb-4">
        <a href="/" class="btn btn-secondary rounded-pill px-2 px-md-4 py-md-2">Volver</a>
        <h1 class="text-center text-white custom-font-size fw-bold">Informe de les incidencies per tecnic</h1>
        <br>
    </div>

<table class="table custom-font-size-table rounded-4 text-center">
    <thead>
        <tr class="align-middle">
            <th class="p-md-3 p-1">Nom</th>
            <th class="p-md-3 p-1">Incidències Assignades</th>
            <th class="p-md-3 p-1">Incidèncias Tancadas</th>
            <th class="p-md-3 p-1">Temps mitjà d'actuació</th>
            <th class="p-md-3 p-1">Llista de incidències</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tecnics as $t) { ?>
            <tr class="align-middle">
                <td class="p-md-3 p-1"><?php echo $t["nom"] ?></td>
                <td class="p-md-3 p-1">
                    <?php echo countIncidenciasAsignadas($mysqli, $t["id"]); ?>
                </td>                
                <td class="p-md-3 p-1">
                    <?php echo countIncidenciasFinalizadas($mysqli, $t["id"]); ?>
                </td>  

                <td class="p-md-3 p-1">
                    <?php 
                        $avg_raw = countAvgTime($mysqli, $t["id"]); 
                        echo formatMinutes($avg_raw); 
                    ?>
                </td>



                <td class="p-md-3 p-2">
                    <a href="incidencias_por_tecnic.php?id=<?php echo $t["id"]?>" class="btn btn-light rounded-pill btn-sm text-black">
                        Veure Incidències
                    </a>
                </td>     
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>



<?php include_once "footer.php"; ?>