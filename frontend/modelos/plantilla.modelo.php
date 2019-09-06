<?php
/*Vamos a llamar al archivo conexion.php
Creamos la clase, en el declaramos un metodo estatico de tipo publico llamado modelo estilo plantilla, el metodo es estatico cuando recibe paramoetros en sus parentesis

dentro de este metodo realizamos la conexion y ejecutamos la siguiente instrucción, donde mandamos a seleccionar todo el contenido de la tabla
retornamos los valores que estan en esta linea de la tabla. Como se trata de una sola linea se utiliza la función fetch, si son varias lineas o filas se tiene que aplicar el fetchAll()

y cerramos la conexión.*/
require_once "conexion.php";

class ModeloPlantilla{
    static public function mdlEstiloPlantilla($tabla){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        
        $stmt -> execute();
        
        return $stmt -> fetch();
        
        $stmt -> close();
        
        $stmt = null;
        
    }
    
    /*==============================================
        TRAEMOS LOS METADATOS DE LAS CABECERAS
    ==============================================*/
    
    static public function mdlTraerCabecera($ruta, $tabla){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta = :ruta");
        
        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);
        
        $stmt -> execute();
        
        return $stmt -> fetch();
        
        $stmt -> close();
        
        $stmt = null;
        
        
    }
}
?>
