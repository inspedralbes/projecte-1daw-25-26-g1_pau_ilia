<?php
include_once "conneccion.php";

if (!isset($_GET["id"])) {
    exit("ID no proporcionado");
}



$id = $_GET["id"];
$sentencia = $mysqli->prepare("SELECT id, title, descripcio, departament_id, data_incidencia FROM incidencies WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$incidencia = $resultado->fetch_assoc();


$sentencia_dep = $mysqli->prepare(
    "SELECT nom 
    FROM departaments 
    WHERE id = ?"
);

$sentencia_dep->bind_param("i", $incidencia["departament_id"]);
$sentencia_dep->execute();
$resultado_dep = $sentencia_dep->get_result();
$department = $resultado_dep->fetch_assoc();






if (!$incidencia) {
    exit("No hay resultados para ese ID");
}

include_once "header.php"; 
?>

<div class="container mt-5 text-center">
    <div class="card shadow p-5">
        <h1 class="text-success">Registro Exitoso!</h1>
        <p class="lead">La teva incidencia amd <strong>ID: <?php echo $incidencia["id"] ?></strong> ha sigut registrada correctament</p>
        
        <div class="my-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
        </div>

        <ul class="list-group list-group-flush text-start mb-4">
            <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($incidencia["title"]) ?></li>
            <li class="list-group-item"><strong>Departament:</strong> <?php echo htmlspecialchars($department["nom"]) ?></li>
            <li class="list-group-item"><strong>Fecha:</strong> <?php echo htmlspecialchars($incidencia["data_incidencia"]) ?></li>
        </ul>

        <div class="d-grid gap-2 d-md-block">
            <a href="/" class="btn btn-primary">Volver al inicio</a>
            <a href="formulari_incidencia.php" class="btn btn-secondary">Registrar nova incidencia</a>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>