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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="width: 80%; margin: auto;">
    <canvas id="graficTendencies"></canvas>
</div>

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

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Dashboard de Control</title>
</head>
<body>

    <div class="container">
        <h2>Estadístiques Generals</h2>
    
        <p><strong>Total d'accessos:</strong> <?php echo $total_vis; ?></p>

        <p><strong>Top Pàgines:</strong></p>
        <ul>
            <?php foreach ($res_pagina_mas_vis as $pag) : ?>
                <li><?php echo $pag['_id']; ?> (<?php echo $pag['count']; ?> visites)</li>
            <?php endforeach; ?>
        </ul>

        <hr>

        <h3>Últims 10 logs:</h3>
        <?php foreach ($logs_detallados as $log) : ?>
            <p>
                <?php
                $fecha = $log['timestamp']->toDateTime()->format('d/m/Y H:i:s');
                echo "Visitó: <b>" . $log['url'] . "</b> el " . $fecha . " desde IP: " . $log["ip"];
                ?>
            </p>
        <?php endforeach; ?>
    </div>

</body>
</html>

<?php include_once "footer.php"; ?>