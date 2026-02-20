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

// Cargar clases
require '../../vendor/autoload.php';

// PARÁMETROS DE BÚSQUEDA Y FILTROS
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'reciente';

// Obtener pedidos
$pedido = new distribuidoraOsvaldo\Pedido;
$info_pedido = $pedido->mostrar();

// CALCULAR ESTADO DINÁMICO
foreach ($info_pedido as &$item) {
    $fecha_pedido = strtotime($item['fecha']);
    $dias_desde_pedido = floor((time() - $fecha_pedido) / 86400);
    
    // Asignar estado basado en días
    if ($dias_desde_pedido > 7) {
        $item['estado'] = 'completado';
        $item['estado_texto'] = 'Completado';
        $item['estado_clase'] = 'success';
    } elseif ($dias_desde_pedido > 3) {
        $item['estado'] = 'en_proceso';
        $item['estado_texto'] = 'En Proceso';
        $item['estado_clase'] = 'warning';
    } else {
        $item['estado'] = 'pendiente';
        $item['estado_texto'] = 'Pendiente';
        $item['estado_clase'] = 'danger';
    }
}
unset($item);

// APLICAR FILTROS
if (!empty($busqueda)) {
    $info_pedido = array_filter($info_pedido, function($item) use ($busqueda) {
        return stripos($item['nombre'], $busqueda) !== false || 
               stripos($item['apellidos'], $busqueda) !== false ||
               stripos($item['id'], $busqueda) !== false;
    });
}

if (!empty($estado_filtro)) {
    $info_pedido = array_filter($info_pedido, function($item) use ($estado_filtro) {
        return $item['estado'] == $estado_filtro;
    });
}

// ORDENAR
switch ($orden) {
    case 'cliente_asc':
        usort($info_pedido, function($a, $b) {
            return strcmp($a['nombre'], $b['nombre']);
        });
        break;
    case 'total_desc':
        usort($info_pedido, function($a, $b) {
            return $b['total'] - $a['total'];
        });
        break;
    case 'total_asc':
        usort($info_pedido, function($a, $b) {
            return $a['total'] - $b['total'];
        });
        break;
    case 'antiguo':
        usort($info_pedido, function($a, $b) {
            return strtotime($a['fecha']) - strtotime($b['fecha']);
        });
        break;
    case 'reciente':
    default:
        usort($info_pedido, function($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });
        break;
}

