<?php
session_start();
require 'funciones.php';

// ===================================
// DATOS DE RESPALDO (Fallback)
// ===================================
$empresa = array(
  'nombre' => 'Distribuidora Osvaldo',
  'descripcion' => 'Tu distribuidora de confianza en Coveñas',
  'telefono' => '+57 312 810 3173',
  'direccion' => 'Coveñas, Sucre, Colombia',
  'horario' => 'Lunes a Sábado: 8:00 AM - 8:00 PM',
  'facebook' => 'https://www.facebook.com/distribuidoraosvaldocovenas',
  'instagram' => 'https://instagram.com/distribuidora_osvaldo',
  'whatsapp' => '573128103173',
  'email' => 'info@distribuidoraosvaldo.com'
);

// Intentar obtener datos de la BD
try {
  require_once('conexion.php');
  $sql = "SELECT * FROM empresa LIMIT 1";
  $res = @mysqli_query($con, $sql);

  if ($res && mysqli_num_rows($res) > 0) {
    $reg = mysqli_fetch_assoc($res);
    foreach ($empresa as $key => $value) {
      if (isset($reg[$key]) && !empty($reg[$key])) {
        $empresa[$key] = $reg[$key];
      }
    }
  }
} catch (Exception $e) {
  // Usar datos de respaldo
}

