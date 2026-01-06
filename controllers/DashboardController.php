<?php

namespace Controllers;

use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController {

    // Usado en la página /admin/dashboard, seria Inicio, justo al entrar al dashboard con cuenta de admin
    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }
        
        // Obtener últimos 5 registros (5 como maximo, ultimos usuarios registrados al evento)
        $registros = Registro::get(5);
        foreach($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'registros' => $registros
        ]);
    }
}