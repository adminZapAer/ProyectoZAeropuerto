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
class ModeloProductos{
    static public function mdlMostrarCategorias($tabla, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR); //ENLAZA EL PARAMETRO ITEM CON VALOR
            $stmt -> execute();
            return $stmt -> fetch();
        }
        else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlMostrarSubcategorias($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlMostrarProductos($tabla, $ordenar, $item, $valor, $base, $tope, $modo){
        
        if($item != null){
            
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla ORDER BY $ordenar $modo LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> execute();

            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlMostrarInfoProducto($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlListarProductos($tabla, $ordenar, $item, $valor){
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
    
    static public function mdlMostrarBanner($tabla, $ruta){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta = :ruta");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlBuscarProductos($tabla, $busqueda, $ordenar, $modo, $base, $tope){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta like '%$busqueda%' OR titulo like '%$busqueda%' OR titular like '%$busqueda%' OR descripcion like '%$busqueda%' OR detalles like '%$busqueda%' ORDER BY $ordenar $modo LIMIT $base, $tope");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlListarProductosBusqueda($tabla, $busqueda){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta like '%$busqueda%' OR titulo like '%$busqueda%' OR titular like '%$busqueda%' OR descripcion like '%$busqueda%'");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlActualizarVistaProducto($tabla, $datos, $item){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE ruta = :ruta");
        $stmt -> bindParam(":ruta", $datos["ruta"], PDO::PARAM_STR);
        $stmt -> bindParam(":".$item, $datos["valor"], PDO::PARAM_STR);
        
        if($stmt -> execute()){
            return "ok";
        }
        else{
            return "error";
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
}
?>