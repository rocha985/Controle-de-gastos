<?php
  $donutLabels  = [];
  $donutValores = [];

  foreach ($lista as $d) {
    $donutLabels[]  = $d->categoria;
    $donutValores[] = (float) $d->total;
  }
?>

<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="fw-bold">Gastos por Categoria</h5>
    </div>
    <div class="card-body">
        <div style="height: 300px;">
            <canvas id="graficoDonut"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const labels = <?php echo json_encode($donutLabels)?>;
    const valores = <?php echo json_encode($donutValores)?>;

    const palette = ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40'];

    const ctx = document.getElementById('graficoDonut');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: valores,
                backgroundColor: palette,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
            },
            plugins: { legend: { position: 'bottom' } }
        }
    });

});
</script>
