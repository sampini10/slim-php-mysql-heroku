<?php

class Pedido
{
    public $id;
    public $mesa_id;
    public $usuario_id;
    public $cliente_nombre;
    public $estado_pedido_id;
    public $fecha_registro;
    
    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (mesa_id, usuario_id, cliente_nombre, estado_pedido_id, fecha_registro) VALUES (:mesa_id, :usuario_id, :cliente_nombre, :estado_pedido_id, :fecha_registro)");
        $consulta->bindValue(':mesa_id', $this->mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $consulta->bindValue(':cliente_nombre', $this->cliente_nombre, PDO::PARAM_STR);
        //el estado deberia inicializar en 1 siempre.
        $consulta->bindValue(':estado_pedido_id', $this->estado_pedido_id, PDO::PARAM_INT);
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
