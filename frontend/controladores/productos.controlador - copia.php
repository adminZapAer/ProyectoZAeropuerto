<?php

class ControladorProductos{
    /*Este metodo enviará un parametro al modelo con el nombre de la tabla y va a pedir una respuestaal modelo, donde se instanciará la clase Modelo Productos y se ejecutará un método llamado mdlMostrarCategorias y le asignamos como parámetro la variable $tabla.
    
    Esto que traiga el modelo lo retornará a vista.
    */
    /*=======================================================
                        MOSTRAR CATEGORIAS
    =======================================================*/
    static public function ctrMostrarCategorias($item, $valor){
        
        $tabla = "categorias";
        
        $respuesta = ModeloProductos::mdlMostrarCategorias($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        MOSTRAR SUBCATEGORIAS
    =======================================================*/
    static public function ctrMostrarSubcategorias($item, $valor){
        
        $tabla = "subcategorias";
        
        $respuesta = ModeloProductos::mdlMostrarSubcategorias($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    /*=======================================================
                        MOSTRAR PRODUCTOS
    =======================================================*/
    static public function ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo){
        
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlMostrarProductos($tabla, $ordenar, $item, $valor, $base, $tope, $modo);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                    MOSTRAR INFOPRODUCTOS
    =======================================================*/
    static public function ctrMostrarInfoProducto($item, $valor){
        
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlMostrarInfoProducto($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        LISTAR PRODUCTOS
    =======================================================*/
    static public function ctrListarProductos($ordenar, $item, $valor){
        
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlListarProductos($tabla, $ordenar, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        MOSTRAR BANNER
    =======================================================*/
    static public function ctrMostrarBanner($ruta){
        
        $tabla = "banner";
        
        $respuesta = ModeloProductos::mdlMostrarBanner($tabla, $ruta);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        BUSCAR PRODUCTOS
    =======================================================*/
    static public function ctrBuscarProductos($busqueda, $ordenar, $modo, $base, $tope){
        
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlBuscarProductos($tabla, $busqueda, $ordenar, $modo, $base, $tope);
        
        return $respuesta;
        
    }
    
    static public function ctrListarProductosBusqueda($busqueda){
        
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlListarProductosBusqueda($tabla, $busqueda);
        
        return $respuesta;
    }
    
    /*=======================================================
                    ACTUALIZAR VISTA PRODUCTO
    =======================================================*/
    
    static public function ctrActualizarVistaProducto($datos, $item){
        
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlActualizarVistaProducto($tabla, $datos, $item);
        
        return $respuesta;
    }
}
?>