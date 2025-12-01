<div class="card border-0 shadow-sm h-100">
  <div class="card-header bg-white border-0 pt-3">
    <h5 class="fw-bold text-dark">
      Saldo Diário
    </h5>
  </div>

  <div class="card-body">
    <div style="height: 350px; position: relative;">
      <canvas id="graficoSaldo"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {

    const labels = <?php echo json_encode($graficoLabels) ?>;
    const saldoPorDia = <?php echo json_encode($saldoPorDia) ?>;

    const ctx = document.getElementById('graficoSaldo').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.45)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Saldo Diário',
          data: saldoPorDia,
          borderColor: '#2563EB',
          backgroundColor: gradient,
          fill: true,
          tension: 0.35,
          borderWidth: 2,
          pointRadius: 0,
          pointHoverRadius: 5
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
          mode: 'index',
          intersect: false,
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: { color: '#f4f4f4' }
          },
          x: {
            grid: { display: false }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function (context) {
                return "Saldo: " + new Intl.NumberFormat('pt-BR', {
                  style: 'currency',
                  currency: 'BRL'
                }).format(context.raw);
              }
            }
          }
        }
      }
    });

  });
</script>