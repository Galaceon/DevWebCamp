<?php

namespace Controllers;

use Model\Registro;
use MVC\Router;

class RegistroController {

    public static function crear(Router $router) {


        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis() {

        if($_SERVER['REQUEST_METHOD']) {
            if(!is_auth()) {
                header('Location: /');
                exit;
            }
            
            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            // Crear Registro
            $datos = [
                'paquete_id' => 3, // En la DB, el pase gratis tiene id 3
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            
            if($resultado) {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }
        }
    }
}