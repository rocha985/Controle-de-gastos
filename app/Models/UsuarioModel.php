<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model {
  protected $table            = 'usuarios';
  protected $primaryKey       = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'object';
  protected $useSoftDeletes   = false;
  protected $protectFields    = true;
  protected $allowedFields    = ['nome', 'usuario', 'senha', 'perfil'];

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
    'nome'    => 'required',
    'usuario' => 'required|is_unique[usuarios.usuario]',
    'senha'   => 'required',
    'perfil'  => 'required',
  ];
  protected $validationMessages   = [];
  protected $skipValidation       = false;
  protected $cleanValidationRules = true;

  // Callbacks
  protected $allowCallbacks = true;
  protected $beforeInsert   = ['hashSenha'];
  protected $afterInsert    = [];
  protected $beforeUpdate   = [];
  protected $afterUpdate    = [];
  protected $beforeFind     = [];
  protected $afterFind      = [];
  protected $beforeDelete   = [];
  protected $afterDelete    = [];

  //método para criptografar a senha
  protected function hashSenha($data) {
    $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
    return $data;
  }

  //método para validar usuário/senha (form de Login)
  public function check($usuario, $senha) {
    //busca o usuário
    $buscaUsuario = $this->where('usuario', $usuario)->first();
    if (is_null($buscaUsuario)) {
      return false;
    }
    //validar a senha
    if (! password_verify($senha, $buscaUsuario->senha)) {
      return false;
    }

    return $buscaUsuario;
  }
}
