<?php $this->extend('admin/template') ?>

<?php $this->section('conteudo') ?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
  <div class="mb-3 mb-md-0">
    <h1 class="display-6 fw-bold text-dark">Visão Geral Completa</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 mb-4">
    <?php echo $this->include('relatorios/components/patrimonio', [
      'anosLabels' => $anosLabels,
      'patrimonioAcumulado' => $patrimonioAcumulado,
    ]) ?>
  </div>
</div>

<div class="row">
  <div class="col-lg-8 mb-4">
    <?php echo $this->include('relatorios/components/anualRxD', [
      'anosLabels' => $anosLabels,
      'receitasAno' => $receitasAno,
      'despesasAno' => $despesasAno,
    ]) ?>
  </div>

  <div class="col-lg-4 mb-4">
    <?php echo $this->include('relatorios/components/list', [
      'lista' => $lista,
      'totalBase' => $totalBase,
    ]) ?>
  </div>
</div>

<?php $this->endSection() ?>