// ESTADÍSTICAS
$total_pedidos = count($info_pedido);
$total_ventas = array_sum(array_column($info_pedido, 'total'));
$pendientes = count(array_filter($info_pedido, fn($p) => $p['estado'] == 'pendiente'));
$completados = count(array_filter($info_pedido, fn($p) => $p['estado'] == 'completado'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Gestión de Pedidos - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Pedidos - Distribuidora Osvaldo</title>
    <link rel="icon" href="../../logoOsvaldo.jpg">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../../assets/css/admin-pedidos-index.css">

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="sidebar">
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

        <!-- HEADER -->
        <div class="content-header">
            <div class="header-top">
                <div>
                    <h1 class="page-title">Pedidos</h1>
                    <div class="breadcrumb-custom">
                        <i class="bi bi-house-door"></i>
                        <a href="../dashboard.php">Inicio</a>
                        <span>/ Pedidos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MINI ESTADÍSTICAS -->
        <div class="mini-stats">
            <div class="mini-stat-card">
                <div class="mini-stat-icon primary">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
                <div class="mini-stat-info">
                    <div class="mini-stat-value"><?php echo $total_pedidos; ?></div>
                    <div class="mini-stat-label">Total Pedidos</div>
                </div>
            </div>

            <div class="mini-stat-card">
                <div class="mini-stat-icon success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="mini-stat-info">
                    <div class="mini-stat-value">$<?php echo number_format($total_ventas, 0, ',', '.'); ?></div>
                    <div class="mini-stat-label">Total Ventas</div>
                </div>
            </div>

            <div class="mini-stat-card">
                <div class="mini-stat-icon danger">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="mini-stat-info">
                    <div class="mini-stat-value"><?php echo $pendientes; ?></div>
                    <div class="mini-stat-label">Pendientes</div>
                </div>
            </div>

            <div class="mini-stat-card">
                <div class="mini-stat-icon warning">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="mini-stat-info">
                    <div class="mini-stat-value"><?php echo $completados; ?></div>
                    <div class="mini-stat-label">Completados</div>
                </div>
            </div>
        </div>

        <!-- FILTROS DE BÚSQUEDA -->
        <div class="search-filters">
            <form method="GET" action="index.php" id="filterForm">
                <div class="filter-row">
                    
                    <!-- Búsqueda -->
                    <div class="search-box">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" 
                               name="buscar" 
                               class="search-input" 
                               placeholder="Buscar por cliente o N° pedido..."
                               value="<?php echo htmlspecialchars($busqueda); ?>"
                               id="searchInput">
                    </div>

                    <!-- Filtro por Estado -->
                    <select name="estado" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" <?php echo $estado_filtro == 'pendiente' ? 'selected' : ''; ?>>
                            Pendientes
                        </option>
                        <option value="en_proceso" <?php echo $estado_filtro == 'en_proceso' ? 'selected' : ''; ?>>
                            En Proceso
                        </option>
                        <option value="completado" <?php echo $estado_filtro == 'completado' ? 'selected' : ''; ?>>
                            Completados
                        </option>
                    </select>

                    <!-- Ordenar -->
                    <select name="orden" class="filter-select" onchange="this.form.submit()">
                        <option value="reciente" <?php echo $orden == 'reciente' ? 'selected' : ''; ?>>
                            Más recientes
                        </option>
                        <option value="antiguo" <?php echo $orden == 'antiguo' ? 'selected' : ''; ?>>
                            Más antiguos
                        </option>
                        <option value="cliente_asc" <?php echo $orden == 'cliente_asc' ? 'selected' : ''; ?>>
                            Cliente A-Z
                        </option>
                        <option value="total_desc" <?php echo $orden == 'total_desc' ? 'selected' : ''; ?>>
                            Mayor valor
                        </option>
                        <option value="total_asc" <?php echo $orden == 'total_asc' ? 'selected' : ''; ?>>
                            Menor valor
                        </option>
                    </select>

                </div>
            </form>
        </div>

        <!-- INFORMACIÓN DE RESULTADOS -->
        <div class="results-info">
            <span>
                <strong><?php echo count($info_pedido); ?></strong> pedido(s) encontrado(s)
                <?php if (!empty($busqueda)): ?>
                    para "<strong><?php echo htmlspecialchars($busqueda); ?></strong>"
                <?php endif; ?>
            </span>
            <button class="btn-card" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise"></i>
                Actualizar
            </button>
        </div>

        <!-- TABLA DE PEDIDOS -->
        <div class="content-card">
            <div class="card-body">
                <?php if (count($info_pedido) > 0): ?>
                    <div class="table-wrapper">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>N° Pedido</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $c = 0;
                                foreach ($info_pedido as $item):
                                    $c++;
                                ?>
                                <tr>
                                    <td><strong><?php echo $c; ?></strong></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['nombre'] . ' ' . $item['apellidos']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">#<?php echo $item['id']; ?></span>
                                    </td>
                                    <td>
                                        <strong style="color: #10b981;">
                                            $<?php echo number_format($item['total'], 0, ',', '.'); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($item['fecha'])); ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $item['estado_clase']; ?>">
                                            <?php echo $item['estado_texto']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-action btn-view" 
                                                onclick="window.location.href='ver.php?id=<?php echo $item['id']; ?>'"
                                                title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h3 class="empty-title">No se encontraron pedidos</h3>
                        <p class="empty-text">
                            <?php if (!empty($busqueda) || !empty($estado_filtro)): ?>
                                Intenta cambiar los filtros de búsqueda
                            <?php else: ?>
                                Los pedidos aparecerán aquí cuando se registren
                            <?php endif; ?>
                        </p>
                        <?php if (!empty($busqueda) || !empty($estado_filtro)): ?>
                            <button class="btn-header btn-primary" onclick="clearFilters()">
                                <i class="bi bi-x-circle"></i>
                                Limpiar Filtros
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>

    <!-- JAVASCRIPT -->
    <script>
    // Limpiar todos los filtros
    function clearFilters() {
        window.location.href = 'index.php';
    }

    // Auto-submit al escribir (con delay)
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 800);
    });
    </script>

</body>
</html>