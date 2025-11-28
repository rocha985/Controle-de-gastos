<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="fw-bold text-dark">Evolução Diária das Despesas (Área Empilhada)</h5>
    </div>
    <div class="card-body">
        <div style="height: 350px; position: relative;">
            <canvas id="graficoRaioX"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const labels = <?php echo json_encode($stackedLabels ?? [])?>;
    let datasets = <?php echo json_encode($stackedDatasets ?? [])?>;

    const colors = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
        '#9966FF', '#FF9F40', '#C9CBCF', '#2563EB', '#10B981'
    ];

    datasets = datasets.map((ds, i) => ({
        ...ds,
        fill: true,
        borderColor: colors[i % colors.length],
        backgroundColor: colors[i % colors.length] + "33",
        tension: 0.3
    }));

    const ctx = document.getElementById('graficoRaioX').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, beginAtZero: true }
            },
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label + ": ";
                            return label + new Intl.NumberFormat(
                                'pt-BR', { style: 'currency', currency: 'BRL' }
                            ).format(context.parsed.y);
                        }
                    }
                }
            }
        }
    });
});
</script>
