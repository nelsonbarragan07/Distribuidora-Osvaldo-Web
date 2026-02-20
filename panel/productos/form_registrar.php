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

// Cargar categorías
require '../../vendor/autoload.php';
$categoria = new distribuidoraOsvaldo\Categoria;
$info_categoria = $categoria->mostrar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Registrar Producto - Distribuidora Osvaldo">
    <meta name="author" content="Distribuidora Osvaldo">

    <title>Registrar Producto - Distribuidora Osvaldo</title>
    <link rel="icon" href="../../logoOsvaldo.jpg">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../../assets/css/admin-regisprod.css">

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
                    <h1 class="page-title">Nuevo Producto</h1>
                    <div class="breadcrumb-custom">
                        <i class="bi bi-house-door"></i>
                        <a href="../dashboard.php">Inicio</a>
                        <span>/</span>
                        <a href="index.php">Productos</a>
                        <span>/ Nuevo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORMULARIO -->
        <div class="form-container">
            
            <form method="POST" action="../acciones.php" enctype="multipart/form-data" id="productForm">
                
                <!-- INFORMACIÓN BÁSICA -->
                <div class="form-card">
                    <h2 class="form-section-title">
                        <i class="bi bi-info-circle"></i>
                        Información Básica
                    </h2>

                    <!-- Título -->
                    <div class="form-group">
                        <label class="form-label">
                            Nombre del Producto
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               name="titulo" 
                               id="titulo"
                               placeholder="Ej: Coca-Cola 2L"
                               maxlength="100"
                               required>
                        <div class="char-counter">
                            <span id="tituloCount">0</span>/100 caracteres
                        </div>
                        <div class="error-message">Por favor ingresa el nombre del producto</div>
                    </div>

                    <!-- Descripción -->
                    <div class="form-group">
                        <label class="form-label">
                            Descripción
                            <span class="required">*</span>
                        </label>
                        <textarea class="form-control" 
                                  name="descripcion" 
                                  id="descripcion"
                                  placeholder="Describe las características del producto..."
                                  maxlength="500"
                                  required></textarea>
                        <div class="char-counter">
                            <span id="descripcionCount">0</span>/500 caracteres
                        </div>
                        <div class="error-message">Por favor ingresa una descripción</div>
                    </div>

                    <!-- Grid: Categoría y Precio -->
                    <div class="form-grid">
                        
                        <!-- Categoría -->
                        <div class="form-group">
                            <label class="form-label">
                                Categoría
                                <span class="required">*</span>
                            </label>
                            <select class="form-control" name="categoria_id" id="categoria_id" required>
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($info_categoria as $item): ?>
                                    <option value="<?php echo $item['id']; ?>">
                                        <?php echo htmlspecialchars($item['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="error-message">Por favor selecciona una categoría</div>
                        </div>

                        <!-- Precio -->
                        <div class="form-group">
                            <label class="form-label">
                                Precio (COP)
                                <span class="required">*</span>
                            </label>
                            <div class="price-input-wrapper">
                                <input type="number" 
                                       class="form-control" 
                                       name="precio" 
                                       id="precio"
                                       placeholder="5000"
                                       min="0"
                                       step="100"
                                       required>
                            </div>
                            <div class="help-text">Precio en pesos colombianos</div>
                            <div class="error-message">Por favor ingresa un precio válido</div>
                        </div>

                    </div>
                </div>

                <!-- IMAGEN DEL PRODUCTO -->
                <div class="form-card">
                    <h2 class="form-section-title">
                        <i class="bi bi-image"></i>
                        Imagen del Producto
                    </h2>

                    <div class="form-group">
                        <label class="form-label">
                            Foto
                            <span class="required">*</span>
                        </label>
                        
                        <!-- Área de subida -->
                        <div class="image-upload-area" id="uploadArea">
                            <i class="bi bi-cloud-upload upload-icon"></i>
                            <p class="upload-text">
                                <strong>Haz clic aquí</strong> o arrastra una imagen
                            </p>
                            <p class="upload-subtext">
                                PNG, JPG, JPEG hasta 5MB
                            </p>
                            <input type="file" 
                                   name="foto" 
                                   id="imageInput" 
                                   accept="image/png, image/jpeg, image/jpg"
                                   required>
                        </div>

                        <!-- Vista previa -->
                        <div class="image-preview-container" id="previewContainer">
                            <img id="imagePreview" class="image-preview" alt="Vista previa">
                            <button type="button" class="remove-image" onclick="removeImage()">
                                <i class="bi bi-trash"></i> Eliminar imagen
                            </button>
                        </div>

                        <div class="error-message">Por favor selecciona una imagen</div>
                    </div>
                </div>

                <!-- BOTONES DE ACCIÓN -->
                <div class="form-actions">
                    <a href="index.php" class="btn-cancel">
                        <i class="bi bi-x-circle"></i>
                        Cancelar
                    </a>
                    <input type="hidden" name="accion" value="Registrar">
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <i class="bi bi-check-circle" id="btnIcon"></i>
                        <span id="btnText">Registrar Producto</span>
                    </button>
                </div>

            </form>

        </div>

    </main>

    <!-- JAVASCRIPT -->
    <script>

    // VISTA PREVIA DE IMAGEN
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');

    // Click en área de subida
    uploadArea.addEventListener('click', () => imageInput.click());

    // Drag & Drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            previewImage(files[0]);
        }
    });

    // Cambio en input de archivo
    imageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            previewImage(e.target.files[0]);
        }
    });

    // Mostrar vista previa
    function previewImage(file) {
        // Validar tipo
        if (!file.type.match('image.*')) {
            alert('Por favor selecciona una imagen válida (PNG, JPG, JPEG)');
            return;
        }

        // Validar tamaño (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('La imagen es muy grande. Máximo 5MB');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            uploadArea.style.display = 'none';
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    // Eliminar imagen
    function removeImage() {
        imageInput.value = '';
        imagePreview.src = '';
        uploadArea.style.display = 'block';
        previewContainer.style.display = 'none';
    }

    // CONTADOR DE CARACTERES
    const titulo = document.getElementById('titulo');
    const tituloCount = document.getElementById('tituloCount');
    const descripcion = document.getElementById('descripcion');
    const descripcionCount = document.getElementById('descripcionCount');

    titulo.addEventListener('input', function() {
        const count = this.value.length;
        tituloCount.textContent = count;
        tituloCount.parentElement.className = 'char-counter';
        
        if (count > 80) {
            tituloCount.parentElement.classList.add('warning');
        }
        if (count > 95) {
            tituloCount.parentElement.classList.add('danger');
        }
    });

    descripcion.addEventListener('input', function() {
        const count = this.value.length;
        descripcionCount.textContent = count;
        descripcionCount.parentElement.className = 'char-counter';
        
        if (count > 400) {
            descripcionCount.parentElement.classList.add('warning');
        }
        if (count > 475) {
            descripcionCount.parentElement.classList.add('danger');
        }
    });

    // VALIDACIÓN DEL FORMULARIO
    const form = document.getElementById('productForm');
    const btnSubmit = document.getElementById('btnSubmit');

    form.addEventListener('submit', function(e) {
        let valid = true;

        // Limpiar errores previos
        document.querySelectorAll('.form-control').forEach(el => {
            el.classList.remove('error', 'success');
        });

        // Validar título
        if (titulo.value.trim() === '') {
            titulo.classList.add('error');
            valid = false;
        } else {
            titulo.classList.add('success');
        }

        // Validar descripción
        if (descripcion.value.trim() === '') {
            descripcion.classList.add('error');
            valid = false;
        } else {
            descripcion.classList.add('success');
        }

        // Validar categoría
        const categoria = document.getElementById('categoria_id');
        if (categoria.value === '') {
            categoria.classList.add('error');
            valid = false;
        } else {
            categoria.classList.add('success');
        }

        // Validar precio
        const precio = document.getElementById('precio');
        if (precio.value === '' || parseFloat(precio.value) <= 0) {
            precio.classList.add('error');
            valid = false;
        } else {
            precio.classList.add('success');
        }

        // Validar imagen
        if (imageInput.files.length === 0) {
            alert('Por favor selecciona una imagen del producto');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            // Scroll al primer error
            const firstError = document.querySelector('.form-control.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        } else {
            // Deshabilitar botón para evitar doble submit
            btnSubmit.disabled = true;
            document.getElementById('btnIcon').className = 'bi bi-hourglass-split';
            document.getElementById('btnText').textContent = 'Registrando...';
        }
    });

    // FORMATEO DE PRECIO
    const precioInput = document.getElementById('precio');
    precioInput.addEventListener('blur', function() {
        if (this.value !== '') {
            // Redondear a múltiplos de 100
            const valor = Math.round(this.value / 100) * 100;
            this.value = valor;
        }
    });

    // PREVENIR PÉRDIDA DE DATOS
    let formModified = false;
    form.addEventListener('input', () => formModified = true);

    window.addEventListener('beforeunload', (e) => {
        if (formModified) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    form.addEventListener('submit', () => formModified = false);
    </script>

</body>
</html>