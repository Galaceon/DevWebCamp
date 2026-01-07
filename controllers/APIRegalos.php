<?php

// API usada en el dashboard de admin, en el apartado de regalos, devuelve informacion al JS para que este muestre
// una grafica con los datos que hay en la tabla regalos de la DB

namespace Controllers;

use Model\Regalo;
use Model\Registro;

class APIRegalos {

    public static function index() {
        if(!is_admin()) {
            header('Location: /login');
            exit;
        }

        $regalos = Regalo::all();

        foreach($regalos as $regalo) {
            $regalo->total = Registro::totalArray(['regalo_id' => $regalo->id, 'paquete_id' => "1"]);
        }

        echo json_encode($regalos);
        return;
        
    }
}