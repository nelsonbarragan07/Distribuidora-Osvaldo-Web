<?php
session_start();
require 'funciones.php';

// Datos de empresa con respaldo
$empresa = array(
    'nombre' => 'Distribuidora Osvaldo',
    'telefono' => '+57 312 810 3173',
    'email' => 'info@distribuidoraosvaldo.com',
    'facebook' => 'https://www.facebook.com/distribuidoraosvaldocovenas',
    'instagram' => 'https://instagram.com/distribuidora_osvaldo',
    'whatsapp' => '573128103173'
);

// Intentar obtener de BD
try {
    require_once('conexion.php');
    $sql = "SELECT * FROM empresa LIMIT 1";
    $res = @mysqli_query($con, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $reg = mysqli_fetch_assoc($res);
        foreach ($reg as $key => $value) {
            if (isset($empresa[$key]) && !empty($value)) {
                $empresa[$key] = $value;
            }
        }
    }
} catch (Exception $e) {}

// Generar número de pedido único
if (!isset($_SESSION['numero_pedido'])) {
    $_SESSION['numero_pedido'] = 'DO-' . date('Ymd') . '-' . rand(1000, 9999);
}

// Obtener datos del pedido (si existen)
$total_pedido = isset($_SESSION['total_pedido']) ? $_SESSION['total_pedido'] : 0;
$items_pedido = isset($_SESSION['items_pedido']) ? $_SESSION['items_pedido'] : 0;

