<?php include_once "header.php"; ?>
<?php
$mysqli = include_once "conneccion.php";
$resultado = $mysqli->query("SELECT id, title, estado, prioritat, tecnic_id, data_incidencia FROM incidencies");
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);?>

<div class="col m-4">
    <div>
<h1 class="text-center text-white fw-bold">Totes les incidencies</h1>
<br>
</div>

<table class="table rounded-4">
            <thead>
                <tr class="align-middle">
                    <th class="p-3">Titul</th>
                    <th class="p-3">Estat</th>
                    <th class="p-3">Prioritat</th>
                    <th class="p-3">Tecnic asignat</th>
                    <th class="p-3">Data creacio</th>
                    <th class="p-3 text-center">Informacio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($incidencias as $incidencia) { ?>
                    <tr class="align-middle">
                        <td class="p-3"><?php echo $incidencia["title"] ?></td>
                        <td class="p-3"><?php echo $incidencia["estado"] ?></td>
                        <td class="p-3"> <?php 
                                $prioritat = $incidencia["prioritat"] ?? "No asignada";
                                $color = "light"; 

                                switch ($prioritat) {
                                    case 'Alta': $color = "#ff4d4d"; break; 
                                    case 'Mitjana': $color = "#ffc107"; break; 
                                    case 'Baixa': $color = "#28a745"; break;
                                }
                            ?>
                            <p class="m-0 " style="color: <?php echo $color; ?>;">
                                <?php echo $prioritat; ?>
                            </p>
                        </td>
                        <td class="p-3"><?php echo $incidencia["tecnic_id"] ?? "No asignat"?></td>
                        <td class="p-3 "><?php echo $incidencia["data_incidencia"] ?></td>
                        <td class="p-3"><a href="incidencia.php?id=<?php echo $incidencia["id"]?>" class="nav-link btn btn-light rounded-pill btn-sm text-black ms-lg-3 p-2">Informacio Incidencia</a></td>     
                    </tr>
                <?php } ?>
            </tbody>
        </table>

</div>


<?php include_once "footer.php"; ?>