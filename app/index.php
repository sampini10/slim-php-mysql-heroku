<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesasController.php';
require_once './controllers/PedidosController.php';
require_once './middlewares/AuthMiddleware.php';


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('[/]', \UsuarioController::class . ':TraerTodos');
  $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
  $group->post('[/]', \UsuarioController::class . ':CargarUno');
})->add(new AuthMiddleware());

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
  $group->get('/{producto}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
})->add(new AuthMiddleware());

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesasController::class . ':TraerTodos');
  $group->get('/{mesa}', \MesasController::class . ':TraerUno');
  $group->post('[/]', \MesasController::class . ':CargarUno');
})->add(new AuthMiddleware());

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \PedidosController::class . ':TraerTodos');
  $group->get('/{pedido}', \PedidosController::class . ':TraerUno');
  $group->post('[/]', \PedidosController::class . ':CargarUno');
})->add(new AuthMiddleware());


$app->get('[/]', function (Request $request, Response $response) {
  $payload = json_encode(array("mensaje" => "Bienvenido a TP COMANDA - Sampini Nicolas"));

  $response->getBody()->write($payload);
  return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
