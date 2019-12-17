<?php

// use SoapClient;

require_once __DIR__ . "/../modelos/productos.modelo.php";
require_once __DIR__ . "/../modelos/usuarios.modelo.php";
require_once __DIR__ . "/../../vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    // $envio = array(
    //     'costoEnvio' => 0,
    //     'origen' => 'planta',
    // );

    // echo json_encode($envio);
    // return false;
    
    if (file_exists(__DIR__ . "/../../.env")) {
        $dotenv = Dotenv\Dotenv::create(__DIR__ . "/../../");
        $dotenv->overload();
    }

    session_start();

    if (!isset($_SESSION['idUsuario'])) {
        $envio = array(
            'costoEnvio' => 0,
            'origen' => '',
        );
    
        echo json_encode($envio);
        return false;
    }

    // SI EL ENVÍO ES ENTREGA PERSONAL
    if (isset($_GET['direccionId']) && $_GET['direccionId'] == "no") {
        $envio = array(
            'costoEnvio' => 0,
            'origen' => '',
        );
    
        echo json_encode($envio);
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
        $envio = array(
            'costoEnvio' => 0,
            'origen' => '',
        );
    
        echo json_encode($envio);
        return false;
    }

    $producto = \ModeloProductos::mdlGetProducto($id);

    // print_r('PRODUCTOS SOLICITADOS ' . $cantidad . ' PRODUCTOS EN STOCK' . $producto['stock']);
    // return false;

    if ($producto['stock'] - $cantidad < 0) {
        // 32500
        $cpOrigen = '78390'; // CODIGO POSTAL DE PLANTA
        $origen = 'planta';
    } else {
        $cpOrigen = '56200'; // CODIGO POSTAL DE ZAPATA
        $origen = 'zapata';
    }
    // return false;




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

    $response = $client->frecuenciacotizador([
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
        'datosOrigen' => [$cpOrigen],
        'datosDestino' => [end($direcciones)['cp']],
    ]);

    // print_r(end($direcciones)['cp']);
    // return false;

    // print_r('PESO: ' . $producto['peso']);
    // print_r(' LARGO: ' . $producto['largo']);
    // print_r(' ALTO: ' .  $producto['alto']);
    // print_r(' ANCHO: ' . $producto['ancho']);
    // print_r(' CP: ' . end($direcciones)['cp'] ." " );
    // return false;
    // print_r($producto['peso']);
    // return false;

    // print_r($producto['alto']);
    // return false;

    // print_r($producto['ancho']);
    // return false;

    // print_r(end($direcciones));
    // return false;

    // print_r($response->FrecuenciaCotizadorResult->Respuesta->TipoServicio);
    // return false;

    $costoEnvio =  $response
        ->FrecuenciaCotizadorResult
        ->Respuesta
        ->TipoServicio
        ->TipoServicio[2]
        ->CostoTotal;

    $costoEnvio = $costoEnvio  * (int) $cantidad;
    $costoEnvio = (float) $costoEnvio;
    $costoEnvio = round($costoEnvio, 2);

    $envio = array(
        'costoEnvio' => $costoEnvio,
        'origen' => $origen,
    );

    echo json_encode($envio);
}
