<?php
include_once "conneccion.php";
$id = $_GET["id"];
$sentencia = $mysqli->prepare(
    "SELECT id, title, descripcio, departament_id, data_incidencia
     FROM incidencies
      WHERE id = ?"
);

$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$incidencia = $resultado->fetch_assoc();

if (!$incidencia) {
    exit("No hay resultados para ese ID");
}

include_once "header.php"; 
?>

<div class="row">
    <div class="col-12">
        <h1>Detalls de l'incidencia <strong>#<?php echo $incidencia["id"]?></strong></h1>
        <h2>Informacion General</h2>
        <h3><strong>Titul</strong><p><?php echo $incidencia["title"]?></p></h3>
        <h3><strong>Titul</strong><p><?php echo $incidencia["title"]?></p></h3>

    </div>
</div>
<?php include_once "footer.php"; ?>