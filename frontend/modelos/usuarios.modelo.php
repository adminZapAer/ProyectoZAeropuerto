<?php

require_once "conexion.php";

class ModeloUsuarios{
    
    /*======================================
    *==        REGISTRO DE USUARIO       ==*
    ======================================*/
    
    static public function mdlRegistroUsuario($tabla, $datos){
        
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, password, email, modo, foto, verificacion, emailEncriptado) VALUES (:nombre, :password, :email, :modo, :foto, :verificacion, :emailEncriptado)");
        $stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":password",$datos["password"],PDO::PARAM_STR);
        $stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
        $stmt->bindParam(":modo",$datos["modo"],PDO::PARAM_STR);
        $stmt->bindParam(":foto",$datos["foto"],PDO::PARAM_STR);
        $stmt->bindParam(":verificacion",$datos["verificacion"],PDO::PARAM_INT);
        $stmt->bindParam(":emailEncriptado",$datos["emailEncriptado"],PDO::PARAM_STR);
        
        //si se ejecuta la operacion
        if($stmt -> execute()){
            return "ok";
        }
        else{
            return "error";
        }
        $stmt -> close();
        $stmt = null;
        
    }
    
    /*======================================
    *==         MOSTRAR USUARIO          ==*
    ======================================*/
    
    static public function mdlMostrarUsuario($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        $stmt -> execute();
        
        return $stmt->fetch();
        
        $stmt -> close();
        
        $stmt = null;
    }
    
    /*======================================
    *==        ACTUALIZAR USUARIO        ==*
    ======================================*/
    static public function mdlActualizarUsuario($tabla,$idUsuario,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE idUsuario = :idUsuario");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        $stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        
        if($stmt -> execute()){
            return "ok";
        }
        else{
            return "error";
        }
        
        $stmt -> close();
        
        $stmt = null;
    }
    
    /*=============================================
	ACTUALIZAR PERFIL
	=============================================*/

	static public function mdlActualizarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, password = :password, foto = :foto WHERE idUsuario = :idUsuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;

	}
    
    /*=============================================
	MOSTRAR COMPRAS
	=============================================*/

	static public function mdlMostrarCompras($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt-> close();

		$stmt = null;

	}
    
    /*=============================================
	MOSTRAR COMENTARIOS EN PERFIL
	=============================================*/

	static public function mdlMostrarComentariosPerfil($tabla, $datos){

		if($datos["idUsuario"] != ""){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario AND idProducto = :idProducto");

			$stmt -> bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
			$stmt -> bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idProducto = :idProducto ORDER BY Rand()");

			$stmt -> bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR COMENTARIO
	=============================================*/

	static public function mdlActualizarComentario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET calificacion = :calificacion, comentario = :comentario WHERE idComentario = :idComentario");

		$stmt->bindParam(":calificacion", $datos["calificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
		$stmt->bindParam(":idComentario", $datos["idComentario"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/

	static public function mdlAgregarDeseo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idUsuario, idProducto) VALUES (:idUsuario, :idProducto)");

		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);	

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR LISTA DE DESEOS
	=============================================*/

	static public function mdlMostrarDeseos($tabla, $item){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario ORDER BY idUsuario DESC");

		$stmt -> bindParam(":idUsuario", $item, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/

	static public function mdlQuitarDeseo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idDeseo = :idDeseo");

		$stmt -> bindParam(":idDeseo", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	ELIMINAR USUARIO
	=============================================*/

	static public function mdlEliminarUsuario($tabla, $idUsuario){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

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
	ELIMINAR COMENTARIOS DE USUARIO
	=============================================*/

	static public function mdlEliminarComentarios($tabla, $idUsuario){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

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
	ELIMINAR COMPRAS DE USUARIO
	=============================================*/

	static public function mdlEliminarCompras($tabla, $idUsuario){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

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
	ELIMINAR LISTA DE DESEOS DE USUARIO
	=============================================*/

	static public function mdlEliminarListaDeseos($tabla, $idUsuario){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = :idUsuario");

		$stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;

	}


    
}
