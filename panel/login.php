<?php

// Iniciar sesión
session_start();

// Configuración de seguridad
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?error=method');
    exit;
}

// Validar que vengan los campos
if (!isset($_POST['nombre_usuario']) || !isset($_POST['clave'])) {
    header('Location: index.php?error=empty');
    exit;
}

// Sanitizar inputs
$nombre_usuario = trim($_POST['nombre_usuario']);
$clave = $_POST['clave']; // No trimear password por seguridad

// Validar campos vacíos
if (empty($nombre_usuario) || empty($clave)) {
    header('Location: index.php?error=empty');
    exit;
}

// Validar longitud mínima
if (strlen($nombre_usuario) < 3 || strlen($clave) < 3) {
    header('Location: index.php?error=short');
    exit;
}

// Protección contra inyección SQL básica
$caracteres_prohibidos = array("'", '"', ';', '--', '/*', '*/', 'xp_', 'sp_', 'exec', 'execute');
foreach ($caracteres_prohibidos as $caracter) {
    if (stripos($nombre_usuario, $caracter) !== false) {
        header('Location: index.php?error=invalid');
        exit;
    }
}

// Limitar intentos de login
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Resetear intentos después de 15 minutos
if (time() - $_SESSION['last_attempt_time'] > 900) { // 900 segundos = 15 minutos
    $_SESSION['login_attempts'] = 0;
}

// Bloquear después de 5 intentos
if ($_SESSION['login_attempts'] >= 5) {
    $tiempo_restante = 900 - (time() - $_SESSION['last_attempt_time']);
    $minutos_restantes = ceil($tiempo_restante / 60);
    header('Location: index.php?error=blocked&minutes=' . $minutos_restantes);
    exit;
}

try {
    // Cargar autoloader
    require '../vendor/autoload.php';

    // Crear instancia del modelo Usuario
    $usuario = new distribuidoraOsvaldo\Usuario;
    
    // Intentar login
    $resultado = $usuario->login($nombre_usuario, $clave);

    if ($resultado) {

        // LOGIN EXITOSO
        
        // Resetear intentos
        $_SESSION['login_attempts'] = 0;
        
        // Regenerar ID de sesión (prevenir session fixation)
        session_regenerate_id(true);
        
        // Guardar información del usuario
        $_SESSION['usuario_info'] = array(
            'id' => $resultado['id'] ?? null,
            'nombre_usuario' => $resultado['nombre_usuario'],
            'nombre' => $resultado['nombre'] ?? $nombre_usuario,
            'email' => $resultado['email'] ?? null,
            'rol' => $resultado['rol'] ?? 'admin',
            'estado' => 1,
            'login_time' => time(),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        );
        
        // Opcional: Guardar token de sesión
        $_SESSION['token'] = bin2hex(random_bytes(32));
        
        // Opcional: Log de acceso exitoso
        $log_file = '../logs/access.log';
        if (is_writable(dirname($log_file))) {
            $log_entry = date('Y-m-d H:i:s') . " - LOGIN EXITOSO - Usuario: {$nombre_usuario} - IP: {$_SERVER['REMOTE_ADDR']}\n";
            @file_put_contents($log_file, $log_entry, FILE_APPEND);
        }
        
        // Verificar si quiere ser recordado
        if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
            // Crear cookie segura (30 días)
            $token = bin2hex(random_bytes(32));
            setcookie(
                'remember_token',
                $token,
                time() + (30 * 24 * 60 * 60), // 30 días
                '/',
                '',
                true, // Solo HTTPS
                true  // Solo HTTP (no JavaScript)
            );
            
            // Aquí deberías guardar el token en la BD
            // Para este ejemplo, lo guardamos en sesión
            $_SESSION['remember_token'] = $token;
        }
        
        // Redirigir al dashboard con mensaje de éxito
        header('Location: dashboard.php?welcome=true&user=' . urlencode($nombre_usuario));
        exit;
        
    } else {
    
        // LOGIN FALLIDO
        
        // Incrementar intentos
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        
        // Opcional: Log de intento fallido
        $log_file = '../logs/failed_logins.log';
        if (is_writable(dirname($log_file))) {
            $log_entry = date('Y-m-d H:i:s') . " - INTENTO FALLIDO - Usuario: {$nombre_usuario} - IP: {$_SERVER['REMOTE_ADDR']} - Intentos: {$_SESSION['login_attempts']}\n";
            @file_put_contents($log_file, $log_entry, FILE_APPEND);
        }
        
        // Calcular intentos restantes
        $intentos_restantes = 5 - $_SESSION['login_attempts'];
        
        // Redirigir con error
        if ($intentos_restantes > 0) {
            header('Location: index.php?error=invalid&attempts=' . $intentos_restantes);
        } else {
            header('Location: index.php?error=blocked&minutes=15');
        }
        exit;
    }
    
} catch (Exception $e) {
    
    // Log del error
    $error_log = '../logs/errors.log';
    if (is_writable(dirname($error_log))) {
        $error_entry = date('Y-m-d H:i:s') . " - ERROR: " . $e->getMessage() . " - Usuario: {$nombre_usuario}\n";
        @file_put_contents($error_log, $error_entry, FILE_APPEND);
    }
    
    // Redirigir con error genérico (no revelar detalles del error)
    header('Location: index.php?error=system');
    exit;
}

// Si llegamos aquí, algo salió mal
header('Location: index.php?error=unknown');
exit;
?>