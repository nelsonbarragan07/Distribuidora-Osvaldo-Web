<?php
//activar sessiones
session_start();
require 'funciones.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    require 'vendor/autoload.php';

    $producto = new distribuidoraOsvaldo\Producto;
    $resultado = $producto->mostrarPorId($id);

    if(!$resultado)
        header('Location: index.php');


    if(isset($_SESSION['carrito'])){ //Si el carrito existe
        //Si el producto existe en el carrito
        if(array_key_exists($id,$_SESSION['carrito'])){
            actualizarProducto($id);
        }else{
            //Si el producto NO existe en el carrito
            agregarProducto($resultado, $id);
        }

    }else{
        //Si el carrito NO existe
        agregarProducto($resultado, $id);
    }
    
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Carrito Compras</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="assets/css/footer.css">
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Distribuidora Osvaldo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li>
              <a href="carrito.php" class="btn"><img class="icono" src="carrito1.png" alt="" height="60">CARRITO <span class="badge"><?php print cantidadProducto(); ?></span></a></img>
            </li> 
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    -------------------------

    <div class="container" id="main">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Foto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
                <tbody>
                    <?php
                        if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])){
                            $total = 0;
                            $c = 0;
                            foreach($_SESSION['carrito'] as $indice => $value){
                                $total = $value['precio'] * $value['cantidad'];
                                $c++;
                    ?>
                    <tr>
                        <form action="actualizar_carrito.php" method="post">
                        <td><?php print $c ?></td>
                        <td><?php print $value['titulo'] ?></td>
                        <td>
                        <?php
                        $foto = 'upload/'.$value['foto'];
                            if(file_exists($foto)){

                        ?>
                            <img src=" <?php print $foto ?> " width="50">

                        <?php }else{
                        ?>
                            <img src="assets/imagenes/not-found.jpg" width="50">
                        <?php }?>
                        </td>
                        <td>$ <?php print $value['precio'] ?> COL</td>
                        <td>
                            <input type="hidden" name="id" value="<?php print $value['id'] ?>">
                            <input type="text" name="cantidad" class="form-control u-size-100" 
                                value="<?php print $value['cantidad'] ?>">
                        </td>
                        <td>
                            $ <?php print $total ?> COL
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-xs">
                            <span class="glyphicon glyphicon-refresh"></span>
                            </button>

                            <a href="eliminar_carrito.php?id=<?php print $value['id'] ?>" 
                            class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                        </form>
                    </tr>


                    <?php
                        }
                        }else{
                    ?>
                    <tr>
                        <td colspan="7">NO HAY PRODUCTOS EN EL CARRITO</td>
                    </tr>


                    <?php
                        }

                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">Total</td>
                        <td>$ <?php print calcularTotal(); ?> COL</td>
                        <td></td>
                    </tr>
                </tfoot>
        </table>
        <hr>
        <?php
        if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])){
        ?>
        <div class="row">
            <div class="pull-left">
                <a href="index.php" class="btn btn-info">Seguir Comprando</a>
            </div>
            <div class="pull-right">
            <a href="finalizar.php" class="btn btn-success">Finalizar Compra</a>
            </div>
        </div>

        <?php
            }
        ?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
