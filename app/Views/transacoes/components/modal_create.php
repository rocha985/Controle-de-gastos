<div class="modal fade" id="modalNovaTransacao" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">

      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Novo Lançamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">

        <ul class="nav nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active bg-danger-soft text-danger fw-bold border border-danger" id="aba-despesa-tab"
              data-bs-toggle="pill" data-bs-target="#aba-despesa" type="button" role="tab">
              <i class="bi bi-arrow-down-circle me-2"></i> Despesa
            </button>
          </li>
          <li class="nav-item ms-2" role="presentation">
            <button class="nav-link bg-success-soft text-success fw-bold border border-success" id="aba-receita-tab"
              data-bs-toggle="pill" data-bs-target="#aba-receita" type="button" role="tab">
              <i class="bi bi-arrow-up-circle me-2"></i> Receita
            </button>
          </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

          <div class="tab-pane fade show active" id="aba-despesa" role="tabpanel">
            <form action="<?php echo base_url('transacoes/adicionar') ?>" method="POST">
              <input type="hidden" name="tipo_fluxo" value="despesa">

              <div class="mb-3">
                <label class="form-label text-muted small fw-bold">DESCRIÇÃO</label>
                <input type="text" name="titulo" class="form-control" placeholder="Ex: Conta de Luz" required>
              </div>
              <div class="row">
                <div class="col-6 mb-3">
                  <label class="form-label text-muted small fw-bold">VALOR (R$)</label>
                  <input type="number" step="0.01" name="valor" class="form-control" placeholder="0.00" required>
                </div>
                <div class="col-6 mb-3">
                  <label class="form-label text-muted small fw-bold">DATA</label>
                  <input type="date" name="data" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted small fw-bold">TIPO DE DESPESA</label>
                <?php echo $comboDespesas ?>
              </div>
              <div class="mb-4">
                <label class="form-label text-muted small fw-bold">PAGAMENTO VIA</label>
                <?php echo $comboPagamentoDespesa ?>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-danger btn-lg">Registrar</button>
              </div>
            </form>
          </div>

          <div class="tab-pane fade" id="aba-receita" role="tabpanel">
            <form action="<?php echo base_url('transacoes/adicionar') ?>" method="POST">
              <input type="hidden" name="tipo_fluxo" value="receita">

              <div class="mb-3">
                <label class="form-label text-muted small fw-bold">DESCRIÇÃO</label>
                <input type="text" name="titulo" class="form-control" placeholder="Ex: Salário Mensal" required>
              </div>
              <div class="row">
                <div class="col-6 mb-3">
                  <label class="form-label text-muted small fw-bold">VALOR (R$)</label>
                  <input type="number" step="0.01" name="valor" class="form-control" placeholder="0.00" required>
                </div>
                <div class="col-6 mb-3">
                  <label class="form-label text-muted small fw-bold">DATA</label>
                  <input type="date" name="data" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted small fw-bold">FONTE DE RENDA</label>
                <?php echo $comboReceitas ?>
              </div>
              <div class="mb-4">
                <label class="form-label text-muted small fw-bold">RECEBIDO EM</label>
                <?php echo $comboPagamentoReceita ?>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">Registrar Entrada</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .nav-pills .nav-link {
    border-radius: 50px;
  }

  .nav-pills .nav-link.active {
    color: #fff !important;
  }

  .nav-pills .nav-link.text-danger.active {
    background-color: #dc3545 !important;
  }

  .nav-pills .nav-link.text-success.active {
    background-color: #198754 !important;
  }
</style>