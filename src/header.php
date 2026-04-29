<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestio d'incidencies</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/slate/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4 py-1">
        <div class="container">
            <a class="navbar-brand text-light" href="index.php">
                 Institut Pedralbes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item mx-2 d-flex align-items-center">
                        <input type="number" id="incidenciaId" class="form-control form-control-sm" 
                            placeholder="ID..." 
                            style="width: 0; opacity: 0; transition: all 0.4s ease; overflow: hidden;">
                        
                        <button type="button" onclick="gestionarBusqueda()" id="btnBusqueda" 
                                class="nav-link btn btn-secondary rounded-circle text-light p-2" 
                                style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border: none;">
                            <i class="bi bi-search"></i>
                        </button>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-light" href="mostrar.php">
                            <i class="bi bi-tools"></i> Tecnics
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link text-warning" href="todas_incidencias.php">
                            <i class="bi bi-exclamation-triangle-fill"></i> Incidencies
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link btn btn-light rounded-pill btn-sm text-black ms-lg-3 p-2" href="formulari_incidencia.php">
                            <i class="bi bi-plus-circle"></i> Afegir Incidencia
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