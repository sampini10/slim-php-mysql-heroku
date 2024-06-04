<?php

class Mesa
{
    public $id;
    public $codigo_mesa;
    public $estado;
    public $fecha_registro;

    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (codigo_mesa, estado, fecha_registro) VALUES (:codigo_mesa, :estado, :fecha_registro)");
        $consulta->bindValue(':codigo_mesa', $this->codigo_mesa, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':fecha_registro', $this->fecha_registro);
        
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }
}
