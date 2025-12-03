<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController {
  public function index() {
    if (session()->has('id')) {
      return redirect()->to('transacoes');
    }

    $data['msg'] = '';

    if ($this->request->is('post')) {
      $usuarioModel = model('UsuarioModel');
      $usuarioData  = $this->request->getPost();

      $checkUsuario = $usuarioModel->check(
        $usuarioData['usuario'],
        $usuarioData['senha']
      );

      if (! $checkUsuario) {
        $data['msg'] = "Usuário e/ou senha incorretos";
      } else {
        $this->session->set('id', $checkUsuario->id);
        $this->session->set('nome', $checkUsuario->nome);
        $this->session->set('perfil', $checkUsuario->perfil);

        return redirect()->to('transacoes');
      }
    }
    return view('login', $data);
  }

  public function logout() {
    $this->session->destroy();
    return redirect()->to('/');
  }
}