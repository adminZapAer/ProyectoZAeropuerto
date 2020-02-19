<?php

require_once "../../vendor/paypal/paypal-checkout-sdk/samples/CaptureIntentExamples/CreateOrder.php";
require_once '../../vendor/autoload.php';
require_once __DIR__ . "/../PHPMailer/PHPMailerAutoload.php";
require_once __DIR__ . '/../modelos/productos.modelo.php';
require_once __DIR__ . '/../modelos/compras.modelo.php';
require_once __DIR__ . '/../modelos/usuarios.modelo.php';

use Sample\CaptureIntentExamples\CreateOrder;
use Sample\CaptureIntentExamples\CaptureOrder;

$dotenv = Dotenv\Dotenv::create('../../');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === "POST"){

    $detalles = $_POST['detalles'];
    print_r($detalles);
    $detalles = $_POST['detalles'];
    $items = $_POST['items'];
    $usuarioId = $_POST['usuario'];

    // print_r($usuarioId);
    // return false;

    /**
     * =============================
     * GUARDAMOS LA COMPRA REALIZADA
     * =============================
     */

    if( $detalles['transaction']['status'] == 'DONE' ){

        $datosCompra = [
			'idUsuario' => (int)$usuarioId,
			'metodo' => 'netpay',
			'envio' => 0,
			'costo_envio' => 200,
			'direccion' => 'Matagalpa',
			'pais' => 'México',
			'fecha' => date('Y-m-d'),
			'statusCompraId' => 1 // en espera
		];
		$compra = ModeloCompras::mdlAgregarCompra('compras', $datosCompra);


    }

    /**
     * =======================
     * 
     * =======================
     */

    return false;

}