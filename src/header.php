<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .nav-link:not(.btn):hover { color: #0d6efd !important; transition: 0.3s; }
        .nav-link.btn:hover { color: #ffffff !important; transform: scale(1.05); transition: 0.3s; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand text-primary" href="index.php">
                <i class="bi bi-controller"></i> GAMESTACK
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="mostrar.php">
                            <i class="bi bi-table"></i> Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm text-white ms-lg-3 px-3" href="insertar.php">
                            <i class="bi bi-plus-circle"></i> Nuevo Juego
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
