<?php

namespace Controllers;

use Model\Evento;
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

        // Calcular los ingresos para mostrarlos en la vista
        $virtuales = Registro:: total('paquete_id', 2);
        $presenciales = Registro:: total('paquete_id', 1);

        $ingresos = ($virtuales * 46.98) + ($presenciales * 191.81);

        // Obtener eventos con mas y menos lugare disponibles
        $menos_disponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $mas_disponibles = Evento::ordenarLimite('disponibles', 'DESC', 5);

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'menos_disponibles' => $menos_disponibles,
            'mas_disponibles' => $mas_disponibles
        ]);
    }
}