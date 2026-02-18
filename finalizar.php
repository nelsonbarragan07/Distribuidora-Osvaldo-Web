<?php
session_start();
require 'funciones.php';

// Redirigir si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit;
}

// Datos de empresa con respaldo
$empresa = array(
    'nombre' => 'Distribuidora Osvaldo',
    'telefono' => '+57 312 810 3173',
    'email' => 'info@distribuidoraosvaldo.com',
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
} catch (Exception $e) {
}

// Detectar página actual
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
    <meta name="description" content="Finalizar compra - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Finalizar Compra - Distribuidora Osvaldo</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizados -->
    <link rel="stylesheet" href="assets/css/navbar-horizontal.css">
    <link rel="stylesheet" href="assets/css/finalizar.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <style>
        body {
            padding-top: 80px;
            background: #f8f9fa;
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

        <!-- HEADER -->
        <div class="finalizar-header">
            <h1>
                <i class="bi bi-check-circle-fill"></i>
                Finalizar tu Compra
            </h1>
            <p>Completa tus datos para procesar tu pedido</p>
        </div>

        <!-- PASOS DEL PROCESO -->
        <div class="checkout-steps">
            <div class="step completed">
                <div class="step-number">1</div>
                <span>Carrito</span>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <span>Datos de Envío</span>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <span>Confirmación</span>
            </div>
        </div>

        <!-- LAYOUT PRINCIPAL -->
        <div class="checkout-layout">

            <!-- FORMULARIO -->
            <div class="form-section">
                <h3>
                    <i class="bi bi-person-fill"></i>
                    Información de Contacto
                </h3>

                <form action="completar_pedido.php" method="POST" id="checkoutForm">

                    <!-- Campo oculto para teléfono sin formato -->
                    <input type="hidden" name="telefono" id="telefono_hidden">

                    <!-- Nombre y Apellidos -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre <span class="required">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    name="nombre"
                                    id="nombre"
                                    placeholder="Ej: Juan"
                                    required>
                                <div class="error-message">Por favor ingresa tu nombre</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellidos <span class="required">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    name="apellidos"
                                    id="apellidos"
                                    placeholder="Ej: Pérez"
                                    required>
                                <div class="error-message">Por favor ingresa tus apellidos</div>
                            </div>
                        </div>
                    </div>

                    <!-- Email y Teléfono -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo Electrónico <span class="required">*</span></label>
                                <input type="email"
                                    class="form-control"
                                    name="email"
                                    id="email"
                                    placeholder="ejemplo@email.com"
                                    required>
                                <div class="error-message">Por favor ingresa un email válido</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono / WhatsApp <span class="required">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    id="telefono_display"
                                    placeholder="312 345 6789"
                                    required
                                    maxlength="12">
                                <div class="error-message">Por favor ingresa un teléfono válido (10 dígitos)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="form-group">
                        <label>Dirección de Entrega <span class="required">*</span></label>
                        <input type="text"
                            class="form-control"
                            name="direccion"
                            id="direccion"
                            placeholder="Calle, Número, Barrio"
                            required>
                        <div class="error-message">Por favor ingresa tu dirección</div>
                    </div>

                    <!-- Ciudad y Código Postal -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Ciudad</label>
                                <input type="text"
                                    class="form-control"
                                    name="ciudad"
                                    id="ciudad"
                                    placeholder="Coveñas"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Código Postal</label>
                                <input type="text"
                                    class="form-control"
                                    name="codigo_postal"
                                    placeholder="700001"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <div class="form-group">
                        <label>Método de Pago <span class="required">*</span></label>
                        <div class="payment-methods">
                            <div class="payment-method selected">
                                <input type="radio" name="metodo_pago" value="efectivo" id="efectivo" checked>
                                <label for="efectivo">
                                    <i class="bi bi-cash-coin"></i>
                                    <div>Efectivo</div>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="metodo_pago" value="transferencia" id="transferencia">
                                <label for="transferencia">
                                    <i class="bi bi-bank"></i>
                                    <div>Transferencia</div>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" name="metodo_pago" value="nequi" id="nequi">
                                <label for="nequi">
                                    <i class="bi bi-phone-fill"></i>
                                    <div>Nequi</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Comentarios -->
                    <div class="form-group">
                        <label>Comentarios Adicionales (Opcional)</label>
                        <textarea name="comentario"
                            class="form-control"
                            rows="4"
                            placeholder="Instrucciones de entrega, referencias, etc."></textarea>
                    </div>

                    <!-- Botones -->
                    <div style="margin-top: 30px;">
                        <a href="carrito.php" class="btn-volver">
                            <i class="bi bi-arrow-left"></i>
                            Volver al Carrito
                        </a>
                        <button type="submit" class="btn-finalizar">
                            <i class="bi bi-check-lg"></i>
                            Confirmar Pedido
                        </button>
                    </div>

                    <!-- Indicadores de Seguridad -->
                    <div class="security-badges">
                        <div class="security-badge">
                            <i class="bi bi-shield-check"></i>
                            <span>Compra Segura</span>
                        </div>
                        <div class="security-badge">
                            <i class="bi bi-truck"></i>
                            <span>Envío Rápido</span>
                        </div>
                        <div class="security-badge">
                            <i class="bi bi-headset"></i>
                            <span>Soporte 24/7</span>
                        </div>
                    </div>
                </form>
            </div>

            <!-- RESUMEN DEL PEDIDO -->
            <div class="order-summary">
                <h3>
                    <i class="bi bi-bag-check-fill"></i>
                    Resumen del Pedido
                </h3>

                <?php
                foreach ($_SESSION['carrito'] as $id => $producto):
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                ?>
                    <div class="summary-item">
                        <div class="item-details">
                            <div class="item-name"><?php echo htmlspecialchars($producto['titulo']); ?></div>
                            <div class="item-quantity">Cantidad: <?php echo $producto['cantidad']; ?></div>
                        </div>
                        <div class="item-price">
                            $<?php echo number_format($subtotal, 0, ',', '.'); ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="summary-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format(calcularTotal(), 0, ',', '.'); ?></span>
                    </div>
                    <div class="total-row">
                        <span>Envío:</span>
                        <span class="text-success">GRATIS</span>
                    </div>
                    <div class="total-row final">
                        <span class="total-label">Total:</span>
                        <span class="total-value">$<?php echo number_format(calcularTotal(), 0, ',', '.'); ?></span>
                    </div>
                </div>

                <div style="margin-top: 20px; padding: 15px; background: #f0fdf4; border-radius: 10px; text-align: center;">
                    <i class="bi bi-truck" style="font-size: 2rem; color: #27ae60;"></i>
                    <div style="margin-top: 10px; font-weight: 600; color: #2c3e50;">
                        Envío Gratis
                    </div>
                    <div style="font-size: 0.9rem; color: #7f8c8d;">
                        En compras superiores a $100.000
                    </div>
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

            // Métodos de pago
            $('.payment-method').click(function() {
                $('.payment-method').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true);
            });

            // FORMATEO DE TELÉFONO (CORREGIDO
            $('#telefono_display').on('input', function() {
                // Remover todo excepto números
                let value = $(this).val().replace(/\D/g, '');

                // Limitar a 10 dígitos
                if (value.length > 10) {
                    value = value.substring(0, 10);
                }

                // Formatear con espacios
                let formatted = value;
                if (value.length >= 6) {
                    formatted = value.substring(0, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6);
                } else if (value.length >= 3) {
                    formatted = value.substring(0, 3) + ' ' + value.substring(3);
                }

                // Mostrar en el campo
                $(this).val(formatted);

                // Guardar sin formato en campo oculto
                $('#telefono_hidden').val(value);
            });

            // Validación del formulario
            $('#checkoutForm').submit(function(e) {
                e.preventDefault(); // Prevenir envío por defecto

                let valid = true;

                // Limpiar errores previos
                $('.form-control').removeClass('error success');

                // Validar nombre
                if ($('#nombre').val().trim() === '') {
                    $('#nombre').addClass('error');
                    valid = false;
                } else {
                    $('#nombre').addClass('success');
                }

                // Validar apellidos
                if ($('#apellidos').val().trim() === '') {
                    $('#apellidos').addClass('error');
                    valid = false;
                } else {
                    $('#apellidos').addClass('success');
                }

                // Validar email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test($('#email').val())) {
                    $('#email').addClass('error');
                    valid = false;
                } else {
                    $('#email').addClass('success');
                }

                // Validar teléfono (del campo oculto sin formato)
                const telefono = $('#telefono_hidden').val();
                if (telefono.length !== 10) {
                    $('#telefono_display').addClass('error');
                    valid = false;
                } else {
                    $('#telefono_display').addClass('success');
                }

                // Validar dirección
                if ($('#direccion').val().trim() === '') {
                    $('#direccion').addClass('error');
                    valid = false;
                } else {
                    $('#direccion').addClass('success');
                }

                if (!valid) {
                    // Scroll al primer error
                    $('html, body').animate({
                        scrollTop: $('.form-control.error').first().offset().top - 100
                    }, 500);
                } else {
                    // Todo válido, enviar formulario
                    $('.btn-finalizar').addClass('loading');
                    this.submit(); // Enviar el formulario
                }
            });

            // Validación en tiempo real
            $('.form-control').on('blur', function() {
                const $this = $(this);
                const value = $this.val().trim();

                if ($this.attr('id') === 'telefono_display') {
                    // Validación especial para teléfono
                    const telefono = $('#telefono_hidden').val();
                    if (telefono.length === 10) {
                        $this.removeClass('error').addClass('success');
                    } else if (value !== '') {
                        $this.removeClass('success').addClass('error');
                    }
                } else if (value !== '') {
                    if ($this.attr('type') === 'email') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (emailRegex.test(value)) {
                            $this.removeClass('error').addClass('success');
                        } else {
                            $this.removeClass('success').addClass('error');
                        }
                    } else {
                        $this.removeClass('error').addClass('success');
                    }
                }
            });
        });
    </script>

</body>

</html>