<?php
session_start();
require 'funciones.php';

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Distribuidora Osvaldo - Tu tienda de bebidas en Coveñas">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Distribuidora Osvaldo - Inicio</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- CSS Personalizados  -->
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/carrusel.css">
    <link rel="stylesheet" href="assets/css/productos.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/whatsapp.css">
    
    <!-- Bootstrap 5 para el slider (solo componentes necesarios) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>

    <!-- NAVBAR  -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">
            <strong>Distribuidora Osvaldo</strong>
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="nosotros.php">
                <i class="glyphicon glyphicon-info-sign"></i> Nosotros
              </a>
            </li>
            <li>
              <a href="carrito.php">
                <i class="glyphicon glyphicon-shopping-cart"></i> Carrito 
                <span class="badge badge-carrito"><?php print cantidadProducto(); ?></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <!-- SLIDER PROFESIONAL - DISTRIBUIDORA OSVALDO -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
  
  <!-- Indicadores  -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Bienvenida"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Productos"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Ofertas"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Calidad"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4" aria-label="Ubicación"></button>
  </div>
  
  <div class="carousel-inner">
    
    <!-- SLIDE 1: Bienvenida Principal -->
    <div class="carousel-item active">
      <div class="carousel-overlay"></div>
      <img src="slider1.jpg" class="d-block w-100 carousel-img" alt="Bienvenidos a Distribuidora Osvaldo">
      <div class="carousel-caption carousel-caption-center">
        <div class="caption-content">
          <span class="badge-slide">Bienvenidos</span>
          <h1 class="display-2 fw-bold mb-3">
            Distribuidora <span class="text-highlight">Osvaldo</span>
          </h1>
          <p class="lead mb-4">
            Tu distribuidora de confianza en Coveñas
          </p>
          <div class="caption-buttons">
            <a href="#main" class="btn btn-primary btn-lg me-3">
              <i class="glyphicon glyphicon-shopping-cart"></i> Ver Productos
            </a>
            <a href="nosotros.php" class="btn btn-outline-light btn-lg">
              <i class="glyphicon glyphicon-info-sign"></i> Conócenos
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- SLIDE 2: Variedad de Productos -->
    <div class="carousel-item">
      <div class="carousel-overlay"></div>
      <img src="bebi.jfif" class="d-block w-100 carousel-img" alt="Gran variedad de productos">
      <div class="carousel-caption carousel-caption-left">
        <div class="caption-content">
          <span class="badge-slide">Catálogo</span>
          <h2 class="display-3 fw-bold mb-3">
            Más de <span class="text-highlight">500</span> Productos
          </h2>
          <p class="lead mb-4">
            Bebidas, snacks y más para tu negocio o evento
          </p>
          <ul class="feature-list">
            <li><i class="glyphicon glyphicon-ok-circle"></i> Refrescos y Gaseosas</li>
            <li><i class="glyphicon glyphicon-ok-circle"></i> Bebidas Alcohólicas</li>
            <li><i class="glyphicon glyphicon-ok-circle"></i> Energizantes e Hidratantes</li>
          </ul>
          <a href="#main" class="btn btn-primary btn-lg">
            <i class="glyphicon glyphicon-eye-open"></i> Explorar Catálogo
          </a>
        </div>
      </div>
    </div>

    <!-- SLIDE 3: Ofertas y Promociones -->
    <div class="carousel-item">
      <div class="carousel-overlay"></div>
      <img src="beb.jfif" class="d-block w-100 carousel-img" alt="Ofertas especiales">
      <div class="carousel-caption carousel-caption-right">
        <div class="caption-content">
          <span class="badge-slide badge-slide-hot">Hot</span>
          <h2 class="display-3 fw-bold mb-3">
            ¡Ofertas <span class="text-highlight">Especiales</span>!
          </h2>
          <p class="lead mb-4">
            Descuentos increíbles en productos seleccionados
          </p>
          <div class="promo-grid">
            <div class="promo-item">
              <h3>20%</h3>
              <p>En compras mayores</p>
            </div>
            <div class="promo-item">
              <h3>Envío</h3>
              <p>Gratis desde $100K</p>
            </div>
            <div class="promo-item">
              <h3>2x1</h3>
              <p>Productos selectos</p>
            </div>
          </div>
          <a href="#main" class="btn btn-warning btn-lg">
            <i class="glyphicon glyphicon-fire"></i> Ver Ofertas
          </a>
        </div>
      </div>
    </div>

    <!-- SLIDE 4: Calidad Garantizada -->
    <div class="carousel-item">
      <div class="carousel-overlay"></div>
      <img src="produc.jpg" class="d-block w-100 carousel-img" alt="Productos de calidad">
      <div class="carousel-caption carousel-caption-center">
        <div class="caption-content">
          <span class="badge-slide badge-slide-quality">Calidad</span>
          <h2 class="display-3 fw-bold mb-3">
            Productos de <span class="text-highlight">Primera</span>
          </h2>
          <p class="lead mb-4">
            Trabajamos solo con las mejores marcas del mercado
          </p>
          <div class="quality-features">
            <div class="quality-item">
              <i class="glyphicon glyphicon-star"></i>
              <h4>Calidad Premium</h4>
            </div>
            <div class="quality-item">
              <i class="glyphicon glyphicon-time"></i>
              <h4>Entrega Rápida</h4>
            </div>
            <div class="quality-item">
              <i class="glyphicon glyphicon-lock"></i>
              <h4>Pago Seguro</h4>
            </div>
          </div>
          <a href="nosotros.php" class="btn btn-success btn-lg">
            <i class="glyphicon glyphicon-certificate"></i> Nuestra Garantía
          </a>
        </div>
      </div>
    </div>

    <!-- SLIDE 5: Ubicación en Coveñas -->
    <div class="carousel-item">
      <div class="carousel-overlay overlay-dark"></div>
      <img src="covenas.jfif" class="d-block w-100 carousel-img" alt="Ubicados en Coveñas">
      <div class="carousel-caption carousel-caption-center">
        <div class="caption-content">
          <span class="badge-slide badge-slide-location">
            <i class="glyphicon glyphicon-map-marker"></i> Ubicación
          </span>
          <h2 class="display-3 fw-bold mb-3">
            Estamos en <span class="text-highlight">Coveñas</span>
          </h2>
          <p class="lead mb-4">
            Tu aliado local para abastecer tu negocio o evento
          </p>
          <div class="location-info">
            <div class="info-item">
              <i class="glyphicon glyphicon-phone"></i>
              <a href="tel:+573128103173">+57 312 810 3173</a>
            </div>
            <div class="info-item">
              <i class="glyphicon glyphicon-time"></i>
              <span>Lun - Sáb: 8:00 AM - 8:00 PM</span>
            </div>
          </div>
          <div class="caption-buttons">
            <a href="https://wa.me/573128103173" class="btn btn-success btn-lg me-3" target="_blank">
              <i class="glyphicon glyphicon-phone"></i> WhatsApp
            </a>
            <a href="nosotros.php" class="btn btn-outline-light btn-lg">
              <i class="glyphicon glyphicon-map-marker"></i> Cómo Llegar
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
  
  <!-- Controles  -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-icon">
      <i class="glyphicon glyphicon-chevron-left"></i>
    </span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-icon">
      <i class="glyphicon glyphicon-chevron-right"></i>
    </span>
    <span class="visually-hidden">Siguiente</span>
  </button>

  <!-- Barra de Progreso -->
  <div class="carousel-progress">
    <div class="carousel-progress-bar"></div>
  </div>

