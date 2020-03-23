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
    
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    
    /*=======================================================
                        MOSTRAR MARCAS
    =======================================================*/
    static public function ctrMostrarMarcas($ordenar, $item, $valor, $base, $tope, $modo){
        
        $tabla = "marcas";
        
        $respuesta = ModeloProductos::mdlMostrarMarcas($tabla, $ordenar, $item, $valor, $base, $tope, $modo);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        LISTAR MARCAS
    =======================================================*/
    static public function ctrListarMarcas($ordenar, $item, $valor){
        
        $tabla = "marcas";
        
        $respuesta = ModeloProductos::mdlListarMarcas($tabla, $ordenar, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                    MOSTRAR RUTA MARCAS
    =======================================================*/
    static public function ctrMostrarRutaMarcas($item, $valor){
        
        $tabla = "marcas";
        
        $respuesta = ModeloProductos::mdlMostrarRutaMarcas($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        MOSTRAR SISTEMAS
    =======================================================*/
    static public function ctrMostrarSistemas($ordenar, $item, $valor, $base, $tope, $modo){
        
        $tabla = "sistemas";
        
        $respuesta = ModeloProductos::mdlMostrarSistemas($tabla, $ordenar, $item, $valor, $base, $tope, $modo);
        
        return $respuesta;
        
    }
    static public function ctrMostrarSistema($item, $valor){
        
        $tabla = "sistemas";
        
        $respuesta = ModeloProductos::mdlMostrarSistema($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    /*=======================================================
                        LISTAR SISTEMAS
    =======================================================*/
    static public function ctrListarSistemas($ordenar, $item, $valor){
        
        $tabla = "sistemas";
        
        $respuesta = ModeloProductos::mdlListarSistemas($tabla, $ordenar, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                    MOSTRAR RUTA SISTEMAS
    =======================================================*/
    static public function ctrMostrarRutaSistemas($item, $valor){
        
        $tabla = "sistemas";
        
        $respuesta = ModeloProductos::mdlMostrarRutaSistemas($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        MOSTRAR APLICACIONES
    =======================================================*/
    static public function ctrMostrarAplicaciones($ordenar, $item, $valor, $base, $tope, $modo){
        
        $tabla = "aplicaciones";
        
        $respuesta = ModeloProductos::mdlMostrarAplicaciones($tabla, $ordenar, $item, $valor, $base, $tope, $modo);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                        LISTAR APLICACIONES
    =======================================================*/
    static public function ctrListarAplicaciones($ordenar, $item, $valor){
        
        $tabla = "aplicaciones";
        
        $respuesta = ModeloProductos::mdlListarAplicaciones($tabla, $ordenar, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=======================================================
                    MOSTRAR RUTA APLICACIONES
    =======================================================*/
    static public function ctrMostrarRutaAplicaciones($item, $valor){
        
        $tabla = "aplicaciones";
        
        $respuesta = ModeloProductos::mdlMostrarRutaAplicaciones($tabla, $item, $valor);
        
        return $respuesta;
        
    }
    
    /*=============================================
	               ACTUALIZAR ESTATUS PROMO PRODUCTOS
	=============================================*/
    static public function ctrActualizarPromocionProd($idProducto, $item, $valor){
        $tabla = "productos";
        
        $respuesta = ModeloProductos::mdlActualizarPromocionProd($tabla,$idProducto,$item,$valor);
        
        return $respuesta;
    }
    
    /*=============================================
	               ACTUALIZAR ESTATUS PROMO SUBCATEGORIA
	=============================================*/
    static public function ctrActualizarPromocionSub($idSubcategoria, $item, $valor){
        $tabla = "subcategorias";
        
        $respuesta = ModeloProductos::mdlActualizarPromocionSub($tabla,$idSubcategoria,$item,$valor);
        
        return $respuesta;
    }
    
    /*=============================================
	               ACTUALIZAR ESTATUS PROMO CATEGORIA
	=============================================*/
    static public function ctrActualizarPromocionCat($idCategoria, $item, $valor){
        $tabla = "categorias";
        
        $respuesta = ModeloProductos::mdlActualizarPromocionCat($tabla,$idCategoria,$item,$valor);
        
        return $respuesta;
    }
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    
}
?>