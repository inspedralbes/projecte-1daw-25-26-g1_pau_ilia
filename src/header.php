<?php require_once 'logger.php';
 ?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestio d'incidencies</title>
    <link rel="icon" type="image/png" href="/img/logo_institut.png">

    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/slate/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }

        .navbar-toggler:focus,
        .navbar-toggler:focus-visible {
            outline: 3px solid #fff;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(255,255,255,.35);
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath fill-rule='evenodd' d='M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z'/%3e%3cpath fill-rule='evenodd' d='M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z'/%3e%3c/svg%3e");
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4 py-2 px-md-0 px-4" aria-label="Navegació principal">
        <div class="container">
            <a class="navbar-brand text-light" href="index.php">
                <img src="/img/logo_institut.png" alt="Logo" width="40" height="40">
                Institut Pedralbes
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar menú de navegació">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3 py-3 py-lg-0">
                    
                    <li class="nav-item d-flex align-items-center">
                        <label for="incidenciaId" class="visually-hidden">Cercar incidència per ID</label>
                        <input type="number" id="incidenciaId" class="form-control form-control-sm me-2" 
                            placeholder="ID..." 
                            style="width: 0; opacity: 0; transition: all 0.4s ease; padding: 0; border: none; overflow: hidden;"
                            aria-hidden="true">
                        
                        <button type="button" onclick="gestionarBusqueda()" id="btnBusqueda" 
                                class="btn btn-secondary rounded-circle text-light p-0 d-flex align-items-center justify-content-center" 
                                style="width: 38px; height: 38px; border: none;"
                                aria-label="Obrir cercador">
                            <i class="bi bi-search" aria-hidden="true"></i>
                        </button>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light d-flex align-items-center" href="tecnics.php">
                            <i class="bi bi-tools me-2" aria-hidden="true"></i> Tècnics
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light d-flex align-items-center" href="dashboard.php">
                            <i class="bi bi-speedometer2 me-2" aria-hidden="true"></i> Panel
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-light d-flex align-items-center" href="departamentos.php">
                            <i class="bi bi-building-fill me-2" aria-hidden="true"></i> Departaments
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-warning d-flex align-items-center" href="todas_incidencias.php">
                            <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i> Incidències
                        </a>
                    </li>

                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-light rounded-pill btn-sm text-black px-3 py-2 d-flex align-items-center" href="formulari_incidencia.php">
                            <i class="bi bi-plus-circle me-2" aria-hidden="true"></i> Afegir Incidència
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function gestionarBusqueda() {
            const input = document.getElementById('incidenciaId');
            const id = input.value;

            const estilo = window.getComputedStyle(input);
            const estaOculto = estilo.width === '0px' || estilo.opacity === '0';

            if (estaOculto) {
                input.style.display = "block";
                input.style.width = '120px';
                input.style.opacity = '1';
                input.style.padding = '0.25rem 0.5rem';
                input.style.marginRight = '10px';
                input.style.border = '1px solid #ced4da';
                input.setAttribute('aria-hidden', 'false');
                input.focus();
            } else {
                if (id !== "") {
                    window.location.href = "incidencia.php?id=" + id;
                } else {
                    input.style.width = '0';
                    input.style.opacity = '0';
                    input.style.padding = '0';
                    input.style.marginRight = '0';
                    input.style.border = 'none';

                    input.setAttribute('aria-hidden', 'true');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('incidenciaId');

            if (input) {
                input.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') gestionarBusqueda();
                });
            }
        });
        
    </script>
</body>
</html>