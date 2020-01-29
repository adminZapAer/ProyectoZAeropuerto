<?php

class ControladorCompras{
    
    static public function ctrAgregarCompra($datos){
        
        $tabla = "compras";
        
        $respuesta = ModeloCompras::mdlAgregarCompra($tabla, $datos);
        
        return $respuesta;
        
    }

    
}

?>