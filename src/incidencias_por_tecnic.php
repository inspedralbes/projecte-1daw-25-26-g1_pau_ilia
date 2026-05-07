<?php
include_once "header.php";
$mysqli = include_once "conneccion.php";
require_once 'logger.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='alert alert-danger m-4'>Error: No s'ha especificat un tècnic vàlid.</div>");
}
$id_tecnic = $_GET['id'];

$stmt_nom = $mysqli->prepare("SELECT nom FROM tecnics WHERE id = ?");
$stmt_nom->bind_param("i", $id_tecnic);
$stmt_nom->execute();
$res_nom = $stmt_nom->get_result();
$tecnic_actual = $res_nom->fetch_assoc();
$nom_del_tecnic = $tecnic_actual ? $tecnic_actual['nom'] : "Desconegut";

$stmt_incidencias = $mysqli->prepare("SELECT id, title, estado, prioritat, tipus_id, data_incidencia 
                                      FROM incidencies WHERE tecnic_id = ?");
$stmt_incidencias->bind_param("i", $id_tecnic);
$stmt_incidencias->execute();
$resultado = $stmt_incidencias->get_result();
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);

$res_tipos = $mysqli->query("SELECT id, nom FROM tipos_incidencia");
$tipos_disponibles = $res_tipos->fetch_all(MYSQLI_ASSOC);
?>

<style>
    table .asign-btn{
        display: flex;
    }

    table .asign-btn .edit-btn{
        opacity: 0;
        transition: .3s;
    }

    table .asign-btn:hover .edit-btn{
        opacity: 1;
        transition: .3s;
    }
    
    table tbody tr[style*="background-color"] td {
        background-color: transparent !important;
    }
</style>

<div class="col m-4">
    <div>
        <h1 class="text-center text-white fw-bold">Incidències assignades a: <?php echo htmlspecialchars($nom_del_tecnic); ?></h1>
        <br>
        <a href="/tecnics.php" class="btn btn-secondary rounded-pill mb-4 px-2 px-md-4 py-md-2">Tornar</a>
    </div>

    <table class="table rounded-4">
        <thead>
            <tr class="align-middle">
                <th class="p-3">ID</th> 
                <th class="p-3">Títol</th>
                <th class="p-3">Estat</th>
                <th class="p-3">Prioritat</th>
                <th class="p-3">Tipus</th>
                <th class="p-3">Data</th>
                <th class="p-3">Informació</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencias as $incidencia) { 
                $bg_color = "";
                switch ($incidencia["prioritat"]) {
                    case 'Alta':
                        $bg_color = "#50080841"; 
                        break;
                    case 'Mitjana':
                        $bg_color = "#614f0c4f"; 
                        break;
                    case 'Baixa': 
                        $bg_color = "#0b612644"; 
                        break;
                }
            ?>
                <tr class="align-middle" style="<?php echo !empty($bg_color) ? 'background-color: ' . $bg_color . ' !important;' : ''; ?>">
                    <td class="p-3 fw-bold">#<?php echo $incidencia["id"] ?></td>
                    <td class="p-3"><?php echo $incidencia["title"] ?></td>
                    <td class="p-3"><?php echo $incidencia["estado"] ?></td>
                    
                    <td class="p-3">
                        <?php if (empty($incidencia["prioritat"])): ?>
                            <button type="button" class="btn btn-outline-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAssignar" 
                                    data-id="<?php echo $incidencia['id']; ?>" 
                                    data-tipus="prioritat">
                                Assignar
                            </button>
                        <?php else: ?>
                            <span class="fw-bold asign-btn">
                                <?php echo $incidencia["prioritat"]; ?>
                                <button type="button" class="btn btn-outline-warning mx-1 btn-sm edit-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAssignar" 
                                    data-id="<?php echo $incidencia['id']; ?>" 
                                    data-tipus="prioritat"><i class="bi bi-pencil"></i></button>
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="p-3">
                        <?php if (empty($incidencia["tipus_id"])): ?>
                            <button type="button" class="btn btn-outline-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAssignar" 
                                    data-id="<?php echo $incidencia['id']; ?>" 
                                    data-tipus="tipus">
                                Assignar
                            </button>
                        <?php else: ?>
                            <span class="fw-bold asign-btn">
                                <?php 
                                    foreach ($tipos_disponibles as $t) {
                                        if ($t['id'] == $incidencia['tipus_id']) echo $t['nom'];
                                    }
                                ?>
                                <button type="button" class="btn btn-outline-info mx-1 btn-sm edit-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalAssignar" 
                                    data-id="<?php echo $incidencia['id']; ?>" 
                                    data-tipus="tipus"><i class="bi bi-pencil"></i></button>
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="p-3"><?php echo $incidencia["data_incidencia"] ?></td>
                    <td class="p-3">
                        <a href="incidencia.php?id=<?php echo $incidencia["id"]?>" class="btn btn-light rounded-pill btn-sm text-black">
                            Informació
                        </a>
                    </td>     
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
</div>

<div class="modal fade" id="modalAssignar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="actualitzar_incidencia.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Assignar Valor</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_incidencia" id="modal_id">
          <input type="hidden" name="camp_a_actualitzar" id="modal_camp">
          
          <div id="selector_prioritat" class="d-none">
            <label class="form-label">Tria la Prioritat:</label>
            <select name="valor_prioritat" class="form-select">
                <option value="Alta">Alta</option>
                <option value="Mitjana">Mitjana</option>
                <option value="Baixa">Baixa</option>
            </select>
          </div>

          <div id="selector_tipus" class="d-none">
            <label class="form-label">Tria el Tipus:</label>
            <select name="valor_tipus" class="form-select">
                <?php foreach ($tipos_disponibles as $t): ?>
                    <option value="<?php echo $t['id']; ?>"><?php echo $t['nom']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>
          
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
          <button type="submit" class="btn btn-primary">Guardar canvis</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const modalAssignar = document.getElementById('modalAssignar');
modalAssignar.addEventListener('show.bs.modal', event => {
  const button = event.relatedTarget;
  const id = button.getAttribute('data-id');
  const tipus = button.getAttribute('data-tipus');

  document.getElementById('modal_id').value = id;
  document.getElementById('modal_camp').value = tipus;

  if(tipus === 'prioritat') {
    document.getElementById('selector_prioritat').classList.remove('d-none');
    document.getElementById('selector_tipus').classList.add('d-none');
  } else if (tipus === 'tipus'){
    document.getElementById('selector_tipus').classList.remove('d-none');
    document.getElementById('selector_prioritat').classList.add('d-none');
  }
});
</script>

<?php include_once "footer.php"; ?>