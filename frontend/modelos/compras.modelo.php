<?php

//El modelo requiere una conexión a la base de datos, del archivo conexion.php
require_once "conexion.php";

/* Creamos la clase modelo productos y el metodo estatico de tipo publico llamado mdlMostrarCategorias, en el metodo asignamos un parámetro llamado tabla.

El metodo tienen que ser estático por que traemos parámetros.

Declaramos una variable llamada stmt, en el ejecutaremos el metodo conectar de la clase conexion, y con las propiedades de PDO prepare ejecutaremos la instrucción de sql y la ejecutamos.

Con la instruccion fechAll retornaremos varias filas de la tabla a consultar y lo almacenaremos en la variable stmt.

Cerramos la conexión con la base de datos
Anulamos el elemento PDO para asegurar el cierre a la conexión a la base de datos.
*/
class ModeloCompras{
    
    static public function mdlMostrarProductos($tabla, $ordenar, $item, $valor, $modo){
        
        if($item != null){
            
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla ORDER BY $ordenar $modo");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> execute();

            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlAgregarCompra($tabla, $datos){

        $conexion = Conexion::conectar();
		$stmt = $conexion->prepare("INSERT INTO $tabla 
			(idUsuario, envio, costo_envio, metodo, direccion, pais, fecha, statusCompraId, validarCompra) 
			VALUES (:idUsuario, :envio, :costo_envio, :metodo, :direccion, :pais, :fecha, :statusCompraId, :validarCompra)");

		$stmt->bindParam(":idUsuario", $datos["idUsuario"], PDO::PARAM_INT);
		$stmt->bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		$stmt->bindParam(":envio", $datos["envio"], PDO::PARAM_INT);
		$stmt->bindParam(":costo_envio", $datos["costo_envio"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":statusCompraId", $datos["statusCompraId"], PDO::PARAM_INT);
        $stmt->bindParam(":validarCompra", $datos["validarCompra"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return $conexion->lastInsertId();

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;
	}
    
    
    static public function mdlListarCompras($tabla, $ordenar, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla ORDER BY $ordenar DESC");
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt = null;
    }

    static public function mdlGetCompra($id){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM productos WHERE idProducto = :idProducto");
        $stmt->bindParam(":idProducto", $id, PDO::PARAM_STR);

        if($stmt->execute()){
            return $stmt->fetch();
        }else{
            return "error";
        }

        $stmt -> close();
        $stmt = null;
    }

    static public function mdlAgregarDetalleCompra($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla 
			(idCompra, idProducto, Cantidad, precio, origen) 
			VALUES (:idCompra, :idProducto, :Cantidad, :precio, :origen)");

		$stmt->bindParam(":idCompra", $datos["idCompra"], PDO::PARAM_INT);
		$stmt->bindParam(":idProducto", $datos["idProducto"], PDO::PARAM_INT);
		$stmt->bindParam(":Cantidad", $datos["Cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":origen", $datos["origen"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";

		}else{

			return "error";

		}

		$stmt-> close();

		$stmt = null;
	}
    
}
