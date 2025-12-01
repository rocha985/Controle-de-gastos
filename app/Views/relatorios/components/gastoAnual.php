<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="fw-bold text-dark">Detalhamento Mensal por Categoria</h5>
    </div>
    <div class="card-body">
        <div style="height: 400px; position: relative;">
            <canvas id="graficoRaioXAnual"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = <?php echo json_encode($graficoLabels ?? [])?>;
        let datasets = <?php echo json_encode($stackedDatasets ?? [])?>;

const colors = [
    '#FF6384', '#4BC0C0', '#FF9F40', '#5F9EA0',
    '#F08080', '#20C997', '#FFCD56', '#9966FF', '#C9CBCF'
];

datasets = datasets.map((ds, i) => ({
    ...ds,
    backgroundColor: colors[i % colors.length],
    borderColor: colors[i % colors.length]
}));


        const ctx = document.getElementById('graficoRaioXAnual').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: { display: false }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            callback: function(value) { return 'R$ ' + value; }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#333',
                        bodyColor: '#333',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                return label;
                            },
                            footer: function(tooltipItems) {
                                let sum = 0;
                                tooltipItems.forEach(function(tooltipItem) {
                                    sum += tooltipItem.parsed.y;
                                });
                                return 'Total do Mês: ' + new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(sum);
                            }
                        }
                    }
                }
            }
        });
    });
</script>