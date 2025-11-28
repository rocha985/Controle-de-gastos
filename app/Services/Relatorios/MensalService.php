<?php
namespace App\Services\Relatorios;

use App\Repositories\RelatorioTransacaoRepository;

class MensalService {
  private $relatorioRepository;

  public function __construct() {
    $this->relatorioRepository = new RelatorioTransacaoRepository();
  }

  public function gerarRelatorio(int $usuarioId, string $ano, string $mes): array {
    $diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

    $dadosBrutos      = $this->relatorioRepository->getBalancoDiarioPorMes($usuarioId, $ano, $mes);
    $detalhesDespesas = $this->relatorioRepository->getTotaisPorCategoriaMes($usuarioId, $ano, $mes);
    $top5             = $this->relatorioRepository->getTop5Despesas($usuarioId, $ano, $mes);
    $gastosDiarios    = $this->relatorioRepository->getGastosDiariosPorCategoria($usuarioId, $ano, $mes);
    $saldoInicialRows = $this->relatorioRepository->getSaldoInicialDoMes($usuarioId, $ano, $mes);

    list(
      $dadosProcessados,
      $graficoSaldo,
      $totalReceita,
      $totalDespesa
    ) = $this->processarBalancoDiario($dadosBrutos, $diasNoMes);

    list($rankLabels, $rankValores) = $this->processarRankingTop5($top5);

    $stackedDatasets = $this->processarGastosDiariosPorCategoria($gastosDiarios, $diasNoMes);

    list($saldoInicial, $saldoPorDia) = $this->calcularSaldoPatrimonioAcumulado(
      $saldoInicialRows,
      $dadosProcessados,
      $diasNoMes
    );

    $graficoLabels = range(1, $diasNoMes);

    return [
      "filtroAno"       => $ano,
      "filtroMes"       => $mes,

      "receita"         => $totalReceita,
      "despesa"         => $totalDespesa,
      "saldo"           => $totalReceita - $totalDespesa,

      "lista"           => $detalhesDespesas,
      "totalBase"       => $totalDespesa,

      "graficoLabels"   => $graficoLabels,
      "graficoSaldo"    => $graficoSaldo,

      "rankLabels"      => $rankLabels,
      "rankValores"     => $rankValores,

      "stackedLabels"   => range(1, $diasNoMes),
      "stackedDatasets" => $stackedDatasets,

      "saldoInicial"    => $saldoInicial,
      "labels"          => range(1, $diasNoMes),
      "saldoPorDia"     => $saldoPorDia,
    ];
  }

  protected function processarBalancoDiario(array $dadosBrutos, int $diasNoMes): array {
    $dadosProcessados = [];
    for ($d = 1; $d <= $diasNoMes; $d++) {
      $dadosProcessados[$d] = ["receita" => 0.0, "despesa" => 0.0];
    }

    foreach ($dadosBrutos as $item) {
      $diaIndex = (int) $item->dia;
      $tipo     = $item->tipo_fluxo;
      if (isset($dadosProcessados[$diaIndex])) {
        $dadosProcessados[$diaIndex][$tipo] = (float) $item->total;
      }
    }

    $graficoSaldo   = [];
    $saldoAcumulado = 0;
    $totalReceita   = 0;
    $totalDespesa   = 0;

    for ($d = 1; $d <= $diasNoMes; $d++) {
      $r  = $dadosProcessados[$d]["receita"];
      $dv = $dadosProcessados[$d]["despesa"];

      $totalReceita += $r;
      $totalDespesa += $dv;

      $saldoAcumulado += ($r - $dv);
      $graficoSaldo[] = $saldoAcumulado;
    }

    return [$dadosProcessados, $graficoSaldo, $totalReceita, $totalDespesa];
  }

  protected function processarRankingTop5(array $top5): array {
    $rankLabels  = [];
    $rankValores = [];

    foreach ($top5 as $item) {
      $rankLabels[]  = $item->categoria;
      $rankValores[] = (float) $item->total;
    }

    return [$rankLabels, $rankValores];
  }

  protected function processarGastosDiariosPorCategoria(array $gastosDiarios, int $diasNoMes): array {
    $categoriasUnicas = [];
    foreach ($gastosDiarios as $g) {
      $categoriasUnicas[$g->categoria] = true;
    }
    $listaCategorias = array_keys($categoriasUnicas);

    $matriz = [];
    foreach ($listaCategorias as $cat) {
      $matriz[$cat] = array_fill(1, $diasNoMes, 0);
    }

    foreach ($gastosDiarios as $item) {
      $dia = (int) $item->dia;
      $cat = $item->categoria;
      if (isset($matriz[$cat][$dia])) {
        $matriz[$cat][$dia] = (float) $item->total;
      }
    }

    $stackedDatasets = [];
    foreach ($matriz as $categoria => $valores) {
      $stackedDatasets[] = [
        "label"        => $categoria,
        "data"         => array_values($valores),
        "borderRadius" => 2,
      ];
    }

    return $stackedDatasets;
  }

  protected function calcularSaldoPatrimonioAcumulado(
    array $saldoInicialRows,
    array $dadosProcessados,
    int $diasNoMes
  ): array {
    $receitaAntes = 0;
    $despesaAntes = 0;
    foreach ($saldoInicialRows as $r) {
      if ($r->tipo_fluxo === 'receita') {
        $receitaAntes = (float) $r->total;
      }

      if ($r->tipo_fluxo === 'despesa') {
        $despesaAntes = (float) $r->total;
      }

    }
    $saldoInicial = $receitaAntes - $despesaAntes;

    $saldoPorDia = [];
    $saldoAtual  = $saldoInicial;
    for ($d = 1; $d <= $diasNoMes; $d++) {
      $saldoAtual += $dadosProcessados[$d]["receita"];
      $saldoAtual -= $dadosProcessados[$d]["despesa"];
      $saldoPorDia[] = $saldoAtual;
    }

    return [$saldoInicial, $saldoPorDia];
  }
}