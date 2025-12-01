<?php
namespace App\Controllers;
class Home extends BaseController {
  public function index() {
    if (session()->has('usuario_id')) {
      return redirect()->to('/transacoes');
    }

    return redirect()->to('/login');
  }
}