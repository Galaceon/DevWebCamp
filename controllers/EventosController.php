<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Hora;
use MVC\Router;

class EventosController {
    public static function index(Router $router) {


        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops'
        ]);
    }

    public static function crear(Router $router) {
        $alertas = [];

        $categotias = Categoria::all();
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $router->render('admin/eventos/crear', [
            'titulo' => 'Crear Eventos',
            'alertas'=> $alertas,
            'categorias' => $categotias,
            'dias' => $dias,
            'horas' => $horas
        ]);
    }
}