<?php
namespace App\Controllers;

use App\Repositories\HomeRepository;

class Home extends BaseController {
    
    private $repository;

    public function __construct() {
        $this->repository = new HomeRepository();
    }

    public function index() {
        if (session()->get('id')) {
            return redirect()->to('/transacoes');
        }

        $categorias = $this->repository->getPrincipaisCategorias();
        $totalUsuarios = $this->repository->getTotalUsuarios();

        $data = [
            'categorias' => $categorias,
            'total_usuarios' => $totalUsuarios
        ];

        return view('home', $data);
    }
}