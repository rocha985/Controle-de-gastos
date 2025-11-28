<?php
namespace App\Services\Relatorios;

use App\Repositories\RelatorioTransacaoRepository;

class GeralService {
  private $relatorioRepository;

  public function __construct() {
    $this->relatorioRepository = new RelatorioTransacaoRepository();
  }

  public function gerarRelatorio(int $usuarioId): array {
    $totais        = $this->relatorioRepository->getTotaisGerais($usuarioId);
    $dadosPorAno   = $this->relatorioRepository->getBalancoAgrupadoPorAno($usuarioId);
    $topCategorias = $this->relatorioRepository->getTotaisPorCategoriaGeral($usuarioId);

    $receitaTotal = $totais->receita ?? 0;
    $despesaTotal = $totais->despesa ?? 0;

    $processadosPorAno = $this->processarBalancoAnualAcumulado($dadosPorAno);

    return [
      "receita"             => $receitaTotal,
      "despesa"             => $despesaTotal,
      "saldo"               => $receitaTotal - $despesaTotal,

      "lista"               => $topCategorias,
      "totalBase"           => $despesaTotal,

      "anosLabels"          => $processadosPorAno['anosLabels'],
      "receitasAno"         => $processadosPorAno['receitasAno'],
      "despesasAno"         => $processadosPorAno['despesasAno'],

      "patrimonioAcumulado" => $processadosPorAno['patrimonioAcumulado'],
    ];
  }

  protected function processarBalancoAnualAcumulado(array $dadosPorAno): array {
    $anosLabels          = [];
    $receitasAno         = [];
    $despesasAno         = [];
    $patrimonioAcumulado = [];
    $saldoTotalAteAgora  = 0;

    foreach ($dadosPorAno as $ano => $valores) {
      $anosLabels[]  = $ano;
      $receitasAno[] = $valores['receita'];
      $despesasAno[] = $valores['despesa'];

      $saldoDoAno = $valores['receita'] - $valores['despesa'];
      $saldoTotalAteAgora += $saldoDoAno;
      $patrimonioAcumulado[] = $saldoTotalAteAgora;
    }

    return [
      "anosLabels"          => $anosLabels,
      "receitasAno"         => $receitasAno,
      "despesasAno"         => $despesasAno,
      "patrimonioAcumulado" => $patrimonioAcumulado,
    ];
  }
}