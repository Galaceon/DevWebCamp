<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';

// Añadir Dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';


// Iniciar sesión con seguridad (lo agregamos aquí)
require 'session.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);