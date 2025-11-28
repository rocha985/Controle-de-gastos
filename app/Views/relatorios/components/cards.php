<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body">
                <small class="text-muted fw-bold text-uppercase">Receita</small>
                <h3 class="fw-bold text-success mb-0">R$ <?php echo number_format($receita, 2, ',', '.')?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
            <div class="card-body">
                <small class="text-muted fw-bold text-uppercase">Despesa</small>
                <h3 class="fw-bold text-danger mb-0">R$ <?php echo number_format($despesa, 2, ',', '.')?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-white <?php echo ($saldo >= 0) ? 'bg-primary' : 'bg-danger'?>">
            <div class="card-body">
                <small class="text-white-50 fw-bold text-uppercase">Saldo</small>
                <h3 class="fw-bold mb-0">R$ <?php echo number_format($saldo, 2, ',', '.')?></h3>
            </div>
        </div>
    </div>
</div>