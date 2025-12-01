<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get("/", "Home::index");

$routes->match(["get", "post"], "/login", "Login::index");
$routes->match(["get", "post"], "/registrar", "Registrar::index");
$routes->get("/login/logout", "Login::logout");

$routes->group(
    "transacoes",
    ["filter" => "auth:usuario,admin"],
    static function ($routes) {
        $routes->get("", "Transacoes::index");
        $routes->post("adicionar", "Transacoes::adicionar");
        $routes->get("excluir/(:num)", 'Transacoes::excluir/$1');
    },
);

$routes->group(
    "relatorios",
    ["filter" => "auth:usuario,admin"],
    static function ($routes) {
        $routes->get("", "Relatorios\Anual::index");

        $routes->get("mensal", "Relatorios\Mensal::index");

        $routes->get("geral", "Relatorios\Geral::index");
    },
);
