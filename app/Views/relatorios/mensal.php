<?php $this->extend('admin/template')?>
<?php $this->section('conteudo')?>

<?php echo $this->include('relatorios/components/header', [
    'filtroAno' => $filtroAno,
    'filtroMes' => $filtroMes,
]) ?>

<?php echo $this->include('relatorios/components/cards', [
    'despesa' => $despesa,
    'receita' => $receita,
    'saldo'   => $saldo,
]) ?>


<div class="row">
    <div class="col-lg-4 mb-4">
        <?php echo $this->include('relatorios/components/despesasRank', [
            'rankLabels'  => $rankLabels,
            'rankValores' => $rankValores,
        ]) ?>
    </div>

    <div class="col-lg-8 mb-4">
        <?php echo $this->include('relatorios/components/graficoMensal', [
            'graficoLabels' => $graficoLabels,
            'graficoSaldo'  => $graficoSaldo,
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <?php echo $this->include('relatorios/components/gastoDiario', [
            'saldoInicial' => $saldoInicial,
            'labels'       => $labels,
            'saldoPorDia'  => $saldoPorDia,
        ]) ?>

    </div>
</div>

<?php $this->endSection()?>