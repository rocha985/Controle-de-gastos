<?php
namespace App\Services\Relatorios;

use App\Repositories\RelatorioTransacaoRepository;

class AnualService {
    private $relatorioRepository;

    public function __construct() {
        $this->relatorioRepository = new RelatorioTransacaoRepository();
    }

    public function gerarRelatorio(int $usuarioId, string $ano): array {
        $dadosBrutos      = $this->relatorioRepository->getBalancoMensalPorAno($usuarioId, $ano);
        $detalhesDespesas = $this->relatorioRepository->getTotaisPorCategoriaAno($usuarioId, $ano);
        $gastosMensais    = $this->relatorioRepository->getGastosMensaisPorCategoria($usuarioId, $ano);

        $dadosProcessados = $this->processarBalancoMensal($dadosBrutos);

        $calculos = $this->calcularTotaisEGraficoSaldo($dadosProcessados);
        
        $totalReceitaAno = $calculos['receita'];
        $totalDespesaAno = $calculos['despesa'];
        $graficoSaldo    = $calculos['grafico'];

        $dadosGraficoCategoria = $this->processarGastosMensaisPorCategoria($gastosMensais);
        $dadosGrafico         = $dadosGraficoCategoria['series'];

        $graficoLabels = [
            "Jan", "Fev", "Mar", "Abr", "Mai", "Jun",
            "Jul", "Ago", "Set", "Out", "Nov", "Dez",
        ];

        return [
            "filtroAno"       => $ano,

            "receita"         => $totalReceitaAno,
            "despesa"         => $totalDespesaAno,
            "saldo"           => $totalReceitaAno - $totalDespesaAno,

            "lista"           => $detalhesDespesas,
            "totalBase"       => $totalDespesaAno,

            "graficoLabels"   => $graficoLabels,
            "graficoSaldo"    => $graficoSaldo,

            "stackedDatasets" => $dadosGrafico,
        ];
    }

    protected function processarBalancoMensal(array $dadosBrutos): array {
        $dadosProcessados = [];

        for ($m = 1; $m <= 12; $m++) {
            $dadosProcessados[$m] = ["receita" => 0.0, "despesa" => 0.0];
        }

        foreach ($dadosBrutos as $d) {
            $mesIndex = (int) $d->mes;
            $tipo     = $d->tipo_fluxo;

            if (isset($dadosProcessados[$mesIndex])) {
                $dadosProcessados[$mesIndex][$tipo] = (float) $d->total;
            }
        }
        return $dadosProcessados;
    }

    protected function calcularTotaisEGraficoSaldo(array $dadosProcessados): array {
        $totalReceitaAno = 0;
        $totalDespesaAno = 0;
        $graficoSaldo    = [];

        for ($m = 1; $m <= 12; $m++) {
            $r = $dadosProcessados[$m]["receita"];
            $d = $dadosProcessados[$m]["despesa"];

            $saldoMes       = $r - $d;
            $graficoSaldo[] = $saldoMes;
            $totalReceitaAno += $r;
            $totalDespesaAno += $d;
        }

        return [
            'receita' => $totalReceitaAno,
            'despesa' => $totalDespesaAno,
            'grafico' => $graficoSaldo,
        ];
    }

    protected function processarGastosMensaisPorCategoria(array $gastosMensais): array {
        $categoriasUnicas = [];
        foreach ($gastosMensais as $g) {
            $categoriasUnicas[$g->categoria] = true;
        }

        $listaCategorias = array_keys($categoriasUnicas);
        $dadosGrafico   = [];

        foreach ($listaCategorias as $catNome) {
            $dataMes = [];

            for ($m = 1; $m <= 12; $m++) {
                $valorDoMes = 0;
                foreach ($gastosMensais as $item) {
                    if ($item->mes == $m && $item->categoria == $catNome) {
                        $valorDoMes = (float) $item->total;
                        break;
                    }
                }
                $dataMes[] = $valorDoMes;
            }

            $dadosGrafico[] = [
                "type"             => "line",
                "label"            => $catNome,
                "data"             => $dataMes,
                "borderWidth"      => 1,
                "fill"             => true,
                "tension"          => 0.4,
                "pointRadius"      => 3,
                "pointHoverRadius" => 6,
            ];
        }

        return [
            'series' => $dadosGrafico
        ];
    }
}