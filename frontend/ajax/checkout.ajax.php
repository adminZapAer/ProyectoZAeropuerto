<?php

require_once "../../vendor/paypal/paypal-checkout-sdk/samples/CaptureIntentExamples/CreateOrder.php";
require_once '../../vendor/autoload.php';
use Sample\CaptureIntentExamples\CreateOrder;
use Sample\CaptureIntentExamples\CaptureOrder;

$dotenv = Dotenv\Dotenv::create('../../');
$dotenv->load();

class AjaxCheckout{
    
    /*========================================
    *        VALIDAR CORREO EXISTENTE        *
    ========================================*/
    public $validarEmail;
    
    public function ajaxValidarEmail(){
        
        $datos = $this->validarEmail;
        
        $respuesta = ControladorUsuarios::ctrMostrarUsuario("email", $datos);
        
        echo json_encode($respuesta);
        
    }
    
    /*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/	

	public $idUsuario;
	public $idProducto;
    
    //Creamos el metodo agregar deseo
	public function ajaxAgregarDeseo(){
        //Creamos el objeto donde almacenaremos los datos que vienen de js
		$datos = array("idUsuario"=>$this->idUsuario,
					   "idProducto"=>$this->idProducto);
        
        //Mandamos a llamar al controlador agregar deseo y enviaremos un dato, solicitando una respuesta.
        
		$respuesta = ControladorUsuarios::ctrAgregarDeseo($datos);

		echo $respuesta;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/

	public $idDeseo;	

	public function ajaxQuitarDeseo(){

		$datos = $this->idDeseo;

		$respuesta = ControladorUsuarios::ctrQuitarDeseo($datos);

		echo $respuesta;

	}
    
}

/*========================================
*        CREAR ORDEN DE COMPRA           *
========================================*/
if($_SERVER['REQUEST_METHOD'] === "POST"){
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