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

// ===================================
// PARÁMETROS DE BÚSQUEDA Y FILTROS
// ===================================
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'reciente';

// Obtener productos
$producto = new distribuidoraOsvaldo\Producto;
$info_productos = $producto->mostrar();

// ===================================
// APLICAR FILTROS
// ===================================
if (!empty($busqueda)) {
    $info_productos = array_filter($info_productos, function($item) use ($busqueda) {
        return stripos($item['titulo'], $busqueda) !== false || 
               stripos($item['nombre'], $busqueda) !== false;
    });
}

if (!empty($categoria_filtro)) {
    $info_productos = array_filter($info_productos, function($item) use ($categoria_filtro) {
        return $item['nombre'] == $categoria_filtro;
    });
}

// ===================================
// ORDENAR
// ===================================
switch ($orden) {
    case 'nombre_asc':
        usort($info_productos, function($a, $b) {
            return strcmp($a['titulo'], $b['titulo']);
        });
        break;
    case 'nombre_desc':
        usort($info_productos, function($a, $b) {
            return strcmp($b['titulo'], $a['titulo']);
        });
        break;
    case 'precio_asc':
        usort($info_productos, function($a, $b) {
            return $a['precio'] - $b['precio'];
        });
        break;
    case 'precio_desc':
        usort($info_productos, function($a, $b) {
            return $b['precio'] - $a['precio'];
        });
        break;
    case 'reciente':
    default:
        // Dejar en orden original (más recientes primero)
        break;
}

// Obtener categorías únicas para el filtro
$categorias = array_unique(array_column($info_productos, 'nombre'));

