<?php
include_once "conneccion.php";
require_once 'logger.php';

if (!isset($_GET["id"])) {
    exit("ID no proporcionado");
}



$id = $_GET["id"];
$sentencia = $mysqli->prepare("SELECT * FROM incidencies WHERE id = ?");
$sentencia->bind_param("i", $id);
$sentencia->execute();
$resultado = $sentencia->get_result();
$incidencia = $resultado->fetch_assoc();



if (!$incidencia) {
    exit("No hay resultados para ese ID");
}

include_once "header.php"; 
?>


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


<html>
    <body>
        <div class="container mt-4 mb-4">
            <a href="/incidencia.php?id=<?php echo htmlspecialchars($id)?>"  class="btn btn-secondary rounded-pill mb-1"><i class="bi bi-arrow-bar-left mx-1"></i>Tornar</a>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2">
                    <h1 class="mb-4">Registrar Actuació</h1>
                    <form action="insertar_actuacio.php" method="POST" id="formActuacion" class="card p-4 shadow-sm">
                        <input type="hidden" name="id_incidencia" value="<?php echo htmlspecialchars($id); ?>">

                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold">Descripció</label>
                            <textarea placeholder="Añade una descripción..." class="form-control placeholder-primary bg-light" name="descripcion" id="descripcion" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="temp" class="form-label fw-bold">Temps invertit</label>
                            <input placeholder="Ej. 20min" class="form-control placeholder-primary bg-light" type="text" name="temp" id="temp">
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input type="hidden" name="visible_usuari" value="No">
                            <input class="form-check-input" type="checkbox" name="visible_usuari" id="visible_usuari" value="Si">
                            <label class="form-check-label fw-bold" for="visible_usuari">Visible per l'usuari</label>
                        </div>

                        <div class="row col-md-12">
                            <div class="mb-2 col-6">
                                <button type="submit" name="accion" value="registrar" class="btn btn-primary w-100">
                                    <i class="bi bi-save me-2"></i>Registrar Actuació
                                </button>
                            </div>
                            <div class="mb-2 col-6">
                                <button type="submit" name="accion" value="cerrar" class="btn btn-secondary w-100">
                                    <i class="bi bi-check-circle me-2"></i>Tancar Incidència
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    const form = document.getElementById('formActuacion');
    let botonPulsado = "";
        form.querySelectorAll('button[type="submit"]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                botonPulsado = e.currentTarget.value;
            });
        });

        form.addEventListener('submit', function(e) {
            if (botonPulsado === "registrar") {
                const descripcion = document.getElementById('descripcion').value.trim();
                const temps = document.getElementById('temp').value.trim();

                if (descripcion.length < 15) {
                    e.preventDefault();
                    alert("Para registrar una actuación, la descripción debe tener al menos 15 caracteres.");
                    return;
                }
                if (!/\d/.test(temps)) {
                    e.preventDefault();
                    alert("Debe indicar el tiempo invertido.");
                    return;
                }
            }
        });
</script>

<?php include_once "footer.php"; ?>
