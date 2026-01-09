<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\EventosRegistros;
use Model\Hora;
use Model\Paquete;
use Model\Ponente;
use Model\Regalo;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController {

    public static function crear(Router $router) {
        if(!is_auth()) {
            header('Location: /');
            exit;
        }

        // Verificar si el usuario ya esta registrado (si ya eligió un plan), si eligio el plan GRATIS lo redirige
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if(isset($registro) && ($registro->paquete_id === "3" || $registro->paquete_id === "2")) {
            header('Location: /boleto?id=' . urlencode($registro->token));
            exit;
        }

        // Verificar si el usuario ya eligió un plan PRESENCIAL( ya pagó ), si es así lo redirige a la selección de conferencias
        // al mismo tiempo que la selección de conferencias redirige al boleto si ya finalizó su registro de eventos
        if(isset($registro) && $registro->paquete_id === "1") {
            header('Location: /finalizar-registro/conferencias');
            exit;
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
                exit;
            }
        }
    }

    public static function boleto(Router $router) {
        if(!is_auth()) {
            header('Location: /');
            exit;
        }

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

        // Verificar que el token del registro( regitrado en el evento, no de sesion ) coincide con el token de la sesion iniciada
        $usuario = Usuario::where('id', $_SESSION['id']);
        $registroUsuario = Registro::where('usuario_id', $usuario->id);
        if($registroUsuario->token !== $registro->token) {
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

    public static function conferencias(Router $router) {
        // Validar login
        if(!is_auth()) {
            header('Location: /login');
            exit;
        }

        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);

        // Redireccionar a boleto en caso de haber finalizado su registro de tipo presencial
        if(isset($registro) && $registro->paquete_id === "2") {
            header('Location: /boleto?id=' . urlencode($registro->token));
            exit;
        }

        // Validar que el usuario tenga el plan presencial
        if($registro->paquete_id !== "1") {
            header('Location: /');
            exit;
        }

        // Redireccionar a boleto virtual en caso de haber finalizado su registro
        if(isset($registro->regalo_id) && $registro->paquete_id === "1") {
            header('Location: /boleto?id=' . urlencode($registro->token));
            exit;
        }

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            if($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }

            if($evento->dia_id === "3" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_d'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }

            if($evento->dia_id === "3" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_d'][] = $evento;
            }
        }

        $regalos = Regalo::all('ASC');

        // Manejando el registro de eventos mediante $_POST
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /');
                exit;
            }

            // Separamos el string de IDs de eventos a IDs separados
            $eventos = explode(',', $_POST['eventos']);

            // Si aqui llega un array de eventos vacios devolvemos false hacia el JS
            if(empty($eventos)) {
                echo json_encode(['resultado' => false]);
                return;
            }

            // Obtener el registro de usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            // Si no existe el registro o el paquete no es presencial, devolvemos false
            if(!isset($registro) || $registro->paquete_id !== "1") {
                echo json_encode(['resultado' => false]);
                return;
            }


            $eventos_array = [];

            // Validar la disponibilidad de los eventos seleccionados
            foreach($eventos as $evento_id) {
                $evento = Evento::find($evento_id);

                // Comprobar que el evento exista
                if(!isset($evento) || $evento->disponibles === "0") {
                    echo json_encode(['resultado' => false]);
                    return;
                }

                $eventos_array[] = $evento;
            }

            foreach($eventos_array as $evento) {
                $evento->disponibles -= 1;
                $evento->guardar();

                // Almacenar el registro y el evento
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_usuario = new EventosRegistros($datos);
                $registro_usuario->guardar();
            }
            
            // Almacenar el regalo
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();

            // Si todo salio bien devolver respuesta JSON al JS
            if($resultado) {
                echo json_encode([
                    'resultado' => $resultado, 
                    'token' => $registro->token
                ]);
            } else {
                echo json_encode(['resultado' => false]);
                return;
            }

            // return para que no haga render a la vista, en este proceso $_POST no es lo que queremos
            return;
        }

        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
    }
}