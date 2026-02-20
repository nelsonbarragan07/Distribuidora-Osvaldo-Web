<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario_info']) || empty($_SESSION['usuario_info'])) {
    header('Location: ../index.php?error=session');
    exit;
}

// Obtener información del usuario
$usuario = $_SESSION['usuario_info']['nombre_usuario'];
$nombre = $_SESSION['usuario_info']['nombre'] ?? $usuario;
$rol = $_SESSION['usuario_info']['rol'] ?? 'Administrador';

// Verificar ID del pedido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?error=invalid_id');
    exit;
}

// Cargar información del pedido
require '../../vendor/autoload.php';

$id = $_GET['id'];
$pedido = new distribuidoraOsvaldo\Pedido;

$info_pedido = $pedido->mostrarPorId($id);
$info_detalle_pedido = $pedido->mostrarDetallePorIdPedido($id);

if (!$info_pedido) {
    header('Location: index.php?error=not_found');
    exit;
}

// Calcular estado del pedido
$fecha_pedido = strtotime($info_pedido['fecha']);
$dias_desde_pedido = floor((time() - $fecha_pedido) / 86400);

if ($dias_desde_pedido > 7) {
    $estado_pedido = ['texto' => 'Completado', 'clase' => 'success', 'icono' => 'check-circle-fill'];
} elseif ($dias_desde_pedido > 3) {
    $estado_pedido = ['texto' => 'En Proceso', 'clase' => 'warning', 'icono' => 'hourglass-split'];
} else {
    $estado_pedido = ['texto' => 'Pendiente', 'clase' => 'danger', 'icono' => 'clock-fill'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Detalle del Pedido #<?php echo $id; ?> - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Pedido #<?php echo $id; ?> - Distribuidora Osvaldo</title>
    <link rel="icon" href="../../logoOsvaldo.jpg">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../../assets/css/admin-pedidos-ver.css">

</head>

<body>

    <!-- SIDEBAR (oculto en impresión) -->
    <aside class="admin-sidebar hidden-print" id="sidebar">
        <div class="sidebar-header">
            <img src="../../logoOsvaldo.jpg" alt="Logo" class="sidebar-logo">
            <h3 class="sidebar-title">Distribuidora Osvaldo</h3>
            <p class="sidebar-subtitle">Panel de Administración</p>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="../dashboard.php" class="menu-link">
                    <i class="bi bi-speedometer2 menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php" class="menu-link active">
                    <i class="bi bi-cart-check menu-icon"></i>
                    <span class="menu-text">Pedidos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="../productos/index.php" class="menu-link">
                    <i class="bi bi-box-seam menu-icon"></i>
                    <span class="menu-text">Productos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="../clientes/clientes.php" class="menu-link">
                    <i class="bi bi-people menu-icon"></i>
                    <span class="menu-text">Clientes</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($usuario, 0, 1)); ?>
                </div>
                <div class="user-details">
                    <p class="user-name"><?php echo htmlspecialchars($nombre); ?></p>
                    <p class="user-role"><?php echo htmlspecialchars($rol); ?></p>
                </div>
            </div>
            <button class="btn-logout" onclick="if(confirm('¿Cerrar sesión?')) window.location.href='../cerrar_session.php'">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">

        <!-- HEADER (oculto en impresión) -->
        <div class="content-header hidden-print">
            <div class="header-top">
                <div>
                    <h1 class="page-title">Detalle del Pedido #<?php echo $id; ?></h1>
                    <div class="breadcrumb-custom">
                        <i class="bi bi-house-door"></i>
                        <a href="../dashboard.php">Inicio</a>
                        <span>/</span>
                        <a href="index.php">Pedidos</a>
                        <span>/ Detalle #<?php echo $id; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FACTURA -->
        <div class="invoice-container">
            <div class="invoice-card">
                
                <!-- Header de la Factura -->
                <div class="invoice-header">
                    <div class="company-info">
                        <h1>Distribuidora Osvaldo</h1>
                        <p><i class="bi bi-geo-alt-fill"></i> Coveñas, Sucre, Colombia</p>
                        <p><i class="bi bi-telephone-fill"></i> +57 312 810 3173</p>
                        <p><i class="bi bi-envelope-fill"></i> info@distribuidoraosvaldo.com</p>
                    </div>
                    <div class="invoice-number">
                        <span class="invoice-badge <?php echo $estado_pedido['clase']; ?>">
                            <i class="bi bi-<?php echo $estado_pedido['icono']; ?>"></i>
                            <?php echo $estado_pedido['texto']; ?>
                        </span>
                        <div class="invoice-id">Pedido #<?php echo $id; ?></div>
                        <div class="invoice-date">
                            <i class="bi bi-calendar3"></i>
                            <?php echo date('d/m/Y H:i', strtotime($info_pedido['fecha'])); ?>
                        </div>
                    </div>
                </div>

                <!-- Información del Cliente -->
                <div class="customer-info">
                    <h3>
                        <i class="bi bi-person-fill"></i>
                        Información del Cliente
                    </h3>
                    <div class="customer-details">
                        <div class="detail-item">
                            <span class="detail-label">Nombre Completo</span>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($info_pedido['nombre'] . ' ' . $info_pedido['apellidos']); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Correo Electrónico</span>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($info_pedido['email']); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Teléfono</span>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($info_pedido['telefono'] ?? 'No especificado'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Fecha del Pedido</span>
                            <span class="detail-value">
                                <?php echo date('d/m/Y', strtotime($info_pedido['fecha'])); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="products-section">
                    <h3>
                        <i class="bi bi-box-seam"></i>
                        Productos del Pedido
                    </h3>
                    
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Foto</th>
                                <th>Precio Unit.</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cantidad = count($info_detalle_pedido);
                            if ($cantidad > 0) {
                                $c = 0;
                                foreach ($info_detalle_pedido as $item) {
                                    $c++;
                                    $subtotal = $item['precio'] * $item['cantidad'];
                            ?>
                            <tr>
                                <td><strong><?php echo $c; ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($item['titulo']); ?></strong></td>
                                <td>
                                    <?php
                                    $foto = '../../upload/' . $item['foto'];
                                    if (!empty($item['foto']) && file_exists($foto)):
                                    ?>
                                        <img src="<?php echo $foto; ?>" class="product-image" alt="<?php echo htmlspecialchars($item['titulo']); ?>">
                                    <?php else: ?>
                                        <div class="no-image">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>$<?php echo number_format($item['precio'], 0, ',', '.'); ?></td>
                                <td><strong><?php echo $item['cantidad']; ?></strong></td>
                                <td><strong style="color: #10b981;">$<?php echo number_format($subtotal, 0, ',', '.'); ?></strong></td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 40px; color: #9ca3af;">
                                    <i class="bi bi-inbox" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                                    No hay productos en este pedido
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Totales -->
                <div class="totals-section">
                    <div class="totals-box">
                        <div class="total-row">
                            <span class="total-label">Subtotal:</span>
                            <span class="total-value">$<?php echo number_format($info_pedido['total'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="total-row">
                            <span class="total-label">Envío:</span>
                            <span class="total-value" style="color: #10b981;">GRATIS</span>
                        </div>
                        <div class="total-row final">
                            <span class="total-label">Total:</span>
                            <span class="total-value">$<?php echo number_format($info_pedido['total'], 0, ',', '.'); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción (ocultos en impresión) -->
                <div class="action-buttons hidden-print">
                    <a href="index.php" class="btn-action btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Volver a Pedidos
                    </a>
                    <button onclick="window.print()" class="btn-action btn-print">
                        <i class="bi bi-printer"></i>
                        Imprimir Pedido
                    </button>
                </div>

            </div>
        </div>

    </main>

</body>
</html>