<?php
namespace App\Controllers\Relatorios;

use App\Controllers\BaseController;
use App\Services\Relatorios\AnualService;

class Anual extends BaseController {
      private $relatorioService;

  public function __construct() {
    $this->relatorioService = new AnualService();
  }

  public function index() {
    $usuarioId = session()->get("id");
    $ano       = $this->request->getGet("ano") ?? date("Y");

    if (! $usuarioId) {
      return redirect()->to(base_url('login'))->with('error', 'acesso não autorizado');
    }

    $dadosRelatorio = $this->relatorioService->gerarRelatorio((int) $usuarioId, $ano);

    $data = array_merge($dadosRelatorio, [
      "active" => "relatorios-anual",
    ]);

    return view("relatorios/anual", $data);
  }
}
