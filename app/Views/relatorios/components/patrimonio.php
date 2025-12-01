<div class="card border-0 shadow-sm h-100">
    <div class="card-header bg-white border-0 pt-3">
        <h5 class="fw-bold text-dark">Crescimento Total do Patrimônio</h5>
    </div>
    <div class="card-body">
        <div style="height: 300px; position: relative;">
            <canvas id="graficoPatrimonio"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = <?php echo json_encode($anosLabels ?? [])?>;
        const dados = <?php echo json_encode($patrimonioAcumulado ?? [])?>;

        const ctx = document.getElementById('graficoPatrimonio').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(75, 192, 192, 0.5)');
        gradient.addColorStop(1, 'rgba(75, 192, 192, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Patrimônio Acumulado',
                    data: dados,

                    borderColor: '#4BC0C0',
                    backgroundColor: gradient,
                    borderWidth: 2,

                    fill: 'start',
                    tension: 0.3,

                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#4BC0C0',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Acumulado: R$ ' + context.raw.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
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