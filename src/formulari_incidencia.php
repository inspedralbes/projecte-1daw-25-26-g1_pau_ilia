<?php include_once "header.php"; ?>

<head>
    <style>
        .placeholder-primary::placeholder {
            color: var(--bs-primary) !important;
            opacity: 1; 
        }
        .placeholder-primary::-webkit-input-placeholder { color: var(--bs-primary); }
        .placeholder-primary::-moz-placeholder { color: var(--bs-primary); }
        .placeholder-primary:-ms-input-placeholder { color: var(--bs-primary); }   
    </style>
</head>


<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <h1 class="mb-4">Registrar Incidència</h1>
            <form action="insertar_incidencia.php" method="POST" class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Titul</label>
                    <input placeholder="Ej. Teclado no funcciona" class="form-control placeholder-primary bg-light" type="text" name="title" id="title" required>
                </div>
                <div class="mb-4">
                    <label for="departaments" class="form-label fw-bold">Departament</label>
                    <select class="form-select placeholder-primary bg-light" name="departament" id="departaments" required>
                        <option value="" disabled selected>Selecciona un departament</option>
                        <option class="placeholder-primary bg-light" value="1">Ciències naturals</option>
                        <option class="placeholder-primary bg-light" value="2">Matemàtiques</option>
                        <option class="placeholder-primary bg-light" value="3">Informatica</option>
                        <option class="placeholder-primary bg-light" value="4">Llengues estrangeres</option>                    
                        <option class="placeholder-primary bg-light" value="5">Direcció</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label fw-bold">Data</label>
                    <input class="form-control placeholder-primary bg-light" type="date" name="date" id="date" required>
                </div>
                <div class="mb-4">
                    <label for="descripcion" class="form-label fw-bold">Descripció</label>
                    <textarea placeholder="Añade una descripción..." class="form-control placeholder-primary bg-light" name="descripcion" id="descripcion" rows="3" required></textarea>
                </div>

                <div class="mb-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-save"></i> Registrar Incidència
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>
