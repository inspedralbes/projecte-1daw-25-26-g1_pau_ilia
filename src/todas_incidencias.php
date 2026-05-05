<?php
include_once "header.php";
$mysqli = include_once "conneccion.php";
require_once 'logger.php';

$sort = $_GET['sort'] ?? 'id';
$order = strtoupper($_GET['order'] ?? 'ASC');

if ($order !== 'ASC' && $order !== 'DESC') {
    $order = 'ASC';
}

$sql_order = "ORDER BY id DESC";

if ($sort === 'prioritat') {
    $sql_order = "ORDER BY (prioritat IS NULL OR prioritat = '') ASC, FIELD(prioritat, 'Alta', 'Mitjana', 'Baixa') $order";
} elseif ($sort === 'data') {
    $sql_order = "ORDER BY data_incidencia $order";
}

$resultado = $mysqli->query("SELECT id, title, estado, prioritat, tecnic_id, tipus_id, data_incidencia FROM incidencies $sql_order");
$incidencias = $resultado->fetch_all(MYSQLI_ASSOC);

$res_tipos = $mysqli->query("SELECT id, nom FROM tipos_incidencia");
$tipos_disponibles = $res_tipos->fetch_all(MYSQLI_ASSOC);

$res_tecnics = $mysqli->query("SELECT id, nom FROM tecnics");
$tecnics = $res_tecnics->fetch_all(MYSQLI_ASSOC);
?>

<style>
   .row-alta {
       background-color: rgba(220, 53, 69, 0.25);
       border-left: 5px solid #dc3545;
   }
   .row-mitjana {
       background-color: rgba(255, 193, 7, 0.2);
       border-left: 5px solid #ffc107;
   }
   .row-baixa {
       background-color: rgba(25, 135, 84, 0.25);
       border-left: 5px solid #198754;
   }

   table .asign-btn {
       display: flex;
       align-items: center;
   }

   table .asign-btn .edit-btn {
       opacity: 0.7;
       transition: .3s;
   }

   table tr:hover .edit-btn, .edit-btn:focus {
       opacity: 1;
   }
  
   table tbody tr[style*="background-color"] td {
       background-color: transparent !important;
   }
</style>

