<?php

namespace MVC;

class Router
{
    // [
    //     '/admin/eventos' => [EventosController::class, 'index']
    // ]
    public array $getRoutes = [];

    // [
    //     '/registro' => [AuthController::class, 'registro']
    // ]
    public array $postRoutes = [];


    // $router->get('/login', [AuthController::class, 'login']);
    // $this->getRoutes['/login'] === [AuthController::class, 'login']
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    // $router->post('/registro', [AuthController::class, 'registro']);
    // $this->postRoutes['/registro'] === [AuthController::class, 'registro']
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }


    // Comprueba la ruta actual y ejecuta el handler adecuado.

    // Ejemplo de valores durante una petición:
    // $_SERVER['PATH_INFO'] = '/admin/eventos'
    // $_SERVER['REQUEST_METHOD'] = 'GET'

    // Entonces: $url_actual = '/admin/eventos', $method = 'GET'

    // $fn será obtenido como $this->getRoutes['/admin/eventos'] (p.ej. [EventosController::class, 'index'])
    // Si $fn existe se ejecuta: call_user_func($fn, $this)

    // (el handler normalmente es un método de un controller que recibe $router para poder llamar a render)

    // Si no existe, redirige a '/404'.
    public function comprobarRutas()
    {

        // Ruta solicitada por el cliente (p.ej. '/admin/eventos')
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';

        // Método HTTP usado en la petición (GET o POST)
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            // Busca en el array de rutas GET
            $fn = $this->getRoutes[$url_actual] ?? null; // $thises router
        } else {
            // Busca en el array de rutas POST
            $fn = $this->postRoutes[$url_actual] ?? null; // $this es router
        }

        if ( $fn ) {
            // Ejemplo: si $fn === [EventosController::class, 'index']
            // esto ejecuta EventosController::index($this)
            call_user_func($fn, $this);
        } else {
            // Si no hay ruta definida para esta URL/método -> redirige a 404
            header('Location: /404');
        }
    }

    // Renderiza una vista dentro del layout correspondiente.
    // Ejemplo de uso:
    // $view = 'paginas/index'
    // $datos = ['titulo' => 'Inicio', 'eventos' => $eventosArray]
    // Después del foreach, estarán disponibles las variables $titulo y $eventos dentro de la vista.
    public function render($view, $datos = [])
    {
        // Convierte $datos en variables sueltas para la vista.
        // Si $datos = ['titulo' => 'Inicio'] entonces tras esto existe la variable $titulo con valor 'Inicio'.
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        // Inicia buffer para capturar la salida de la vista
        ob_start();

        // Incluye la vista que genera HTML (p.ej. views/paginas/index.php)
        include_once __DIR__ . "/views/$view.php";

        // Guarda el HTML generado de la vista en $contenido y limpia el buffer
        $contenido = ob_get_clean(); // Limpia el Buffer

        // Elegir layout según la URL actual
        // Si la URL contiene '/admin' usa el layout de admin, si no usa el layout público.
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        if(str_contains($url_actual, '/admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
