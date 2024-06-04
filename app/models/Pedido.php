<?php

class Pedido
{
    public $id;
    public $mesa_id;
    public $usuario_id;
    public $cliente_nombre;
    public $estado;
    public $fecha_registro;
    
    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (mesa_id, usuario_id, cliente_nombre, estado, fecha_registro) VALUES (:mesa_id, :usuario_id, :cliente_nombre, :estado, :fecha_registro)");
        $consulta->bindValue(':mesa_id', $this->mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $consulta->bindValue(':cliente_nombre', $this->fecha_registro, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_registro', $this->fecha_registro);
        
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }
}
