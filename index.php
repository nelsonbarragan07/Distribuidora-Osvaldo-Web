<?php
session_start();
require 'funciones.php';

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

    <title>Distribuidora Osvaldo</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="assets/css/productos.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/whatsapp.css">


    <!--css-only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
          <a class="navbar-brand alinear" href="index.php"><h2>Distribuidora Osvaldo</h2></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li>
              <a href="carrito.php" class="btn"><img class="icono" src="carrito1.png" alt="" height="60">CARRITO <span class="badge car"><?php print cantidadProducto(); ?></span></a></img>
            </li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li>
              <a class="btn" href="nosotros.php"><img class="icono" src="info.png" alt="" height="58">NOSOTROS</a></img>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <!----------------------Slider------------------- -->
    <div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
  </div>
  <div class="carousel-inner">

  <div class="carousel-item active d-item">
      <img src="slider1.jpg" class="d-block w-100 d-img" alt="slider-1">
      <div class="carousel-caption top-0 mt-4">
        <p class="mt-5 fs-3 text-uppercase">
          Descubre infinidad de productos aqui.
        </p>
        <h1 class="display-1 fw-bolder text-capitalize" >Distribuidora Osvaldo</h1>
        <a class="btn btn-primary px-4 py-2 fs-5 mt-5" href="nosotros.php">Información</a>
      </div>
    </div>

    <div class="carousel-item active d-item">
      <img src="bebi.jfif" class="d-block w-100 d-img" alt="slider-1">
      <div class="carousel-caption top-0 mt-4">
        <p class="mt-5 fs-3 text-uppercase">
          Descubre infinidad de productos aqui.
        </p>
        <h1 class="display-1 fw-bolder text-capitalize" >Distribuidora Osvaldo</h1>
        <a class="btn btn-primary px-4 py-2 fs-5 mt-5" href="nosotros.php">Información</a>
      </div>
    </div>

    <div class="carousel-item d-item">
      <img src="beb.jfif" class="d-block w-100 d-img" alt="slider-1">
      <div class="carousel-caption top-0 mt-4">
        <p class="mt-5 fs-3 text-uppercase">
          Descubre infinidad de productos aqui.
        </p>
        <h1 class="display-1 fw-bolder text-capitalize" >Distribuidora Osvaldo</h1>
        <button class="btn btn-primary px-4 py-2 fs-5 mt-5">Información</button>
      </div>
    </div>

    <div class="carousel-item d-item">
      <img src="produc.jpg" class="d-block w-100 d-img" alt="slider-1">
      <div class="carousel-caption top-0 mt-4">
        <p class="mt-5 fs-3 text-uppercase">
          Descubre infinidad de productos aqui.
        </p>
        <h1 class="display-1 fw-bolder text-capitalize" >Distribuidora Osvaldo</h1>
        <button class="btn btn-primary px-4 py-2 fs-5 mt-5">Información</button>
      </div>
    </div>

    <div class="carousel-item d-item">
      <img src="covenas.jfif" class="d-block w-100 d-img" alt="slider-4">
      <div class="carousel-caption top-0 mt-4">
        <p class="mt-5 fs-3 text-uppercase">
        Estamos ubicados en Coveñas
        </p>
        <h1 class="display-1 fw-bolder text-capitalize" >Distribuidora Osvaldo</h1>
        <button class="btn btn-primary px-4 py-2 fs-5 mt-5">Información</button>
      </div>
    </div>

    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

    <!---------------------------CONTENEDOR DE PRODUCTOS------------ -->
    <fieldset>
      <br>
      <h1><legend class="text-center titulo-pelicula">CATALOGO DE PRODUCTOS</legend></h1>
    <div class="container" id="main">
      <div class="row">
        <?php
        require 'vendor/autoload.php';
        $pelicula =new distribuidoraOsvaldo\Producto;
        $info_productos = $pelicula->mostrar();
        $cantidad = count($info_productos);
          if($cantidad>0){
            for($x=0;$x<$cantidad;$x++){
              $item = $info_productos[$x];
        ?>
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h1 class="text-center titulo-pelicula"><?php print $item['titulo'] ?></h1>
            </div>
            <div class="panel-body">
          <?php

            $foto = 'upload/'.$item['foto'];
              if(file_exists($foto)){

          ?>
              <center><img src=" <?php print $foto ?> " class="img-responsive"></center>

          <?php }else{
          ?>
            <img src="assets/imagenes/not-found.jpg" class="img-responsive">
          <?php }
          ?>
         <br>
          <h1 class="text-center titulo-pelicula">$ <?php print $item['precio'] ?></h1>
          
            </div>
            <div class="panel-footer">
              <a href="carrito.php?id=<?php print $item['id'] ?>" class="btn btn-success btn-block">
              <span class="glyphicon glyphicon-shopping-cart"></span> Comprar</a>
            </div>
          </div>
        </div>

        <?php 
            }
      }else{ ?>
          <h4>NO HAY REGISTROS</h4>
          <?php } ?>
      </div>

    </div> <!-- /container -->
    </fieldset>

    <div class="orden">
    <a href="https://wa.me/573128103173" class="btn-whatsapp">
          <img src="whatsapp.png" alt="Contactar por WhatsApp" height="60">
    </a>
  </div>

    <!-- /footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-s-3 icon-footer">
                <img src="envios.png" alt="icono" height="60"/>
                <p><strong>Envios gratis</strong><br>Por $29 de compra</p>
            </div>

            <div class="col-xs-6 col-s-3 icon-footer">
                <img src="devolucion.png" alt="icono" height="60"/>
                <p><strong>Devoluciones gratis</strong><br>Tienes 90 dias</p>
            </div>

            <div class="col-xs-6 col-s-3 icon-footer">
                <img src="atencion.png" alt="icono" height="60"/>
                <p><strong>Atencion al cliente</strong><br>7 dias a la semana</p>
            </div>

            <div class="col-xs-6 col-s-3 icon-footer">
                <img src="seguro.png" alt="icono" height="60"/>
                <p><strong>Pago seguro</strong><br>100% confiable</p>
            </div>
        </div>
      </div>
        <br><br>
        <p>&copy; Distribuidora Osvaldo</p>
    </div>
   </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

  </body>
</html>