</div>

    <!-- CATÁLOGO DE PRODUCTOS -->
    <fieldset>
      <br>
      <h1><legend class="text-center titulo-pelicula">CATÁLOGO DE PRODUCTOS</legend></h1>
    <div class="container" id="main">
      <div class="row">
        <?php
        require 'vendor/autoload.php';
        $pelicula = new distribuidoraOsvaldo\Producto;
        $info_productos = $pelicula->mostrar();
        $cantidad = count($info_productos);
          if($cantidad > 0){
            for($x = 0; $x < $cantidad; $x++){
              $item = $info_productos[$x];
        ?>
        <div class="col-md-3 col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><?php print $item['titulo'] ?></h4>
            </div>
            <div class="panel-body">
          <?php
            $foto = 'upload/'.$item['foto'];
              if(file_exists($foto)){
          ?>
              <center><img src="<?php print $foto ?>" class="img-responsive" style="max-height: 200px;"></center>
          <?php }else{ ?>
            <center><img src="assets/imagenes/not-found.jpg" class="img-responsive"></center>
          <?php } ?>
         <br>
          <h3 class="text-center"><strong>$ <?php print number_format($item['precio'], 0, ',', '.') ?></strong></h3>
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
          <div class="col-md-12">
            <div class="alert alert-warning text-center">
              <h4>NO HAY PRODUCTOS REGISTRADOS</h4>
            </div>
          </div>
          <?php } ?>
      </div>

    </div>
    </fieldset>

    <!-- BOTÓN WHATSAPP -->
    <div class="orden">
      <a href="https://wa.me/573128103173" class="btn-whatsapp" target="_blank">
        <img src="whatsapp.png" alt="Contactar por WhatsApp" height="60">
      </a>
    </div>

    <footer>
    <div class="container">
        <!-- Beneficios -->
        <div class="row footer-benefits">
            <div class="col-xs-6 col-sm-3 icon-footer">
                <div class="icon-footer-image">
                    <img src="envios.png" alt="Envíos">
                </div>
                <p><strong>Envíos gratis</strong><br>Por $100.000 de compra</p>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="row footer-info">
            <div class="col-md-4 footer-section">
                <h4>Sobre Nosotros</h4>
                <p>Distribuidora Osvaldo, tu aliado en Coveñas para las mejores bebidas.</p>
                
                <div class="footer-social">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <a href="#" class="social-link facebook">
                            <i class="glyphicon glyphicon-thumbs-up"></i>
                        </a>
                        <a href="#" class="social-link instagram">
                            <i class="glyphicon glyphicon-camera"></i>
                        </a>
                        <a href="https://wa.me/573128103173" class="social-link whatsapp">
                            <i class="glyphicon glyphicon-phone"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 footer-section">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="nosotros.php">Nosotros</a></li>
                    <li><a href="carrito.php">Carrito</a></li>
                    <li><a href="#">Términos y Condiciones</a></li>
                </ul>
            </div>

            <div class="col-md-4 footer-contact">
                <h4>Contacto</h4>
                <div class="footer-contact-item">
                    <i class="glyphicon glyphicon-map-marker"></i>
                    <span>Coveñas, Colombia</span>
                </div>
                <div class="footer-contact-item">
                    <i class="glyphicon glyphicon-phone"></i>
                    <a href="tel:+573128103173">+57 312 810 3173</a>
                </div>
                <div class="footer-contact-item">
                    <i class="glyphicon glyphicon-envelope"></i>
                    <a href="mailto:info@distribuidoraosvaldo.com">info@distribuidoraosvaldo.com</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="footer-copyright">
                    &copy; <?php echo date('Y'); ?> Distribuidora Osvaldo. Todos los derechos reservados.
                </p>
                <div class="footer-links">
                    <a href="#">Privacidad</a>
                    <a href="#">Términos</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Botón Scroll to Top -->
<div class="scroll-to-top" id="scrollToTop">
    <i class="glyphicon glyphicon-chevron-up"></i>
</div>

    <!-- JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slider.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para efecto scroll en navbar -->
    <script>
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar-default').addClass('scrolled');
        } else {
            $('.navbar-default').removeClass('scrolled');
        }
    });
    </script>

  </body>
</html>