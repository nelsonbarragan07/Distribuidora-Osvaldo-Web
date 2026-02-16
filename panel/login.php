<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

$nombre_usuario = $_POST['nombre_usuario'];
$clave = $_POST['clave'];

require '../vendor/autoload.php';

    $usuario = new distribuidoraOsvaldo\Usuario;
    $resultado = $usuario->login($nombre_usuario, $clave);

    if($resultado){
        session_start();
        
        $_SESSION['usuario_info'] = array(
            'nombre_usuario' => $resultado['nombre_usuario'],
            'estado'=> 1
        );
        echo "<script languaje='javascript'>alert('Bienvenido al sitio de administrador');</script>";
      
        echo "<script languaje='javascript'>window.location='dashboard.php';</script>";
    }else{
       
		echo "<script languaje='javascript'>alert('Datos incorrectos');</script>";
        echo "<script languaje='javascript'>window.location='index.php';</script>";
        
    }

}
?>