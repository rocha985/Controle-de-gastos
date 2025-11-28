<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Registrar extends BaseController {
  public function index() {
    if (session()->has('id')) {
      return redirect()->to('transacoes');
    }

    $data['msg'] = '';

    if ($this->request->is('post')) {
      $usuarioModel = model('UsuarioModel');

      try {
        $usuarioData           = $this->request->getPost();
        $usuarioData['perfil'] = 'usuario';

        if ($usuarioModel->insert($usuarioData)) {
          $data['msg']      = "Usuário criado com sucesso! Faça login.";
          $data['msg_type'] = 'success';
        } else {
          $data['msg']    = "Erro ao criar usuário";
          $data['errors'] = $usuarioModel->errors();
        }
      } catch (\Exception $e) {
        $data['msg'] = "Erro: " . $e->getMessage();
      }
    }
    return view('registrar', $data);
  }
}