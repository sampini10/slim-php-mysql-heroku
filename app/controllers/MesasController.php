<?php

use Illuminate\Support\Facades\Date;

require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesasController extends Mesa implements IApiUsable
{
    public function TraerUno($request, $response, $args)
    {
    }
    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listarMesas" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigo_mesa = $parametros['codigo_mesa'];
        $estado = $parametros['estado'];
        $fecha_registro = Date::now();

        $mesa =  new Mesa();
        $mesa->codigo_mesa = $codigo_mesa;
        $mesa->estado = $estado;
        $mesa->fecha_registro = $fecha_registro;

        $mesa->crearMesa();

        $payload = json_encode(array("Mensaje" => "Mesa creada con exito"));

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
