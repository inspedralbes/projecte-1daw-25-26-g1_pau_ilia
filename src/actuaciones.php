<?php
include_once "header.php";
$mysqli = include_once "conneccion.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='alert alert-danger m-4'>Error: ID d'incidència no vàlid.</div>");
}
$id = $_GET['id'];

$sentencia = $mysqli->prepare("SELECT * FROM actuacions WHERE incidencia_id = ? ORDER BY data_actuacio DESC");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$actuaciones = $sentencia->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="col m-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="incidencia.php?id=<?php echo $id; ?>" class="btn btn-secondary rounded-pill px-4">Volver</a>
        
        <h2 class="text-white fw-bold bg-secondary bg-opacity-25 px-4 py-2 rounded m-0">
            Actuacions de l'incidencia amb ID: <?php echo $id; ?>
        </h2>
        
        <a href="formulari_actuacio.php?id=<?php echo $id; ?>" class="btn btn-light rounded-pill px-4 text-black">
            Afegir
        </a>
    </div>

    <table class="table rounded-4 text-center mt-3">
        <thead>
            <tr class="align-middle">
                <th class="p-3">Data creació</th>
                <th class="p-3 text-start">Descripció</th>
                <th class="p-3">Temps (minuts)</th>
                <th class="p-3">Visible per a l'usuari</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($actuaciones) > 0): ?>
                <?php foreach ($actuaciones as $act): ?>
                    <tr class="align-middle">
                        <td class="p-3"><?php echo htmlspecialchars($act["data_actuacio"] ?? ''); ?></td>
                        
                        <td class="p-3 text-start text-break" style="max-width: 400px;">
                            <?php echo htmlspecialchars($act["descripcio"] ?? ''); ?>
                        </td>
                        
                        <td class="p-3">
                            <span class="badge bg-secondary">
                                <?php echo htmlspecialchars($act["temps_minuts"] ?? '0'); ?> min
                            </span>
                        </td>
                        
                        <td class="p-3">
                            <?php if(isset($act["visible_usuari"]) && $act["visible_usuari"] == 'Si'): ?>
                                <span class="text-success fw-bold">Sí</span>
                            <?php else: ?>
                                <span class="text-danger">No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="p-5 text-muted fst-italic">
                        No hi ha actuacions registrades per a aquesta incidència encara.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<?php include_once "footer.php"; ?>