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

class AjaxCheckout
{

	/*=============================================
	AGREGAR COMPRA A BD
	=============================================*/

	public $idUsuario;
	public $idProducto;
	public $usuario;

	//Creamos el metodo agregar deseo
	public function ajaxAgregarCompra($detalles, $usuario, $productos, $direccion)
	{


		// print_r($productos);
		// return false;

		session_start();

		// print_r($productos);
		// return false;

		// $sku = ModeloProductos::mdlGetProducto(1)["sku"];
		// print_r($sku);
		// print_r(ModeloProductos::mdlGetProducto(1));
		// return false;

		$tabla = "usuarios";
		$item = "idUsuario";
		$user = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $usuario);

		$usuario = $user['idUsuario'];

		// print_r($direccion);
		// return false;



		$envio = 0;
		if (isset($direccion) && !is_null($direccion) && !empty($direccion)) {
			$direccionEnvio = ModeloUsuarios::mdlMostrarDireccion('direccion', $user['idUsuario'], $direccion[0]["id"]);
			$envio = 1;
		} else {
			$direccionEnvio = null;
		}

		// print_r(json_encode($direccionEnvio));
		// return false;

		if ($_POST['metodo'] == 'paypal') {
			$costoEnvio = $detalles['purchase_units'][0]['amount']['breakdown']['shipping']['value'];
		}

		if ($_POST['metodo'] == 'netpay') {
			$costoEnvio = 0;
		}


		// ALMACENAMOS LA COMPRA REALIZADA
		$datosCompra = [
			'idUsuario' => $user['idUsuario'],
			'metodo' => $_POST['metodo'],
			'envio' => $envio,
			'costo_envio' => $costoEnvio,
			'direccion' => $direccionEnvio ? json_encode($direccionEnvio[0]) : null,
			'pais' => 'México',
			'fecha' => date('Y-m-d'),
			'statusCompraId' => 1, // en espera
			'validarCompra' => 1,
		];
		$compra = ModeloCompras::mdlAgregarCompra('compras', $datosCompra);

		// ALMACENAMOS EL DETALLE DE LA COMPRA (CADA UNO DE LOS PRODUCTOS Y SU CANTIDAD)

		if ($_POST['metodo'] == 'netpay') {

			// AQUI VOY
			// print_r( json_decode($_POST['productos']) );
			// print_r($detalles);

			// return false;

			foreach( json_decode($_POST['productos']) as $producto){
				// print_r($producto->idProducto);
				$product = \ModeloProductos::mdlGetProducto($producto->idProducto);
			
				// ELIMINAMOS LA OFERTA EN CASO DE QUE ESTE VACÍO EL STOCK.
				$nuevoStock =  $product['stock'] - $producto->cantidad;
				if ($nuevoStock <= 0) {
					$tendraOferta = 0;
					\ModeloProductos::mdlActualizarProducto('productos', 'oferta', $tendraOferta, $producto->idProducto);
				}

				// OBTENEMOS EL ORIGEN DE DEL PRODUCTO
				if ($envio == 1 && $nuevoStock <= 0) {
					$origen = 'planta';
				} else if ($envio == 1 && $nuevoStock > 0) {
					$origen = 'zapata';
				} else {
					$origen = 'zapata';
				}

				\ModeloProductos::mdlActualizarProducto('productos', 'stock', $nuevoStock, $producto->idProducto);

				if ($product !== "error") {
					$datos = [
						'idCompra' => $compra,
						'idProducto' => $producto->idProducto,
						'Cantidad' => $producto->cantidad,
						'precio' => $producto->precio + $producto->costoEnvio,
						'origen' => $origen,
					];

					ModeloCompras::mdlAgregarDetalleCompra('detalle_compra', $datos);
				}
			
			}

			// print_r($_POST['metodo']);
			// return false;
		}
		// print_r($_POST['metodo']);
		// return false;

