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

// Cargar producto
require '../../vendor/autoload.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = $_GET['id'];

  $producto = new distribuidoraOsvaldo\Producto;
  $resultado = $producto->mostrarPorId($id);

  if (!$resultado) {
    header('Location: index.php?error=not_found');
    exit;
  }
} else {
  header('Location: index.php');
  exit;
}

// Cargar categorías
$categoria = new distribuidoraOsvaldo\Categoria;
$info_categoria = $categoria->mostrar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Actualizar Producto - Distribuidora Osvaldo">
  <meta name="author" content="Distribuidora Osvaldo">

  <title>Actualizar Producto - Distribuidora Osvaldo</title>
  <link rel="icon" href="../../logoOsvaldo.jpg">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="../../assets/css/admin-dashboard.css">
  <link rel="stylesheet" href="../../assets/css/admin-updateprod.css">
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
          <h1 class="page-title">Actualizar Producto</h1>
          <div class="breadcrumb-custom">
            <i class="bi bi-house-door"></i>
            <a href="../dashboard.php">Inicio</a>
            <span>/</span>
            <a href="index.php">Productos</a>
            <span>/ Actualizar #<?php echo $resultado['id']; ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- FORMULARIO -->
    <div class="form-container">

      <form method="POST" action="../acciones.php" enctype="multipart/form-data" id="productForm">

        <!-- ID oculto -->
        <input type="hidden" name="id" value="<?php echo $resultado['id']; ?>">
        <input type="hidden" name="foto_temp" value="<?php echo $resultado['foto']; ?>">

        <!-- INFORMACIÓN BÁSICA -->
        <div class="form-card">
          <h2 class="form-section-title">
            <i class="bi bi-info-circle"></i>
            Información del Producto
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
              value="<?php echo htmlspecialchars($resultado['titulo']); ?>"
              maxlength="100"
              required>
            <div class="char-counter">
              <span id="tituloCount"><?php echo strlen($resultado['titulo']); ?></span>/100 caracteres
            </div>
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
              maxlength="500"
              required><?php echo htmlspecialchars($resultado['descripcion']); ?></textarea>
            <div class="char-counter">
              <span id="descripcionCount"><?php echo strlen($resultado['descripcion']); ?></span>/500 caracteres
            </div>
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
                  <option value="<?php echo $item['id']; ?>"
                    <?php echo $resultado['categoria_id'] == $item['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($item['nombre']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
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
                  value="<?php echo $resultado['precio']; ?>"
                  min="0"
                  step="100"
                  required>
              </div>
              <div class="help-text">Precio en pesos colombianos</div>
            </div>

          </div>
        </div>

        <!-- IMAGEN DEL PRODUCTO -->
        <div class="form-card">
          <h2 class="form-section-title">
            <i class="bi bi-image"></i>
            Imagen del Producto
          </h2>

          <!-- Imagen actual -->
          <div class="current-image-wrapper">
            <span class="current-image-label">Imagen Actual</span>
            <?php
            $foto_path = '../../upload/' . $resultado['foto'];
            if (!empty($resultado['foto']) && file_exists($foto_path)):
            ?>
              <img src="<?php echo $foto_path; ?>"
                alt="<?php echo htmlspecialchars($resultado['titulo']); ?>"
                class="current-image">
            <?php else: ?>
              <div class="no-current-image">
                <i class="bi bi-image"></i>
                <div>No hay imagen cargada</div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Alerta informativa -->
          <div class="alert-info">
            <i class="bi bi-info-circle-fill"></i>
            <div class="alert-info-text">
              <strong>Cambiar imagen (Opcional):</strong><br>
              Solo selecciona una nueva imagen si deseas reemplazar la actual.
              Si no seleccionas nada, se mantendrá la imagen existente.
            </div>
          </div>

          <!-- Nueva imagen -->
          <div class="form-group">
            <label class="form-label">
              Nueva Foto (Opcional)
            </label>

            <!-- Área de subida -->
            <div class="image-upload-area" id="uploadArea">
              <i class="bi bi-cloud-upload upload-icon"></i>
              <p class="upload-text">
                <strong>Haz clic aquí</strong> para cambiar la imagen
              </p>
              <p class="upload-subtext">
                PNG, JPG, JPEG hasta 5MB
              </p>
              <input type="file"
                name="foto"
                id="newImageInput"
                accept="image/png, image/jpeg, image/jpg">
            </div>

            <!-- Vista previa de nueva imagen -->
            <div class="image-preview-container" id="previewContainer">
              <img id="imagePreview" class="image-preview" alt="Vista previa">
              <button type="button" class="remove-image" onclick="removeNewImage()">
                <i class="bi bi-x-circle"></i> Cancelar cambio
              </button>
            </div>
          </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="form-actions">
          <a href="index.php" class="btn-cancel">
            <i class="bi bi-x-circle"></i>
            Cancelar
          </a>
          <input type="hidden" name="accion" value="Actualizar">
          <button type="submit" class="btn-submit" id="btnSubmit">
            <i class="bi bi-check-circle" id="btnIcon"></i>
            <span id="btnText">Actualizar Producto</span>
          </button>
        </div>

      </form>

    </div>

  </main>

  <!-- JAVASCRIPT -->
  <script>
    // VISTA PREVIA DE NUEVA IMAGEN
    const uploadArea = document.getElementById('uploadArea');
    const newImageInput = document.getElementById('newImageInput');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');

    // Click en área de subida
    uploadArea.addEventListener('click', () => newImageInput.click());

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
        newImageInput.files = files;
        previewImage(files[0]);
      }
    });

    // Cambio en input de archivo
    newImageInput.addEventListener('change', (e) => {
      if (e.target.files.length > 0) {
        previewImage(e.target.files[0]);
      }
    });

    // Mostrar vista previa
    function previewImage(file) {
      if (!file.type.match('image.*')) {
        alert('Por favor selecciona una imagen válida (PNG, JPG, JPEG)');
        return;
      }

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

    // Cancelar cambio de imagen
    function removeNewImage() {
      newImageInput.value = '';
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

      if (count > 80) tituloCount.parentElement.classList.add('warning');
      if (count > 95) tituloCount.parentElement.classList.add('danger');
    });

    descripcion.addEventListener('input', function() {
      const count = this.value.length;
      descripcionCount.textContent = count;
      descripcionCount.parentElement.className = 'char-counter';

      if (count > 400) descripcionCount.parentElement.classList.add('warning');
      if (count > 475) descripcionCount.parentElement.classList.add('danger');
    });

    
    // VALIDACIÓN DEL FORMULARIO
    const form = document.getElementById('productForm');
    const btnSubmit = document.getElementById('btnSubmit');

    form.addEventListener('submit', function(e) {
      // Validaciones básicas (HTML5 se encarga)
      // Solo mostramos loading
      btnSubmit.disabled = true;
      document.getElementById('btnIcon').className = 'bi bi-hourglass-split';
      document.getElementById('btnText').textContent = 'Actualizando...';
    });

    // FORMATEO DE PRECIO
    const precioInput = document.getElementById('precio');
    precioInput.addEventListener('blur', function() {
      if (this.value !== '') {
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