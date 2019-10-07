<?php

require_once "../../vendor/paypal/paypal-checkout-sdk/samples/CaptureIntentExamples/CreateOrder.php";
require_once '../../vendor/autoload.php';
use Sample\CaptureIntentExamples\CreateOrder;
use Sample\CaptureIntentExamples\CaptureOrder;

$dotenv = Dotenv\Dotenv::create('../../');
$dotenv->load();

class AjaxCheckout{
    
    /*=============================================
	AGREGAR COMPRA A BD
	=============================================*/	

	public $idUsuario;
	public $idProducto;
    
    //Creamos el metodo agregar deseo
	public function ajaxAgregarCompra($detalles){
        echo json_encode($detalles);

		return;

	}
    
}

/*========================================
*        CREAR ORDEN DE COMPRA           *
========================================*/
if($_SERVER['REQUEST_METHOD'] === "POST"){
	$ajaxCheckout = new AjaxCheckout();

	if ($_POST['detalles']) {
		$ajaxCheckout->ajaxAgregarCompra($_POST['detalles']);

	} else {
		/*========================================
    	*        CREAR ORDEN DE COMPRA           *
    	========================================*/

		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$order = CreateOrder::createOrder(false, $data);
		// echo print_r($order);
		// return false;
	    //print "Creating Order...\n";
		$orderId = "";
		if ($order->statusCode == 201)
		{
		    echo json_encode($order, JSON_PRETTY_PRINT);
		    return $order;
		}
		else {
			return json_encode(['error'=>$order]);
		}
	}
}

   
/*

[0] => Array
        (
            [idProducto] => 4
            [titulo] => Manguera para unidad O500
            [precio] => 469.23
            [tipo] => fisico
            [cantidad] => 2
        )


*/

?>