$cantidad = count($info_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Gestión de Productos - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Productos - Distribuidora Osvaldo</title>
    <link rel="icon" href="../../logoOsvaldo.jpg">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">

    <style>
        /* Estilos adicionales específicos para productos */
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .product-image:hover {
            transform: scale(2);
            z-index: 1000;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .no-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 0.8rem;
            text-align: center;
            border: 2px dashed #d1d5db;
        }

        .search-filters {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 15px;
            align-items: end;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 45px 12px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.2rem;
        }

        .clear-search {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 5px;
            display: none;
        }

        .search-input:not(:placeholder-shown) + .search-icon + .clear-search {
            display: block;
        }

        .filter-select {
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            min-width: 150px;
        }

        .filter-select:focus {
            outline: none;
            border-color: #667eea;
        }

        .results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .product-card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f3f4f6;
        }

        .product-card-body {
            padding: 20px;
        }

        .product-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-card-category {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .product-card-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 15px;
        }

        .product-card-actions {
            display: flex;
            gap: 8px;
        }

        .product-card-actions .btn-action {
            flex: 1;
        }

        .view-toggle {
            display: flex;
            gap: 5px;
        }

        .view-btn {
            padding: 8px 12px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .view-btn:hover:not(.active) {
            border-color: #667eea;
            color: #667eea;
        }

        @media (max-width: 768px) {
            .filter-row {
                grid-template-columns: 1fr;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                <a href="../pedidos/index.php" class="menu-link">
                    <i class="bi bi-cart-check menu-icon"></i>
                    <span class="menu-text">Pedidos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php" class="menu-link active">
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
                    <h1 class="page-title">Productos</h1>
                    <div class="breadcrumb-custom">
                        <i class="bi bi-house-door"></i>
                        <a href="../dashboard.php">Inicio</a>
                        <span>/ Productos</span>
                    </div>
                </div>
                <div class="header-actions">
                    <button class="btn-header btn-primary" onclick="window.location.href='form_registrar.php'">
                        <i class="bi bi-plus-lg"></i>
                        Nuevo Producto
                    </button>
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
                               placeholder="Buscar productos..."
                               value="<?php echo htmlspecialchars($busqueda); ?>"
                               id="searchInput">
                        <button type="button" class="clear-search" onclick="clearSearch()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <!-- Filtro por Categoría -->
                    <select name="categoria" class="filter-select" onchange="this.form.submit()">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" 
                                    <?php echo $categoria_filtro == $cat ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Ordenar -->
                    <select name="orden" class="filter-select" onchange="this.form.submit()">
                        <option value="reciente" <?php echo $orden == 'reciente' ? 'selected' : ''; ?>>
                            Más recientes
                        </option>
                        <option value="nombre_asc" <?php echo $orden == 'nombre_asc' ? 'selected' : ''; ?>>
                            Nombre A-Z
                        </option>
                        <option value="nombre_desc" <?php echo $orden == 'nombre_desc' ? 'selected' : ''; ?>>
                            Nombre Z-A
                        </option>
                        <option value="precio_asc" <?php echo $orden == 'precio_asc' ? 'selected' : ''; ?>>
                            Precio menor
                        </option>
                        <option value="precio_desc" <?php echo $orden == 'precio_desc' ? 'selected' : ''; ?>>
                            Precio mayor
                        </option>
                    </select>

                </div>
            </form>
        </div>

        <!-- INFORMACIÓN DE RESULTADOS -->
        <div class="results-info">
            <span>
                <strong><?php echo $cantidad; ?></strong> producto(s) encontrado(s)
                <?php if (!empty($busqueda)): ?>
                    para "<strong><?php echo htmlspecialchars($busqueda); ?></strong>"
                <?php endif; ?>
            </span>
            <div class="view-toggle">
                <button class="view-btn active" onclick="toggleView('grid')" id="gridViewBtn">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
                <button class="view-btn" onclick="toggleView('table')" id="tableViewBtn">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- VISTA DE CUADRÍCULA (por defecto) -->
        <div id="gridView" class="product-grid">
            <?php if ($cantidad > 0): ?>
                <?php foreach ($info_productos as $item): ?>
                    <div class="product-card">
                        <?php
                        $foto = '../../upload/' . $item['foto'];
                        if (file_exists($foto) && !empty($item['foto'])):
                        ?>
                            <img src="<?php echo $foto; ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>" class="product-card-image">
                        <?php else: ?>
                            <div class="product-card-image" style="display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <i class="bi bi-image" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-card-body">
                            <h3 class="product-card-title" title="<?php echo htmlspecialchars($item['titulo']); ?>">
                                <?php echo htmlspecialchars($item['titulo']); ?>
                            </h3>
                            <span class="product-card-category">
                                <?php echo htmlspecialchars($item['nombre']); ?>
                            </span>
                            <div class="product-card-price">
                                $<?php echo number_format($item['precio'], 0, ',', '.'); ?>
                            </div>
                            <div class="product-card-actions">
                                <button class="btn-action btn-edit" 
                                        onclick="window.location.href='form_actualizar.php?id=<?php echo $item['id']; ?>'"
                                        title="Editar">
                                    <i class="bi bi-pencil"></i>
                                    Editar
                                </button>
                                <button class="btn-action btn-delete" 
                                        onclick="eliminarProducto(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['titulo']); ?>')"
                                        title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="empty-title">No se encontraron productos</h3>
                    <p class="empty-text">
                        <?php if (!empty($busqueda) || !empty($categoria_filtro)): ?>
                            Intenta cambiar los filtros de búsqueda
                        <?php else: ?>
                            Comienza agregando tu primer producto
                        <?php endif; ?>
                    </p>
                    <?php if (empty($busqueda) && empty($categoria_filtro)): ?>
                        <button class="btn-header btn-primary" onclick="window.location.href='form_registrar.php'">
                            <i class="bi bi-plus-lg"></i>
                            Agregar Producto
                        </button>
                    <?php else: ?>
                        <button class="btn-header btn-primary" onclick="clearFilters()">
                            <i class="bi bi-x-circle"></i>
                            Limpiar Filtros
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- VISTA DE TABLA (oculta por defecto) -->
        <div id="tableView" class="content-card" style="display: none;">
            <div class="card-body">
                <div class="table-wrapper">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($cantidad > 0): ?>
                                <?php 
                                $c = 0;
                                foreach ($info_productos as $item): 
                                    $c++;
                                ?>
                                <tr>
                                    <td><strong><?php echo $c; ?></strong></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['titulo']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            <?php echo htmlspecialchars($item['nombre']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong style="color: #10b981;">
                                            $<?php echo number_format($item['precio'], 0, ',', '.'); ?>
                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $foto = '../../upload/' . $item['foto'];
                                        if (file_exists($foto) && !empty($item['foto'])):
                                        ?>
                                            <img src="<?php echo $foto; ?>" class="product-image" alt="<?php echo htmlspecialchars($item['titulo']); ?>">
                                        <?php else: ?>
                                            <div class="no-image">
                                                <i class="bi bi-image"></i>
                                                <div>Sin foto</div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-action btn-edit" 
                                                onclick="window.location.href='form_actualizar.php?id=<?php echo $item['id']; ?>'"
                                                title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn-action btn-delete" 
                                                onclick="eliminarProducto(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['titulo']); ?>')"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- JAVASCRIPT -->
    <script>
    // Limpiar búsqueda
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('filterForm').submit();
    }

    // Limpiar todos los filtros
    function clearFilters() {
        window.location.href = 'index.php';
    }

    // Cambiar vista
    function toggleView(view) {
        const gridView = document.getElementById('gridView');
        const tableView = document.getElementById('tableView');
        const gridBtn = document.getElementById('gridViewBtn');
        const tableBtn = document.getElementById('tableViewBtn');

        if (view === 'grid') {
            gridView.style.display = 'grid';
            tableView.style.display = 'none';
            gridBtn.classList.add('active');
            tableBtn.classList.remove('active');
            localStorage.setItem('productView', 'grid');
        } else {
            gridView.style.display = 'none';
            tableView.style.display = 'block';
            gridBtn.classList.remove('active');
            tableBtn.classList.add('active');
            localStorage.setItem('productView', 'table');
        }
    }

    // Restaurar vista guardada
    window.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('productView');
        if (savedView === 'table') {
            toggleView('table');
        }
    });

    // Eliminar producto
    function eliminarProducto(id, nombre) {
        if (confirm(`¿Estás seguro de eliminar el producto "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
            window.location.href = `../acciones.php?id=${id}`;
        }
    }

    // Auto-submit al escribir (con delay)
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 600);
    });
    </script>

</body>
</html>