<?php
    class ControladorPlantilla{
        /*==============================================
                METODO PARA LLAMAR A LA PLANTILLA
        ==============================================*/
        public function plantilla(){
            include "vistas/template.php";
        }
        /*==============================================
            TRAER LOS ESTILOS DINAMICOS DE LA PLANTILLA
        ==============================================*/
        public function ctrEstiloPlantilla(){

            $tabla = "plantilla";

            $respuesta = ModeloPlantilla::mdlEstiloPlantilla($tabla);

            return $respuesta;
        }
        
        /*==============================================
            TRAEMOS LOS METADATOS DE LAS CABECERAS
        ==============================================*/
        
        static public function ctrTraerCabecera($ruta){
            
            $tabla = "cabeceras";
            
            $respuesta = ModeloPlantilla::mdlTraerCabecera($ruta, $tabla);
            
            return $respuesta;
            
        }
    }
?>