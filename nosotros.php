<?php
session_start();
require 'funciones.php';

// ===================================
// DATOS DE RESPALDO (Fallback)
// ===================================
$empresa = array(
    'nombre' => 'Distribuidora Osvaldo',
    'descripcion' => 'Somos una empresa dedicada a la distribución de bebidas de calidad en Coveñas y sus alrededores. Más de 10 años sirviendo a nuestros clientes con los mejores productos y el mejor servicio.',
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
    <meta name="description" content="Conoce más sobre Distribuidora Osvaldo, tu aliado en Coveñas para la distribución de bebidas de calidad">
    <meta name="author" content="Distribuidora Osvaldo">
    <meta name="keywords" content="distribuidora, bebidas, coveñas, osvaldo, licores, refrescos">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Nosotros - Distribuidora Osvaldo">
    <meta property="og:description" content="Conoce nuestra historia y compromiso con Coveñas">
    <meta property="og:image" content="logoOsvaldo.jpg">

    <title>Nosotros - Distribuidora Osvaldo | Coveñas</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizados -->
    <link rel="stylesheet" href="assets/css/navbar-horizontal.css">
    <link rel="stylesheet" href="assets/css/nosotros.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/whatsapp.css">

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
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1: Historia -->
            <div class="carousel-item active">
                <div class="carousel-overlay"></div>
                <img src="slider1.jpg" class="d-block w-100 carousel-img" alt="Historia" loading="eager">
                <div class="carousel-caption carousel-caption-center">
                    <div class="caption-content">
                        <span class="badge-slide">Sobre Nosotros</span>
                        <h1 class="display-2 fw-bold mb-3">
                            Conoce Nuestra <span class="text-highlight">Historia</span>
                        </h1>
                        <p class="lead mb-4">Más de 10 años sirviendo a Coveñas</p>
                        <a href="#historia" class="btn btn-primary btn-lg">
                            <i class="bi bi-info-circle"></i> Saber Más
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Ubicación -->
            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="covenas.jfif" class="d-block w-100 carousel-img" alt="Coveñas" loading="lazy">
                <div class="carousel-caption carousel-caption-center">
                    <div class="caption-content">
                        <span class="badge-slide badge-slide-location">
                            <i class="bi bi-geo-alt-fill"></i> Ubicación
                        </span>
                        <h2 class="display-3 fw-bold mb-3">
                            Estamos en <span class="text-highlight">Coveñas</span>
                        </h2>
                        <p class="lead mb-4"><?php echo $empresa['direccion']; ?></p>
                        <a href="#contacto" class="btn btn-success btn-lg">
                            <i class="bi bi-telephone-fill"></i> Contáctanos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Calidad -->
            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="produc.jpg" class="d-block w-100 carousel-img" alt="Calidad" loading="lazy">
                <div class="carousel-caption carousel-caption-center">
                    <div class="caption-content">
                        <span class="badge-slide badge-slide-quality">Calidad Premium</span>
                        <h2 class="display-3 fw-bold mb-3">
                            Compromiso con la <span class="text-highlight">Excelencia</span>
                        </h2>
                        <p class="lead mb-4">Solo los mejores productos</p>
                        <a href="#valores" class="btn btn-warning btn-lg">
                            <i class="bi bi-star-fill"></i> Nuestros Valores
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-icon">
                <i class="bi bi-chevron-left"></i>
            </span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-icon">
                <i class="bi bi-chevron-right"></i>
            </span>
        </button>

        <div class="carousel-progress">
            <div class="carousel-progress-bar"></div>
        </div>
    </div>
    <!-- FIN CAROUSEL -->

    <!-- HERO SECTION -->
    <section class="nosotros-hero" id="historia">
        <div class="container">
            <nav class="breadcrumb-custom">
                <a href="index.php">Inicio</a> / <span>Nosotros</span>
            </nav>
            <h1>Bienvenidos a <?php echo $empresa['nombre']; ?></h1>
            <p class="lead"><?php echo $empresa['descripcion']; ?></p>
        </div>
    </section>

    <!-- ESTADÍSTICAS ANIMADAS -->
    <section class="estadisticas-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-6 mb-3">
                    <div class="stat-item">
                        <div class="stat-number" data-count="10">0+</div>
                        <div class="stat-label">Años de Experiencia</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3">
                    <div class="stat-item">
                        <div class="stat-number" data-count="500">0+</div>
                        <div class="stat-label">Productos</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3">
                    <div class="stat-item">
                        <div class="stat-number" data-count="1000">0+</div>
                        <div class="stat-label">Clientes Felices</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Satisfacción</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MISIÓN Y VISIÓN -->
    <section class="mision-vision">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="mision-vision-card">
                        <div class="icon">
                            <i class="bi bi-flag-fill"></i>
                        </div>
                        <h2>Nuestra Misión</h2>
                        <p>Proveer a nuestros clientes productos de alta calidad y garantizar un excelente servicio, siendo su aliado confiable para el abastecimiento de bebidas y productos en la región de Coveñas.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="mision-vision-card">
                        <div class="icon">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <h2>Nuestra Visión</h2>
                        <p>Convertirnos en líderes del mercado en la distribución de productos y ser reconocidos por nuestra calidad, confiabilidad y excelente servicio al cliente en toda la región.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VALORES -->
    <section class="valores-section" id="valores">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Valores</h2>
                <p>Los principios que nos guían cada día</p>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h4>Calidad</h4>
                        <p>Ofrecemos solo productos de las mejores marcas y en perfecto estado</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4>Compromiso</h4>
                        <p>Dedicación total con nuestros clientes y su satisfacción</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <h4>Puntualidad</h4>
                        <p>Entregas a tiempo, siempre cumplimos con nuestros plazos</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="bi bi-person-fill-check"></i>
                        </div>
                        <h4>Confianza</h4>
                        <p>Construimos relaciones duraderas basadas en la confianza</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                        </div>
                        <h4>Honestidad</h4>
                        <p>Transparencia en todos nuestros procesos y precios justos</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4>Excelencia</h4>
                        <p>Buscamos la mejora continua en todos nuestros servicios</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section class="info-contacto" id="contacto">
        <div class="container">
            <div class="section-title" style="margin-bottom: 60px;">
                <h2 style="color: white;">Contáctanos</h2>
                <p style="color: rgba(255,255,255,0.8);">Estamos aquí para atenderte</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="info-box">
                        <div class="icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h3>Teléfono</h3>
                        <p><a href="tel:<?php echo $empresa['telefono']; ?>"><?php echo $empresa['telefono']; ?></a></p>
                        <a href="tel:<?php echo $empresa['telefono']; ?>" class="btn btn-outline-light btn-sm mt-2">
                            <i class="bi bi-phone"></i> Llamar Ahora
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="info-box">
                        <div class="icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h3>Dirección</h3>
                        <p><?php echo $empresa['direccion']; ?></p>
                        <a href="https://maps.google.com/?q=<?php echo urlencode($empresa['direccion']); ?>" target="_blank" class="btn btn-outline-light btn-sm mt-2">
                            <i class="bi bi-map"></i> Ver en Mapa
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="info-box">
                        <div class="icon">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <h3>Horario</h3>
                        <p><?php echo $empresa['horario']; ?></p>
                        <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" target="_blank" class="btn btn-success btn-sm mt-2">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GALERÍA -->
    <section class="multimedia-section">
        <div class="container">
            <div class="section-title">
                <h2>Conoce Más</h2>
                <p>Explora nuestra galería</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card-multimedia">
                        <figure>
                            <video src="video1.mp4" controls preload="metadata" poster="slider1.jpg"></video>
                        </figure>
                        <div class="contenido-card">
                            <h3>Visítanos</h3>
                            <p><i class="bi bi-telephone"></i> <?php echo $empresa['telefono']; ?></p>
                            <p><i class="bi bi-geo-alt"></i> <?php echo $empresa['direccion']; ?></p>
                            <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" target="_blank" class="btn btn-success">
                                <i class="bi bi-whatsapp"></i> Contactar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card-multimedia">
                        <figure>
                            <img src="mejor.jfif" alt="Servicio" loading="lazy">
                        </figure>
                        <div class="contenido-card">
                            <h3>Excelente Servicio</h3>
                            <p>Siempre al servicio de nuestros clientes con la mejor atención y productos.</p>
                            <a href="index.php" class="btn btn-primary">
                                <i class="bi bi-cart"></i> Ver Productos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card-multimedia">
                        <figure>
                            <img src="contac.jfif" alt="Redes" loading="lazy">
                        </figure>
                        <div class="contenido-card">
                            <h3>Síguenos</h3>
                            <p>Mantente al día con ofertas y promociones exclusivas.</p>
                            <div class="social-buttons">
                                <a href="<?php echo $empresa['facebook']; ?>" target="_blank" class="btn btn-facebook">
                                    <i class="bi bi-facebook"></i> Facebook
                                </a>
                                <a href="<?php echo $empresa['instagram']; ?>" target="_blank" class="btn btn-instagram">
                                    <i class="bi bi-instagram"></i> Instagram
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section" style="padding: 60px 0; background: linear-gradient(135deg, #3498db, #2ecc71); text-align: center; color: white;">
        <div class="container">
            <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 20px;">¿Listo para hacer tu pedido?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 30px;">Contáctanos ahora</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" target="_blank" class="btn btn-success btn-lg">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>
                <a href="tel:<?php echo $empresa['telefono']; ?>" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-telephone"></i> Llamar
                </a>
                <a href="index.php" class="btn btn-warning btn-lg">
                    <i class="bi bi-cart"></i> Ver Productos
                </a>
            </div>
        </div>
    </section>

    <!-- BOTÓN WHATSAPP -->
    <div class="orden">
        <a href="https://wa.me/573128103173" class="btn-whatsapp" target="_blank">
            <img src="whatsapp.png" alt="Contactar por WhatsApp" height="60">
            <span class="whatsapp-tooltip">¿Necesitas ayuda?</span>
        </a>
    </div>
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
                    <p><strong>Devoluciones Gratis</strong><br>Tienes 90 días</p>
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
            });

            // Animación de contadores
            function animateCounters() {
                $('.stat-number[data-count]').each(function() {
                    const $this = $(this);
                    const count = parseInt($this.attr('data-count'));
                    const suffix = $this.text().replace(/[0-9]/g, '');

                    $({
                        Counter: 0
                    }).animate({
                        Counter: count
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.ceil(this.Counter) + suffix);
                        }
                    });
                });
            }

            // Activar al hacer scroll
            let counterAnimated = false;
            $(window).scroll(function() {
                const estadisticas = $('.estadisticas-section');
                if (estadisticas.length && !counterAnimated) {
                    const scrollTop = $(window).scrollTop();
                    const elemTop = estadisticas.offset().top;
                    const windowHeight = $(window).height();

                    if (scrollTop + windowHeight > elemTop + 100) {
                        counterAnimated = true;
                        animateCounters();
                    }
                }
            });

            // Scroll to top
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#scrollToTop').addClass('visible');
                } else {
                    $('#scrollToTop').removeClass('visible');
                }
            });

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
        });
    </script>

</body>

</html>