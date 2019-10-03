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
    
}