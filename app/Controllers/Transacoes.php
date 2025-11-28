<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\TransacaoService;

class Transacoes extends BaseController {

  private $transacaoService;

  public function __construct() {
    $this->transacaoService = new TransacaoService();
    helper('form');
  }

  public function index() {
    $usuarioId = session()->get('id');

    $data = $this->transacaoService->getDadosDashboard($usuarioId);

    $listas = $this->transacaoService->getListasAuxiliares();

    $data['comboDespesas'] = form_dropdown('tipo_transacao_id', $listas['despesas'], [], 'class="form-select" required');
    $data['comboReceitas'] = form_dropdown('tipo_transacao_id', $listas['receitas'], [], 'class="form-select" required');

    $data['comboPagamentoDespesa'] = form_dropdown('forma_pagamento_id', $listas['formas'], [], 'class="form-select" required');
    $data['comboPagamentoReceita'] = form_dropdown('forma_pagamento_id', $listas['formas'], [], 'class="form-select" required');

    $data['active']      = 'lancamentos';
    $data['msg']         = session()->getFlashdata('msg');
    $data['msg_icon']    = session()->getFlashdata('msg_icon');
    $data['erros']       = session()->getFlashdata('erros');
    $data['abrir_modal'] = (bool) session()->getFlashdata('erros');

    return view('transacoes/index', $data);
  }

  public function adicionar() {
    if (! $this->request->is('post')) {
      return redirect()->to('transacoes');
    }

    $transacao               = $this->request->getPost();
    $transacao['usuario_id'] = session()->get('id');

    if ($this->transacaoService->criar($transacao)) {
      session()->setFlashdata('msg', 'Transação lançada com sucesso');
      session()->setFlashdata('msg_icon', 'success');
      return redirect()->to('transacoes');
    } else {
      session()->setFlashdata('msg', 'Erro ao lançar transação');
      session()->setFlashdata('msg_icon', 'danger');

      session()->setFlashdata('erros', $this->transacaoService->getErrors());
      return redirect()->to('transacoes')->withInput();
    }
  }

  public function excluir($id = null) {
    if ($id === null) {
      return redirect()->to('transacoes');
    }

    $usuarioId = session()->get('id');

    if ($this->transacaoService->excluir($id, $usuarioId)) {
      session()->setFlashdata('msg', 'Item excluído.');
      session()->setFlashdata('msg_icon', 'success');
    } else {
      session()->setFlashdata('msg', 'Erro ao excluir ou item não encontrado.');
      session()->setFlashdata('msg_icon', 'danger');
    }

    return redirect()->to('transacoes');
  }
}