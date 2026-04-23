<?php include_once "header.php"; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4 text-primary">🕹️ Gestió de Videojocs</h1>
            <p class="lead mb-5 text-muted">Benvingut al sistema d'inventari. Què vols fer avui?</p>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-controller fs-1 text-primary"></i>
                            </div>
                            <h5 class="card-title">Inventari</h5>
                            <p class="card-text text-muted small">Consulta tots els jocs registrats i els seus detalls.</p>
                            <a href="mostrar.php" class="btn btn-outline-primary mt-auto">
                                <i class="bi bi-list-ul"></i> Veure llista
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 bg-light">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-plus-circle-fill fs-1 text-success"></i>
                            </div>
                            <h5 class="card-title">Nou Joc</h5>
                            <p class="card-text text-muted small">Afegeix un nou títol a la base de dades del sistema.</p>
                            <a href="insertar.php" class="btn btn-success mt-auto shadow-sm">
                                <i class="bi bi-plus-lg"></i> Agregar joc nou
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="mt-5 mb-4 opacity-25">
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>