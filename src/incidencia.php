<?php
include_once "conneccion.php";
require_once 'logger.php';

$id = $_GET["id"];

$sentencia = $mysqli->prepare("SELECT i.*, t.nom AS tecnic_nom FROM incidencies i LEFT JOIN tecnics t ON i.tecnic_id = t.id WHERE i.id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$incidencia = $sentencia->get_result()->fetch_assoc();

if (!$incidencia) { exit("No hay resultados"); }

$res_tipos = $mysqli->query("SELECT id, nom FROM tipos_incidencia");
$tipos_disponibles = $res_tipos->fetch_all(MYSQLI_ASSOC);

$res_tecnics = $mysqli->query("SELECT id, nom FROM tecnics");
$tecnics_disponibles = $res_tecnics->fetch_all(MYSQLI_ASSOC);

$sentencia_historial = $mysqli->prepare("SELECT * FROM actuacions WHERE incidencia_id = ? AND visible_usuari = 'Si' ORDER BY data_actuacio DESC LIMIT 5");
$sentencia_historial->bind_param("i", $id);
$sentencia_historial->execute();
$historial = $sentencia_historial->get_result();

include_once "header.php"; 
?>

<div class="container-fluid p-3">
    <a href="todas_incidencias.php" class="btn rounded-pill btn-secondary mb-1">Tornar</a>
    <h1 class="mb-2">Detalls de la incidència <strong>#<?php echo $incidencia["id"]?></strong></h1>
    
    <form action="actualitzar_incidencia.php" method="POST">
        <input type="hidden" name="id_incidencia" value="<?php echo $incidencia['id']; ?>">
        <input type="hidden" name="bulk_update" value="1"> <div class="row"> 
            <div class="col-md-6 mb-2">
                <div class="card bg-dark text-light p-3 border-secondary">
                    <h3>Informació General</h3>
                    <hr class="border-secondary">
                    <h4><strong>Títol</strong></h4>
                    <p class="medium"><?php echo $incidencia["title"]?></p>
                    <div class="row">
                        <div class="col-6">
                            <h4><strong>Estat</strong></h4>
                            <p class="medium"><?php echo $incidencia["estado"]?></p>
                        </div>
                        <div class="col-6">
                            <h4><strong>Prioritat</strong></h4>
                            <select name="valor_prioritat" class="form-select bg-dark text-white border-secondary mb-3">
                                <option value="Alta" <?php echo ($incidencia['prioritat'] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                                <option value="Mitjana" <?php echo ($incidencia['prioritat'] == 'Mitjana') ? 'selected' : ''; ?>>Mitjana</option>
                                <option value="Baixa" <?php echo ($incidencia['prioritat'] == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
                            </select>
                        </div>
                    </div>
                    <h4><strong>Tècnic</strong></h4>
                    <select name="valor_tecnics" class="form-select bg-dark text-white border-secondary mb-3">
                        <option value="">No assignat</option>
                        <?php foreach ($tecnics_disponibles as $t): ?>
                            <option value="<?php echo $t['id']; ?>" <?php echo ($incidencia['tecnic_id'] == $t['id']) ? 'selected' : ''; ?>>
                                <?php echo $t['nom']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <h4><strong>Tipus</strong></h4>
                    <select name="valor_tipus" class="form-select bg-dark text-white border-secondary mb-3">
                        <option value="">No assignat</option>
                        <?php foreach ($tipos_disponibles as $t): ?>
                            <option value="<?php echo $t['id']; ?>" <?php echo ($incidencia['tipus_id'] == $t['id']) ? 'selected' : ''; ?>>
                                <?php echo $t['nom']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="row">
                            <div class="col-6">
                                <h4><strong>Data creació</strong></h4>
                                <p class="medium"><?php echo $incidencia["data_incidencia"]?></p>
                            </div>
                            <div class="col-6">
                                <h4><strong>Data de Finalització</strong></h4>
                                <p class="medium"><?php echo $incidencia["data_finalitzacio"] ?? "Aquesta incidencia esta en proceso"?></p>
                            </div>
                    </div>                
                    <h4><strong>Ultima actualització</strong></h4>
                    <p class="medium"><?php echo $incidencia["ultima_actuacio_data"] ?? "Sense actualitzacions"; ?></p>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">Guardar Canvis</button>
                        <a href="/formulari_actuacio.php?id=<?php echo $incidencia["id"]?>" class="btn btn-primary flex-grow-1">Afegir Actuació</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-2 border-start border-secondary d-flex flex-column align-content-end justify-content-start">
                <h3 class="ms-3">Historial d'actuacions</h3>
                <div class="p-3">
                    <?php if ($historial->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while($act = $historial->fetch_assoc()): ?>
                        <li class="list-group-item bg-dark text-light border-secondary mb-2">
                            <small class="text-secondary d-block mb-1">
                                <strong><?php echo $act["data_actuacio"] ?></strong> — <?php echo $act["temps_minuts"] ?> minuts
                            </small>
                            <p class="mb-0 text-light"><?php echo $act["descripcio"] ?></p>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php else: ?>
                    <p class="text-muted fst-italic">No hi ha actuacions registrades.</p>
                    <?php endif; ?>
                </div>
                
                <div class="p-3 text-end">
                    <a href="actuaciones.php?id=<?php echo $incidencia["id"]?>" class="btn rounded-pill btn-secondary mb-1">Ver Todas</a>
                </div>
            </div>
        </div> 
    </form>
</div>
<?php include_once "footer.php"; ?>



