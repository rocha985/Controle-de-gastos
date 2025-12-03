<?php
namespace App\Repositories;

class HomeRepository {
  private $db;

  public function __construct() {
    $this->db = \Config\Database::connect();
  }

  public function getPrincipaisCategorias() {
    return $this->db->table('tipos_transacao')
      ->select('nome, descricao')
      ->where('tipo', 'despesa')
      ->orderBy('nome', 'ASC')
      ->limit(6)
      ->get()
      ->getResultArray();
  }

  public function getTotalUsuarios() {
    return $this->db->table('usuarios')->countAll();
  }
}