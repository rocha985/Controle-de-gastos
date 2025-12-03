<div class="card border-0 shadow-sm h-100">
  <div class="card-header bg-white border-0 pt-3">
    <h5 class="fw-bold text-dark">Balanço Mensal</h5>
  </div>
  <div class="card-body">
    <div style="height: 300px; position: relative;">
      <canvas id="graficoSaldo"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const labels = <?php echo json_encode($graficoLabels ?? []) ?>;
    const saldos = <?php echo json_encode($graficoSaldo ?? []) ?>;

    const backgroundColors = saldos.map(v => v >= 0 ? '#4BC0C0' : '#FF6384');
    const borderColors = saldos.map(v => v >= 0 ? '#4BC0C0' : '#FF6384');

    const ctx = document.getElementById('graficoSaldo').getContext('2d');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Saldo (R$)',
          data: saldos,
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1,
          borderRadius: 4
        }]
      },
      options: {
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
                let value = context.raw;
                return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
              }
            }
          }
        },
        scales: {
          y: { beginAtZero: true, grid: { color: '#f0f0f0' } },
          x: { grid: { display: false } }
        }
      }
    });
  });
</script>