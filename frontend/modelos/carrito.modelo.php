<?php

require_once "conexion.php";

class ModeloCarrito{
    
	/*=============================================
	MOSTRAR TARIFAS
	=============================================*/
    
	static public function mdlMostrarTarifas($tabla){
        
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        
		$stmt -> execute();
        
		return $stmt -> fetch();
        
		$stmt -> close();
        
		$tmt =null;
        
	}
    
	/*=============================================
	NUEVAS COMPRAS
	=============================================*/
    
	static public function mdlNuevasCompras($tabla, $datos){
        
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idUsuario, idProducto, metodo, email, direccion, pais, cantidad, detalle, pago) VALUES (:idUsuario, :idProducto, :metodo, :email, :direccion, :pais, :cantidad, :detalle, :pago)");
        
		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);
		$stmt->bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
		$stmt->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);
        
		if($stmt->execute()){ 
            
			return "ok"; 
            
		}else{ 
            
			return "error"; 
            
		}
        
		$stmt->close();
        
		$tmt =null;
	}
    
    /*=============================================
    VERIFICAR SI EXISTEN DATOS FACTURACION
    =============================================*/
    
    static public function mdlComprobarDatosFacturacion($idUsuario, $tabla){
        
		$stmt = Conexion::conectar()->prepare("SELECT rfc FROM $tabla WHERE idUsuario = :idUsuario");
        
		$stmt -> bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        
        if($stmt -> execute()){
            //return "bien";
            $stmt -> execute();
            return $stmt -> fetch();
        }
        else{
            return "error";
        }
        
		$stmt -> close();
        
		$stmt = null;
        
	}
    
    /*=============================================
	REGISTRAR COMPROBANTE
	=============================================*/

	static public function mdlCargarComprobante($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idUsuario, idCompra, fechaPago, banco, monto, referencia, rutaIMG) VALUES (:idUsuario, :idCompra, :fechaPago, :banco, :monto, :referencia, :rutaIMG)");

		$stmt->bindParam(":idUsuario", $datos["usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":idCompra", $datos["idCompra"], PDO::PARAM_INT);
		$stmt->bindParam(":fechaPago", $datos["fechaPago"], PDO::PARAM_STR);
		$stmt->bindParam(":banco", $datos["banco"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":referencia", $datos["referencia"], PDO::PARAM_STR);
        $stmt->bindParam(":rutaIMG", $datos["foto"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
	}
    
    static public function mdlMostrarComprobante($idUsuario, $tabla){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario = :idUsuario");
        
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
            
        if($stmt -> execute()){
            //return "bien";
            $stmt -> execute();
            return $stmt -> fetch();
        }
        else{
            return "error";
        }
        
		$stmt -> close();
        
		$stmt = null;
        
    }
    
    static public function mdlEliminarComprobante($idPagoT, $idUsuario, $tabla){
        
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idUsuario = $idUsuario AND idPagoT = $idPagoT");
        
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        
        $stmt->bindParam(":idPagoT", $idPagoT, PDO::PARAM_INT);
        
        if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();

		$stmt = null;
        
    }
    
}