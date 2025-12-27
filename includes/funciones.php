<?php

// Muestra información estructurada de una variable
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa el HTML especial para evitar ataques XSS
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Comprueba que la página actual(url) sea igual a la pasada como parámetro en $path
function pagina_actual($path) {
    return isset($_SERVER['PATH_INFO']) && str_contains($_SERVER['PATH_INFO'], $path);
}

// Verifica si el usuario está autenticado
function is_auth() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

// Verifica si el usuario es administrador
function is_admin() {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && (int) $_SESSION['admin'] === 1;
}