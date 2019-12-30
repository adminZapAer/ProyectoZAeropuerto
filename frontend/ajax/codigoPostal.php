<?php

// use SoapClient;

require_once __DIR__ . "/../modelos/codigos_postales.modelo.php";
require_once __DIR__ . "/../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $cp = $_GET['cp'];

    if (file_exists(__DIR__ . "/../../.env")) {
        $dotenv = Dotenv\Dotenv::create(__DIR__ . "/../../");
        $dotenv->overload();
    }

    $direccion = \ModeloCodigosPostales::mdlMostrarDireccion('codigo_postal', 'codigo_postal', $cp);

    if (empty($direccion)) {
        echo json_encode(array(
            'status' => 'empty',
            'direccion' => null,
        ));
        return false;
    }

    echo json_encode(array(
        'status' => 'success',
        'direccion' => $direccion
    ));


    return false;
}
