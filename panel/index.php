<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Panel de Administración - Distribuidora Osvaldo">
  <meta name="author" content="Distribuidora Osvaldo">
  <meta name="robots" content="noindex, nofollow">

  <title>Admin Login - Distribuidora Osvaldo</title>
  <link rel="icon" href="../logoOsvaldo.jpg">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="../assets/css/admin-login.css">
</head>

<body>

  <div class="login-container">
    <div class="login-card">

      <!-- Header con Logo -->
      <div class="login-header">
        <div class="logo-container">
          <img src="../logoOsvaldo.jpg" alt="Distribuidora Osvaldo">
        </div>
        <h1 class="login-title">PANEL DE ADMINISTRACIÓN</h1>
        <p class="login-subtitle">Distribuidora Osvaldo</p>
      </div>

      <!-- Body del Formulario -->
      <div class="login-body">
        <p class="welcome-text">
          <i class="bi bi-shield-lock-fill"></i>
          Acceso Seguro
        </p>

        <?php
        // MENSAJES DE ERROR
        if (isset($_GET['error'])) {
          $error_message = '';
          $error_icon = 'bi-exclamation-triangle-fill';

          switch ($_GET['error']) {
            case 'invalid':
              $error_message = 'Usuario o contraseña incorrectos';
              if (isset($_GET['attempts']) && $_GET['attempts'] > 0) {
                $error_message .= '. Te quedan <strong>' . $_GET['attempts'] . '</strong> intento(s)';
              }
              break;

            case 'empty':
              $error_message = 'Por favor complete todos los campos';
              break;

            case 'short':
              $error_message = 'Usuario y contraseña deben tener al menos 3 caracteres';
              break;

            case 'blocked':
              $error_icon = 'bi-shield-x';
              $minutes = isset($_GET['minutes']) ? $_GET['minutes'] : 15;
              $error_message = 'Demasiados intentos fallidos. Por seguridad, espera <strong>' . $minutes . '</strong> minuto(s) antes de intentar nuevamente';
              break;

            case 'session':
              $error_icon = 'bi-clock-history';
              $error_message = 'Tu sesión ha expirado. Por favor inicia sesión nuevamente';
              break;

            case 'system':
              $error_icon = 'bi-exclamation-octagon';
              $error_message = 'Error del sistema. Por favor contacta al administrador';
              break;

            case 'method':
              $error_message = 'Método de acceso no permitido';
              break;

            default:
              $error_message = 'Error al iniciar sesión. Intenta nuevamente';
          }

          echo '<div class="alert alert-danger">';
          echo '<i class="bi ' . $error_icon . '"></i> ';
          echo $error_message;
          echo '</div>';
        }

        // MENSAJE DE LOGOUT EXITOSO
        if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
          echo '<div class="alert alert-success">';
          echo '<i class="bi bi-check-circle-fill"></i> ';
          echo 'Sesión cerrada correctamente. ¡Hasta pronto!';
          echo '</div>';
        }
        ?>

        <form action="login.php" method="post" id="loginForm">

          <!-- Usuario -->
          <div class="form-group">
            <label for="nombre_usuario">
              <i class="bi bi-person-fill"></i>
              Usuario
            </label>
            <div class="input-wrapper">
              <input type="text"
                class="form-control"
                id="nombre_usuario"
                name="nombre_usuario"
                placeholder="Ingrese su usuario"
                autocomplete="username"
                required
                autofocus
                minlength="3"
                maxlength="50">
              <i class="bi bi-person-circle input-icon"></i>
            </div>
          </div>

          <!-- Contraseña -->
          <div class="form-group">
            <label for="clave">
              <i class="bi bi-lock-fill"></i>
              Contraseña
            </label>
            <div class="input-wrapper">
              <input type="password"
                class="form-control"
                id="clave"
                name="clave"
                placeholder="Ingrese su contraseña"
                autocomplete="current-password"
                required
                minlength="3">
              <i class="bi bi-lock input-icon"></i>
              <button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>

          <!-- Recordarme / Olvidé contraseña -->
          <div class="remember-forgot">
            <label class="remember-me">
              <input type="checkbox" name="remember" id="remember">
              <span>Recordarme</span>
            </label>
            <a href="mailto:admin@distribuidoraosvaldo.com?subject=Recuperar%20Contraseña" class="forgot-password">
              ¿Olvidaste tu contraseña?
            </a>
          </div>

          <!-- Botón de Login -->
          <button type="submit" class="btn-login" id="btnLogin">
            <i class="bi bi-box-arrow-in-right"></i>
            Iniciar Sesión
          </button>

          <!-- Badges de Seguridad -->
          <div class="security-badges">
            <div class="security-badge">
              <i class="bi bi-shield-check"></i>
              <span>Conexión Segura</span>
            </div>
            <div class="security-badge">
              <i class="bi bi-lock-fill"></i>
              <span>Datos Protegidos</span>
            </div>
          </div>

        </form>
      </div>

      <!-- Footer -->
      <div class="login-footer">
        <p>
          &copy; <?php echo date('Y'); ?>
          <a href="../index.php">Distribuidora Osvaldo</a>.
          Todos los derechos reservados.
        </p>
      </div>

    </div>
  </div>

  <!-- JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {


      // TOGGLE PASSWORD VISIBILITY
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('clave');

      if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
          const type = passwordInput.type === 'password' ? 'text' : 'password';
          passwordInput.type = type;

          const icon = this.querySelector('i');
          icon.classList.toggle('bi-eye');
          icon.classList.toggle('bi-eye-slash');
        });
      }

      // VALIDACIÓN DEL FORMULARIO
      const loginForm = document.getElementById('loginForm');
      const btnLogin = document.getElementById('btnLogin');

      loginForm.addEventListener('submit', function(e) {
        const usuario = document.getElementById('nombre_usuario').value.trim();
        const clave = document.getElementById('clave').value;

        // Validar campos vacíos
        if (usuario === '' || clave === '') {
          e.preventDefault();
          showAlert('Por favor complete todos los campos', 'danger');
          return false;
        }

        // Validar longitud mínima
        if (usuario.length < 3 || clave.length < 3) {
          e.preventDefault();
          showAlert('Usuario y contraseña deben tener al menos 3 caracteres', 'danger');
          return false;
        }

        // Mostrar loading en el botón
        btnLogin.classList.add('loading');
        btnLogin.innerHTML = '';
      });

      // RECORDAR USUARIO
      const rememberCheckbox = document.getElementById('remember');
      const usuarioInput = document.getElementById('nombre_usuario');

      // Cargar usuario guardado
      const savedUsername = localStorage.getItem('admin_username');
      if (savedUsername) {
        usuarioInput.value = savedUsername;
        rememberCheckbox.checked = true;
      }

      // Guardar usuario si está marcado
      loginForm.addEventListener('submit', function() {
        if (rememberCheckbox.checked) {
          localStorage.setItem('admin_username', usuarioInput.value);
        } else {
          localStorage.removeItem('admin_username');
        }
      });


      // FUNCIÓN PARA MOSTRAR ALERTAS
      function showAlert(message, type) {
        // Remover alerta existente
        const existingAlert = document.querySelector('.alert');
        if (existingAlert && !existingAlert.classList.contains('alert-from-php')) {
          existingAlert.remove();
        }

        // Crear nueva alerta
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `<i class="bi bi-exclamation-triangle-fill"></i> ${message}`;

        // Insertar antes del formulario
        const loginBody = document.querySelector('.login-body');
        const welcomeText = document.querySelector('.welcome-text');
        loginBody.insertBefore(alert, welcomeText.nextSibling);

        // Auto-remover después de 5 segundos
        setTimeout(() => {
          alert.style.animation = 'slideDown 0.4s ease-out reverse';
          setTimeout(() => alert.remove(), 400);
        }, 5000);
      }

      // DETECTAR ENTER EN CAMPOS
      usuarioInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          passwordInput.focus();
        }
      });

      // ANIMACIÓN DE PARTÍCULAS
      
      function createParticle() {
        const particle = document.createElement('div');
        particle.style.position = 'fixed';
        particle.style.width = '4px';
        particle.style.height = '4px';
        particle.style.background = 'rgba(255, 255, 255, 0.5)';
        particle.style.borderRadius = '50%';
        particle.style.pointerEvents = 'none';
        particle.style.left = Math.random() * window.innerWidth + 'px';
        particle.style.top = '-10px';
        particle.style.zIndex = '1';

        document.body.appendChild(particle);

        const duration = Math.random() * 3000 + 2000;
        const animation = particle.animate([{
            transform: 'translateY(0px)',
            opacity: 1
          },
          {
            transform: `translateY(${window.innerHeight}px)`,
            opacity: 0
          }
        ], {
          duration: duration,
          easing: 'linear'
        });

        animation.onfinish = () => particle.remove();
      }

      // Crear partículas cada 300ms
      setInterval(createParticle, 300);

      // FOCUS AUTOMÁTICO
      if (usuarioInput.value === '') {
        usuarioInput.focus();
      } else {
        passwordInput.focus();
      }

      // LIMPIAR URL DESPUÉS DE 3 SEGUNDOS
      if (window.location.search) {
        setTimeout(function() {
          window.history.replaceState({}, document.title, window.location.pathname);
        }, 3000);
      }
    });
  </script>

</body>

</html>