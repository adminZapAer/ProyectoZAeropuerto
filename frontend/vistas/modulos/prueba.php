<?php

$url = Ruta::ctrRuta();
$servidor = Ruta::ctrRutaServidor();

if(!isset($_SESSION["validarSesion"])){
    
	echo '<script>
        
		window.location = "'.$url.'";
        
	</script>';
    
	exit();
    
}

?>


<?php

$idUsuario = $_SESSION["idUsuario"];

$idPagoT = "";

$idCompra = "";

$nombreUsuario = "";

$fechaPago = "";

$banco = "";

$montoPago = "";

$referenciaPago = "";

$imgComprobante = "";

$metodoPago = "";

$comprobante = ControladorCarrito::ctrMostrarComprobante($idUsuario);

$fechaRegistro = "";

//var_dump($comprobante);

if($comprobante != null){
    var_dump($comprobante);
    
    $idPagoT = $comprobante["idPagoT"];
    
    $idCompra = $comprobante["idCompra"];
    
    $fechaPago = $comprobante["fechaPago"];
    
    $banco = $comprobante["banco"];
    
    $montoPago = $comprobante["monto"];
    
    $referenciaPago = $comprobante["referencia"];
    
    $imgComprobante = $comprobante["rutaIMG"];
    
    $metodoPago = "transferencia";
    
    $fechaRegistro = $comprobante["fecha"];
    
    
    
    
}
else{
    var_dump("error ", $comprobante);
    
    $metodoPago = "paypal";
}

			$transferenciaHTML = "";
			//if (isset($compra['direccion']) && !is_null($compra['direccion'])) {
				$transferenciaHTML = "
					<p><b>Datos de Pago de Transferencia</b><br></p>
                    <p><b>Fecha Registro: </b>" . $fechaRegistro . "</p>
                    <p><b>IdCliente: </b>" . $_SESSION['idUsuario'] ."</p>
                    <p><b>Cliente: </b>" . $nombreUsuario ."</p>
                    <br>
                    <p><b>Banco: </b>" . $banco . " | <b>Monto de pago: $</b>" . $montoPago . " |  <b>Referencia: </b>" . $referenciaPago . "</p>
                ";
			//}

var_dump($transferenciaHTML);

//$compra = ModeloCompras::mdlGetCompra()

?>