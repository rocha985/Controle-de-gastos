<?php
namespace App\Controllers\Relatorios;

use App\Controllers\BaseController;
use App\Services\Relatorios\MensalService;

class Mensal extends BaseController {
  private $relatorioService;

  public function __construct() {
    $this->relatorioService = new MensalService();
  }

  public function index() {
    $usuarioId = session()->get("id");
    $ano       = $this->request->getGet("ano") ?? date("Y");
    $mes       = $this->request->getGet("mes") ?? date("m");

    if (! $usuarioId) {
      return redirect()->to(base_url('login'))->with('error', 'acesso não autorizado');
    }

    $dadosRelatorio = $this->relatorioService->gerarRelatorio($usuarioId, $ano, $mes);

    $data = array_merge($dadosRelatorio, [
      "active" => "relatorios-mensal",
    ]);

    return view("relatorios/mensal", $data);
  }
}