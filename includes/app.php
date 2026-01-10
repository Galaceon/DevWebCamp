<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';

// Añadir Dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';


// Iniciar sesión con seguridad
require 'session.php';
require 'csrf.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);