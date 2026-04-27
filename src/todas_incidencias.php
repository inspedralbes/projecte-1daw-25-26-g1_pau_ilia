<?php include_once "header.php"; ?>
<?php
$mysqli = include_once "conneccion.php";
$resultado = $mysqli->query("SELECT title, estado, prioritat, tecnic_id, data_incidencia FROM incidencies");
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);?>
<table class="table">
            <thead>
                <tr>
                    <th>Titul</th>
                    <th>Estat</th>
                    <th>Prioritat</th>
                    <th>Tecnic asignat</th>
                    <th>data creacio</th>
                    <th>Informacio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($incidencias as $incidencia) { ?>
                    <tr>
                        <td><?php echo $incidencia["title"] ?></td>
                        <td><?php echo $incidencia["estado"] ?></td>
                        <td>
                            <?php 
                                $color = "black";
                                $prioritat = $incidencia["prioritat"];

                                switch ($prioritat) {
                                    case 'Alta':
                                        $color = "red";
                                        break;
                                    case 'Mitjana':
                                        $color = "yellow";
                                        break;
                                    case 'Baixa': 
                                        $color = "green";
                                        break;
                                }
                                ?>
                                <p style="color: <?php echo $color; ?>; font-weight: bold;">
                                    <?php echo $prioritat; ?>
                                </p>
                        </td>
                        <td><?php echo $incidencia["tecnic_id"] ?></td>
                        <td><?php echo $incidencia["data_incidencia"] ?></td>      
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php include_once "footer.php"; ?>