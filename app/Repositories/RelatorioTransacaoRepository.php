<?php
namespace App\Repositories;

use App\Models\TransacaoModel;

class RelatorioTransacaoRepository {
  private $transacaoModel;

  public function __construct() {
    $this->transacaoModel = model(TransacaoModel::class);
  }

  public function getTotaisPorCategoriaAno($usuario_id, $ano) {
    return $this->transacaoModel->select('t.nome as categoria, t.tipo as tipo_fluxo, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->where('t.tipo', 'despesa')
      ->groupBy('transacoes.tipo_transacao_id')
      ->orderBy('total', 'DESC')
      ->findAll();
  }

  public function getBalancoMensalPorAno($usuario_id, $ano) {
    return $this->transacaoModel->select("MONTH(data) as mes, t.tipo as tipo_fluxo, SUM(transacoes.valor) as total")
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->groupBy("mes, t.tipo")
      ->orderBy("mes", "ASC")
      ->findAll();
  }

  public function getTotaisPorCategoriaMes($usuario_id, $ano, $mes) {
    return $this->transacaoModel->select('t.nome as categoria, t.tipo as tipo_fluxo, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->where('MONTH(transacoes.data)', $mes)
      ->where('t.tipo', 'despesa')
      ->groupBy('transacoes.tipo_transacao_id')
      ->orderBy('total', 'DESC')
      ->findAll();
  }

  public function getBalancoDiarioPorMes($usuario_id, $ano, $mes) {
    return $this->transacaoModel->select("DAY(data) as dia, t.tipo as tipo_fluxo, SUM(transacoes.valor) as total")
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->where('MONTH(transacoes.data)', $mes)
      ->groupBy("dia, t.tipo")
      ->orderBy("dia", "ASC")
      ->findAll();
  }

  public function getTotaisGerais($usuario_id) {
    $resultados = $this->transacaoModel->select('t.tipo as tipo_fluxo, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->groupBy('t.tipo')
      ->findAll();

    $totais = (object) ['receita' => 0.0, 'despesa' => 0.0];

    foreach ($resultados as $row) {
      $tipo          = $row->tipo_fluxo;
      $totais->$tipo = (float) $row->total;
    }

    return $totais;
  }

  public function getBalancoAgrupadoPorAno($usuario_id) {
    $resultados = $this->transacaoModel->select("YEAR(data) as ano, t.tipo as tipo_fluxo, SUM(transacoes.valor) as total")
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->groupBy("ano, t.tipo")
      ->orderBy("ano", "ASC")
      ->findAll();

    $dadosPorAno = [];

    foreach ($resultados as $row) {
      $ano  = $row->ano;
      $tipo = $row->tipo_fluxo;

      if (! isset($dadosPorAno[$ano])) {
        $dadosPorAno[$ano] = ['receita' => 0.0, 'despesa' => 0.0];
      }

      $dadosPorAno[$ano][$tipo] = (float) $row->total;
    }

    return $dadosPorAno;
  }

  public function getTotaisPorCategoriaGeral($usuario_id) {
    return $this->transacaoModel->select('t.nome as categoria, t.tipo as tipo_fluxo, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('t.tipo', 'despesa')
      ->groupBy('transacoes.tipo_transacao_id')
      ->orderBy('total', 'DESC')
      ->findAll();
  }

  public function getTop5Despesas($usuario_id, $ano, $mes) {
    return $this->transacaoModel->select('t.nome as categoria, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->where('MONTH(transacoes.data)', $mes)
      ->where('t.tipo', 'despesa')
      ->groupBy('transacoes.tipo_transacao_id')
      ->orderBy('total', 'DESC')
      ->limit(5)
      ->findAll();
  }

  public function getGastosDiariosPorCategoria($usuario_id, $ano, $mes) {
    return $this->transacaoModel->select('DAY(transacoes.data) as dia, t.nome as categoria, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->where('MONTH(transacoes.data)', $mes)
      ->where('t.tipo', 'despesa')
      ->groupBy('dia, transacoes.tipo_transacao_id')
      ->orderBy('dia', 'ASC')
      ->findAll();
  }

  public function getGastosMensaisPorCategoria($usuario_id, $ano) {
    return $this->transacaoModel->select('MONTH(transacoes.data) as mes, t.nome as categoria, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->where('YEAR(transacoes.data)', $ano)
      ->where('t.tipo', 'despesa')
      ->groupBy('mes, transacoes.tipo_transacao_id')
      ->orderBy('mes', 'ASC')
      ->findAll();
  }

  public function getSaldoInicialDoMes($usuario_id, $ano, $mes) {
    return $this->transacaoModel->select('t.tipo as tipo_fluxo, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 't.id = transacoes.tipo_transacao_id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->groupStart()
      ->where('YEAR(transacoes.data) <', $ano)
      ->orGroupStart()
      ->where('YEAR(transacoes.data)', $ano)
      ->where('MONTH(transacoes.data) <', $mes)
      ->groupEnd()
      ->groupEnd()
      ->groupBy('t.tipo')
      ->findAll();
  }
}