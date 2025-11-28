<?php
namespace App\Models;

use CodeIgniter\Model;

class TransacaoModel extends Model {
  protected $table            = 'transacoes';
  protected $primaryKey       = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'object';
  protected $useSoftDeletes   = false;
  protected $protectFields    = true;
  protected $allowedFields    = ['usuario_id', 'tipo_transacao_id', 'forma_pagamento_id', 'titulo', 'valor', 'data'];

  protected bool $allowEmptyInserts = false;
  protected bool $updateOnlyChanged = true;

  protected array $casts        = [];
  protected array $castHandlers = [];

  // Dates
  protected $useTimestamps = false;
  protected $dateFormat    = 'datetime';
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  // Validation
  protected $validationRules = [
    'titulo'             => 'required|min_length[3]',
    'valor'              => 'required|numeric',
    'data'               => 'required|valid_date',
    'tipo_transacao_id'  => 'required',
    'forma_pagamento_id' => 'required',
  ];
  protected $validationMessages   = [];
  protected $skipValidation       = false;
  protected $cleanValidationRules = true;

  public function getTransacoesPaginadas($usuario_id, $perPage = 10) {
    return $this->select('transacoes.*, t.nome as tipo_nome, t.tipo as tipo_fluxo, f.nome as forma_nome')
      ->join('tipos_transacao t', 'transacoes.tipo_transacao_id = t.id')
      ->join('formas_pagamento f', 'transacoes.forma_pagamento_id = f.id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->orderBy('transacoes.data DESC, transacoes.id DESC')
      ->paginate($perPage);
  }

  public function getTotais($usuario_id) {
    $query = $this->select('t.tipo as tipo_fluxo, SUM(transacoes.valor) as total')
      ->join('tipos_transacao t', 'transacoes.tipo_transacao_id = t.id')
      ->where('transacoes.usuario_id', $usuario_id)
      ->groupBy('t.tipo')
      ->findAll();

    $dados = [
      'receita' => 0,
      'despesa' => 0,
      'saldo'   => 0,
    ];

    foreach ($query as $row) {
      if ($row->tipo_fluxo == 'receita') {
        $dados['receita'] = (float) $row->total;
      } else {
        $dados['despesa'] = (float) $row->total;
      }
    }

    $dados['saldo'] = $dados['receita'] - $dados['despesa'];

    return $dados;
  }
}