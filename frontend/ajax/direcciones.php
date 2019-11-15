<?php

// use SoapClient;

require_once __DIR__ . "/../modelos/productos.modelo.php";
require_once __DIR__ . "/../modelos/usuarios.modelo.php";
require_once __DIR__ . "/../../vendor/autoload.php";

if($_SERVER['REQUEST_METHOD'] === "GET"){

    session_start();

    if(!isset($_SESSION['idUsuario'])){
        print_r(json_encode([
            'error' => 'Para cotizar el envío, es necesario iniciar sesión'
        ]));
        return false;
    }

    $idUsuario = $_SESSION['idUsuario'];
    $direcciones = $direcciones = \ModeloUsuarios::mdlMostrarDirecciones('direccion',$idUsuario);

    if(is_null($direcciones) || !count($direcciones)){
        print_r(json_encode([
            'error' => 'No cuentas con ningúna dirección para cotizar el envío.'
        ]));
        return false;
    }

    print_r(json_encode([
        'direcciones' => $direcciones,
    ]));
    return false;
}