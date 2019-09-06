<?php

require_once"../controladores/productos.controlador.php";
require_once"../modelos/productos.modelo.php";

class AjaxProductos{
    
    public $valor;
    public $item;
    public $ruta;
    
    public function ajaxVistaProducto(){
        $datos = array("valor" => $this->valor,
                       "ruta" => $this->ruta);
        $item = $this->item;
        $respuesta = ControladorProductos::ctrActualizarVistaProducto($datos, $item);
        echo $respuesta;
    }
    
    /*=====================================
       TRAER EL PRODUCTO DE ACUERDO AL ID
    =====================================*/
    public $idProducto;
    
    public function ajaxTraerProducto(){
        
        $item = "idProducto";
        $valor = $this->idProducto;
        
        $respuesta = ControladorProductos::ctrMostrarInfoProducto($item,$valor);
        
        echo json_encode($respuesta);
        
    }
    
    
}




if(isset($_POST["valor"])){
    $vista = new AjaxProductos();
    $vista -> valor = $_POST["valor"];
    $vista -> item = $_POST["item"];
    $vista -> ruta = $_POST["ruta"];
    $vista -> ajaxVistaProducto();
}

if(isset($_POST["idProducto"])){
    $producto = new AjaxProductos();
    $producto -> idProducto = $_POST["idProducto"];
    $producto -> ajaxTraerProducto();
}

?>