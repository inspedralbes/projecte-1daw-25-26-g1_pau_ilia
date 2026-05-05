<?php include_once "header.php";
require_once 'logger.php';


$resultado = $mysqli->query("SELECT COUNT(*) FROM incidencies");
$total_inc = $resultado->fetch_all(MYSQLI_ASSOC);



?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2 class="display-5 mb-4 text-light">
            <i class="bi bi-exclamation-triangle-fill me-3"></i>Gestió d'incidències
            </h2>
            <p class="lead text-muted">Benvingut al sistema de gestió d'incidències del Institut Pedralbes</p>
            <p class="lead mb-5 text-muted">Què vols fer avui?</p>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm rounded-4 border-0">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-exclamation-octagon-fill fs-1 text-danger"></i>
                            </div>
                            <h5 class="card-title">Tots les incidències</h5>
                            <p class="card-text text-muted small">Consulta totes les incidències y els seus detalls.</p>
                            <a href="todas_incidencias.php" class="btn rounded-pill btn-outline-light border-light mt-auto">
                                <i class="bi bi-list-ul"></i> Veure llista
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 rounded-4 bg-light">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-plus-circle-fill fs-1 text-warning"></i>
                            </div>
                            <h5 class="text-primary">Nova Incidència</h5>
                            <p class="card-text text-primary small">Afegeix una nova incidència a la base de dates</p>
                            <a href="formulari_incidencia.php" class="button btn  btn-primary rounded-pill mt-auto shadow-sm">
                                <i class="bi bi-plus-lg"></i> Agregar nova incidència
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="mt-5 mb-2 opacity-25">
        </div>
    </div>
</div>


<div class="container mt-4">
    <div class="row text-center">
        <h2 class="text-light mb-4">Estàdistica de totes les incidències</h2>
        
        <div class="col-md-4">
            <div class="card bg-dark mb-2 rounded-4 border-secondary p-2">
                <h5 class="text-light">Registrats</h5>
                <h2 class="text-secondary"><?php echo $total; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark mb-2 rounded-4 border-secondary p-2">
                <h5 class="text-light">En procés</h5>
                <h2 class="text-warning"><?php echo $enProces; ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark mb-2 rounded-4 border-secondary p-2">
                <h5 class="text-light">Tancades</h5>
                <h2 class="text-success"><?php echo $tancades; ?></h2>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>