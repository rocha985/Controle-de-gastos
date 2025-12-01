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

        $balanco = $this->processarBalancoDiario($dadosBrutos, $diasNoMes);
        
        [
            'dadosProcessados' => $dadosProcessados,
            'graficoSaldo'     => $graficoSaldo,
            'receita'          => $totalReceita,
            'despesa'          => $totalDespesa
        ] = $balanco;

        $ranking = $this->processarRankingTop5($top5);
        
        $dadosGraficoCategoria = $this->processarGastosDiariosPorCategoria($gastosDiarios, $diasNoMes);

        $patrimonio = $this->calcularSaldoPatrimonioAcumulado(
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

            "rankLabels"      => $ranking['labels'],
            "rankValores"     => $ranking['valores'],

            "stackedDatasets" => $dadosGraficoCategoria['dados'],

            "saldoInicial"    => $patrimonio['inicial'],
            "saldoPorDia"     => $patrimonio['porDia'],
        ];
    }

    protected function processarBalancoDiario(array $dadosBrutos, int $diasNoMes): array {
        $dadosProcessados = array_fill(1, $diasNoMes, ["receita" => 0.0, "despesa" => 0.0]);

        foreach ($dadosBrutos as $item) {
            $diaIndex = (int) $item->dia;
            if (isset($dadosProcessados[$diaIndex])) {
                $dadosProcessados[$diaIndex][$item->tipo_fluxo] = (float) $item->total;
            }
        }

        $graficoSaldo   = [];
        $saldoAcumulado = 0;
        $totalReceita   = 0;
        $totalDespesa   = 0;

        for ($d = 1; $d <= $diasNoMes; $d++) {
            $r = $dadosProcessados[$d]["receita"];
            $dVal = $dadosProcessados[$d]["despesa"];

            $totalReceita += $r;
            $totalDespesa += $dVal;
            $saldoAcumulado += ($r - $dVal);
            $graficoSaldo[] = $saldoAcumulado;
        }

        return [
            'dadosProcessados' => $dadosProcessados,
            'graficoSaldo'     => $graficoSaldo,
            'receita'          => $totalReceita,
            'despesa'          => $totalDespesa
        ];
    }

    protected function processarRankingTop5(array $top5): array {
        return [
            'labels'  => array_column($top5, 'categoria'),
            'valores' => array_map('floatval', array_column($top5, 'total'))
        ];
    }

    protected function processarGastosDiariosPorCategoria(array $gastosDiarios, int $diasNoMes): array {
        $categorias = array_unique(array_column($gastosDiarios, 'categoria'));
        $matriz = array_fill_keys($categorias, array_fill(1, $diasNoMes, 0));

        foreach ($gastosDiarios as $item) {
            $dia = (int) $item->dia;
            if (isset($matriz[$item->categoria][$dia])) {
                $matriz[$item->categoria][$dia] = (float) $item->total;
            }
        }

        $dadosGrafico = [];
        foreach ($matriz as $categoria => $valores) {
            $dadosGrafico[] = [
                "label"        => $categoria,
                "data"         => array_values($valores),
                "borderRadius" => 2,
            ];
        }

        return ['dados' => $dadosGrafico];
    }

    protected function calcularSaldoPatrimonioAcumulado(
        array $saldoInicialRows,
        array $dadosProcessados,
        int $diasNoMes
    ): array {
        $mapaSaldo = array_column($saldoInicialRows, 'total', 'tipo_fluxo');
        $saldoInicial = ((float) ($mapaSaldo['receita'] ?? 0)) - ((float) ($mapaSaldo['despesa'] ?? 0));

        $saldoPorDia = [];
        $saldoAtual  = $saldoInicial;
        
        for ($d = 1; $d <= $diasNoMes; $d++) {
            $saldoAtual += $dadosProcessados[$d]["receita"] - $dadosProcessados[$d]["despesa"];
            $saldoPorDia[] = $saldoAtual;
        }

        return [
            'inicial' => $saldoInicial,
            'porDia'  => $saldoPorDia
        ];
    }
}