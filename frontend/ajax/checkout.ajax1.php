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

    public $idPagoT;

    public $idCompra;

    public $nombreUsuario;

    public $fechaPago;

    public $banco;

    public $montoPago;

    public $referenciaPago;

    public $imgComprobante;

    public $metodoPago;

    public $comprobante;

    public $fechaRegistro;

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
        
        /*-------------------------------------------------------------------------------------------------*/
        
        $comprobante = ControladorCarrito::ctrMostrarComprobante($user['idUsuario']);
        $validarCompra = 0;
        
        if($comprobante != null){
            $metodoPago = 'transferencia';
            $validarCompra = 0;
            
            $idPagoT = $comprobante["idPagoT"];
            $idCompra = $comprobante["idCompra"];
            $fechaPago = $comprobante["fechaPago"];
            $banco = $comprobante["banco"];
            $montoPago = $comprobante["monto"];
            $referenciaPago = $comprobante["referencia"];
            $imgComprobante = $comprobante["rutaIMG"];
            $fechaRegistro = $comprobante["fecha"];
            $nombreUsuario = $user["nombre"];
        }
        else{
            $metodoPago = 'paypal';
            $validarCompra = 1;
        }
        
        /*-------------------------------------------------------------------------------------------------*/
        
		$envio = 0;
		if (isset($direccion) && !is_null($direccion) && !empty($direccion)) {
			$direccionEnvio = ModeloUsuarios::mdlMostrarDireccion('direccion', $user['idUsuario'], $direccion[0]["id"]);
			$envio = 1;
		}
        else {
			$direccionEnvio = null;
		}

		// print_r(json_encode($direccionEnvio));
		// return false;

		// ALMACENAMOS LA COMPRA REALIZADA
		$datosCompra = [
			'idUsuario' => $user['idUsuario'],
			'metodo' => $metodoPago,
			'envio' => $envio,
			'costo_envio' => $detalles['purchase_units'][0]['amount']['breakdown']['shipping']['value'],
			'direccion' => $direccionEnvio ? json_encode($direccionEnvio[0]) : null,
			'pais' => 'México',
			'fecha' => date('Y-m-d'),
			'statusCompraId' => 1,
            'validarCompra' => $validarCompra
		];
		$compra = ModeloCompras::mdlAgregarCompra('compras', $datosCompra);
        
        /*------------------------------------------------------------------------------------------------------*/
        $idCompra = $compra;
        
        $datosT = array("usuario" => $_SESSION["idUsuario"],
                       "idCompra"=> $idCompra,
                       "fechaPago" => $fechaPago,
                       "banco" => $banco,
                       "monto" => $monto,
                       "referencia" => $referencia,
                       "foto" => $ruta);
            
        /*------------------------------------------------------------------------------------------------------*/

		// ALMACENAMOS EL DETALLE DE LA COMPRA (CADA UNO DE LOS PRODUCTOS Y SU CANTIDAD)

		foreach ($detalles['purchase_units'][0]['items'] as $key => $item) {
			$producto = \ModeloProductos::mdlGetProducto($productos[$key]->idProducto);

			// ELIMINAMOS LA OFERTA EN CASO DE QUE ESTE VACÍO EL STOCK.
			$nuevoStock =  $producto['stock'] - $item['quantity'];
			if ($nuevoStock <= 0) {
				$tendraOferta = 0;
				\ModeloProductos::mdlActualizarProducto('productos', 'oferta', $tendraOferta, $producto['idProducto']);
			}

			// OBTENEMOS EL ORIGEN DE DEL PRODUCTO
			if($envio == 1 && $nuevoStock <= 0){
				$origen = 'planta';
			}else if($envio == 1 && $nuevoStock > 0){
				$origen = 'zapata';
			}else{
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
                
                /*-------------------------------------------------------------------------------------------*/
                if($comprobante != null){
                    
                    $tabla = "pagostransferencia";
                    
                    $respuesta = ModeloCarrito::mdlCargarComprobante($tabla, $datosT);
                    
                }
                /*-------------------------------------------------------------------------------------------*/
                
            }
            
		}
        
        if($comprobante != null){
            $this->sendEmailTransferenciaEmpleado($user, $productos, $datosCompra);
        }
        else{
            $this->sendEmailCliente($user, $productos, $datosCompra);
            $this->sendEmailEmpleado($user, $productos, $datosCompra);
        }
        
		// print_r('compra finalizada');
		// return false;

		print_r(true);
		return false;
	}

	public function sendEmailCliente($user, $productos, $compra)
	{
		date_default_timezone_set("America/Mexico_City");

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
			$mail->setFrom($_SERVER['MAIL_FROM'], 'Refacciones Zapata Camiones');
			$mail->addAddress($user['email'], $user['nombre']);     // Add a recipient, Name is optional

			// // Attachments
			// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = 'Gracias por comprar en refaccioneszapatacamiones.com';

			$listaProductos = "";
			$productosEnviadosDesdePlanta = '';
			foreach ($productos as $producto) {
				$sku = ModeloProductos::mdlGetProducto($producto->idProducto)["sku"];
				$listaProductos = $listaProductos . "<p>" . "SKU: " . $sku . ", producto: " . $producto->titulo . ", cantidad:" . $producto->cantidad . "</p>";
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
					<p><b>DIRECCIÓN DE ENVÍO</b><br></p>
                    <p><b>Nombre: </b>" . $direccionDestinoCliente['nombre'] . "</p>
                    <p><b>Dirección: </b>" . $direccionDestinoCliente['calle'] . " | <b>Numero Exterior: </b>" . $direccionDestinoCliente['numext'] . " | <b>Numero Interior: </b>" . $direccionDestinoCliente['numint'] . "</p>
                    <p><b>Colonia: </b>" . $direccionDestinoCliente['colonia'] . " | <b>Municipio: </b>" . $direccionDestinoCliente['municipio'] . " | <b>Estado: </b>" . $direccionDestinoCliente['estado'] . " | <b>Código Postal: </b>" . $direccionDestinoCliente['cp'] . "</p>
                    <p><b>Teléfono: </b>" . $direccionDestinoCliente['celular'] . "</p>
                    ";
			}

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
		                    ' . $listaProductos . '
		                    <br>
							
							<hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
		                    	<p>
		                    		Los siguientes productos serán enviados desde planta:
								</p>
								' . $productosEnviadosDesdePlanta . '
		                    </h4>
		                    
							<br>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
							' . $direccionHTML . '
							<hr style="border:1px solid #ccc; width:80%;">

		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">¡Gracias por elegir Refacciones Zapata Camiones!.</h4>
		                    
		                </center>
		                
		            </div>
		            
		        </div>
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

		$mail = new PHPMailer;

		try {

			$mail->CharSet = 'UTF-8';
			$mail->isSMTP();
			$mail->Host       = $_SERVER['MAIL_HOST'];
			$mail->SMTPAuth   = true;
			$mail->Username   = $_SERVER['MAIL_USERNAME'];
			$mail->Password   = $_SERVER['MAIL_PASSWORD'];

			$mail->Port       = $_SERVER['MAIL_PORT'];

			$mail->setFrom($_SERVER['MAIL_FROM'], 'Refacciones Zapata Camiones');
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
				$listaProductos = $listaProductos . "<p>" . "SKU: " . $sku . ", producto: " . $producto->titulo . ", cantidad:" . $producto->cantidad . "</p>";
                
				if ($producto->origen == 'planta') {
					$productosEnviadosDesdePlanta = $productosEnviadosDesdePlanta . "-" . $producto->titulo . " <br>";
					// print_r($productosEnviadosDesdePlanta);
					// return false;
				}
			}
            
			$direccionDestino = json_decode($compra['direccion'], true);
            
			$direccionHTML = "";
			if (isset($compra['direccion']) && !is_null($compra['direccion'])) {
				$direccionHTML = "
					<p><b>DIRECCIÓN DE ENVÍO</b><br></p>
                    <p><b>Nombre: </b>" . $direccionDestino['nombre'] . "</p>
                    <p><b>Dirección: </b>" . $direccionDestino['calle'] . " | <b>Numero Exterior: </b>" . $direccionDestino['numext'] . " | <b>Numero Interior: </b>" . $direccionDestino['numint'] . "</p>
                    <p><b>Colonia: </b>" . $direccionDestino['colonia'] . " | <b>Municipio: </b>" . $direccionDestino['municipio'] . " | <b>Estado: </b>" . $direccionDestino['estado'] . " | <b>Código Postal: </b>" . $direccionDestino['cp'] . "</p>
                    <p><b>Teléfono: </b>" . $direccionDestino['celular'] . "</p>
                    ";
			}
            
			$mail->msgHTML('
		        <div style="width:100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
		            <center>
		                <img src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png" alt="logo-zapata" style="width: 20%; padding: 20px;">
		            </center>
		            <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">
		            
		                <center>
		                    <img src="https://www.zapataaeropuerto.com/img/mail/icon-email.png" alt="icono-mail" style="padding: 20px; width: 10%;">
		                    
							<h3 style="font-weight: 100; color: #000;">
								Se ha realizado una compra por el cliente:' . $user['nombre'] .
				'<br> Con el correo: ' . $user['email'] .
				'</h3>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
		                    	<p>
		                    		La compra se realizo en la fecha ' . date('Y-m-d h:i') . '
		                    		Los productos que el cliente adquirió son los siguientes:
								</p>
								' . $listaProductos . '
		                    </h4>
		                    
							<br>
							
							<hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
		                    	<p>
		                    		Los siguientes productos serán enviados desde planta:
								</p>
								' . $productosEnviadosDesdePlanta . '
		                    </h4>
		                    
							<br>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
                            
                            <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
		                    	<p><b>DATOS DE FACTURACION</b></p>
                                ' . $facturacionHTML . '
		                    </h4>
                            
                            
		                </center>
		                
		            </div>
		            
		        </div>
		    ');
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
			$mail->send();
		} catch (Exception $e) {
			echo "<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
    
    public function sendEmailTransferenciaEmpleado($user, $productos, $compra)
	{
		date_default_timezone_set("America/Mexico_City");

		$mail = new PHPMailer;

		try {

			$mail->CharSet = 'UTF-8';
			$mail->isSMTP();
			$mail->Host       = $_SERVER['MAIL_HOST'];
			$mail->SMTPAuth   = true;
			$mail->Username   = $_SERVER['MAIL_USERNAME'];
			$mail->Password   = $_SERVER['MAIL_PASSWORD'];

			$mail->Port       = $_SERVER['MAIL_PORT'];

			$mail->setFrom($_SERVER['MAIL_FROM'], 'Refacciones Zapata Camiones');
			$mail->addAddress($_SERVER['MAIL_VENDEDOR']); //'jmolina@zapata.com.mx'
            
			$mail->Subject = 'Notificación de Transferencia Bancaria por un cliente';
            
			$item = $_SESSION["idUsuario"];
            
			$listaProductos = "";
			$productosEnviadosDesdePlanta = '';
			foreach ($productos as $producto) {
				$sku = ModeloProductos::mdlGetProducto($producto->idProducto)["sku"];
				$listaProductos = $listaProductos . "<p>" . "SKU: " . $sku . ", producto: " . $producto->titulo . ", cantidad:" . $producto->cantidad . "</p>";
                
				if ($producto->origen == 'planta') {
					$productosEnviadosDesdePlanta = $productosEnviadosDesdePlanta . "-" . $producto->titulo . " <br>";
					// print_r($productosEnviadosDesdePlanta);
					// return false;
				}
			}
            
            /*--------------------------------------------------------------------------------------------------*/
            
            /*$idPagoT = $comprobante["idPagoT"];
            $idCompra = $comprobante["idCompra"];
            $fechaPago = $comprobante["fechaPago"];
            $banco = $comprobante["banco"];
            $montoPago = $comprobante["monto"];
            $referenciaPago = $comprobante["referencia"];
            $imgComprobante = $comprobante["rutaIMG"];
            $fechaRegistro = $comprobante["fecha"];
            $nombreUsuario = $user["nombre"];*/
            $transferenciaHTML = "";
            $transferenciaHTML = "
				<p><b>Datos de Pago de Transferencia</b><br></p>
                <p><b>Fecha Registro: </b>" . $fechaRegistro . "</p>
                <p><b>IdCliente: </b>" . $_SESSION['idUsuario'] ."</p>
                <p><b>Cliente: </b>" . $nombreUsuario ."</p>
                <br>
                <p><b>Banco: </b>" . $banco . " | <b>Monto de pago: $</b>" . $montoPago . " |  <b>Referencia: </b>" . $referenciaPago . "</p>
            ";
            
            /*--------------------------------------------------------------------------------------------------*/
            
			$direccionDestino = json_decode($compra['direccion'], true);
            
			$direccionHTML = "";
			if (isset($compra['direccion']) && !is_null($compra['direccion'])) {
				$direccionHTML = "
					<p><b>DIRECCIÓN DE ENVÍO</b><br></p>
                    <p><b>Nombre: </b>" . $direccionDestino['nombre'] . "</p>
                    <p><b>Dirección: </b>" . $direccionDestino['calle'] . " | <b>Numero Exterior: </b>" . $direccionDestino['numext'] . " | <b>Numero Interior: </b>" . $direccionDestino['numint'] . "</p>
                    <p><b>Colonia: </b>" . $direccionDestino['colonia'] . " | <b>Municipio: </b>" . $direccionDestino['municipio'] . " | <b>Estado: </b>" . $direccionDestino['estado'] . " | <b>Código Postal: </b>" . $direccionDestino['cp'] . "</p>
                    <p><b>Teléfono: </b>" . $direccionDestino['celular'] . "</p>
                    ";
			}
            
			$mail->msgHTML('
		        <div style="width:100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
		            <center>
		                <img src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png" alt="logo-zapata" style="width: 20%; padding: 20px;">
		            </center>
		            <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">
		            
		                <center>
		                    <img src="https://www.zapataaeropuerto.com/img/mail/icon-email.png" alt="icono-mail" style="padding: 20px; width: 10%;">
		                    
							<h3 style="font-weight: 100; color: #000;">
								Se ha realizado una compra por el cliente:' . $user['nombre'] .
				'<br> Con el correo: ' . $user['email'] .
				'</h3>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
		                    
		                    <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
		                    	<p>
		                    		La compra se realizo en la fecha ' . date('Y-m-d h:i') . '
		                    		Los productos que el cliente adquirió son los siguientes:
								</p>
								' . $listaProductos . '
		                    </h4>
		                    
							<br>
		                    
		                    <hr style="border:1px solid #ccc; width:80%;">
                            
                            <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
                                ' . $transferenciaHTML . '
		                    </h4>
                            
                            
		                </center>
		                
		            </div>
		            
		        </div>
		    ');
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
			//$mail->send();
            
            $envio = $mail->Send();

			if(!$envio){

				echo '<script> 

					swal({
						  title: "¡ERROR!",
						  text: "¡Ha ocurrido un problema enviando el mensaje!",
						  type:"error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						},

						function(isConfirm){

							if(isConfirm){
								window.location = rutaFrontEnd;
							}
					});

				</script>';

			}else{

				echo '<script> 

					swal({
					  title: "¡OK!",
					  text: "¡Su mensaje ha sido enviado, muy pronto le responderemos!",
					  type: "success",
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	  
									localStorage.removeItem("listaProductos");
									localStorage.removeItem("sumaCesta");
									localStorage.removeItem("cantidadCesta");
									window.location = rutaFrontEnd;
								}
					});

				</script>';

			}
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
