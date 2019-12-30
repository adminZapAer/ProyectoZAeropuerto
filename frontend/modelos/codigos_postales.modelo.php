<?php

require_once "conexion.php";

class ModeloCodigosPostales
{

	/*======================================
    *==        REGISTRO DE USUARIO       ==*
    ======================================*/

	static public function mdlMostrarDireccion($tabla, $item, $valor)
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
}