<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="fw-bold text-dark">Comparativo Anual (Receitas x Despesas)</h5>
    </div>
    <div class="card-body">
        <div style="height: 350px; position: relative;">
            <canvas id="graficoComparativo"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels =                                                                   <?php echo json_encode($anosLabels ?? []) ?>;
        const receitas =                                                                         <?php echo json_encode($receitasAno ?? []) ?>;
        const despesas =                                                                         <?php echo json_encode($despesasAno ?? []) ?>;

        const ctx = document.getElementById('graficoComparativo').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Receitas',
                        data: receitas,
                        backgroundColor: '#4BC0C0',
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    {
                        label: 'Despesas',
                        data: despesas,
                        backgroundColor: '#FF6384',
                        borderRadius: 4,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0f0f0' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>