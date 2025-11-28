<?php
namespace App\Controllers\Relatorios;

use App\Controllers\BaseController;
use App\Services\Relatorios\GeralService;

class Geral extends BaseController {
  private $relatorioService;

  public function __construct() {
    $this->relatorioService = new GeralService();
  }

  public function index() {
    $usuarioId = session()->get("id");

    if (! $usuarioId) {
      return redirect()->to(base_url('login'))->with('error', 'acesso não autorizado');
    }

    $dadosRelatorio = $this->relatorioService->gerarRelatorio($usuarioId);

    $data = array_merge($dadosRelatorio, [
      "active" => "relatorios-geral",
    ]);

    return view("relatorios/geral", $data);
  }
}