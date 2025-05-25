<?php
// Cabeceras CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Requerir archivos del sistema
require_once __DIR__ . '/../router/Router.php';
require_once __DIR__ . '/../controlador/ArticuloController.php';
require_once __DIR__ . '/../controlador/ClienteController.php';
require_once __DIR__ . '/../controlador/PedidoController.php';
require_once __DIR__ . '/../controlador/VendedorController.php';

// Obtener la ruta
$url = $_SERVER['REQUEST_URI'];
$url = parse_url($url, PHP_URL_PATH);
$basePath = '/rabadan_hierro_ruben_DWES04_TE/public';

if (strpos($url, $basePath) === 0) {
    $relativeUrl = substr($url, strlen($basePath));
    $relativeUrl = rtrim($relativeUrl, '/');
    if ($relativeUrl === '') $relativeUrl = '/';
} else {
    http_response_code(404);
    echo json_encode(["error" => "URL no válida. Debe comenzar con /public"]);
    exit;
}

// Crear router
$router = new Router();

// Rutas para Artículos
$router->add('/articulos', 'ArticuloController@get');
$router->add('/articulos/post', 'ArticuloController@create');
$router->add('/articulos/put/{id}', 'ArticuloController@update');
$router->add('/articulos/delete/{id}', 'ArticuloController@delete');

// Rutas para Clientes
$router->add('/clientes', 'ClienteController@get');
$router->add('/clientes/post', 'ClienteController@create');
$router->add('/clientes/put/{id}', 'ClienteController@update');
$router->add('/clientes/delete/{id}', 'ClienteController@delete');
$router->add('/articulos/get/{id}', 'ArticuloController@getById');


// Rutas para Pedidos
$router->add('/pedidos', 'PedidoController@get');
$router->add('/pedidos/post', 'PedidoController@create');
$router->add('/pedidos/put/{id}', 'PedidoController@update');
$router->add('/pedidos/delete/{id}', 'PedidoController@delete');

// Rutas para Vendedores
$router->add('/vendedores', 'VendedorController@get');
$router->add('/vendedores/post', 'VendedorController@create');
$router->add('/vendedores/put/{id}', 'VendedorController@update');
$router->add('/vendedores/delete/{id}', 'VendedorController@delete');

// Despachar la solicitud
$router->dispatch($relativeUrl);
