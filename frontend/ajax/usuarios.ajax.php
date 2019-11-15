<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxUsuarios{
    
    /*========================================
    *        VALIDAR CORREO EXISTENTE        *
    ========================================*/
    public $validarEmail;
    
    public function ajaxValidarEmail(){
        
        $datos = $this->validarEmail;
        
        $respuesta = ControladorUsuarios::ctrMostrarUsuario("email", $datos);
        
        echo json_encode($respuesta);
        
    }
    
    /*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/	

	public $idUsuario;
	public $idProducto;
    
    //Creamos el metodo agregar deseo
	public function ajaxAgregarDeseo(){
        //Creamos el objeto donde almacenaremos los datos que vienen de js
		$datos = array("idUsuario"=>$this->idUsuario,
					   "idProducto"=>$this->idProducto);
        
        //Mandamos a llamar al controlador agregar deseo y enviaremos un dato, solicitando una respuesta.
        
		$respuesta = ControladorUsuarios::ctrAgregarDeseo($datos);

		echo $respuesta;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/

	public $idDeseo;	

	public function ajaxQuitarDeseo(){

		$datos = $this->idDeseo;

		$respuesta = ControladorUsuarios::ctrQuitarDeseo($datos);

		echo $respuesta;

	}
    
}

/*========================================
*        VALIDAR CORREO EXISTENTE        *
========================================*/
if(isset($_POST["validarEmail"])){
    $valEmail = new AjaxUsuarios();
    $valEmail -> validarEmail = $_POST["validarEmail"];
    $valEmail -> ajaxValidarEmail();
}

/*=============================================
AGREGAR A LISTA DE DESEOS
=============================================*/	

if(isset($_POST["idUsuario"])){

	$deseo = new AjaxUsuarios();
	$deseo -> idUsuario = $_POST["idUsuario"];
	$deseo -> idProducto = $_POST["idProducto"];
	$deseo ->ajaxAgregarDeseo();
}

/*=============================================
QUITAR PRODUCTO DE LISTA DE DESEOS
=============================================*/

if(isset($_POST["idDeseo"])){

	$quitarDeseo = new AjaxUsuarios();
	$quitarDeseo -> idDeseo = $_POST["idDeseo"];
	$quitarDeseo ->ajaxQuitarDeseo();
}
// >>>>>>> origin/paypal
