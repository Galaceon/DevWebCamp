<?php
// Detectar si estamos en local o en producción para configurar 'secure'
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') === 0);

$isSecure = !$isLocal && ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443);

// Configurar cookie de sesión segura
session_set_cookie_params([
    'lifetime' => 0,          // La sesión dura mientras esté abierto el navegador
    'path' => '/',
    'domain' => '',           // Vacío = dominio actual
    'secure' => $isSecure,    // Solo enviar cookie en HTTPS (true en producción)
    'httponly' => true,       // Cookie inaccesible desde JavaScript
    'samesite' => 'Lax'       // Evitar ataques CSRF, puedes usar 'Strict' si quieres más seguridad
]);

// Luego inicias la sesión
session_start();