<main class="col m-4 table-responsive">
   
   <div class="d-flex justify-content-between align-items-center mb-4">
       <h1 class="text-white fw-bold m-0">Totes les incidències</h1>
       
        <select class="form-select bg-dark text-white border-light w-auto shadow-sm" aria-label="Ordenar incidències" onchange="if(this.value) window.location.href=this.value;">
            <option value="" selected disabled>Ordenar per...</option>
            <option value="?sort=prioritat&order=asc">Prioritat (Alta a Baixa)</option>
            <option value="?sort=prioritat&order=desc">Prioritat (Baixa a Alta)</option>
            <option value="?sort=data&order=desc">Data (Més recents primer)</option>
            <option value="?sort=data&order=asc">Data (Més antigues primer)</option>
        </select>
   </div>

   <table class="table table-dark table-hover rounded-4">
       <thead>
           <tr class="align-middle">
               <th scope="col" class="p-3">Títol</th>
               <th scope="col" class="p-3">Estat</th>
               <th scope="col" class="p-3">Prioritat</th>
               <th scope="col" class="p-3">Tipus</th>
               <th scope="col" class="p-3">Tècnic</th>
               <th scope="col" class="p-3">Data</th>
               <th scope="col" class="p-3">Informació</th>
           </tr>
       </thead>
       <tbody>
           <?php foreach ($incidencias as $incidencia) {
               $clase_prioritat = "";
               switch ($incidencia["prioritat"]) {
                   case 'Alta': $clase_prioritat = "row-alta"; break;
                   case 'Mitjana': $clase_prioritat = "row-mitjana"; break;
                   case 'Baixa': $clase_prioritat = "row-baixa"; break;
               }
           ?>
               <tr class="align-middle <?php echo $clase_prioritat; ?>">
                   <td class="p-3"><?php echo htmlspecialchars($incidencia["title"]) ?></td>
                   <td class="p-3"><?php echo htmlspecialchars($incidencia["estado"]) ?></td>
                  
                   <td class="p-3">
                       <?php if (empty($incidencia["prioritat"])): ?>
                           <button type="button" class="btn btn-outline-warning btn-sm"
                                   data-bs-toggle="modal" data-bs-target="#modalAssignar"
                                   data-id="<?php echo $incidencia['id']; ?>" data-tipus="prioritat"
                                   aria-label="Assignar prioritat a la incidencia <?php echo $incidencia['id']; ?>">
                               Assignar
                           </button>
                       <?php else: ?>
                           <div class="asign-btn">
                               <span><?php echo htmlspecialchars($incidencia["prioritat"]); ?></span>
                               <button type="button" class="btn btn-outline-warning mx-1 btn-sm edit-btn"
                                   data-bs-toggle="modal" data-bs-target="#modalAssignar"
                                   data-id="<?php echo $incidencia['id']; ?>" data-tipus="prioritat"
                                   aria-label="Editar prioritat de la incidencia <?php echo $incidencia['id']; ?>">
                                   <i class="bi bi-pencil" aria-hidden="true"></i>
                               </button>
                           </div>
                       <?php endif; ?>
                   </td>

                   <td class="p-3">
                       <?php if (empty($incidencia["tipus_id"])): ?>
                           <button type="button" class="btn btn-outline-info btn-sm"
                                   data-bs-toggle="modal" data-bs-target="#modalAssignar"
                                   data-id="<?php echo $incidencia['id']; ?>" data-tipus="tipus"
                                   aria-label="Assignar tipus a la incidencia <?php echo $incidencia['id']; ?>">
                               Assignar
                           </button>
                       <?php else: ?>
                           <div class="asign-btn">
                               <span>
                                   <?php
                                       foreach ($tipos_disponibles as $t) {
                                           if ($t['id'] == $incidencia['tipus_id']) echo htmlspecialchars($t['nom']);
                                       }
                                   ?>
                               </span>
                               <button type="button" class="btn btn-outline-info mx-1 btn-sm edit-btn"
                                   data-bs-toggle="modal" data-bs-target="#modalAssignar"
                                   data-id="<?php echo $incidencia['id']; ?>" data-tipus="tipus"
                                   aria-label="Editar tipus de la incidencia <?php echo $incidencia['id']; ?>">
                                   <i class="bi bi-pencil" aria-hidden="true"></i>
                               </button>
                           </div>
                       <?php endif; ?>
                   </td>

                   <td class="p-3">
                       <?php if (empty($incidencia["tecnic_id"])): ?>
                           <button type="button" class="btn btn-outline-light btn-sm"
                                   data-bs-toggle="modal" data-bs-target="#modalAssignar"
                                   data-id="<?php echo $incidencia['id']; ?>" data-tipus="tecnics"
                                   aria-label="Assignar tècnic a la incidencia <?php echo $incidencia['id']; ?>">
                               Assignar
                           </button>
                       <?php else: ?>
                           <div class="asign-btn">
                               <span>
                                   <?php
                                       foreach ($tecnics as $t) {
                                           if ($t['id'] == $incidencia['tecnic_id']) echo htmlspecialchars($t['nom']);
                                       }
                                   ?>
                               </span>
                               <button type="button" class="btn btn-outline-light mx-1 btn-sm edit-btn"
                                   data-bs-toggle="modal" data-bs-target="#modalAssignar"
                                   data-id="<?php echo $incidencia['id']; ?>" data-tipus="tecnics"
                                   aria-label="Editar tècnic de la incidencia <?php echo $incidencia['id']; ?>">
                                   <i class="bi bi-pencil" aria-hidden="true"></i>
                               </button>
                           </div>
                       <?php endif; ?>
                   </td>

                   <td class="p-3"><?php echo htmlspecialchars($incidencia["data_incidencia"]) ?></td>
                   <td class="p-3">
                       <a href="incidencia.php?id=<?php echo $incidencia["id"]?>"
                          class="btn btn-light rounded-pill btn-sm text-black"
                          aria-label="Més informació de la incidencia <?php echo $incidencia['id']; ?>">
                           Informació
                       </a>
                   </td>    
               </tr>
           <?php } ?>
       </tbody>
   </table>
</main>

<div class="modal fade" id="modalAssignar" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
 <div class="modal-dialog">
   <div class="modal-content">
     <form action="actualitzar_incidencia.php" method="POST">
       <div class="modal-header">
         <h2 class="modal-title h5" id="modalTitle">Assignar Valor</h2>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tancar"></button>
       </div>
       <div class="modal-body">
         <input type="hidden" name="id_incidencia" id="modal_id">
         <input type="hidden" name="camp_a_actualitzar" id="modal_camp">
        
         <div id="selector_prioritat" class="d-none">
           <label for="valor_prioritat" class="form-label">Tria la Prioritat:</label>
           <select name="valor_prioritat" id="valor_prioritat" class="form-select">
               <option value="Alta">Alta</option>
               <option value="Mitjana">Mitjana</option>
               <option value="Baixa">Baixa</option>
           </select>
         </div>

         <div id="selector_tipus" class="d-none">
           <label for="valor_tipus" class="form-label">Tria el Tipus:</label>
           <select name="valor_tipus" id="valor_tipus" class="form-select">
               <?php foreach ($tipos_disponibles as $t): ?>
                   <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['nom']); ?></option>
               <?php endforeach; ?>
           </select>
         </div>

         <div id="selector_tecnics" class="d-none">
           <label for="valor_tecnics" class="form-label">Tria el Tècnic:</label>
           <select name="valor_tecnics" id="valor_tecnics" class="form-select">
               <?php foreach ($tecnics as $t): ?>
                   <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['nom']); ?></option>
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