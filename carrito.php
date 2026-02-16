<?php
//activar sessiones
session_start();
require 'funciones.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    require 'vendor/autoload.php';

    $producto = new distribuidoraOsvaldo\Producto;
    $resultado = $producto->mostrarPorId($id);

    if (!$resultado)
        header('Location: index.php');

    if (isset($_SESSION['carrito'])) {
        if (array_key_exists($id, $_SESSION['carrito'])) {
            actualizarProducto($id);
        } else {
            agregarProducto($resultado, $id);
        }
    } else {
        agregarProducto($resultado, $id);
    }
}

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
    <meta name="description" content="Carrito de compras - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Carrito de Compras - Distribuidora Osvaldo</title>
    <link rel="icon" href="logoOsvaldo.jpg">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizados -->
    <link rel="stylesheet" href="assets/css/navbar-horizontal.css">
    <link rel="stylesheet" href="assets/css/carrito.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/whatsapp.css">

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

                    <li class="nav-item whatsapp-link">
                        <a class="nav-link text-success" href="https://wa.me/573128103173" target="_blank">
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

        <!-- HEADER DEL CARRITO -->
        <div class="carrito-header">
            <h1>
                <i class="bi bi-cart-check-fill"></i>
                Tu Carrito de Compras
                <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
                    <span class="contador-productos">
                        <i class="bi bi-bag-fill"></i>
                        <?php echo count($_SESSION['carrito']); ?> producto(s)
                    </span>
                <?php endif; ?>
            </h1>
            <p>Revisa los productos que has agregado y finaliza tu compra</p>
        </div>

        <?php if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>

            <!-- TABLA DE PRODUCTOS -->
            <div class="carrito-table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Producto</th>
                            <th style="width: 100px;">Foto</th>
                            <th style="width: 130px;">Precio Unit.</th>
                            <th style="width: 100px;">Cantidad</th>
                            <th style="width: 130px;">Total</th>
                            <th style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 0;
                        foreach ($_SESSION['carrito'] as $indice => $value):
                            $total = $value['precio'] * $value['cantidad'];
                            $c++;
                        ?>
                            <tr>
                                <td class="text-center"><strong><?php echo $c; ?></strong></td>

                                <td>
                                    <div class="producto-nombre"><?php echo htmlspecialchars($value['titulo']); ?></div>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $foto = 'upload/' . $value['foto'];
                                    if (file_exists($foto)):
                                    ?>
                                        <img src="<?php echo $foto; ?>" class="producto-img" alt="<?php echo htmlspecialchars($value['titulo']); ?>">
                                    <?php else: ?>
                                        <img src="assets/imagenes/not-found.jpg" class="producto-img" alt="No disponible">
                                    <?php endif; ?>
                                </td>

                                <td class="producto-precio">
                                    $<?php echo number_format($value['precio'], 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <form action="actualizar_carrito.php" method="post" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                                        <input type="number"
                                            name="cantidad"
                                            class="cantidad-input"
                                            value="<?php echo $value['cantidad']; ?>"
                                            min="1"
                                            max="99">
                                </td>

                                <td class="producto-total">
                                    $<?php echo number_format($total, 0, ',', '.'); ?>
                                </td>

                                <td>
                                    <button type="submit" class="btn-actualizar" title="Actualizar cantidad">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                    </form>

                                    <a href="eliminar_carrito.php?id=<?php echo $value['id']; ?>"
                                        class="btn-eliminar"
                                        title="Eliminar producto"
                                        onclick="return confirm('¿Estás seguro de eliminar este producto?');">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>TOTAL A PAGAR:</strong></td>
                            <td colspan="2" class="total-amount">
                                $<?php echo number_format(calcularTotal(), 0, ',', '.'); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- RESUMEN DEL PEDIDO -->
            <div class="row mt-4">
                <div class="col-md-4 offset-md-8">
                    <div class="resumen-pedido">
                        <h3><i class="bi bi-receipt"></i> Resumen del Pedido</h3>

                        <div class="resumen-item">
                            <span class="resumen-label">Subtotal:</span>
                            <span class="resumen-valor">$<?php echo number_format(calcularTotal(), 0, ',', '.'); ?></span>
                        </div>

                        <div class="resumen-item">
                            <span class="resumen-label">Envío:</span>
                            <span class="resumen-valor text-success">GRATIS</span>
                        </div>

                        <div class="resumen-item resumen-total">
                            <span class="resumen-label">Total:</span>
                            <span class="resumen-valor">$<?php echo number_format(calcularTotal(), 0, ',', '.'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES DE ACCIÓN -->
            <div class="carrito-acciones">
                <a href="index.php" class="btn-seguir-comprando">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                    Seguir Comprando
                </a>

                <a href="finalizar.php" class="btn-finalizar">
                    <i class="bi bi-check-circle-fill"></i>
                    Finalizar Compra
                </a>
            </div>

        <?php else: ?>

            <!-- CARRITO VACÍO -->
            <div class="carrito-vacio">
                <i class="bi bi-cart-x"></i>
                <h3>Tu carrito está vacío</h3>
                <p>¡Agrega productos para comenzar tu compra!</p>
                <a href="index.php" class="btn-seguir-comprando">
                    <i class="bi bi-shop"></i>
                    Ir a la Tienda
                </a>
            </div>

        <?php endif; ?>

    </div>

    <!-- BOTÓN WHATSAPP FLOTANTE -->
    <a href="https://wa.me/573128103173" class="btn-whatsapp" target="_blank" rel="noopener">
        <img src="whatsapp.png" alt="WhatsApp" height="60" width="60">
        <span class="whatsapp-tooltip">¿Listo para pedir?</span>
    </a>
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

    <!-- JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slider.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


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

            // Confirmación de eliminación mejorada
            $('.btn-eliminar').on('click', function(e) {
                if (!confirm('¿Estás seguro de eliminar este producto del carrito?')) {
                    e.preventDefault();
                }
            });

            // Validación de cantidad
            $('.cantidad-input').on('change', function() {
                const val = parseInt($(this).val());
                if (val < 1) {
                    $(this).val(1);
                }
                if (val > 99) {
                    $(this).val(99);
                }
            });

            // Auto-actualizar al cambiar cantidad (opcional)
            $('.cantidad-input').on('blur', function() {
                const form = $(this).closest('form');
                const cantidad = parseInt($(this).val());
                const originalCantidad = parseInt($(this).data('original'));

                if (cantidad !== originalCantidad) {
                    if (confirm('¿Deseas actualizar la cantidad de este producto?')) {
                        form.submit();
                    }
                }
            });

            // Guardar cantidad original
            $('.cantidad-input').each(function() {
                $(this).data('original', $(this).val());
            });
        });
    </script>

</body>

</html>