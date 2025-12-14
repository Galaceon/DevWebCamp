<?php

namespace Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Model\Ponente;
use MVC\Router;

class PonentesController {

    public static function index(Router $router) {


        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas'
        ]);
    }

    public static function crear(Router $router) {
        $alertas = [];
        $ponente =  new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer Imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp$imagen_webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            }

            $ponente->sincronizar($_POST);

            // Validar
            $alertas = $ponente->validar();

            // Guardar el Registro
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente
        ]);
    }
}