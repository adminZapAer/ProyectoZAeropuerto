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
    
}

