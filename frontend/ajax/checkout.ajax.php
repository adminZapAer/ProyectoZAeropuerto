<?php

require_once "../../vendor/paypal/paypal-checkout-sdk/samples/CaptureIntentExamples/CreateOrder.php";
require_once '../../vendor/autoload.php';
require_once __DIR__."/../PHPMailer/PHPMailerAutoload.php";
require_once __DIR__ . '/../modelos/productos.modelo.php';
require_once __DIR__ . '/../modelos/compras.modelo.php';
require_once __DIR__ . '/../modelos/usuarios.modelo.php';
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
	public function ajaxAgregarCompra($detalles, $usuario, $productos){
		$tabla = "usuarios";
		$item = "idUsuario";
		$user = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $usuario);
		//print_r($user['idUsuario']);
		//print_r($productos);
		$i = 0;
      	foreach ($detalles['purchase_units'][0]['items'] as $item) {
			$producto = \ModeloProductos::mdlGetProducto($productos[$i]->idProducto);
			// print_r($producto);
			// return false;
            if ($producto !== "error") {
				$datos = [
					'idUsuario' => $user['idUsuario'],
					'metodo' => 'paypal',
					'envio' => 1,
					'direccion' => ModeloUsuarios::mdlMostrarDirecciones('direccion', $user['idUsuario'])[0]['colonia'],
					'pais' => 'México',
					'fecha' => date('Y-m-d'),
					'statusCompraId' => 1 // en espera
				];

				// print_r($datos);
				// return false;

				$compra = ModeloCompras::mdlAgregarCompra('compras', $datos);

				// print_r($compra);
				// return false;

				$datos = [
					'idCompra' => $compra,
					'idProducto' => $productos[$i]->idProducto,
					'Cantidad' => $item['quantity'],
					'precio' => $item['unit_amount']['value'],
				];

				$detalleVenta = ModeloCompras::mdlAgregarDetalleCompra('detalle_compra', $datos);

			}
			$i = $i++;
        }
		
      	$this->sendEmailCliente($user);
      	$this->sendEmailEmpleado($user);
        
        // $envio= $mail->Send();
        //echo json_encode($detalles, JSON_FORCE_OBJECT);

	}

	public function sendEmailCliente($user)
	{
		date_default_timezone_set("America/Mexico_City");
        
        $mail = new PHPMailer;

        try {
		    //Server settings
		    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
		    $mail->CharSet = 'UTF-8';
		    $mail->isSMTP();                                      // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                             // Enable SMTP authentication
		    $mail->Username   = 'pruebasbyw@gmail.com';           // SMTP username
		    $mail->Password   = 'Pruebas123@';                    // SMTP password
		    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		    $mail->Port       = 587;                              // TCP port to connect to

		    //Recipients
		    $mail->setFrom('no_reply@zapata.com', 'Refacciones Zapata Camiones');
		    $mail->addAddress($user['email'], $user['nombre']);     // Add a recipient, Name is optional

		    // // Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Gracias por comprar en refaccioneszapatacamiones.com';
		    $mail->msgHTML('
		        <div style="width:100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
		            <center>
		                <img src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png" alt="logo-zapata" style="width: 20%; padding: 20px;">
		            </center>
		            <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">
		            
		                <center>
		                    <img src="https://www.zapataaeropuerto.com/img/mail/icon-email.png" alt="icono-mail" style="padding: 20px; width: 15%;">
		                    
		                    <h3 style="font-weight: 100; color: #000;">Gracias por comprar en refaccioneszapatacamiones.com</h3>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">Nos complace informarle que su pedido ha sido procesado.</h4>
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">Los siguientes artículos enlistado han sido adquiridos.</h4>
		                    
		                    <br>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">¡Gracias por elegir Refacciones Zapata Camiones!.</h4>
		                    
		                </center>
		                
		            </div>
		            
		        </div>
		    ');
		    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		    echo 'Message has been sent';
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

	public function sendEmailEmpleado($user)
	{
		date_default_timezone_set("America/Mexico_City");
        
        $mail = new PHPMailer;

        try {

		    $mail->CharSet = 'UTF-8';
		    $mail->isSMTP();
		    $mail->Host       = 'smtp.gmail.com';
		    $mail->SMTPAuth   = true;
		    $mail->Username   = 'pruebasbyw@gmail.com';
		    $mail->Password   = 'Pruebas123@';

		    $mail->Port       = 587;

		    $mail->setFrom('no_reply@zapata.com', 'Refacciones Zapata Camiones');
		    $mail->addAddress('dani_9_valerdi@hotmail.com');//'jmolina@zapata.com.mx'

		    $mail->Subject = 'Notificación de compra por un cliente';
		    $mail->msgHTML('
		        <div style="width:100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
		            <center>
		                <img src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png" alt="logo-zapata" style="width: 20%; padding: 20px;">
		            </center>
		            <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">
		            
		                <center>
		                    <img src="https://www.zapataaeropuerto.com/img/mail/icon-email.png" alt="icono-mail" style="padding: 20px; width: 10%;">
		                    
		                    <h3 style="font-weight: 100; color: #000;">Se ha realizado una compra por el cliente:'. $user['nombre'] .'</h3>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
		                    	<p>
		                    		La compra se realizo en la fecha '.date('Y-m-d h:i') .'
		                    		Los productos que el cliente adquirio son los siguientes:
		                    	</p>
		                    </h4>
		                    
		                    <br>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
		                    
		                </center>
		                
		            </div>
		            
		        </div>
		    ');
		    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		    echo '<br>Message has been sent';
		} catch (Exception $e) {
		    echo "<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
    
}

/*========================================
*        CREAR ORDEN DE COMPRA           *
========================================*/
if($_SERVER['REQUEST_METHOD'] === "POST"){
	$ajaxCheckout = new AjaxCheckout();

	if (isset($_POST['detalles'])) {
		// print_r('si compro');
		// return false;
		$ajaxCheckout->ajaxAgregarCompra($_POST['detalles'], json_decode($_POST['usuario']), json_decode($_POST['productos']) );

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