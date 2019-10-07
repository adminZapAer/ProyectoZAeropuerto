<?php
class Ruta{
    /*---------------------------------------
                Ruta Lado Cliente
    ---------------------------------------*/
    public function ctrRuta(){
        return getenv('RUTA_FRONT'); 
        
    }
    /*---------------------------------------
                Ruta Lado Servidor
    ---------------------------------------*/
    public function ctrRutaServidor(){
        return getenv('RUTA_BACK');
        
    }
    
}
?>