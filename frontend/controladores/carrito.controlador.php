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
				PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
				=============================================*/
                //Creamos la direccion donde se van a guardar las imagenes
				$directorio = "vistas/img/rtfc/us".$idUsuario;
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
					$ruta = "vistas/img/rtfc/us".$idUsuario."/cmp".$idUsuario."_".$aleatorio.".jpg";
                    
					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/
                    //creamos una nueva imagen jpg
					$origen = imagecreatefromjpeg($_FILES["datosRecibo"]["tmp_name"]);
                    //enviamos la imagen nueva a la ruta destino
					imagejpeg($origen, $ruta);
                    
				}

				if($_FILES["datosRecibo"]["type"] == "image/png"){
                    
                    $ruta = "vistas/img/rtfc/us".$_POST["idUsuario"]."/cmp".$idUsuario."_".$aleatorio.".png";
                    
					/*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/
                    
					$origen = imagecreatefrompng($_FILES["datosRecibo"]["tmp_name"]);
                    
					imagepng($origen, $ruta);
                    
				}
                
			}

			$datos = array("usuario" => $_SESSION["idUsuario"],
						   "fechaPago" => $fechaPago,
						   "banco" => $banco,
                           "monto" => $monto,
                           "referencia" => $referencia,
						   "foto" => $ruta);


			$tabla = "pagostransferencia";

			$respuesta = ModeloCarrito::mdlCargarComprobante($tabla, $datos);

			if($respuesta == "ok"){

				echo '
                <script> 
				    swal({
                        title: "¡Excelente!",
                        text: "¡Sus datos se han enviado correctamente. Su pago será validado en un lapso de 12 a 24 horas. Verifique el status de su producto en Mi Perfil > Mis Compras.!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if(isConfirm){
							window.location = rutaFrontEnd ;
						}
                    });
				</script>';
                
			}

		}

	}
    
}

