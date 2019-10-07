<?php
require_once "controladores/plantilla.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/slide.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/carrito.controlador.php";

require_once "modelos/plantilla.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/slide.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/carrito.modelo.php";

require_once "modelos/rutas.php";

require_once "PHPMailer/PHPMailerAutoload.php";

//Biblioteca para leer variables de entorno de archivo
require('../vendor/autoload.php');

/*========================================
    CARGA DE VARIABLES DE ENTORNO
========================================*/
if (file_exists(__DIR__.'/../.env')){
	$dotenv = Dotenv\Dotenv::create('../');
	$dotenv->overload();
}
print_r($dotenv);

$template = new ControladorPlantilla();
$template -> plantilla();



?>
