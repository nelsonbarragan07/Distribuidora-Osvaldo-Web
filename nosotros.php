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
    <meta name="description" content="Conoce más sobre Distribuidora Osvaldo, tu aliado en Coveñas para la distribución de bebidas de calidad">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Nosotros - Distribuidora Osvaldo</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/nosotros.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/whatsapp.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand alinear" href="index.php">
                    <h2>Distribuidora Osvaldo</h2>
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a class="btn" href="carrito.php">
                            <img class="icono" src="carrito1.png" alt="Carrito" height="60">
                            CARRITO
                            <span class="badge"><?php print cantidadProducto(); ?></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <li class="active">
                        <a class="btn" href="nosotros.php">
                            <img class="icono" src="nosotros.png" alt="Nosotros" height="60">
                            ACERCA DE NOSOTROS
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- SLIDER PROFESIONAL -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-overlay"></div>
                <img src="slider1.jpg" class="d-block w-100 carousel-img" alt="Distribuidora Osvaldo">
                <div class="carousel-caption carousel-caption-center">
                    <div class="caption-content">
                        <span class="badge-slide">Sobre Nosotros</span>
                        <h1 class="display-2 fw-bold mb-3">
                            Conoce Nuestra <span class="text-highlight">Historia</span>
                        </h1>
                        <p class="lead mb-4">
                            Más de 10 años sirviendo a Coveñas y sus alrededores
                        </p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="covenas.jfif" class="d-block w-100 carousel-img" alt="Ubicación Coveñas">
                <div class="carousel-caption carousel-caption-center">
                    <div class="caption-content">
                        <span class="badge-slide badge-slide-location">
                            <i class="glyphicon glyphicon-map-marker"></i> Ubicación
                        </span>
                        <h2 class="display-3 fw-bold mb-3">
                            Estamos en <span class="text-highlight">Coveñas</span>
                        </h2>
                        <p class="lead mb-4">
                            Tu distribuidora de confianza local
                        </p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="carousel-overlay"></div>
                <img src="produc.jpg" class="d-block w-100 carousel-img" alt="Calidad">
                <div class="carousel-caption carousel-caption-center">
                    <div class="caption-content">
                        <span class="badge-slide badge-slide-quality">Calidad</span>
                        <h2 class="display-3 fw-bold mb-3">
                            Compromiso con la <span class="text-highlight">Excelencia</span>
                        </h2>
                        <p class="lead mb-4">
                            Los mejores productos al mejor precio
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-icon">
                <i class="glyphicon glyphicon-chevron-left"></i>
            </span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-icon">
                <i class="glyphicon glyphicon-chevron-right"></i>
            </span>
        </button>

        <div class="carousel-progress">
            <div class="carousel-progress-bar"></div>
        </div>
    </div>

    <!-- HERO SECTION -->
    <section class="nosotros-hero">
        <div class="container">
            <nav class="breadcrumb-custom">
                <a href="index.php">Inicio</a> / <span>Nosotros</span>
            </nav>
            <?php
            require_once('conexion.php');
            $sql = "SELECT * FROM empresa";
            $res = mysqli_query($con, $sql);
            
            if($reg = mysqli_fetch_assoc($res)){
                echo '<h1>Bienvenidos a '.$reg['nombre'].'</h1>';
                echo '<p class="lead">'.$reg['descripcion'].'</p>';
            }
            ?>
        </div>
    </section>

    <!-- ESTADÍSTICAS -->
    <section class="estadisticas-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Años de Experiencia</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Productos</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Clientes Felices</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
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
                <div class="col-md-6">
                    <div class="mision-vision-card">
                        <div class="icon">
                            <i class="glyphicon glyphicon-flag"></i>
                        </div>
                        <h2>Nuestra Misión</h2>
                        <h5>Proveer a nuestros clientes productos de alta calidad y garantizar un excelente servicio, siendo su aliado confiable para el abastecimiento de bebidas y productos en la región de Coveñas.</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mision-vision-card">
                        <div class="icon">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </div>
                        <h2>Nuestra Visión</h2>
                        <h5>Convertirnos en líderes del mercado en la distribución de productos y ser reconocidos por nuestra calidad, confiabilidad y excelente servicio al cliente en toda la región.</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VALORES -->
    <section class="valores-section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Valores</h2>
                <p>Los principios que nos guían cada día</p>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="glyphicon glyphicon-ok-sign"></i>
                        </div>
                        <h4>Calidad</h4>
                        <p>Ofrecemos solo productos de las mejores marcas y en perfecto estado</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="glyphicon glyphicon-heart"></i>
                        </div>
                        <h4>Compromiso</h4>
                        <p>Dedicación total con nuestros clientes y su satisfacción</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="glyphicon glyphicon-time"></i>
                        </div>
                        <h4>Puntualidad</h4>
                        <p>Entregas a tiempo, siempre cumplimos con nuestros plazos</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="glyphicon glyphicon-user"></i>
                        </div>
                        <h4>Confianza</h4>
                        <p>Construimos relaciones duraderas basadas en la confianza</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="glyphicon glyphicon-thumbs-up"></i>
                        </div>
                        <h4>Honestidad</h4>
                        <p>Transparencia en todos nuestros procesos y precios justos</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="valor-item">
                        <div class="valor-icon">
                            <i class="glyphicon glyphicon-star"></i>
                        </div>
                        <h4>Excelencia</h4>
                        <p>Buscamos la mejora continua en todos nuestros servicios</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INFORMACIÓN DE CONTACTO -->
    <section class="info-contacto">
        <div class="container">
            <div class="section-title" style="margin-bottom: 60px;">
                <h2 style="color: white;">Contáctanos</h2>
                <p style="color: rgba(255,255,255,0.8);">Estamos aquí para atenderte</p>
            </div>
            <div class="row">
                <?php
                require_once('conexion.php');
                $sql = "SELECT * FROM empresa";
                $res = mysqli_query($con, $sql);
                
                if($reg = mysqli_fetch_assoc($res)){
                ?>
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="icon">
                            <i class="glyphicon glyphicon-phone"></i>
                        </div>
                        <h3>Teléfono</h3>
                        <p><a href="tel:<?php echo $reg['telefono']; ?>"><?php echo $reg['telefono']; ?></a></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="icon">
                            <i class="glyphicon glyphicon-map-marker"></i>
                        </div>
                        <h3>Dirección</h3>
                        <p><?php echo $reg['direccion']; ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <div class="icon">
                            <i class="glyphicon glyphicon-time"></i>
                        </div>
                        <h3>Horario</h3>
                        <p>Lunes - Sábado<br>8:00 AM - 8:00 PM</p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- GALERÍA MULTIMEDIA -->
    <section class="multimedia-section">
        <div class="container">
            <div class="section-title">
                <h2>Conoce Más</h2>
                <p>Explora nuestra galería multimedia</p>
            </div>
            <div class="row">
                <!-- Card 1: Video -->
                <div class="col-md-4">
                    <div class="card-multimedia">
                        <figure>
                            <video src="video1.mp4" controls></video>
                        </figure>
                        <div class="contenido-card">
                            <?php
                            require_once('conexion.php');
                            $sql = "SELECT * FROM empresa";
                            $res = mysqli_query($con, $sql);
                            
                            if($reg = mysqli_fetch_assoc($res)){
                            ?>
                            <h3>Visítanos</h3>
                            <h4><i class="glyphicon glyphicon-phone"></i> <?php echo $reg['telefono']; ?></h4>
                            <p><i class="glyphicon glyphicon-map-marker"></i> Estamos ubicados en: <?php echo $reg['direccion']; ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Servicio -->
                <div class="col-md-4">
                    <div class="card-multimedia">
                        <figure>
                            <img src="mejor.jfif" alt="Servicio al cliente">
                        </figure>
                        <div class="contenido-card">
                            <h3>Excelente Servicio</h3>
                            <p>Siempre al servicio de nuestros clientes. En Distribuidora Osvaldo nos enfocamos en brindarte la mejor atención y los mejores productos.</p>
                            <a href="index.php" class="btn btn-primary">Ver Productos</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Redes Sociales -->
                <div class="col-md-4">
                    <div class="card-multimedia">
                        <figure>
                            <img src="contac.jfif" alt="Redes sociales">
                        </figure>
                        <div class="contenido-card">
                            <h3>Síguenos en Redes</h3>
                            <p>Mantente al día con nuestras ofertas, promociones y novedades siguiéndonos en nuestras redes sociales.</p>
                            <div class="social-buttons">
                                <a href="https://www.facebook.com/distribuidoraosvaldocovenas" target="_blank" class="btn btn-facebook">
                                    <i class="glyphicon glyphicon-thumbs-up"></i> Facebook
                                </a>
                                <a href="https://instagram.com/distribuidora_osvaldo" target="_blank" class="btn btn-instagram">
                                    <i class="glyphicon glyphicon-camera"></i> Instagram
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BOTÓN WHATSAPP -->
    <a href="https://wa.me/573128103173" class="btn-whatsapp" target="_blank">
        <img src="whatsapp.png" alt="WhatsApp" height="60">
        <span class="whatsapp-tooltip">¿Necesitas ayuda?</span>
    </a>

    <!-- FOOTER -->
    <footer>
        <div class="container">
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
                        <img src="seguro.png" alt="Pago seguro" height="45">
                    </div>
                    <p><strong>Pago Seguro</strong><br>100% confiable</p>
                </div>
            </div>
        </div>

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
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/slider.js"></script>

</body>
</html>