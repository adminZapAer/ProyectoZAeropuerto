<?php

// use SoapClient;

require_once __DIR__ . "/../modelos/productos.modelo.php";
require_once __DIR__ . "/../modelos/usuarios.modelo.php";
require_once __DIR__ . "/../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (file_exists(__DIR__ . "/../../.env")) {
        $dotenv = Dotenv\Dotenv::create(__DIR__ . "/../../");
        $dotenv->overload();
    }

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        print_r(0);
        return false;
    }

    // SI EL ENVÍO ES ENTREGA PERSONAL
    if (isset($_GET['direccionId']) && $_GET['direccionId'] == "no") {
        print_r(0);
        return false;
    }

    $cantidad = $_GET['cantidad'];

    $id = $_GET['id'];
    $idUsuario = $_SESSION["idUsuario"];

    if (empty($_GET['direccionId'])) {
        $direcciones = \ModeloUsuarios::mdlMostrarDirecciones('direccion', $idUsuario);
    } else {
        $direcciones = \ModeloUsuarios::mdlMostrarDireccion('direccion', $idUsuario, $_GET['direccionId']);
    }

    if (empty($direcciones) || !count($direcciones)) {
        print_r(0);
        return false;
    }

    $producto = \ModeloProductos::mdlGetProducto($id);

    $opts = array(
        'http' => array(
            'header' => 'Content-Type:application/xml;charset=utf-8',
            'user_agent' => 'PHPSoapClient'
        )
    );

    $params = array(
        'encoding' => 'UTF-8',
        'verifypeer' => false,
        'verifyhost' => false,
        'soap_version' => SOAP_1_2,
        'trace' => 1,
        'exceptions' => 1,
        'connection_timeout' => 5000,
        'stream_context' => stream_context_create($opts)
    );

    $url = "http://frecuenciacotizador.estafeta.com/Service.asmx?wsdl";

    $client = new SoapClient($url, $params);


    // // dd($client->__getFunctions());
    // // dd($client->__getTypes());
    // // dd($client->__getLastResponseHeaders());

    $response = $client->FrecuenciaCotizador([
        'idusuario' => 1,
        'usuario' => 'AdminUser',
        'contra' => ',1,B(vVi',
        'esFrecuencia' => false,
        'esLista' => true,
        'tipoEnvio' =>
        [
            'EsPaquete' => true,
            'Largo' => $producto['largo'],
            'Peso' => $producto['peso'],
            'Alto' => $producto['alto'],
            'Ancho' => $producto['ancho'],
        ],
        'datosOrigen' => ['56200'],
        'datosDestino' => [end($direcciones)['cp']],
    ]);

    echo json_encode((float) $response->FrecuenciaCotizadorResult->Respuesta->TipoServicio->TipoServicio[2]->CostoTotal * (int) $cantidad);

}