// Detectar página actual
$current_page = basename($_SERVER['PHP_SELF']);
function isActive($page) {
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
    <meta name="description" content="¡Gracias por tu compra! - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>¡Gracias por tu Compra! - Distribuidora Osvaldo</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizados -->
    <link rel="stylesheet" href="assets/css/navbar-horizontal.css">
    <link rel="stylesheet" href="assets/css/gracias.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <style>
        body {
            padding-top: 80px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house-fill"></i>
                            INICIO
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="nosotros.php">
                            <i class="bi bi-info-circle-fill"></i>
                            NOSOTROS
                        </a>
                    </li>

                    <li class="nav-item">
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

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container" id="main">
        <div class="success-card">
            
            <!-- Icono de Éxito -->
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <!-- Título -->
            <h1 class="success-title">¡Pedido Confirmado!</h1>
            
            <!-- Subtítulo -->
            <p class="success-subtitle">
                Tu pedido ha sido recibido exitosamente
            </p>

            <!-- Mensaje -->
            <p class="success-message">
                Gracias por confiar en nosotros. Hemos recibido tu pedido y lo estamos procesando. 
                En breve nos pondremos en contacto contigo para coordinar la entrega.
            </p>

            <!-- Detalles del Pedido -->
            <div class="order-details">
                <h3>
                    <i class="bi bi-receipt"></i>
                    Detalles del Pedido
                    <span class="order-number"><?php echo $_SESSION['numero_pedido']; ?></span>
                </h3>

                <div class="detail-row">
                    <span class="detail-label">Número de Pedido:</span>
                    <span class="detail-value"><?php echo $_SESSION['numero_pedido']; ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Fecha:</span>
                    <span class="detail-value"><?php echo date('d/m/Y H:i'); ?></span>
                </div>

                <?php if ($items_pedido > 0): ?>
                <div class="detail-row">
                    <span class="detail-label">Productos:</span>
                    <span class="detail-value"><?php echo $items_pedido; ?> artículo(s)</span>
                </div>
                <?php endif; ?>

                <?php if ($total_pedido > 0): ?>
                <div class="detail-row">
                    <span class="detail-label">Total:</span>
                    <span class="detail-value" style="color: #27ae60; font-size: 1.3rem;">
                        $<?php echo number_format($total_pedido, 0, ',', '.'); ?>
                    </span>
                </div>
                <?php endif; ?>

                <div class="detail-row">
                    <span class="detail-label">Estado:</span>
                    <span class="detail-value" style="color: #f39c12;">
                        <i class="bi bi-clock-fill"></i> En proceso
                    </span>
                </div>
            </div>

            <!-- Próximos Pasos -->
            <div class="next-steps">
                <h4>
                    <i class="bi bi-list-check"></i>
                    ¿Qué sigue?
                </h4>
                <ul>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Recibirás un mensaje de confirmación por WhatsApp</span>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Nuestro equipo preparará tu pedido</span>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Te contactaremos para coordinar la entrega</span>
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Recibirás tu pedido en la fecha acordada</span>
                    </li>
                </ul>
            </div>

            <!-- Badges de Información -->
            <div class="info-badges">
                <div class="info-badge">
                    <i class="bi bi-truck"></i>
                    <p>Envío Rápido</p>
                </div>
                <div class="info-badge">
                    <i class="bi bi-shield-check"></i>
                    <p>Compra Segura</p>
                </div>
                <div class="info-badge">
                    <i class="bi bi-headset"></i>
                    <p>Soporte 24/7</p>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="action-buttons">
                <a href="index.php" class="btn-primary-custom">
                    <i class="bi bi-shop"></i>
                    Seguir Comprando
                </a>
                <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>?text=Hola, tengo una consulta sobre mi pedido <?php echo $_SESSION['numero_pedido']; ?>" 
                   class="btn-secondary-custom" 
                   target="_blank">
                    <i class="bi bi-whatsapp"></i>
                    Contactar por WhatsApp
                </a>
            </div>

            <!-- Redes Sociales -->
            <div class="social-share">
                <p>Síguenos en nuestras redes sociales</p>
                <div class="social-links">
                    <a href="<?php echo $empresa['facebook']; ?>" class="social-link facebook" target="_blank" rel="noopener">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="<?php echo $empresa['instagram']; ?>" class="social-link instagram" target="_blank" rel="noopener">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://wa.me/<?php echo $empresa['whatsapp']; ?>" class="social-link whatsapp" target="_blank" rel="noopener">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer style="margin-top: 80px;">
        <div class="container">
            <div class="row footer-benefits">
                <div class="col-xs-6 col-sm-3 icon-footer">
                    <div class="icon-footer-image">
                        <img src="envios.png" alt="Envíos" height="45">
                    </div>
                    <p><strong>Envíos Gratis</strong><br>Por $100.000</p>
                </div>
                <div class="col-xs-6 col-sm-3 icon-footer">
                    <div class="icon-footer-image">
                        <img src="devolucion.png" alt="Devoluciones" height="45">
                    </div>
                    <p><strong>Devoluciones</strong><br>10 días</p>
                </div>
                <div class="col-xs-6 col-sm-3 icon-footer">
                    <div class="icon-footer-image">
                        <img src="atencion.png" alt="Atención" height="45">
                    </div>
                    <p><strong>Atención</strong><br>7 días</p>
                </div>
                <div class="col-xs-6 col-sm-3 icon-footer">
                    <div class="icon-footer-image">
                        <img src="seguro.png" alt="Pago" height="45">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        // Navbar scroll
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('#mainNavbar').addClass('scrolled');
            } else {
                $('#mainNavbar').removeClass('scrolled');
            }
            
            const scrollTop = $(window).scrollTop();
            const docHeight = $(document).height();
            const winHeight = $(window).height();
            const scrollPercent = (scrollTop / (docHeight - winHeight)) * 100;
            $('#scrollProgress').css('width', scrollPercent + '%');
        });

        // Efecto confetti
        function createConfetti() {
            const confetti = $('<div class="confetti"></div>');
            confetti.css({
                left: Math.random() * 100 + '%',
                animationDuration: (Math.random() * 2 + 2) + 's',
                animationDelay: Math.random() * 2 + 's'
            });
            $('body').append(confetti);
            
            setTimeout(() => confetti.remove(), 5000);
        }

        // Crear 20 confettis
        for (let i = 0; i < 20; i++) {
            setTimeout(() => createConfetti(), i * 200);
        }

        // Limpiar sesión del carrito después de 3 segundos
        setTimeout(function() {
            // Aquí podrías hacer una llamada AJAX para limpiar el carrito
            console.log('Pedido completado');
        }, 3000);
    });
    </script>

</body>
</html>
<?php
// Limpiar variables de sesión del proceso de compra
unset($_SESSION['carrito']);
unset($_SESSION['total_pedido']);
unset($_SESSION['items_pedido']);
?>