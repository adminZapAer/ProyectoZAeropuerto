<?php

class ControladorCarrito{
    
    /*=============================================
	MOSTRAR TARIFAS
	=============================================*/
    
    public function ctrMostrarTarifas(){
        
		$tabla = "comercio";
        
		$respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);
        
		return $respuesta;
        
	}
    
    /*=============================================
	NUEVAS COMPRAS
	=============================================*/

	static public function ctrNuevasCompras($datos){
        
		$tabla = "compras";
        
		$respuesta = ModeloCarrito::mdlNuevasCompras($tabla, $datos);
        
		if($respuesta == "ok"){
            
			$tabla = "comentarios";
			ModeloUsuarios::mdlIngresoComentarios($tabla, $datos);
            
		}
        
		return $respuesta;
        
	}
    
    /*=============================================
    VERIFICAR SI EXISTEN DATOS FACTURACION
    =============================================*/
    
    public function ctrComprobarDatosFacturacion(){
        
        $tabla = "facturacion";
        
        if(isset($_SESSION["validarSesion"])){
            
            $url = Ruta::ctrRuta();
            
            if($_SESSION["validarSesion"] == "ok"){
                
                $idUsuario = $_SESSION["idUsuario"];
                
                $respuesta = ModeloCarrito::mdlComprobarDatosFacturacion($idUsuario,$tabla);
                
                /*if($respuesta != null){
                    echo "<br>esta bien<br>";
                    //var_dump($respuesta);
                    echo $respuesta["rfc"];
                }
                else{
                    echo "<br>esta mal <br>";
                    var_dump($respuesta);
                }*/
                
                
                if($respuesta != null){
                    
                    echo '
                    <a id="btnCheckout" href="'.$url.'proceder-pago" data-toggle="modal" idUsuario="'.$_SESSION["idUsuario"].'">
                        <button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button>
                    </a>
                    ';
                    
                }
                else{
                    
                    echo'
                    <a class ="datosFacturacion" data-toggle="modal">
                        <button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button>
                    </a>
                    ';
                    
                }
                
            }
            
        }
        
    }
    
    /*=============================================
        VERIFICAR SI EXISTE FACTURA TEMPORAL
    =============================================*/
    
    public function ctrComprobarFactTemporal(){
        
        $tabla = "facturacion";
        
        if(isset($_SESSION["validarSesion"])){
            
            if($_SESSION["validarSesion"] == "ok"){
                
                $idUsuario = $_SESSION["idUsuario"];
                
                $comprobarDFact = ModeloCarrito::mdlComprobarDatosFacturacion($idUsuario,$tabla);
                
                if($comprobarDFact != null){
                    $datosFacturacion = ControladorUsuarios::ctrMostrarDatosFacturacion($idUsuario);
                    
                    $rfcTemporal=$datosFacturacion[0]["rfc"];
                    if($rfcTemporal == "XAXX010101000"){
                        
                        $eliminarFT = ControladorUsuarios::ctrEliminarFacturacionTemporal($rfcTemporal, $idUsuario);
                    }
                    
                }
                else{}
                
            }
            
        }
        
    }
    
    /*=============================================
	ACTUALIZAR PERFIL
	=============================================*/
	public function ctrCargarComprobante(){

		if(isset($_POST["usuarioComprobante"])){

			/*=============================================
			VALIDAR IMAGEN
			=============================================*/
			$ruta = "";
            $fechaPago = $_POST["fechaPago"];
            $idUsuario = $_SESSION["idUsuario"];
            $banco = $_POST["banco"];
            $monto = $_POST["montoExacto"];
            $referencia = $_POST["referencia"];
            
            //Preguntamos si viene un archivo
			if(isset($_FILES["datosRecibo"]["tmp_name"]) && !empty($_FILES["datosRecibo"]["tmp_name"])){
                
				/*=============================================
				PRIMERO PREGUNTAMOS SI EXISTE EL DIRECTORIO, SINO EXISTE SE CREA
				=============================================*/
                //Creamos la direccion donde se van a guardar las imagenes
				$directorio = "../backend/vistas/img/rtfc/us".$idUsuario;
                    //Si no hay imagen en la base de datos creamos un nuevo directorio, en donde se va a guardar la imagen
				
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777, true);
                }
                
				/*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/
                
				$aleatorio = mt_rand(100, 999);
                
				if($_FILES["datosRecibo"]["type"] == "image/jpeg"){
                    //Mandamos a llamar el nuevo directoro de la imagen y le asignaremos un nombre a la imagen
					$ruta = "../backend/vistas/img/rtfc/us".$idUsuario."/cmp".$idUsuario."_".$aleatorio.".jpg";
                    
					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/
                    //creamos una nueva imagen jpg
					$origen = imagecreatefromjpeg($_FILES["datosRecibo"]["tmp_name"]);
                    //enviamos la imagen nueva a la ruta destino
					imagejpeg($origen, $ruta);
                    
				}

				if($_FILES["datosRecibo"]["type"] == "image/png"){
                    
                    $ruta = "../backend/vistas/img/rtfc/us".$_POST["idUsuario"]."/cmp".$idUsuario."_".$aleatorio.".png";
                    
					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/
                    
					$origen = imagecreatefrompng($_FILES["datosRecibo"]["tmp_name"]);
                    
					imagepng($origen, $ruta);
                    
				}
                
			}

			$datosT = array("usuario" => $_SESSION["idUsuario"],
                           "idCompra" => 0,
						   "fechaPago" => $fechaPago,
						   "banco" => $banco,
                           "monto" => $monto,
                           "referencia" => $referencia,
						   "foto" => $ruta);
            
			$tabla = "pagostransferencia";
            
            $nombreUsuario = $_SESSION["nombre"];
            
            $fechaRegistro = date("Y-m-d");
            
            $transferenciaHTML = "";
            
            $transferenciaHTML = "
				<p><b>Datos de Pago de Transferencia</b><br></p>
                <p><b>Fecha Registro: </b>" . $fechaRegistro . "</p>
                <br>
                <p><b>Fecha de Pago: </b>" . $fechaPago . "</p>
                <p><b>IdCliente: </b>" . $_SESSION['idUsuario'] ."</p>
                <p><b>Cliente: </b>" . $nombreUsuario ."</p>
                <br>
                <p><b>Banco: </b>" . $banco . " | <b>Monto de pago: $</b>" . $monto . " |  <b>Referencia: </b>" . $referencia . "</p>
            ";
            
			$respuesta = ModeloCarrito::mdlCargarComprobante($tabla, $datosT);
            
			if($respuesta == "ok"){
                
                //$registro = $this::ctrEnviarCorreoComprobante();
                /*=============================================
                ENVÍO CORREO ELECTRÓNICO
                =============================================*/

                date_default_timezone_set("America/Mexico_City");

                $url = Ruta::ctrRuta();	

                $mail = new PHPMailer;

                $mail->CharSet = 'UTF-8';

                $mail->isMail();

                $mail->setFrom('noreply@refaccioneszapatacamiones.com', 'Refacciones Zapata Camiones');

                $mail->addReplyTo('noreply@refaccioneszapatacamiones.com', 'Refacciones Zapata Camiones');

                $mail->Subject = "Ha recibido una Transferencia";

                $mail->addAddress("jmolina@zapata.com.mx");
                
                //$mail->addAddress("zapata.camiones.redes@gmail.com");



                $mail->msgHTML('
                <div style="width:100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">

                    <center>
                        <img src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png" alt="logo-zapata" style="width: 20%; padding: 20px;">
                    </center>

                    <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">

                        <center>

                            <img src="https://www.zapataaeropuerto.com/img/mail/icon-email.png" alt="icono-mail" style="padding: 20px; width: 10%;">

                            <h3 style="font-weight: 100; color: #000;">
                                Se ha realizado una compra por el cliente:' . $_SESSION['nombre'] .'

                                <br> Con el correo: ' . $_SESSION['email'] .
                            '</h3>

                            <hr style="border:1px solid #ccc; width:80%;">

                            <h4 style="font-weight: 100; color: #000; padding: 0 20px;">
                                <p>
                                    La compra se realizo en la fecha ' . date('Y-m-d h:i') . '
                                    La compra fue por medio de Transferencia Electrónica
                                </p>

                            </h4>

                            <br>

                            <hr style="border:1px solid #ccc; width:80%;">

                            <h4 style="font-weight: 100; color: #000; padding: 0 20px;">

                                ' . $transferenciaHTML . '

                            </h4>

                            <br>


                        </center>

                    </div>

                </div>
                ');

                $envioComp = $mail->Send();

                if(!$envioComp){

                    echo '
                    <script> 

                        swal
                        (
                            {
                                title: "¡ERROR!",
                                text: "¡Ha ocurrido un problema enviando su información!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if(isConfirm){
                                    history.back();
                                }
                            }
                        );

                    </script>';
                }
                else{

                    echo 
                    '
                    <script> 

                        swal
                        (
                            {
                                title: "¡Excelente!",
                                text: "¡Sus datos se han enviado correctamente. Su pago será validado en un lapso de 12 a 24 horas.!",
                                type: "success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if (isConfirm) {	  
                                    window.location = rutaFrontEnd ;
                                }
                            }
                        );

                    </script>

                    ';

                }
                
			}

		}

	}
    
    
    
    static public function ctrMostrarComprobante($idUsuario){
        
        $tabla = "pagostransferencia";
        
        $respuesta = ModeloCarrito::mdlMostrarComprobante($idUsuario, $tabla);
        
        return $respuesta;
    }
    
    static public function ctrEliminarComprobante($idPagoT, $idUsuario){
        
        $tabla = "pagostransferencia";
        
        $respuesta = ModeloCarrito::EliminarComprobante($idPagoT, $idUsuario, $tabla);
        
        return $respuesta;
        
    }
    
}

