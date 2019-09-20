<?php

require_once "../../vendor/paypal/paypal-checkout-sdk/samples/CaptureIntentExamples/CreateOrder.php";
use Sample\CaptureIntentExamples\CreateOrder;
use Sample\CaptureIntentExamples\CaptureOrder;

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
if(isset($_POST)){
	$order = CreateOrder::createOrder(true);
    //print "Creating Order...\n";
	$orderId = "";
	if (is_null($order)) {
		return "null";
	}
	else{
		return $order;
	}
	if ($order->statusCode == 201)
	{
	    $orderId = $order->result->id;
	    // print "Links:\n";
	    // for ($i = 0; $i < count($order->result->links); ++$i)
	    // {
	    //     $link = $order->result->links[$i];
	    //     print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
	    // }
	    // print "Created Successfully\n";
	    // print "Copy approve link and paste it in browser. Login with buyer account and follow the instructions.\nOnce approved hit enter...\n";
	    return $order;
	}
	else {
		return json_encode(['error'=>$order]);
	    //exit(1);
	}


	// print "Capturing Order...\n";
	// $response = CaptureOrder::captureOrder($orderId);
	// if ($response->statusCode == 201)
	// {
	//     print "Captured Successfully\n";
	//     print "Status Code: {$response->statusCode}\n";
	//     print "Status: {$response->result->status}\n";
	//     print "Order ID: {$response->result->id}\n";
	//     print "Links:\n";
	//     for ($i = 0; $i < count($response->result->links); ++$i){
	//         $link = $response->result->links[$i];
	//         print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
	//     }
	//     foreach($response->result->purchase_units as $purchase_unit)
	//     {
	//         foreach($purchase_unit->payments->captures as $capture)
	//         {    
	//             $captureId = $capture->id;
	//         }
	//     }
	// }
	// else {
	//     exit(1);
	// }
}

if(isset($_GET)){
	echo "GET";
}

?>