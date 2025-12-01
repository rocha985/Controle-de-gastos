<div class="card border-0 shadow-sm h-100">
  <div class="card-header bg-white border-0 pt-3">
    <h5 class="fw-bold text-dark">Top 5 Maiores Gastos</h5>
  </div>
  <div class="card-body">
    <div style="height: 300px; position: relative;">
      <canvas id="graficoRanking"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const labels = <?php echo json_encode($rankLabels ?? []) ?>;
    const valores = <?php echo json_encode($rankValores ?? []) ?>;

    const ctx = document.getElementById('graficoRanking').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 300, 0);
    gradient.addColorStop(0, '#FF6384');
    gradient.addColorStop(1, '#FF9F40');


    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Valor Gasto',
          data: valores,
          backgroundColor: gradient,
          borderRadius: 4,
          barPercentage: 0.6,
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 2000,
          easing: 'easeOutQuart'
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function (context) {
                return 'R$ ' + context.raw.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { display: false }
          },
          y: {
            grid: { display: false },
            ticks: {
              font: { weight: 'bold' },
              color: '#555'
            }
          }
        }
      }
    });
  });
</script>