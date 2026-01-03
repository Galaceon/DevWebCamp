<?php

namespace Controllers;

use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController {

    public static function crear(Router $router) {
        if(!is_auth()) {
            header('Location: /');
            exit;
        }

        // Verificar si el usuario ya esta registrado (si ya eligió un plan)
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === "3") {
            header('Location: /boleto?id=' . urlencode($registro->token));
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /');
                exit;
            }

            // Verificar si el usuario ya esta registrado
            // (Si ya eligió un plan. Verificacion solo para gratis, pagar no la tendra por si el usuario quiere cambiar de plan posteriormente)
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urlencode($registro->token));
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

    public static function boleto(Router $router) {
        // Validar la URL
        $id = $_GET['id'];

        // Validar que hay un $id en la url y que su extension sea de 8
        if(!$id || strlen($id) !== 8) {
            header('Location: /');
            exit;
        }

        // Buscarlo en la DB
        $registro = Registro::where('token', $id);
        if(!$registro) {
            header('Location: /');
            exit;
        }

        // Llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

    public static function pagar() {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /');
                exit;
            }

            // Validar que POST no venga vacio
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }

            // Crear Registro
            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }
}