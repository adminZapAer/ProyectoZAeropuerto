<?php

require_once "conexion.php";

class ModeloUsuarios
{

	/*======================================
    *==        REGISTRO DE USUARIO       ==*
    ======================================*/

	static public function mdlRegistroUsuario($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, password, email, modo, foto, verificacion, emailEncriptado) VALUES (:nombre, :password, :email, :modo, :foto, :verificacion, :emailEncriptado)");
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":modo", $datos["modo"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":verificacion", $datos["verificacion"], PDO::PARAM_INT);
		$stmt->bindParam(":emailEncriptado", $datos["emailEncriptado"], PDO::PARAM_STR);

		//si se ejecuta la operacion
		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stmt->close();
		$stmt = null;
	}

	/*======================================
    *==         MOSTRAR USUARIO          ==*
    ======================================*/

	static public function mdlMostrarUsuario($tabla, $item, $valor)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return $stmt->fetch();
		} else {
			return $stmt->errorInfo();
		}

		$stmt->close();

		$stmt = null;
	}

	/*======================================
    *==        ACTUALIZAR USUARIO        ==*
    ======================================*/
	static public function mdlActualizarUsuario($tabla, $idUsuario, $item, $valor)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR PERFIL
	=============================================*/

	static public function mdlActualizarPerfil($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, password = :password, foto = :foto WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/

	static public function mdlMostrarCompras($tabla, $item, $valor)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}
    
    /*=============================================
	           MOSTRAR DETALLES DE COMPRAS
	=============================================*/
    
    static public function mdlMostrarDetallesCompras($tabla, $idCompra){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idCompra = :idCompra");
        
        $stmt -> bindParam(":idCompra", $idCompra, PDO::PARAM_INT);
        
        $stmt -> execute();
        
        return $stmt -> fetchAll();
        
        $stmt -> close();
        
        $stmt = null;
        
    }

	/*=============================================
	MOSTRAR COMENTARIOS EN PERFIL
	=============================================*/

	static public function mdlMostrarComentariosPerfil($tabla, $datos)
	{

		if ($datos["idUsuario"] != "") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario AND idProducto = :idProducto");

			$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
			$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetch();
			
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idProducto = :idProducto ORDER BY Rand()");

			$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll();
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR COMENTARIO
	=============================================*/

	static public function mdlCrearComentario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idUsuario, idProducto, calificacion, comentario) VALUES (:idUsuario, :idProducto, :calificacion, :comentario)");
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);
		$stmt->bindParam(":calificacion", $datos["calificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt->close();

		$stmt = null;

	}

	static public function mdlActualizarComentario($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET calificacion = :calificacion, comentario = :comentario WHERE idComentario = :idComentario");

		$stmt->bindParam(":calificacion", $datos["calificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
		$stmt->bindParam(":idComentario", $datos["idComentario"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/

	static public function mdlAgregarDeseo($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idUsuario, idProducto) VALUES (:idUsuario, :idProducto)");

		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	MOSTRAR LISTA DE DESEOS
	=============================================*/

	static public function mdlMostrarDeseos($tabla, $item)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario ORDER BY idUsuario DESC");

		$stmt->bindParam(":idUsuario", $item, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/

	static public function mdlQuitarDeseo($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idDeseo = :idDeseo");

		$stmt->bindParam(":idDeseo", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	ELIMINAR USUARIO
	=============================================*/

	static public function mdlEliminarUsuario($tabla, $idUsuario)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}


	/*=============================================
	ELIMINAR COMENTARIOS DE USUARIO
	=============================================*/

	static public function mdlEliminarComentarios($tabla, $idUsuario)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}


	/*=============================================
	ELIMINAR COMPRAS DE USUARIO
	=============================================*/

	static public function mdlEliminarCompras($tabla, $idUsuario)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}


	/*=============================================
	ELIMINAR LISTA DE DESEOS DE USUARIO
	=============================================*/

	static public function mdlEliminarListaDeseos($tabla, $idUsuario)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

		$stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	AGREGAR DIRECCIÓN DE USUARIO
	=============================================*/

	public function mdlAgregarDireccion($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla 
			(nombre, celular, cp, estado, municipio, colonia, calle, numext, numint, id_usuario, entreCalle, yCalle, referencia) 
			VALUES (:nombre, :celular, :cp, :estado, :municipio, :colonia, :calle, :numext, :numint, :id_usuario, :entreCalle, :yCalle, :referencia)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
		$stmt->bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":numext", $datos["numext"], PDO::PARAM_INT);
		$stmt->bindParam(":numint", $datos["numint"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":entreCalle", $datos["entreCalle"], PDO::PARAM_STR);
		$stmt->bindParam(":yCalle", $datos["yCalle"], PDO::PARAM_STR);
		$stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}
    
    public function mdlModificarDireccion($tabla, $datos, $idDireccion)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre,  celular = :celular, cp = :cp, estado = :estado, municipio = :municipio, colonia = :colonia, calle = :calle, numext = :numext, numint = :numint, id_usuario = :id_usuario, entreCalle = :entreCalle, yCalle = :yCalle, referencia = :referencia WHERE id = :idDireccion");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		$stmt->bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
		$stmt->bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":numext", $datos["numext"], PDO::PARAM_INT);
		$stmt->bindParam(":numint", $datos["numint"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":entreCalle", $datos["entreCalle"], PDO::PARAM_STR);
		$stmt->bindParam(":yCalle", $datos["yCalle"], PDO::PARAM_STR);
		$stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
        $stmt->bindParam(":idDireccion", $idDireccion, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	MOSTRAR LISTA DE DIRECCIONES
	=============================================*/

	static public function mdlMostrarDirecciones($tabla, $item)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario ORDER BY id_usuario DESC");

		$stmt->bindParam(":id_usuario", $item, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	MOSTRAR UNA SOLA DIRECCION
	=============================================*/

	static public function mdlMostrarDireccion($tabla, $item, $id)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id = :id ORDER BY id_usuario DESC");

		$stmt->bindParam(":id_usuario", $item, PDO::PARAM_INT);
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}
    
    /*=============================================
            MOSTRAR LISTA DE CODIGO POSTAL
    =============================================*/
    
    static public function mdlMostrarCP($item, $tabla){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo_postal = :codigo_postal ORDER BY codigo_postal DESC");
        
        $stmt -> bindParam(":codigo_postal", $item, PDO::PARAM_STR);
        
        $stmt -> execute();
        
        return $stmt -> fetchAll();
        
        $stmt - close();
        
        $stmt = null;
        
    }

	/*=============================================
	ELIMINAR DIRECCION DE USUARIO
	=============================================*/

	static public function mdlEliminarDireccion($tabla, $idDireccion)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $idDireccion, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	AGREGAR DATOS DE FACTURACION
	=============================================*/

	public function mdlAgregarFacturacion($tabla, $datos){
        
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idUsuario, nombreRazon, rfc, tipoPersona, calle, numExterior, numInterior, colonia, municipio, estado, codigoPostal, telefono, email) VALUES (:idUsuario, :nombreRazon, :rfc, :tipoPersona, :calle, :numExterior, :numInterior, :colonia, :municipio, :estado, :codigoPostal, :telefono, :email)");
        
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":nombreRazon", $datos["nombreRazon"], PDO::PARAM_STR);
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPersona", $datos["tipoPersona"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":numExterior", $datos["numExterior"], PDO::PARAM_INT);
		$stmt->bindParam(":numInterior", $datos["numInterior"], PDO::PARAM_INT);
        $stmt->bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
        $stmt->bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt->bindParam(":codigoPostal", $datos["codigoPostal"], PDO::PARAM_STR);
        $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_INT);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		
        
		if($stmt -> execute()){
            
			return "ok";
            
		}else{
            
			return "error";
            
		}
        
		$stmt-> close();
        
		$stmt = null;
	}

	/*=============================================
	MOSTRAR DATOS FACTURACION
	=============================================*/

	static public function mdlMostrarDatosFacturacion($tabla, $item)
	{

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario ORDER BY idUsuario DESC");

		$stmt->bindParam(":idUsuario", $item, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	ELIMINAR DATOS FACTURACION
	=============================================*/

	static public function mdlEliminarDatosFacturacion($tabla, $idFactura)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idFactura = :idFactura");

		$stmt->bindParam(":idFactura", $idFactura, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}
    
    /*=============================================
	ELIMINAR DATOS FACTURACION TEMPORAL
	=============================================*/
    
	static public function mdlEliminarFacturacionTemporal($tabla, $rfcTemp, $idUsuario){
        
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE rfc = :rfcTemp AND idUsuario = :idUsuario");
        
		$stmt -> bindParam(":rfcTemp", $rfcTemp, PDO::PARAM_STR);
		$stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        
		if($stmt -> execute()){
            
			return "ok";
            
		}else{
            
			return "error";
            
		}
        
		$stmt-> close();
        
		$stmt = null;
        
	}

	/*=============================================
	ANADIR VISTA DE PRODUCTO
	=============================================*/

	static public function mdlAgregarVistaProducto($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario_id, producto_id) VALUES (:usuario_id, :producto_id)");

		$stmt->bindParam(":usuario_id", $datos["usuario_id"], PDO::PARAM_INT);
		$stmt->bindParam(":producto_id", $datos["producto_id"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}
}
