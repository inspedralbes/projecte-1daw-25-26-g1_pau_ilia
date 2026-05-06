<?php
require_once 'logger.php'; 
include_once "header.php";

$pipelineTotal = [['$count' => 'total']];
$resTotal = $coleccionLogs->aggregate($pipelineTotal)->toArray();
$total_vis = !empty($resTotal) ? $resTotal[0]['total'] : 0;

$pipelinePaginas = [
    ['$group' => ['_id' => '$url', 'count' => ['$sum' => 1]]],
    ['$sort' => ['count' => -1]],
    ['$limit' => 5]
];
$res_pagina_mas_vis = $coleccionLogs->aggregate($pipelinePaginas);

$pipelineDia = [
    ['$group' => [
        '_id' => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$timestamp']],
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]]
];
$results_per_day = $coleccionLogs->aggregate($pipelineDia);

$logs_detallados = $coleccionLogs->find([], ['limit' => 10, 'sort' => ['timestamp' => -1]])->toArray(); 

$labels = [];
$counts = [];

foreach ($results_per_day as $dia) {
    $labels[] = $dia['_id'];   
    $counts[] = $dia['count']; 
}

$labels_json = json_encode($labels);
$counts_json = json_encode($counts);
?>




<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Dashboard de Control</title>
</head>
<body>

    <div class="container">
        <a href="/" class="btn btn-secondary rounded-pill px-2 px-md-4 py-md-2">Volver</a>
        <h1 class="mb-4">Estadístiques Generals</h2>

        <div style="width: 80%; margin: auto; padding: .3rem;">
            <canvas id="graficTendencies"></canvas>
        </div>
    
        <p class="fs-4"><strong>Total d'accessos:</strong> <?php echo $total_vis; ?></p>

        <p class="fs-4"><strong>Top Pàgines:</strong></p>
        <ul>
            <?php foreach ($res_pagina_mas_vis as $pag) : ?>
                <li class="fs-7"><?php echo $pag['_id']; ?> (<?php echo $pag['count']; ?> visites)</li>
            <?php endforeach; ?>
        </ul>

        <hr>



        <div class="col m-4 table-responsive">
            <div class="d-flex justify-content-between text-center align-items-center mb-4">
                <h3>Últims 10 logs:</h3>
                <br>
            </div>

            <table class="table custom-font-size-table rounded-4 text-center">
                <thead>
                    <tr class="align-middle">
                        <th class="p-md-3 p-1">URL</th>
                        <th class="p-md-3 p-1">Metodo</th>
                        <th class="p-md-3 p-1">IP</th>
                        <th class="p-md-3 p-1">Navegador</th>
                        <th class="p-md-3 p-1">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs_detallados as $log) :  ?>
                        <?php $fecha = $log['timestamp']->toDateTime()->format('d/m/Y H:i:s'); ?>
                        <tr class="align-middle">
                            <td class="p-md-2 p-1"><?php echo $log["url"] ?></td>
                            <td class="p-md-2 p-1">
                                <?php echo $log["metodo"]; ?>
                            </td>                
                            <td class="p-md-2 ">
                                <?php echo $log["ip"]; ?>
                            </td>      
                            <td class="p-md-2 p-1">
                                <?php echo $log["navegador"]; ?>
                            </td> 
                            <td class="p-md-2 p-1">
                                <?php echo $fecha ?>
                            </td> 
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
const ctx = document.getElementById('graficTendencies').getContext('2d');
new Chart(ctx, {
    type: 'line', 
    data: {
        labels: <?php echo $labels_json; ?>,
        datasets: [{
            label: 'Visites totals per dia',
            data: <?php echo $counts_json; ?>,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 3,
            fill: true,
            tension: 0.3, 
            pointRadius: 5,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>

</body>
</html>



<?php include_once "footer.php"; ?>


