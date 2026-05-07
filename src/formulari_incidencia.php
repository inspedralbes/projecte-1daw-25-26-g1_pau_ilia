<?php include_once "header.php"; 
require_once 'logger.php';
?>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <h1 class="mb-4">Registrar Incidència</h1>
            <form action="insertar_incidencia.php" method="POST" class="card p-4 shadow-sm">
                <p class="text-muted small">Tots els camps amb <span class="text-danger">*</span> són obligatoris.</p>
                
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Títol <span class="text-danger">*</span></label>
                    <input placeholder="Ex. El teclat no funciona" class="form-control bg-light" type="text" name="title" id="title" required aria-required="true">
                </div>

                <div class="mb-4">
                    <label for="departaments" class="form-label fw-bold">Departament <span class="text-danger">*</span></label>
                    <select class="form-select bg-light" name="departament" id="departaments" required aria-required="true">
                        <option value="" disabled selected>Selecciona un departament</option>
                        <option value="1">Ciències naturals</option>
                        <option value="2">Matemàtiques</option>
                        <option value="3">Informàtica</option>
                        <option value="4">Llengües estrangeres</option>                    
                        <option value="5">Direcció</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label fw-bold">Data <span class="text-danger">*</span></label>
                    <input class="form-control bg-light" type="date" name="date" id="date" required aria-required="true" max="<?= date('Y-m-d') ?>">
                </div>

                <div class="mb-4">
                    <label for="descripcion" class="form-label fw-bold">Descripció <span class="text-danger">*</span></label>
                    <textarea placeholder="Explica breument el problema..." class="form-control bg-light" name="descripcion" id="descripcion" rows="3" required aria-required="true" minlength="10"></textarea>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-save" aria-hidden="true"></i> Registrar Incidència
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>
