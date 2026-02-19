<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario_info']) || empty($_SESSION['usuario_info'])) {
    header('Location: index.php?error=session');
    exit;
}

// Obtener información del usuario
$usuario = $_SESSION['usuario_info']['nombre_usuario'];
$nombre = $_SESSION['usuario_info']['nombre'] ?? $usuario;
$rol = $_SESSION['usuario_info']['rol'] ?? 'Administrador';

// Cargar clases
require '../vendor/autoload.php';

// ===================================
// CALCULAR ESTADÍSTICAS DINÁMICAS
// ===================================

$pedido = new distribuidoraOsvaldo\Pedido;
$info_pedido = $pedido->mostrarUltimos();

// Fechas para comparación
$hoy = date('Y-m-d');
$inicio_mes_actual = date('Y-m-01');
$fin_mes_actual = date('Y-m-t');
$inicio_mes_anterior = date('Y-m-01', strtotime('-1 month'));
$fin_mes_anterior = date('Y-m-t', strtotime('-1 month'));

// Inicializar contadores
$stats = [
    'total_pedidos' => 0,
    'total_ventas' => 0,
    'pedidos_hoy' => 0,
    'clientes_unicos' => [],
    
    // Mes anterior para comparación
    'pedidos_mes_anterior' => 0,
    'ventas_mes_anterior' => 0,
    'pedidos_dia_anterior' => 0,
    'clientes_mes_anterior' => []
];

// Procesar pedidos
foreach ($info_pedido as $item) {
    $fecha_pedido = date('Y-m-d', strtotime($item['fecha']));
    $mes_pedido = date('Y-m', strtotime($item['fecha']));
    $cliente_id = $item['nombre'] . ' ' . $item['apellidos']; // ID único del cliente
    
    // Estadísticas generales (últimos 10 pedidos)
    $stats['total_pedidos']++;
    $stats['total_ventas'] += $item['total'];
    
    // Clientes únicos
    if (!in_array($cliente_id, $stats['clientes_unicos'])) {
        $stats['clientes_unicos'][] = $cliente_id;
    }
    
    // Pedidos de hoy
    if ($fecha_pedido == $hoy) {
        $stats['pedidos_hoy']++;
    }
    
    // Pedidos del día anterior (para comparación)
    $ayer = date('Y-m-d', strtotime('-1 day'));
    if ($fecha_pedido == $ayer) {
        $stats['pedidos_dia_anterior']++;
    }
    
    // Estadísticas del mes anterior (para comparación de tendencias)
    if ($fecha_pedido >= $inicio_mes_anterior && $fecha_pedido <= $fin_mes_anterior) {
        $stats['pedidos_mes_anterior']++;
        $stats['ventas_mes_anterior'] += $item['total'];
        
        if (!in_array($cliente_id, $stats['clientes_mes_anterior'])) {
            $stats['clientes_mes_anterior'][] = $cliente_id;
        }
    }
}

// Contar clientes únicos
$total_clientes = count($stats['clientes_unicos']);
$clientes_mes_anterior = count($stats['clientes_mes_anterior']);

// ===================================
// CALCULAR PORCENTAJES DE CAMBIO
// ===================================

/**
 * Calcula el porcentaje de cambio entre dos valores
 * @return array ['porcentaje' => float, 'tendencia' => 'up'|'down'|'neutral']
 */
function calcularCambio($valor_actual, $valor_anterior) {
    if ($valor_anterior == 0) {
        // Si no hay valor anterior, mostrar crecimiento del 100% si hay valor actual
        if ($valor_actual > 0) {
            return ['porcentaje' => 100, 'tendencia' => 'up'];
        }
        return ['porcentaje' => 0, 'tendencia' => 'neutral'];
    }
    
    $cambio = (($valor_actual - $valor_anterior) / $valor_anterior) * 100;
    
    if ($cambio > 0) {
        $tendencia = 'up';
    } elseif ($cambio < 0) {
        $tendencia = 'down';
    } else {
        $tendencia = 'neutral';
    }
    
    return [
        'porcentaje' => abs(round($cambio, 1)),
        'tendencia' => $tendencia
    ];
}

// Calcular cambios
$cambio_pedidos = calcularCambio($stats['total_pedidos'], $stats['pedidos_mes_anterior']);
$cambio_ventas = calcularCambio($stats['total_ventas'], $stats['ventas_mes_anterior']);
$cambio_pedidos_hoy = calcularCambio($stats['pedidos_hoy'], $stats['pedidos_dia_anterior']);
$cambio_clientes = calcularCambio($total_clientes, $clientes_mes_anterior);

