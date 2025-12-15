<?php

namespace Controllers;

use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Ponente;
use MVC\Router;

class PonentesController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/ponentes?page=1');
        }
        $registros_por_pagina = 10;
        $total = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);


        $ponentes = Ponente::all();

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes
        ]);
    }

    public static function crear(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }

        $alertas = [];
        $ponente =  new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                exit;
            }
            // Leer Imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            }
            // Convertir el array de redes a string con json (siendo un array sincronizar() no funcionaria)
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            // Sincronizo el objeto modelo de Ponente con los datos que vienen en el POST
            $ponente->sincronizar($_POST);

            // Validar
            $alertas = $ponente->validar();

            // Guardar el Registro
            if(empty($alertas)) {

                // Guardar las imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                // Guardar en la DB
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }
        
        $redes = json_decode($ponente->redes);

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }

        $alertas = [];
        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/ponentes');
        }

        // Obtener ponente a Editar
        $ponente = Ponente::find($id);

        if(!$ponente) {
            header('Location: /admin/ponentes');
        }

        $ponente->imagen_actual = $ponente->imagen;

        $redes = json_decode($ponente->redes);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
                exit;
            }

            // Leer Imagen
            if(!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/speakers';

                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }

            // Convertir el array de redes a string con json (siendo un array sincronizar() no funcionaria)
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    // Guardar las imagenes
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                $resultado = $ponente->guardar();

                if($resultado) {
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Actualizar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function eliminar() {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $ponente = Ponente::find($id);

            if(!isset($ponente)) {
                header('Location: /admin/ponentes');
            }

            $resultado  = $ponente->eliminar();

            if($resultado) {
                header('Location: /admin/ponentes');
            }

            debuguear($ponente);
        }
    }
}