		// print_r($_POST['metodo']);
		// print_r('aqui');
		// print_r('aqui');
		// print_r('aqui');
// 		print_r('aqui');
// 		return false;

		if ($_POST['metodo'] == 'paypal') {
			foreach ($detalles['purchase_units'][0]['items'] as $key => $item) {
				$producto = \ModeloProductos::mdlGetProducto($productos[$key]->idProducto);

				// ELIMINAMOS LA OFERTA EN CASO DE QUE ESTE VACÍO EL STOCK.
				$nuevoStock =  $producto['stock'] - $item['quantity'];
				if ($nuevoStock <= 0) {
					$tendraOferta = 0;
					\ModeloProductos::mdlActualizarProducto('productos', 'oferta', $tendraOferta, $producto['idProducto']);
				}

				// OBTENEMOS EL ORIGEN DE DEL PRODUCTO
				if ($envio == 1 && $nuevoStock <= 0) {
					$origen = 'planta';
				} else if ($envio == 1 && $nuevoStock > 0) {
					$origen = 'zapata';
				} else {
					$origen = 'zapata';
				}

				// print_r($origen);
				// return false;

				\ModeloProductos::mdlActualizarProducto('productos', 'stock', $nuevoStock, $producto['idProducto']);

				if ($producto !== "error") {
					$datos = [
						'idCompra' => $compra,
						'idProducto' => $productos[$key]->idProducto,
						'Cantidad' => $item['quantity'],
						'precio' => $item['unit_amount']['value'],
						'origen' => $origen,
					];

					ModeloCompras::mdlAgregarDetalleCompra('detalle_compra', $datos);
				}
			}
		}

		$this->sendEmailCliente($user, $productos, $datosCompra);
		$this->sendEmailEmpleado($user, $productos, $datosCompra);


