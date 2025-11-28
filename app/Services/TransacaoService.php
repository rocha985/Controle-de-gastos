<?php
namespace App\Services;

class TransacaoService {

  protected $transacaoModel;
  protected $tipoModel;
  protected $formaModel;

  public function __construct() {
    $this->transacaoModel = model('TransacaoModel');
    $this->tipoModel      = model('TipoTransacaoModel');
    $this->formaModel     = model('FormaPagamentoModel');
  }

  public function getDadosDashboard(int $usuarioId, int $perPage = 10): array {
    $data = [];

    $data['transacoes'] = $this->transacaoModel->getTransacoesPaginadas($usuarioId, $perPage);
    $data['pager']      = $this->transacaoModel->pager;

    $totais          = $this->transacaoModel->getTotais($usuarioId);
    $data['receita'] = $totais['receita'];
    $data['despesa'] = $totais['despesa'];
    $data['saldo']   = $totais['saldo'];

    return $data;
  }

  public function getListasAuxiliares(): array {
    return [
      'despesas' => $this->tipoModel->getTiposToDropDown('despesa'),
      'receitas' => $this->tipoModel->getTiposToDropDown('receita'),
      'formas'   => $this->formaModel->getFormasToDropDown(),
    ];
  }

  public function criar(array $dados): bool {
    return $this->transacaoModel->insert($dados);
  }

  public function excluir(int $id, int $usuarioId): bool {
    $transacao = $this->transacaoModel
      ->where('id', $id)
      ->where('usuario_id', $usuarioId)
      ->first();

    if (! $transacao) {
      return false;
    }

    return $this->transacaoModel->delete($id);
  }

  public function getErrors(): array {
    return $this->transacaoModel->errors();
  }
}