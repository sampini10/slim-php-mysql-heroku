<?php

use Illuminate\Support\Facades\Date;

require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function TraerUno($request, $response, $args)
    {
    }
    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodos();
        $payload = json_encode(array("listaProductos" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre_producto = $parametros['nombre_producto'];
        $categoria_id = $parametros['categoria_id'];
        $precio = $parametros['precio'];
        $fecha_registro = Date::now();

        $producto =  new Producto();
        $producto->nombre_producto = $nombre_producto;
        $producto->categoria_id = $categoria_id;
        $producto->precio = $precio;
        $producto->fecha_registro = $fecha_registro;

        $producto->crearProducto();

        $payload = json_encode(array("Mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
    }
    public function ModificarUno($request, $response, $args)
    {
    }

    public function CargarProductoCSV($request, $response, $args)
    {
        $archivo = $request->getUploadedFiles();
        $data = $archivo['archivo'];
        $csv = $data->getStream()->getContents();

        if ($csv !== false) {
            $rows = array_map('str_getcsv', explode("\n", $csv));
            foreach ($rows as $row) {
                if (!empty($row) && count($row) >= 3) {
                    $producto = new Producto();
                    $producto->nombre_producto = $row[0];
                    $producto->precio = $row[1];
                    $producto->categoria_id = $row[2];
                    $producto->fecha_registro = Date::now();

                    $producto->CrearProducto();
                }
            }
        }
        $payload = json_encode(array("mensaje" => "Producto creado con exito"));
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
