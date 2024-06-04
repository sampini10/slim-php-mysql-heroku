<?php

use Illuminate\Support\Facades\Date;

require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class PedidosController extends Pedido implements IApiUsable
{
    public function TraerUno($request, $response, $args)
    {
    }
    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        $payload = json_encode(array("listaPedidos" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $mesa_id = $parametros['mesa_id'];
        $usuario_id = $parametros['usuario_id'];
        $cliente_nombre = $parametros['cliente_nombre'];
        $estado = $parametros['estado'];
        $fecha_registro = Date::now();

        $pedido =  new Pedido();
        $pedido->mesa_id = $mesa_id;
        $pedido->usuario_id = $usuario_id;
        $pedido->cliente_nombre = $cliente_nombre;
        $pedido->estado = $estado;
        $pedido->fecha_registro = $fecha_registro;

        $pedido->crearpedido();

        $payload = json_encode(array("Mensaje" => "Pedido creado con exito"));

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');

    }
    public function BorrarUno($request, $response, $args)
    {
    }
    public function ModificarUno($request, $response, $args)
    {
    }
}
