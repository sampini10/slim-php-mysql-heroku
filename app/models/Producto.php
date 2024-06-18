<?php

class Producto
{
    public $id;
    public $nombre_producto;
    public $categoria_id;
    public $precio;
    public $fecha_registro;
    public $fecha_baja;


    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (nombre_producto, categoria_id, precio, fecha_registro) VALUES (:nombre_producto, :categoria_id, :precio, :fecha_registro)");
        $consulta->bindValue(':nombre_producto', $this->nombre_producto, PDO::PARAM_STR);
        $consulta->bindValue(':categoria_id', $this->categoria_id);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':fecha_registro', $this->fecha_registro);
        
        try{
            $consulta->execute();
        }
        catch(Exception $ex){
            echo "Falle" . $ex;
        }

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }
    
}