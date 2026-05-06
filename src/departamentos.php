<?php
include_once "header.php";

$mysqli = include_once "conneccion.php";

require_once 'logger.php';


function countIncidenciasAsignadas($mysqli, $departament_id) {
    $sentencia = $mysqli->prepare("SELECT COUNT(*) as total FROM incidencies WHERE departament_id = ? AND estado IN ('Registrat', 'En Proces')");
    
    $sentencia->bind_param("i", $departament_id);
    $sentencia->execute(); 
    $resultado = $sentencia->get_result();
    $data = $resultado->fetch_assoc();
    
    return $data['total'];
}

function countIncidenciasFinalizadas($mysqli, $departament_id) {
    $sentencia = $mysqli->prepare("SELECT COUNT(*) as total FROM incidencies WHERE departament_id = ? AND estado IN ('Finalitzat')");
    
    $sentencia->bind_param("i", $departament_id);
    $sentencia->execute(); 
    $resultado = $sentencia->get_result();
    $data = $resultado->fetch_assoc();
    
    return $data['total'];
}

function countTotal_Time($mysqli, $departament_id) {
    $sql = "SELECT SUM(CAST(REGEXP_REPLACE(a.temps_minuts, '[^0-9]', '') AS UNSIGNED)) as total_time 
            FROM actuacions a 
            INNER JOIN incidencies i ON a.incidencia_id = i.id 
            WHERE i.departament_id = ? AND i.estado = 'Finalitzat'";

    $sentencia = $mysqli->prepare($sql);
    $sentencia->bind_param("i", $departament_id);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $data = $resultado->fetch_assoc();

    return $data['total_time'] ?? 0;
}

function formatMinutes($total_minutes) {
    $total = (int)$total_minutes; 
    if ($total <= 0) {
        return "0 min";
    }
    $hours = floor($total / 60);
    $minutes = $total % 60;
    if ($hours > 0) {
        return $hours . "h" . ($minutes > 0 ? " " . $minutes . " min" : "");
    }
    return $minutes . " min";
}
$res_dep = $mysqli->query("SELECT id, nom FROM departaments");
$departamentos = $res_dep->fetch_all(MYSQLI_ASSOC);
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
        <h1 class="text-center text-white custom-font-size fw-bold">Informe de les incidencies per departament</h1>
        <br>
    </div>

<table class="table custom-font-size-table rounded-4 text-center">
    <thead>
        <tr class="align-middle">
            <th class="p-md-3 p-1">Nom</th>
            <th class="p-md-3 p-1">Incidències Assignades</th>
            <th class="p-md-3 p-1">Incidèncias Tancadas</th>
            <th class="p-md-3 p-1">Temps utilitzat</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($departamentos as $d) { ?>
            <tr class="align-middle">
                <td class="p-md-3 p-1"><?php echo $d["nom"] ?></td>
                <td class="p-md-3 p-1">
                    <?php echo countIncidenciasAsignadas($mysqli, $d["id"]); ?>
                </td>                
                <td class="p-md-3 p-1">
                    <?php echo countIncidenciasFinalizadas($mysqli, $d["id"]); ?>
                </td>      
                <td class="p-md-3 p-1">
                    <?php echo formatMinutes(countTotal_Time($mysqli, $d["id"])); ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>



<?php include_once "footer.php"; ?>