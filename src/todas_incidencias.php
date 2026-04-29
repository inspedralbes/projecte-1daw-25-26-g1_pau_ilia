<?php
include_once "header.php";
$mysqli = include_once "conneccion.php";

$resultado = $mysqli->query("SELECT id, title, estado, prioritat, tecnic_id, tipus_id, data_incidencia
FROM incidencies");
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);

$res_tipos = $mysqli->query("SELECT id, nom FROM tipos_incidencia");
$tipos_disponibles = $res_tipos->fetch_all(MYSQLI_ASSOC);

$res_tecnics = $mysqli->query("SELECT id, nom FROM tecnics");
$tecnics = $res_tecnics->fetch_all(MYSQLI_ASSOC);
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
</style>


<div class="col m-4">
    <div>
<h1 class="text-center text-white fw-bold">Totes les incidencies</h1>
<br>
</div>

<table class="table rounded-4">
    <thead>
        <tr class="align-middle">
            <th class="p-3">Titul</th>
            <th class="p-3">Estat</th>
            <th class="p-3">Prioritat</th>
            <th class="p-3">Tipo</th>
            <th class="p-3">Tècnic</th>
            <th class="p-3">Data</th>
            <th class="p-3">Informació</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($incidencias as $incidencia) { ?>
            <tr class="align-middle">
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
                        <span class="fw-bold asign-btn" style="color: <?php echo $color; ?>;">
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

                <td class="p-3">
                    <?php if (empty($incidencia["tecnic_id"])): ?>
                        <button type="button" class="btn btn-outline-light btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalAssignar" 
                                data-id="<?php echo $incidencia['id']; ?>" 
                                data-tipus="tecnics">
                            Assignar
                        </button>
                    <?php else: ?>
                        <span class="fw-bold asign-btn">
                            <?php 
                                foreach ($tecnics as $t) {
                                    if ($t['id'] == $incidencia['tecnic_id']) echo $t['nom'];
                                }
                            ?>
                            <button type="button" class="btn btn-outline-light mx-1 btn-sm edit-btn" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalAssignar" 
                                data-id="<?php echo $incidencia['id']; ?>" 
                                data-tipus="tecnics"><i class="bi bi-pencil"></i></button>
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


        <div id="selector_tecnics" class="d-none">
            <label class="form-label">Tria el Tecnic:</label>
            <select name="valor_tecnics" class="form-select">
                <?php foreach ($tecnics as $t): ?>
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
    document.getElementById('selector_tecnics').classList.add('d-none');
    document.getElementById('selector_tipus').classList.add('d-none');
  } else if (tipus === 'tipus'){
    document.getElementById('selector_tipus').classList.remove('d-none');
    document.getElementById('selector_prioritat').classList.add('d-none');
    document.getElementById('selector_tecnics').classList.add('d-none');
  }else{
    document.getElementById('selector_tecnics').classList.remove('d-none');
    document.getElementById('selector_prioritat').classList.add('d-none');
    document.getElementById('selector_tipus').classList.add('d-none');
  }
});
</script>

<?php include_once "footer.php"; ?>