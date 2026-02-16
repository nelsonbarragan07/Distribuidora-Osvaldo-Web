<?php

require '../vendor/autoload.php';

$producto = new distribuidoraOsvaldo\Producto;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_POST['accion'] === 'Registrar'){

        if(empty($_POST['titulo']))
            exit('Completar titulo');

        if(empty($_POST['descripcion']))
            exit('Completar descripcion');

        if(empty($_POST['categoria_id']))
            exit('Seleccionar una categoria');

        if(!is_numeric($_POST['categoria_id']))
            exit('Seleccionar una Categoria valida');

    
            $_params = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'foto' => subirFoto(),
                'precio' => $_POST['precio'],
                'categoria_id' => $_POST['categoria_id'],
                'fecha' => date('Y-m-d')
            );

    $rpt = $producto -> registrar($_params);
            
        if($rpt)
            header('Location: productos/index.php');
        else
            print 'Error al registrar un producto';
    }

    if($_POST['accion'] === 'Actualizar'){
        if(empty($_POST['titulo']))
            exit('Completar titulo');

        if(empty($_POST['descripcion']))
            exit('Completar descripcion');

        if(empty($_POST['categoria_id']))
            exit('Seleccionar una categoria');

        if(!is_numeric($_POST['categoria_id']))
            exit('Seleccionar una Categoria valida');

            $_params = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'precio' => $_POST['precio'],
                'categoria_id' => $_POST['categoria_id'],
                'fecha' => date('Y-m-d'),
                'id' => $_POST['id']
            );

            if(!empty($_POST['foto_temp']))
                $_params['foto']= $_POST['foto_temp'];

            if(!empty($_FILES['foto']['name']))
                $_params['foto']=subirFoto();

        $rpt = $producto -> actualizar($_params);
            
            if($rpt)
                header('Location: productos/index.php');
            else
                print 'Error al Actualizar un producto';
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = $_GET['id'];
    $rpt = $producto -> eliminar($id);
           
        if($rpt)
            header('Location: productos/index.php');
        else
            print 'Error al eliminar un producto';
}

function subirFoto(){

    $carpeta = __DIR__.'../../upload/';

    $archivo = $carpeta.$_FILES['foto']['name'];

    move_uploaded_file($_FILES['foto']['tmp_name'],$archivo);
    return $_FILES['foto']['name'];
}
?>