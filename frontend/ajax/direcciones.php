<?php

// use SoapClient;

require_once __DIR__ . "/../modelos/productos.modelo.php";
require_once __DIR__ . "/../modelos/usuarios.modelo.php";
require_once __DIR__ . "/../../vendor/autoload.php";

if($_SERVER['REQUEST_METHOD'] === "GET"){

    session_start();

    if(!isset($_SESSION['idUsuario'])){
        print_r(json_encode([
            'error' => '
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    Para que la compra sea enviada a su domicilio es necesario <a href="#modalIngreso" data-toggle="modal">Iniciar Sesión</a> o <a href="#modalRegistro" data-toggle="modal">Registrarse</a>
                </div>
            </div>
            '
        ]));
        /*print_r(json_encode([
            'error' => 'Para que la compra sea enviada a su domicilio es necesario <a href="#modalIngreso" data-toggle="modal">Iniciar Sesión</a> o <a href="#modalRegistro" data-toggle="modal">Registrarse</a>'
        ]));*/
        return false;
    }

    $idUsuario = $_SESSION['idUsuario'];
    $direcciones = $direcciones = \ModeloUsuarios::mdlMostrarDirecciones('direccion',$idUsuario);

    if(is_null($direcciones) || !count($direcciones)){
        print_r(json_encode([
            'error' => 'No cuentas con ningúna dirección para cotizar el envío. Ve a la sección <a href="'.$url.'direcciones"><i class="fa fa-map-marker"></i> Dirección de Envío</a> y registra una dirección'
        ]));
        return false;
    }

    print_r(json_encode([
        'direcciones' => $direcciones,
    ]));
    return false;
}
?>
