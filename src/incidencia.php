<?php
include_once "conneccion.php";
$id = $_GET["id"];

$sentencia = $mysqli->prepare(
    "SELECT 
        i.*, 
        t.nom AS tecnic_nom,
        a.descripcio AS ultima_actuacio_desc,
        a.data_actuacio AS ultima_actuacio_data,
        a.id AS id_actuacio
     FROM incidencies i
     LEFT JOIN tecnics t ON i.tecnic_id = t.id
     LEFT JOIN actuacions a ON a.id = (
         SELECT id FROM actuacions 
         WHERE incidencia_id = i.id 
         ORDER BY data_actuacio DESC, id DESC 
         LIMIT 1
     )
     WHERE i.id = ?"
);




$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$incidencia = $resultado->fetch_assoc();


if (!$incidencia) {
    exit("No hay resultados para ese ID");
}

$sentencia_historial = $mysqli->prepare(
    "SELECT *
     FROM actuacions 
     WHERE incidencia_id = ? 
     ORDER BY data_actuacio DESC"
);
$sentencia_historial->bind_param("i", $id);
$sentencia_historial->execute();
$historial = $sentencia_historial->get_result();


$sentencia_tipus = $mysqli->prepare(
    "SELECT *
     FROM tipos_incidencia 
     WHERE id = ? "
);
$sentencia_tipus->bind_param("i", $incidencia["tipus_id"]);
$sentencia_tipus->execute();
$res = $sentencia_tipus->get_result();
$tipo = $res->fetch_assoc();


include_once "header.php"; 
?>

<div class="container-fluid p-3">
    <a href="/todas_incidencias.php" class="btn btn-secondary mb-1">Volver</a>
    <h1 class="mb-2">Detalls de l'incidencia <strong>#<?php echo $incidencia["id"]?></strong></h1>
    <div class="row"> 
        <div class="col-md-6">
            <div class="card bg-dark text-light p-3 border-secondary">
                <h3>Informació General</h3>
                <hr class="border-secondary">

                <h4><strong>Títol</strong></h4>
                <p class="medium"><?php echo $incidencia["title"]?></p>

                <h4><strong>Descripció</strong></h4>
                <p class="medium"><?php echo $incidencia["descripcio"]?></p>

                <div class="row">
                    <div class="col-6">
                        <h4><strong>Estat</strong></h4>
                        <p class="medium"><?php echo $incidencia["estado"]?></p>
                    </div>
                    <div class="col-6">
                        <h4><strong>Prioritat</strong></h4>
                        <p class="medium"><?php echo $incidencia["prioritat"] ?? "No assignada"; ?></p>
                    </div>
                </div>

                <h4><strong>Fecha creació</strong></h4>
                <p class="medium"><?php echo $incidencia["data_incidencia"]?></p>

                <h4><strong>Tècnic</strong></h4>
                <p class="medium"><?php echo $incidencia["tecnic_nom"] ?? "No assignat"; ?></p>

                <h4><strong>Tipo</strong></h4>
                <p class="medium"><?php echo $tipo["nom"] ?? "No assignat"; ?></p>

                <h4><strong>Ultima actualitzacio</strong></h4>
                <p class="medium"><?php echo $incidencia["ultima_actuacio_data"] ?? "Sense actualitzacions"; ?></p>

                <div class="mt-4">
                    <a href="/formulari_actuacio.php?id=<?php echo $incidencia["id"]?>" class="btn btn-primary w-100">Afegir Actuació</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 border-start border-secondary">
            <h3 class="ms-3">Historial d'actuacions</h3>
            <div class="p-3">
                <?php if ($historial->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while($act = $historial->fetch_assoc()): ?>
                            <?php if($act["visible_usuari"] == "Si"): ?>
                                <li class="list-group-item bg-dark text-light border-secondary mb-2">
                                    <small class="text-secondary d-block mb-1">
                                        <strong><?php echo $act["data_actuacio"] ?></strong> — <?php echo $act["temps_minuts"] ?> minuts
                                    </small>
                                    <p class="mb-0 text-light"><?php echo $act["descripcio"] ?></p>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted fst-italic">No hi ha actuacions registrades.</p>
                <?php endif; ?>
            </div>
        </div>
    </div> </div> <?php include_once "footer.php"; ?>