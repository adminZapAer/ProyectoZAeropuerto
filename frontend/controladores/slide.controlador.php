<?php

class ControladorSlide{
    /*Este metodo enviará un parametro al modelo con el nombre de la tabla y va a pedir una respuesta al modelo, donde se instanciará la clase Controlador Slide y se ejecutará un método llamado mdlMostrarCategorias y le asignamos como parámetro la variable $tabla.
    
    Esto que traiga el modelo lo retornará a vista.
    */
    /*=======================================================
                        MOSTRAR CATEGORIAS
    =======================================================*/
    public function ctrMostrarSlide(){
        
        $tabla = "slide";
        
        $respuesta = ModeloSlide::mdlMostrarSlide($tabla);
        
        return $respuesta;
        
    }
    
}
?>