		// print_r('compra finalizada');
		// return false;

// 		print_r('paypal');
		print_r(true);
		return false;
	}

	public function sendEmailCliente($user, $productos, $compra)
	{
		date_default_timezone_set("America/Mexico_City");

		$fecha = date('Y');

		$mail = new PHPMailer;

		try {
			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
			$mail->CharSet = 'UTF-8';
			$mail->isSMTP();                                      // Send using SMTP
			$mail->Host       = $_SERVER['MAIL_HOST'];                 // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                             // Enable SMTP authentication
			$mail->Username   = $_SERVER['MAIL_USERNAME'];           // SMTP username
			$mail->Password   = $_SERVER['MAIL_PASSWORD'];                    // SMTP password
			//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
			$mail->Port       = $_SERVER['MAIL_PORT'];                              // TCP port to connect to

			//Recipients
			$mail->setFrom($_SERVER['MAIL_FROM'], 'Refaccionaria Online Zapata');
			$mail->addAddress($user['email'], $user['nombre']);     // Add a recipient, Name is optional

			// // Attachments
			// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Gracias por comprar en refaccionariazapata.com';

			$listaProductos = "";
			$productosEnviadosDesdePlanta = '';
			foreach ($productos as $producto) {
				$sku = ModeloProductos::mdlGetProducto($producto->idProducto)["sku"];
				$listaProductos = $listaProductos . "<p>" . "SKU: " . $sku . ", Producto: " . $producto->titulo . ", Cantidad:" . $producto->cantidad . ", Precio: <strong>$ ".$producto->precio."</strong></p>";
				if ($producto->origen == 'planta') {
					$productosEnviadosDesdePlanta = $productosEnviadosDesdePlanta . "-" . $producto->titulo . " <br>";
					// print_r($productosEnviadosDesdePlanta);
					// return false;
				}
			}

			$direccionDestinoCliente = json_decode($compra['direccion'], true);

			$direccionHTML = "";
			if (isset($compra['direccion']) && !is_null($compra['direccion'])) {
				$direccionHTML = "
					<p><b>Calle: </b>".$direccionDestinoCliente['calle']."</p>
		            <p><b>No. Exterior: </b>".$direccionDestinoCliente['numext']." | <b>No. Interior: </b>" .$direccionDestinoCliente['numint']."</p>
		            <p><b>Colonia: </b>".$direccionDestinoCliente['colonia']."</p>
		            <p><b>Municipio: </b>".$direccionDestinoCliente['municipio']." | <b>Estado: </b>" .$direccionDestinoCliente['estado']."</p>
		            <p><b>Código Postal: </b>".$direccionDestinoCliente['cp']."</p>
		            <p><b>Teléfono: </b>".$direccionDestinoCliente['celular']."</p>
		            <br>
		            <p><b>Lo recibirá:</b>".$direccionDestinoCliente['nombre']."</p>
                    ";
			}

			$mail->msgHTML('
		    <header style="background: linear-gradient(0deg, rgba(193,39,45,1) 10%, rgba(0,0,0,1) 10%, rgba(0,0,0,0.8015581232492998) 15%, rgba(67,71,74,0) 30%), url(https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/fondo-cabez.jpg); width: 100%; height: 70px;">

	            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/logo-online.png" alt="" style="width: 135px; float: left; margin-top:11px; margin-left:25px;">

	        </header>
	        
	        <div class="correo" style="align-content: center; justify-content: center; text-align: center; font-family: Arial; margin-top: 40px;">
	            
	            <br>
	            
	            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/verification.png" alt="" style="width: 100%; max-width: 80px;">
	            
	            <h3 style="font-size: 18px;">Gracias por comprar en <a href="https://www.refaccionariazapata.com" style="text-decoration: none;">Refaccionaria Online Zapata</a></h3>
	            
	            <hr style="border:1px solid #ccc; width:92%;">
	            
	        </div>
	        
	        <body style="align-content: center; justify-content: center; text-align: center; font-family: Arial;">
	            
	            <p>Saludos '.strtok($_SESSION["nombre"], " ").'</p>
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Nos complace informarle que su pedido ha sido procesado</h4>
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;"><strong>Usted adquirio los siguientes artículos:</strong></h4>
	            
	            '.$listaProductos.'
	            
	            <br>
	            
	            <hr style="border:1px solid #ccc; width:80%;">
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Los siguientes productos serán enviados desde planta:</h4>
	            
	            <h5 style="font-weight: 100; color: #000000; padding: 0 20px;">'.$productosEnviadosDesdePlanta.'</h5>
	            
	            <hr style="border:1px solid #ccc; width:80%;">
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Se enviarán a la siguiente dirección:</h4>
	            
	            '.$direccionHTML.'
	            
	        </body>
	        
	        <footer style="background: linear-gradient(to top, black 30% ,white 80%);">
	            
	            <hr style="border:1px solid #ccc; width:80%;">
	            
	            <h5 style="font-weight: 100; color: 5d5d5d; text-align:center;">¡Gracias por elegir Refaccionaria Online Zapata!</h5>
	            
	            <br><br><br>
	            
	            <div style="text-align: center; align-content: center; align-items: center; justify-content: center;">
	            
	                <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 25px;">Conócenos... </a>
	                
	                <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 18px;">¿Quienes somos?</a>
	                
	                <br><br>
	                
	                <img src="https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/logob.png" alt="" style="display: flex; margin: 0 auto; width: 100%; max-width: 160px;">
	                
	                <p style="color: #ffffff; font-size: 12px;">&copy; '.$fecha.'. Todos los derechos reservados.</p>
	                
	                <a href="https://www.refaccionariazapata.com/frontend/terminos-y-condiciones" target="_blank" style="color: #ffffff; font-size: 12px;">Términos y Condiciones</a>
	                
	                <br><br>
	                
	            </div>
	            
	        </footer>
		    ');
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

	public function sendEmailEmpleado($user, $productos, $compra)
	{
		date_default_timezone_set("America/Mexico_City");

		$fecha = date('Y');

		$mail = new PHPMailer;

		try {

			$mail->CharSet = 'UTF-8';
			$mail->isSMTP();
			$mail->Host       = $_SERVER['MAIL_HOST'];
			$mail->SMTPAuth   = true;
			$mail->Username   = $_SERVER['MAIL_USERNAME'];
			$mail->Password   = $_SERVER['MAIL_PASSWORD'];

			$mail->Port       = $_SERVER['MAIL_PORT'];

			$mail->setFrom($_SERVER['MAIL_FROM'], 'Refaccionaria Online Zapata');
			$mail->addAddress($_SERVER['MAIL_VENDEDOR']); //'jmolina@zapata.com.mx'

			$mail->Subject = 'Notificación de compra por un cliente';

			$item = $_SESSION["idUsuario"];

			$facturaciones = ModeloUsuarios::mdlMostrarDatosFacturacion("facturacion", $compra['idUsuario']);
			//$facturaciones = ControladorUsuarios::ctrMostrarDatosFacturacion($compra['idUsuario']);

			$facturacionHTML = "";
			foreach ($facturaciones as $key => $value) {

				$facturacionHTML = "
                <p><b>Nombre / Razón Social: </b>" . $value["nombreRazon"] . "</p>
                <p><b>RFC: </b>" . $value["rfc"] . " | <b>Tipo de Persona: </b>" . $value["tipoPersona"] . "</p>
                <p><b>Dirección: </b>" . $value["calle"] . " | <b>Numero Exterior: </b>" . $value["numExterior"] . " | <b>Numero Interior: </b>" . $value["numInterior"] . "</p>
                <p><b>Colonia: </b>" . $value["colonia"] . " | <b>Municipio: </b>" . $value["municipio"] . " | <b>Estado: </b>" . $value["estado"] . " | <b>Codigo Postal: </b>" . $value["codigoPostal"] . "</p>
                <p><b>Teléfono: </b>" . $value["telefono"] . " | <b>Correo Electrónico: </b>" . $value["email"] . "</p>
                ";
			}

			$listaProductos = "";
			$productosEnviadosDesdePlanta = '';
			foreach ($productos as $producto) {
				$sku = ModeloProductos::mdlGetProducto($producto->idProducto)["sku"];
				$listaProductos = $listaProductos . "<p>" . "SKU: " . $sku . ", producto: " . $producto->titulo . ", cantidad:" . $producto->cantidad . ", Precio: <strong>$ ".$producto->precio."</strong></p>";

				if ($producto->origen == 'planta') {
					$productosEnviadosDesdePlanta = $productosEnviadosDesdePlanta . "-" . $producto->titulo . " <br>";
					// print_r($productosEnviadosDesdePlanta);
					// return false;
				}
			}

			$direccionDestinoCliente = json_decode($compra['direccion'], true);

			$metodoPago = $compra['metodo'];

			$direccionHTML = "";
			if (isset($compra['direccion']) && !is_null($compra['direccion'])) {
				$direccionHTML = "
                	<p><b>Calle: </b>".$direccionDestinoCliente['calle']."</p>
		            <p><b>No. Exterior: </b>".$direccionDestinoCliente['numext']." | <b>No. Interior: </b>" .$direccionDestinoCliente['numint']."</p>
		            <p><b>Colonia: </b>".$direccionDestinoCliente['colonia']."</p>
		            <p><b>Municipio: </b>".$direccionDestinoCliente['municipio']." | <b>Estado: </b>" .$direccionDestinoCliente['estado']."</p>
		            <p><b>Código Postal: </b>".$direccionDestinoCliente['cp']."</p>
		            <p><b>Teléfono: </b>".$direccionDestinoCliente['celular']."</p>
		            <br>
		            <p><b>Lo recibirá:</b>".$direccionDestinoCliente['nombre']."</p>    
                ";
			}

			$mail->msgHTML('
			<header style="background: linear-gradient(0deg, rgba(193,39,45,1) 10%, rgba(0,0,0,1) 10%, rgba(0,0,0,0.8015581232492998) 15%, rgba(67,71,74,0) 30%), url(https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/fondo-cabez.jpg); width: 100%; height: 70px;">
				
	            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/logo-online.png" alt="" style="width: 135px; float: left; margin-top:11px; margin-left:25px;">
	            
	        </header>
	        
	        <div class="correo" style="align-content: center; justify-content: center; text-align: center; font-family: Arial; margin-top: 40px;">
	            
	            <br>
	            
	            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/verification.png" alt="" style="width: 100%; max-width: 80px;">
	            
	            <h3 style="font-size: 18px;">
	                
	                El usuario: '.$user['nombre'].' realizó una compra
	                <br>
	                con el correo: '.$user['email'].'
	                
	            </h3>
	            
	            <hr style="border:1px solid #ccc; width:92%;">
	            
	        </div>
	        
	        <body style="align-content: center; justify-content: center; text-align: center; font-family: Arial;">
	            
	            <p>Saludos Jose Antonio</p>
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Se realizó una compra el dia '.date('Y-m-d h:i').'</h4>
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;"><strong>Los productos que el cliente adquirió son los siguientes:</strong></h4>
	            
	            '.$listaProductos.'
	            
	            <br>
	            
	            <hr style="border:1px solid #ccc; width:80%;">
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Los siguientes productos serán enviados desde planta:</h4>
	            
	            <h5 style="font-weight: 100; color: #000000; padding: 0 20px;">'.$productosEnviadosDesdePlanta.'</h5>
	            
	            <hr style="border:1px solid #ccc; width:80%;">
	            
	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Los datos de Facturación son los siguientes:</h4>
	            
	            '.$facturacionHTML.'
	            <br>

	            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Metodo de pago usado: '.$metodoPago.'</h4>
	            
	        </body>
	        
	        <footer style="background: linear-gradient(to top, black 30% ,white 80%);">
	            
	            <hr style="border:1px solid #ccc; width:80%;">
	            
	            <h5 style="font-weight: 100; color: 5d5d5d; text-align:center;">¡Gracias por elegir Refaccionaria Online Zapata!</h5>
	            
	            <br><br><br>
	            
	            <div style="text-align: center; align-content: center; align-items: center; justify-content: center;">
	            
	                <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 25px;">Conócenos... </a>
	                
	                <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 18px;">¿Quienes somos?</a>
	                
	                <br><br>
	                
	                <img src="https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/logob.png" alt="" style="display: flex; margin: 0 auto; width: 100%; max-width: 160px;">
	                
	                <p style="color: #ffffff; font-size: 12px;">&copy; '.$fecha.'. Todos los derechos reservados.</p>
	                
	                <a href="https://www.refaccionariazapata.com/frontend/terminos-y-condiciones" target="_blank" style="color: #ffffff; font-size: 12px;">Términos y Condiciones</a>
	                
	                <br><br>
	                
	            </div>
	            
	        </footer>
		    ');
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
		} catch (Exception $e) {
			echo "<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}

/*========================================
*        CREAR ORDEN DE COMPRA           *
========================================*/
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$ajaxCheckout = new AjaxCheckout();

	if (isset($_POST['detalles'])) {
		// print_r('si compro');
		// return false;
		$ajaxCheckout->ajaxAgregarCompra($_POST['detalles'], json_decode($_POST['usuario']), json_decode($_POST['productos']), $_POST['direccion']);
	} else {
		/*========================================
    	*        CREAR ORDEN DE COMPRA           *
    	========================================*/

		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body, true);
		$order = CreateOrder::createOrder(false, $data);
		// echo print_r($order);
		// return false;
		//print "Creating Order...\n";
		$orderId = "";
		if ($order->statusCode == 201) {
			echo json_encode($order, JSON_PRETTY_PRINT);
			return $order;
		} else {
			return json_encode(['error' => $order]);
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
