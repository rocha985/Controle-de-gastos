<?php $this->extend('admin/template') ?>
<?php $this->section('conteudo') ?>

<?php echo $this->include('relatorios/components/header', [
  'filtroAno' => $filtroAno,
]) ?>

<div class="row">
  <div class="col-12 mb-4">
    <?php echo $this->include('relatorios/components/gastoAnual', [
      'graficoLabels' => $graficoLabels,
      'stackedDatasets' => $stackedDatasets,
    ]) ?>
  </div>
</div>


<div class="row">
  <div class="col-lg-4 mb-4">
    <?php echo $this->include('relatorios/components/donut', [
      'lista' => $lista,
      'totalBase' => $despesa,
    ]) ?>
  </div>

  <div class="col-lg-8 mb-4">

    <?php echo $this->include('relatorios/components/graficoAnual') ?>

  </div>

</div>







<?php $this->endSection() ?>