<?php
class Ruta{
    /*---------------------------------------
                Ruta Lado Cliente
    ---------------------------------------*/
    public function ctrRuta(){
        return "http://localhost/ProyectoZAeropuerto/frontend/"; //ruta para pruebas local
        //return "http://localhost/frontend/";
        
    }
    /*---------------------------------------
                Ruta Lado Servidor
    ---------------------------------------*/
    public function ctrRutaServidor(){
        return "http://localhost/ProyectoZAeropuerto/backend/";
        //return "http://localhost/backend/";
        
    }
    
}
?>