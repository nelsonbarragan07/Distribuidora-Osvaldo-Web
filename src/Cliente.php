<?php

namespace distribuidoraOsvaldo;

class Cliente{

    private $config;
    private $cn = null;

    public function __construct(){

        $this->config = parse_ini_file(__DIR__.'/../config.ini');

        $this->cn = new \PDO( $this->config['dns'], $this->config['usuario'],$this->config['clave'],
        array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
        
    }

    public function registrar($_params){
        $sql = "INSERT INTO `clientes`( `nombre`, `apellidos`, `email`, `telefono`, `comentario`)
        VALUES (:nombre,:apellidos,:email,:telefono,:comentario)";

        $resultado = $this->cn->prepare($sql);

        $_array = array(
            ":nombre" => $_params['nombre'],
            ":apellidos" => $_params['apellidos'],
            ":email" => $_params['email'],
            ":telefono" => $_params['telefono'],
            ":comentario" => $_params['comentario']
        );

        if($resultado->execute($_array))
            return $this->cn->lastInsertId();

        return false;
    }

    public function mostrar(){
        $sql = "SELECT c.id, nombre, apellidos, email, telefono, comentario FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id ORDER BY c.id DESC";

        $resultado = $this->cn->prepare($sql);

        if($resultado->execute())
            return $resultado->fetchAll();

        return false;
    }
}
?>