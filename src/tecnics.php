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
    // $sentencia = $mysqli->prepare("");    
    // $sentencia->bind_param("i", $id_tecnic);
    // $sentencia->execute(); 
    // $resultado = $sentencia->get_result();
    // $data = $resultado->fetch_assoc();
    
    // return $data['total'];

    //TODO: acabar la funccion
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
</style>


<div class="col m-4">
    <div>
<h1 class="text-center text-white fw-bold">Totes les incidencies</h1>
<br>
</div>

<table class="table rounded-4">
    <thead>
        <tr class="align-middle">
            <th class="p-3">Nom</th>
            <th class="p-3">Incidencias Asignadas</th>
            <th class="p-3">Incidencias Cerradas</th>
            <th class="p-3">Tiempo Promedio Cierre</th>
            <th class="p-3">Llista de incidencias</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tecnics as $t) { ?>
            <tr class="align-middle">
                <td class="p-3"><?php echo $t["nom"] ?></td>
                <td class="p-3">
                    <?php echo countIncidenciasAsignadas($mysqli, $t["id"]); ?>
                </td>                
                <td class="p-3">
                    <?php echo countIncidenciasFinalizadas($mysqli, $t["id"]); ?>
                </td>  

                <td class="p-3">

                </td>



                <td class="p-3">
                    <a href="incidencia.php?id=<?php ?>" class="btn btn-light rounded-pill btn-sm text-black">
                        Ver Incidencias
                    </a>
                </td>     
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>



<?php include_once "footer.php"; ?>