// Detectar página actual para navbar
$current_page = basename($_SERVER['PHP_SELF']);
function isActive($page)
{
  global $current_page;
  return ($current_page == $page) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Distribuidora Osvaldo - Tu tienda de bebidas en Coveñas. Más de 500 productos de calidad.">
  <meta name="author" content="Distribuidora Osvaldo">
  <meta name="keywords" content="distribuidora, bebidas, coveñas, osvaldo, licores, gaseosas, snacks">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="Distribuidora Osvaldo - Inicio">
  <meta property="og:description" content="Tu distribuidora de confianza en Coveñas">
  <meta property="og:image" content="logoOsvaldo.jpg">

  <title>Distribuidora Osvaldo - Inicio | Coveñas</title>
  <link rel="icon" href="logoOsvaldo.jpg">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <!-- CSS Personalizados -->
  <link rel="stylesheet" href="assets/css/navbar-horizontal.css">
  <link rel="stylesheet" href="assets/css/slider.css">
  <link rel="stylesheet" href="assets/css/productos.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="assets/css/whatsapp.css">

  <style>
    /* Estilos adicionales para el catálogo */
    .catalogo-section {
      padding: 80px 0;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .titulo-catalogo {
      text-align: center;
      font-size: 2.5rem;
      font-weight: 700;
      color: #2c3e50;
      margin-bottom: 50px;
      text-transform: uppercase;
      letter-spacing: 2px;
      position: relative;
      padding-bottom: 20px;
    }

    .titulo-catalogo::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: linear-gradient(90deg, #3498db, #2ecc71);
      border-radius: 2px;
    }

    .producto-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      margin-bottom: 30px;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .producto-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .producto-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 15px;
      color: white;
      min-height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .producto-header h4 {
      margin: 0;
      font-size: 1.1rem;
      font-weight: 600;
      text-align: center;
    }

    .producto-body {
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .producto-imagen {
      text-align: center;
      margin-bottom: 15px;
      min-height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f8f9fa;
      border-radius: 10px;
      overflow: hidden;
    }

    .producto-imagen img {
      max-height: 200px;
      width: auto;
      max-width: 100%;
      object-fit: contain;
      transition: transform 0.3s ease;
    }

    .producto-card:hover .producto-imagen img {
      transform: scale(1.1);
    }

    .producto-precio {
      text-align: center;
      font-size: 1.8rem;
      font-weight: 700;
      color: #27ae60;
      margin: 15px 0;
    }

    .producto-footer {
      padding: 15px;
      border-top: 1px solid #eee;
    }

    .btn-comprar {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      background: linear-gradient(135deg, #2ecc71, #27ae60);
      border: none;
      color: white;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .btn-comprar:hover {
      background: linear-gradient(135deg, #27ae60, #229954);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }

    .no-productos {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .no-productos i {
      font-size: 4rem;
      color: #f39c12;
      margin-bottom: 20px;
    }

    .no-productos h4 {
      color: #7f8c8d;
      font-size: 1.5rem;
    }

    /* Animación de entrada */
    .producto-card {
      animation: fadeInUp 0.6s ease-out;
      animation-fill-mode: both;
    }

    .producto-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .producto-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .producto-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .producto-card:nth-child(4) {
      animation-delay: 0.4s;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Scroll to top button */
    .scroll-to-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #3498db, #2980b9);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      z-index: 999;
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .scroll-to-top.visible {
      opacity: 1;
      visibility: visible;
    }

    .scroll-to-top:hover {
      background: linear-gradient(135deg, #2980b9, #21618c);
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
    }

    .scroll-to-top i {
      font-size: 1.5rem;
    }
  </style>
</head>

<body>

  <!-- NAVBAR MEJORADO -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNavbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <h2 class="mb-0">DISTRIBUIDORA OSVALDO</h2>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item <?php echo isActive('index.php'); ?>">
            <a class="nav-link" href="index.php">
              <i class="bi bi-house-fill"></i>
              INICIO
            </a>
          </li>

          <li class="nav-item <?php echo isActive('nosotros.php'); ?>">
            <a class="nav-link" href="nosotros.php">
              <i class="bi bi-info-circle-fill"></i>
              NOSOTROS
            </a>
          </li>

          <li class="nav-item <?php echo isActive('carrito.php'); ?>">
            <a class="nav-link position-relative" href="carrito.php">
              <i class="bi bi-cart-fill"></i>
              CARRITO
              <?php
              $cantidad = cantidadProducto();
              if ($cantidad > 0):
              ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?php echo $cantidad; ?>
                </span>
              <?php endif; ?>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#contacto">
              <i class="bi bi-envelope-fill"></i>
              CONTACTO
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-success" href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" target="_blank">
              <i class="bi bi-whatsapp"></i>
              WHATSAPP
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="navbar-line"></div>
    <div class="scroll-progress" id="scrollProgress"></div>
  </nav>
  <!-- FIN NAVBAR -->

  <!-- SLIDER PROFESIONAL -->
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">

    <!-- Indicadores -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
    </div>

    <div class="carousel-inner">

      <!-- SLIDE 1: Bienvenida Principal -->
      <div class="carousel-item active">
        <div class="carousel-overlay"></div>
        <img src="slider1.jpg" class="d-block w-100 carousel-img" alt="Bienvenidos" loading="eager">
        <div class="carousel-caption carousel-caption-center">
          <div class="caption-content">
            <span class="badge-slide">Bienvenidos</span>
            <h1 class="display-2 fw-bold mb-3">
              Distribuidora <span class="text-highlight">Osvaldo</span>
            </h1>
            <p class="lead mb-4">Tu distribuidora de confianza en Coveñas</p>
            <div class="caption-buttons">
              <a href="#main" class="btn btn-primary btn-lg me-3">
                <i class="bi bi-cart-fill"></i> Ver Productos
              </a>
              <a href="nosotros.php" class="btn btn-outline-light btn-lg">
                <i class="bi bi-info-circle"></i> Conócenos
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- SLIDE 2: Variedad de Productos -->
      <div class="carousel-item">
        <div class="carousel-overlay"></div>
        <img src="bebi.jfif" class="d-block w-100 carousel-img" alt="Productos" loading="lazy">
        <div class="carousel-caption carousel-caption-left">
          <div class="caption-content">
            <span class="badge-slide">Catálogo</span>
            <h2 class="display-3 fw-bold mb-3">
              Más de <span class="text-highlight">500</span> Productos
            </h2>
            <p class="lead mb-4">Bebidas, snacks y más para tu negocio o evento</p>
            <ul class="feature-list">
              <li><i class="bi bi-check-circle-fill"></i> Refrescos y Gaseosas</li>
              <li><i class="bi bi-check-circle-fill"></i> Bebidas Alcohólicas</li>
              <li><i class="bi bi-check-circle-fill"></i> Energizantes e Hidratantes</li>
            </ul>
            <a href="#main" class="btn btn-primary btn-lg">
              <i class="bi bi-grid-fill"></i> Explorar Catálogo
            </a>
          </div>
        </div>
      </div>

      <!-- SLIDE 3: Ofertas -->
      <div class="carousel-item">
        <div class="carousel-overlay"></div>
        <img src="beb.jfif" class="d-block w-100 carousel-img" alt="Ofertas" loading="lazy">
        <div class="carousel-caption carousel-caption-right">
          <div class="caption-content">
            <span class="badge-slide badge-slide-hot">Hot</span>
            <h2 class="display-3 fw-bold mb-3">
              ¡Ofertas <span class="text-highlight">Especiales</span>!
            </h2>
            <p class="lead mb-4">Descuentos increíbles en productos seleccionados</p>
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
              <i class="bi bi-fire"></i> Ver Ofertas
            </a>
          </div>
        </div>
      </div>

      <!-- SLIDE 4: Calidad -->
      <div class="carousel-item">
        <div class="carousel-overlay"></div>
        <img src="produc.jpg" class="d-block w-100 carousel-img" alt="Calidad" loading="lazy">
        <div class="carousel-caption carousel-caption-center">
          <div class="caption-content">
            <span class="badge-slide badge-slide-quality">Calidad</span>
            <h2 class="display-3 fw-bold mb-3">
              Productos de <span class="text-highlight">Primera</span>
            </h2>
            <p class="lead mb-4">Trabajamos solo con las mejores marcas del mercado</p>
            <div class="quality-features">
              <div class="quality-item">
                <i class="bi bi-star-fill"></i>
                <h4>Calidad Premium</h4>
              </div>
              <div class="quality-item">
                <i class="bi bi-clock-fill"></i>
                <h4>Entrega Rápida</h4>
              </div>
              <div class="quality-item">
                <i class="bi bi-shield-check"></i>
                <h4>Pago Seguro</h4>
              </div>
            </div>
            <a href="nosotros.php" class="btn btn-success btn-lg">
              <i class="bi bi-award-fill"></i> Nuestra Garantía
            </a>
          </div>
        </div>
      </div>

      <!-- SLIDE 5: Ubicación -->
      <div class="carousel-item">
        <div class="carousel-overlay overlay-dark"></div>
        <img src="covenas.jfif" class="d-block w-100 carousel-img" alt="Ubicación" loading="lazy">
        <div class="carousel-caption carousel-caption-center">
          <div class="caption-content">
            <span class="badge-slide badge-slide-location">
              <i class="bi bi-geo-alt-fill"></i> Ubicación
            </span>
            <h2 class="display-3 fw-bold mb-3">
              Estamos en <span class="text-highlight">Coveñas</span>
            </h2>
            <p class="lead mb-4">Tu aliado local para abastecer tu negocio o evento</p>
            <div class="location-info">
              <div class="info-item">
                <i class="bi bi-telephone-fill"></i>
                <a href="tel:<?php echo $empresa['telefono']; ?>"><?php echo $empresa['telefono']; ?></a>
              </div>
              <div class="info-item">
                <i class="bi bi-clock-fill"></i>
                <span><?php echo $empresa['horario']; ?></span>
              </div>
            </div>
            <div class="caption-buttons">
              <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" class="btn btn-success btn-lg me-3" target="_blank">
                <i class="bi bi-whatsapp"></i> WhatsApp
              </a>
              <a href="nosotros.php" class="btn btn-outline-light btn-lg">
                <i class="bi bi-map-fill"></i> Cómo Llegar
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-icon">
        <i class="bi bi-chevron-left"></i>
      </span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-icon">
        <i class="bi bi-chevron-right"></i>
      </span>
      <span class="visually-hidden">Siguiente</span>
    </button>

    <!-- Barra de Progreso -->
    <div class="carousel-progress">
      <div class="carousel-progress-bar"></div>
    </div>

  </div>
  <!-- FIN CAROUSEL -->

  <!-- CATÁLOGO DE PRODUCTOS -->
  <section class="catalogo-section" id="main">
    <div class="container">
      <h1 class="titulo-catalogo">Catálogo de Productos</h1>

      <div class="row">
        <?php
        require 'vendor/autoload.php';
        $pelicula = new distribuidoraOsvaldo\Producto;
        $info_productos = $pelicula->mostrar();
        $cantidad = count($info_productos);

        if ($cantidad > 0) {
          for ($x = 0; $x < $cantidad; $x++) {
            $item = $info_productos[$x];
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
              <div class="producto-card">
                <div class="producto-header">
                  <h4><?php echo htmlspecialchars($item['titulo']); ?></h4>
                </div>
                <div class="producto-body">
                  <div class="producto-imagen">
                    <?php
                    $foto = 'upload/' . $item['foto'];
                    if (file_exists($foto)) {
                    ?>
                      <img src="<?php echo $foto; ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>" loading="lazy">
                    <?php } else { ?>
                      <img src="assets/imagenes/not-found.jpg" alt="Imagen no disponible" loading="lazy">
                    <?php } ?>
                  </div>
                  <div class="producto-precio">
                    $<?php echo number_format($item['precio'], 0, ',', '.'); ?>
                  </div>
                </div>
                <div class="producto-footer">
                  <a href="carrito.php?id=<?php echo $item['id']; ?>" class="btn btn-comprar">
                    <i class="bi bi-cart-plus-fill"></i> Agregar al Carrito
                  </a>
                </div>
              </div>
            </div>
          <?php
          }
        } else {
          ?>
          <div class="col-md-12">
            <div class="no-productos">
              <i class="bi bi-inbox"></i>
              <h4>No hay productos registrados</h4>
              <p>Pronto tendremos productos disponibles para ti</p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- WHATSAPP FLOTANTE -->
  <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" class="btn-whatsapp" target="_blank">
    <img src="whatsapp.png" alt="WhatsApp" height="60" width="60">
    <span class="whatsapp-tooltip">¿Necesitas ayuda?</span>
  </a>

  <!-- SCROLL TO TOP -->
  <div class="scroll-to-top" id="scrollToTop">
    <i class="bi bi-chevron-up"></i>
  </div>

  <!-- FOOTER -->
  <footer id="contacto">
    <div class="container">
      <!-- Beneficios -->
      <div class="row footer-benefits">
        <div class="col-xs-6 col-sm-3 icon-footer">
          <div class="icon-footer-image">
            <img src="envios.png" alt="Envíos" height="45">
          </div>
          <p><strong>Envíos Gratis</strong><br>Por $100.000 de compra</p>
        </div>
        <div class="col-xs-6 col-sm-3 icon-footer">
          <div class="icon-footer-image">
            <img src="devolucion.png" alt="Devoluciones" height="45">
          </div>
          <p><strong>Devoluciones Gratis</strong><br>Tienes 10 días</p>
        </div>
        <div class="col-xs-6 col-sm-3 icon-footer">
          <div class="icon-footer-image">
            <img src="atencion.png" alt="Atención" height="45">
          </div>
          <p><strong>Atención al Cliente</strong><br>7 días a la semana</p>
        </div>
        <div class="col-xs-6 col-sm-3 icon-footer">
          <div class="icon-footer-image">
            <img src="seguro.png" alt="Pago" height="45">
          </div>
          <p><strong>Pago Seguro</strong><br>100% confiable</p>
        </div>
      </div>

      <!-- Información adicional -->
      <div class="row footer-info">
        <div class="col-md-4 footer-section">
          <h4>Sobre Nosotros</h4>
          <p><?php echo $empresa['descripcion']; ?></p>

          <div class="footer-social">
            <h4>Síguenos</h4>
            <div class="social-links">
              <a href="<?php echo $empresa['facebook']; ?>" class="social-link facebook" target="_blank">
                <i class="bi bi-facebook"></i>
              </a>
              <a href="<?php echo $empresa['instagram']; ?>" class="social-link instagram" target="_blank">
                <i class="bi bi-instagram"></i>
              </a>
              <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" class="social-link whatsapp" target="_blank">
                <i class="bi bi-whatsapp"></i>
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
            <li><a href="#main">Productos</a></li>
          </ul>
        </div>

        <div class="col-md-4 footer-contact">
          <h4>Contacto</h4>
          <div class="footer-contact-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span><?php echo $empresa['direccion']; ?></span>
          </div>
          <div class="footer-contact-item">
            <i class="bi bi-telephone-fill"></i>
            <a href="tel:<?php echo $empresa['telefono']; ?>"><?php echo $empresa['telefono']; ?></a>
          </div>
          <div class="footer-contact-item">
            <i class="bi bi-envelope-fill"></i>
            <a href="mailto:<?php echo $empresa['email']; ?>"><?php echo $empresa['email']; ?></a>
          </div>
          <div class="footer-contact-item">
            <i class="bi bi-clock-fill"></i>
            <span><?php echo $empresa['horario']; ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <div class="container">
        <div class="footer-bottom-content">
          <p class="footer-copyright">
            &copy; <?php echo date('Y'); ?> <a href="index.php">Distribuidora Osvaldo</a>.
            Todos los derechos reservados.
          </p>
          <div class="footer-links">
            <a href="nosotros.php">Nosotros</a>
            <a href="index.php">Productos</a>
            <a href="carrito.php">Carrito</a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function() {
      // Efecto scroll navbar
      $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
          $('#mainNavbar').addClass('scrolled');
        } else {
          $('#mainNavbar').removeClass('scrolled');
        }

        // Barra de progreso
        const scrollTop = $(window).scrollTop();
        const docHeight = $(document).height();
        const winHeight = $(window).height();
        const scrollPercent = (scrollTop / (docHeight - winHeight)) * 100;
        $('#scrollProgress').css('width', scrollPercent + '%');

        // Botón scroll to top
        if ($(this).scrollTop() > 300) {
          $('#scrollToTop').addClass('visible');
        } else {
          $('#scrollToTop').removeClass('visible');
        }
      });

      // Scroll to top
      $('#scrollToTop').click(function() {
        $('html, body').animate({
          scrollTop: 0
        }, 600);
      });

      // Smooth scroll
      $('a[href^="#"]').on('click', function(e) {
        const target = $(this.attr('href'));
        if (target.length) {
          e.preventDefault();
          $('html, body').animate({
            scrollTop: target.offset().top - 80
          }, 800);
          $('.navbar-collapse').collapse('hide');
        }
      });

      // Animación productos al hacer scroll
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, {
        threshold: 0.1
      });

      document.querySelectorAll('.producto-card').forEach(card => {
        observer.observe(card);
      });
    });
  </script>

</body>

</html>