// ===================================
// DATOS FINALES
// ===================================

$dashboard_data = [
    'total_pedidos' => [
        'valor' => $stats['total_pedidos'],
        'cambio' => $cambio_pedidos['porcentaje'],
        'tendencia' => $cambio_pedidos['tendencia']
    ],
    'total_ventas' => [
        'valor' => $stats['total_ventas'],
        'cambio' => $cambio_ventas['porcentaje'],
        'tendencia' => $cambio_ventas['tendencia']
    ],
    'pedidos_hoy' => [
        'valor' => $stats['pedidos_hoy'],
        'cambio' => $cambio_pedidos_hoy['porcentaje'],
        'tendencia' => $cambio_pedidos_hoy['tendencia']
    ],
    'clientes' => [
        'valor' => $total_clientes,
        'cambio' => $cambio_clientes['porcentaje'],
        'tendencia' => $cambio_clientes['tendencia']
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dashboard Administrador - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Dashboard - Distribuidora Osvaldo</title>
    <link rel="icon" href="../logoOsvaldo.jpg">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="sidebar">
        
        <!-- Header del Sidebar -->
        <div class="sidebar-header">
            <img src="../logoOsvaldo.jpg" alt="Logo" class="sidebar-logo">
            <h3 class="sidebar-title">Distribuidora Osvaldo</h3>
            <p class="sidebar-subtitle">Panel de Administración</p>
        </div>

        <!-- Menú de Navegación -->
        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="dashboard.php" class="menu-link active">
                    <i class="bi bi-speedometer2 menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="pedidos/index.php" class="menu-link">
                    <i class="bi bi-cart-check menu-icon"></i>
                    <span class="menu-text">Pedidos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="productos/index.php" class="menu-link">
                    <i class="bi bi-box-seam menu-icon"></i>
                    <span class="menu-text">Productos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="clientes/clientes.php" class="menu-link">
                    <i class="bi bi-people menu-icon"></i>
                    <span class="menu-text">Clientes</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="reportes.php" class="menu-link">
                    <i class="bi bi-graph-up menu-icon"></i>
                    <span class="menu-text">Reportes</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="configuracion.php" class="menu-link">
                    <i class="bi bi-gear menu-icon"></i>
                    <span class="menu-text">Configuración</span>
                </a>
            </li>
        </ul>

        <!-- Usuario -->
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
            <button class="btn-logout" onclick="confirmLogout()">
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
                    <h1 class="page-title">Dashboard</h1>
                    <div class="breadcrumb-custom">
                        <i class="bi bi-house-door"></i>
                        <a href="dashboard.php">Inicio</a>
                        <span>/ Dashboard</span>
                    </div>
                </div>
                <div class="header-actions">
                    <button class="btn-header btn-primary" onclick="window.location.href='pedidos/index.php'">
                        <i class="bi bi-plus-lg"></i>
                        Nuevo Pedido
                    </button>
                </div>
            </div>
        </div>

        <!-- TARJETAS DE ESTADÍSTICAS DINÁMICAS -->
        <div class="stats-grid">
            
            <!-- Total Pedidos -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon primary">
                        <i class="bi bi-cart-check-fill"></i>
                    </div>
                    <?php if ($dashboard_data['total_pedidos']['tendencia'] != 'neutral'): ?>
                    <div class="stat-trend <?php echo $dashboard_data['total_pedidos']['tendencia']; ?>">
                        <i class="bi bi-arrow-<?php echo $dashboard_data['total_pedidos']['tendencia'] == 'up' ? 'up' : 'down'; ?>"></i>
                        <?php echo $dashboard_data['total_pedidos']['cambio']; ?>%
                    </div>
                    <?php endif; ?>
                </div>
                <div class="stat-value"><?php echo $dashboard_data['total_pedidos']['valor']; ?></div>
                <div class="stat-label">Total Pedidos</div>
                <small style="color: #9ca3af; font-size: 0.8rem; display: block; margin-top: 5px;">
                    vs. mes anterior (<?php echo $stats['pedidos_mes_anterior']; ?>)
                </small>
            </div>

            <!-- Total Ventas -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon success">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <?php if ($dashboard_data['total_ventas']['tendencia'] != 'neutral'): ?>
                    <div class="stat-trend <?php echo $dashboard_data['total_ventas']['tendencia']; ?>">
                        <i class="bi bi-arrow-<?php echo $dashboard_data['total_ventas']['tendencia'] == 'up' ? 'up' : 'down'; ?>"></i>
                        <?php echo $dashboard_data['total_ventas']['cambio']; ?>%
                    </div>
                    <?php endif; ?>
                </div>
                <div class="stat-value">$<?php echo number_format($dashboard_data['total_ventas']['valor'], 0, ',', '.'); ?></div>
                <div class="stat-label">Total Ventas</div>
                <small style="color: #9ca3af; font-size: 0.8rem; display: block; margin-top: 5px;">
                    vs. mes anterior ($<?php echo number_format($stats['ventas_mes_anterior'], 0, ',', '.'); ?>)
                </small>
            </div>

            <!-- Pedidos Hoy -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon warning">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <?php if ($dashboard_data['pedidos_hoy']['tendencia'] != 'neutral'): ?>
                    <div class="stat-trend <?php echo $dashboard_data['pedidos_hoy']['tendencia']; ?>">
                        <i class="bi bi-arrow-<?php echo $dashboard_data['pedidos_hoy']['tendencia'] == 'up' ? 'up' : 'down'; ?>"></i>
                        <?php echo $dashboard_data['pedidos_hoy']['cambio']; ?>%
                    </div>
                    <?php endif; ?>
                </div>
                <div class="stat-value"><?php echo $dashboard_data['pedidos_hoy']['valor']; ?></div>
                <div class="stat-label">Pedidos Hoy</div>
                <small style="color: #9ca3af; font-size: 0.8rem; display: block; margin-top: 5px;">
                    vs. ayer (<?php echo $stats['pedidos_dia_anterior']; ?>)
                </small>
            </div>

            <!-- Clientes Únicos -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon danger">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <?php if ($dashboard_data['clientes']['tendencia'] != 'neutral'): ?>
                    <div class="stat-trend <?php echo $dashboard_data['clientes']['tendencia']; ?>">
                        <i class="bi bi-arrow-<?php echo $dashboard_data['clientes']['tendencia'] == 'up' ? 'up' : 'down'; ?>"></i>
                        <?php echo $dashboard_data['clientes']['cambio']; ?>%
                    </div>
                    <?php endif; ?>
                </div>
                <div class="stat-value"><?php echo $dashboard_data['clientes']['valor']; ?></div>
                <div class="stat-label">Clientes Únicos</div>
                <small style="color: #9ca3af; font-size: 0.8rem; display: block; margin-top: 5px;">
                    vs. mes anterior (<?php echo $clientes_mes_anterior; ?>)
                </small>
            </div>

        </div>

        <!-- INFORMACIÓN DE CÁLCULO (Solo visible en desarrollo) -->
        <?php if (isset($_GET['debug'])): ?>
        <div class="content-card" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
            <div class="card-header" style="background: transparent; border-bottom: 1px solid #fbbf24;">
                <h2 class="card-title" style="color: #b45309;">
                    <i class="bi bi-bug"></i>
                    Información de Debug
                </h2>
            </div>
            <div class="card-body">
                <pre style="background: white; padding: 15px; border-radius: 8px; overflow-x: auto;"><?php
                echo "=== ESTADÍSTICAS CALCULADAS ===\n\n";
                echo "Pedidos actuales: " . $stats['total_pedidos'] . "\n";
                echo "Pedidos mes anterior: " . $stats['pedidos_mes_anterior'] . "\n";
                echo "Cambio: " . ($cambio_pedidos['tendencia'] == 'up' ? '+' : ($cambio_pedidos['tendencia'] == 'down' ? '-' : '')) . $cambio_pedidos['porcentaje'] . "%\n\n";
                
                echo "Ventas actuales: $" . number_format($stats['total_ventas'], 0, ',', '.') . "\n";
                echo "Ventas mes anterior: $" . number_format($stats['ventas_mes_anterior'], 0, ',', '.') . "\n";
                echo "Cambio: " . ($cambio_ventas['tendencia'] == 'up' ? '+' : ($cambio_ventas['tendencia'] == 'down' ? '-' : '')) . $cambio_ventas['porcentaje'] . "%\n\n";
                
                echo "Pedidos hoy: " . $stats['pedidos_hoy'] . "\n";
                echo "Pedidos ayer: " . $stats['pedidos_dia_anterior'] . "\n";
                echo "Cambio: " . ($cambio_pedidos_hoy['tendencia'] == 'up' ? '+' : ($cambio_pedidos_hoy['tendencia'] == 'down' ? '-' : '')) . $cambio_pedidos_hoy['porcentaje'] . "%\n\n";
                
                echo "Clientes únicos: " . $total_clientes . "\n";
                echo "Clientes mes anterior: " . $clientes_mes_anterior . "\n";
                echo "Cambio: " . ($cambio_clientes['tendencia'] == 'up' ? '+' : ($cambio_clientes['tendencia'] == 'down' ? '-' : '')) . $cambio_clientes['porcentaje'] . "%\n";
                ?></pre>
                <small style="color: #92400e; display: block; margin-top: 10px;">
                    <strong>Nota:</strong> Esta sección solo es visible añadiendo <code>?debug</code> a la URL
                </small>
            </div>
        </div>
        <?php endif; ?>

        <!-- TABLA DE ÚLTIMOS PEDIDOS -->
        <div class="content-card">
            
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-clock-history"></i>
                    Últimos 10 Pedidos
                </h2>
                <div class="card-actions">
                    <button class="btn-card" onclick="window.location.reload()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Actualizar
                    </button>
                    <button class="btn-card" onclick="window.location.href='pedidos/index.php'">
                        <i class="bi bi-eye"></i>
                        Ver Todos
                    </button>
                </div>
            </div>

            <div class="card-body">
                <?php if ($stats['total_pedidos'] > 0): ?>
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
                                    
                                    // Determinar estado basado en fecha
                                    $fecha_pedido = strtotime($item['fecha']);
                                    $dias_desde_pedido = floor((time() - $fecha_pedido) / 86400);
                                    
                                    if ($dias_desde_pedido > 7) {
                                        $estado = ['clase' => 'badge-success', 'texto' => 'Completado'];
                                    } elseif ($dias_desde_pedido > 3) {
                                        $estado = ['clase' => 'badge-warning', 'texto' => 'En Proceso'];
                                    } else {
                                        $estado = ['clase' => 'badge-danger', 'texto' => 'Pendiente'];
                                    }
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
                                        <span class="badge <?php echo $estado['clase']; ?>">
                                            <?php echo $estado['texto']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-action btn-view" 
                                                onclick="window.location.href='pedidos/ver.php?id=<?php echo $item['id']; ?>'"
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
                        <h3 class="empty-title">No hay pedidos registrados</h3>
                        <p class="empty-text">Los pedidos aparecerán aquí cuando se registren en el sistema</p>
                        <button class="btn-header btn-primary" onclick="window.location.href='pedidos/index.php'">
                            <i class="bi bi-plus-lg"></i>
                            Crear Primer Pedido
                        </button>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </main>

    <!-- TOAST DE BIENVENIDA -->
    <?php if (isset($_GET['welcome']) && $_GET['welcome'] == 'true'): ?>
        <div class="welcome-toast" id="welcomeToast">
            <div class="toast-header-custom">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                    <strong class="toast-title">¡Bienvenido!</strong>
                </div>
                <button class="toast-close" onclick="closeToast()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="toast-body-custom">
                <i class="bi bi-person-circle"></i>
                Hola <strong><?php echo htmlspecialchars($nombre); ?></strong>, has iniciado sesión correctamente.
            </div>
        </div>

        <script>
        // Confetti
        function createConfetti() {
            const confetti = document.createElement('div');
            confetti.style.position = 'fixed';
            confetti.style.width = '10px';
            confetti.style.height = '10px';
            confetti.style.borderRadius = '50%';
            const colors = ['#f39c12', '#e74c3c', '#3498db', '#2ecc71', '#9b59b6'];
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.left = Math.random() * 100 + '%';
            confetti.style.top = '-10px';
            confetti.style.zIndex = '9998';
            confetti.style.pointerEvents = 'none';
            document.body.appendChild(confetti);
            
            const animation = confetti.animate([
                { transform: 'translateY(-100vh) rotate(0deg)', opacity: 1 },
                { transform: 'translateY(100vh) rotate(720deg)', opacity: 0 }
            ], {
                duration: Math.random() * 2000 + 2000,
                easing: 'linear'
            });
            
            animation.onfinish = () => confetti.remove();
        }

        for (let i = 0; i < 20; i++) {
            setTimeout(() => createConfetti(), i * 200);
        }

        setTimeout(() => closeToast(), 5000);
        setTimeout(() => {
            window.history.replaceState({}, document.title, 'dashboard.php');
        }, 100);
        </script>
    <?php endif; ?>

    <!-- JAVASCRIPT -->
    <script>
    function closeToast() {
        const toast = document.getElementById('welcomeToast');
        if (toast) {
            toast.style.animation = 'slideInRight 0.5s ease-out reverse';
            setTimeout(() => toast.remove(), 500);
        }
    }

    function confirmLogout() {
        if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
            window.location.href = 'cerrar_session.php';
        }
    }
    </script>

</body>
</html>