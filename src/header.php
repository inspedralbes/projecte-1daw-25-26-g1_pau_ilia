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
        :root {
            --primary-bg: #45494e; 
            --accent-color: #f0ad4e; 
            --text-white: #ffffff;
            --transition: all 0.3s ease;
        }

        .custom-navbar {
            background-color: var(--primary-bg);
            padding: 0.8rem 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            font-family: sans-serif;
            margin-bottom: .7rem;

        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: bold;
            gap: 10px;
        }

        .nav-logo img { height: 40px; }

        .nav-menu {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 20px;
            margin: 0;
        }

        .nav-link {
            color: #ccc;
            text-decoration: none;
            transition: var(--transition);
        }

        .nav-link:hover { color: white; }
        .highlight { color: var(--accent-color) !important; }

        .btn-add {
            background: white;
            color: black;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: var(--transition);
        }

        .btn-add:hover { background: #ddd; }

        .search-container { display: flex; align-items: center; }
        .search-input {
            width: 0;
            opacity: 0;
            transition: var(--transition);
            border: none;
            border-radius: 4px;
            outline: none;
        }
        .search-input.active {
            width: 100px;
            opacity: 1;
            padding: 5px;
            margin-right: 5px;
        }
        .btn-search { background: transparent; border: none; cursor: pointer; font-size: 1.2rem; }

        .menu-toggle { display: none; flex-direction: column; cursor: pointer; background: none; border: none; }
        .bar { height: 3px; width: 25px; background-color: white; margin: 4px 0; border-radius: 2px; }

        @media (max-width: 992px) {
            .menu-toggle { display: flex; }

            .nav-menu {
                position: absolute;
                top: -100%;
                left: 0;
                flex-direction: column;
                background-color: var(--primary-bg);
                width: 100%;
                text-align: center;
                transition: 0.4s;
                padding: 20px 0;
                box-shadow: 0 10px 10px rgba(0,0,0,0.2);
                z-index: 100;
                filter: brightness(100%);
            }

            .nav-menu.active { top: 65px;
                filter: brightness(90%);
                }
            .nav-item { margin: 15px 0; }
        }
        
    </style>
</head>
<body>
    <nav class="custom-navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <img src="/img/logo_institut.png" alt="Logo">
            <span>Institut Pedralbes</span>
        </a>

        <button class="menu-toggle" id="mobile-menu" aria-label="Obrir menú">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <ul class="nav-menu" id="nav-menu">
            <li class="nav-item search-container">
                <input type="number" id="incidenciaId" placeholder="ID..." class="search-input">
                <button type="button" onclick="gestionarBusqueda()" class="btn-search" aria-label="Cercar">
                    <i class="bi bi-search text-light"></i>
                </button>
            </li>
            
            <li class="nav-item">
                <a href="tecnics.php" class="nav-link">
                    <i class="bi bi-tools"></i> Tècnics
                </a>
            </li>
            
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Panel
                </a>
            </li>
            
            <li class="nav-item">
                <a href="departamentos.php" class="nav-link">
                    <i class="bi bi-building-fill"></i> Departaments
                </a>
            </li>
            
            <li class="nav-item">
                <a href="todas_incidencias.php" class="nav-link highlight">
                    <i class="bi bi-exclamation-triangle-fill"></i> Incidències
                </a>
            </li>
            
            <li class="nav-item">
                <a href="formulari_incidencia.php" class="btn-add">
                    <i class="bi bi-plus-circle"></i> Afegir Incidència
                </a>
            </li>
        </ul>
    </div>
</nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        const menuToggle = document.getElementById('mobile-menu');
        const navMenu = document.getElementById('nav-menu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });

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