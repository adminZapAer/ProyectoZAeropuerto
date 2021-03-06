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
        
        if($item != null){
        
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
        
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
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
        
        $query = "";
        
        $palabras = array("y","además","también","más","aún","para","con","en","de","que","un","del");
        
        $tamano = count($palabras);
        
        $x = 0;
        
        while ($x < $tamano){
            
            if($palabras[$x] == $busqueda[0]){
                
                $query = "titulo = '$palabras[$x]'";
                break;
                
            }
            
            if($x == ($tamano - 1)){
                
                $query = "ruta LIKE '$busqueda[0]%' OR titulo LIKE '$busqueda[0]%' OR titular LIKE '$busqueda[0]%' OR descripcion LIKE '%$busqueda[0]%' OR detalles LIKE '%$busqueda[0]%' OR marca LIKE '%$busqueda[0]%' OR tipoSistema LIKE '%$busqueda[0]%' OR aplicacion LIKE '$busqueda[0]%' OR sku LIKE '%$busqueda[0]%' OR tipoAplicacion LIKE '%$busqueda[0]%'";
                
            }
            
            $x++;
            
        }
        
        $x = 0;
        
        for ($i = 1; $i < sizeof($busqueda); $i++){
            
            if(!empty($busqueda[$i])){
                
                while($x < $tamano){
                    
                    if($palabras[$x] == $busqueda[$i]){
                        
                        $query .= " OR titulo = '$palabras[$x]'";
                        break;
                        
                    }
                    
                    if($x == ($tamano - 1)){
                        
                        $query .= " OR ruta LIKE '%$busqueda[$i]%' OR titulo LIKE '%$busqueda[$i]%' OR titular LIKE '%$busqueda[$i]%' OR descripcion LIKE '%$busqueda[$i]%' OR detalles LIKE '%$busqueda[$i]%' OR marca LIKE '%$busqueda[$i]%' OR tipoSistema LIKE '%$busqueda[$i]%' OR aplicacion LIKE '$busqueda[$i]%' OR sku LIKE '%$busqueda[$i]%' OR tipoAplicacion LIKE '%$busqueda[$i]%'";
                        
                    }
                    
                    $x++;
                    
                }
                
                $x = 0;
                
            }
            
        }
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $query ORDER BY $ordenar $modo LIMIT $base, $tope");
        $stmt -> execute();
        return $stmt -> fetchAll();
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlListarProductosBusqueda($tabla, $busqueda){
        
        $query = "";
        
        $palabras = array("y","además","también","más","aún","para","con","en","de","que","un","del");
        
        $tamano = count($palabras);
        
        $x = 0;
        
        while ($x < $tamano){
            
            if($palabras[$x] == $busqueda[0]){
                
                $query = "titulo = '$palabras[$x]'";
                break;
                
            }
            
            if($x == ($tamano - 1)){
                
                $query = "ruta LIKE '%$busqueda[0]%' OR titulo LIKE '%$busqueda[0]%' OR titular LIKE '%$busqueda[0]%' OR descripcion LIKE '%$busqueda[0]%' OR detalles LIKE '%$busqueda[0]%' OR marca LIKE '%$busqueda[0]%' OR tipoSistema LIKE '%$busqueda[0]%' OR aplicacion LIKE '$busqueda[0]%' OR sku LIKE '%$busqueda[0]%' OR tipoAplicacion LIKE '%$busqueda[0]%'";
                
            }
            
            $x++;
            
        }
        
        $x = 0;
        
        for ($i = 1; $i < sizeof($busqueda); $i++){
            
            if(!empty($busqueda[$i])){
                
                while($x < $tamano){
                    
                    if($palabras[$x] == $busqueda[$i]){
                        
                        $query .= " OR titulo = '$palabras[$x]'";
                        break;
                        
                    }
                    
                    if($x == ($tamano - 1)){
                        
                        $query .= " OR ruta LIKE '%$busqueda[$i]%' OR titulo LIKE '%$busqueda[$i]%' OR titular LIKE '%$busqueda[$i]%' OR descripcion LIKE '%$busqueda[$i]%' OR detalles LIKE '%$busqueda[$i]%' OR marca LIKE '%$busqueda[$i]%' OR tipoSistema LIKE '%$busqueda[$i]%' OR aplicacion LIKE '$busqueda[$i]%' OR sku LIKE '%$busqueda[$i]%' OR tipoAplicacion LIKE '%$busqueda[$i]%'";
                        
                    }
                    
                    $x++;
                    
                }
                
                $x = 0;
                
            }
            
        }
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $query");
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

    static public function mdlActualizarProducto($tabla, $item, $valor, $idProducto){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE idProducto = :idProducto");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        $stmt -> bindParam(":idProducto", $idProducto, PDO::PARAM_INT);
        
        if($stmt -> execute()){
            return "ok";
        }
        else{
            return "error";
        }
        
        $stmt -> close();
        
        $stmt = null;
    }

    static public function mdlGetProducto($id){
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
    
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    
    /*=======================================================
                        MOSTRAR MARCAS
    =======================================================*/
    static public function mdlMostrarMarcas($tabla, $ordenar, $item, $valor, $base, $tope, $modo){
        
        if($item != null){
            
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> execute();

            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        LISTAR MARCAS
    =======================================================*/
    
    static public function mdlListarMarcas($tabla, $ordenar, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR RUTA MARCA
    =======================================================*/    
    
    static public function mdlMostrarRutaMarcas($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR SISTEMA
    =======================================================*/
    static public function mdlMostrarSistemas($tabla, $ordenar, $item, $valor, $base, $tope, $modo){
        
        if($item != null){
            
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> execute();

            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
    static public function mdlMostrarSistema($tabla, $item, $valor){
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
    
    /*=======================================================
                        LISTAR SISTEMA
    =======================================================*/
    
    static public function mdlListarSistemas($tabla, $ordenar, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR RUTA SISTEMA
    =======================================================*/    
    
    static public function mdlMostrarRutaSistemas($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR APLICACIONES
    =======================================================*/
    static public function mdlMostrarAplicaciones($tabla, $ordenar, $item, $valor, $base, $tope, $modo){
        
        if($item != null){
            
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> execute();

            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        LISTAR APLICACIONES
    =======================================================*/
    
    static public function mdlListarAplicaciones($tabla, $ordenar, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR RUTA APLICACIONES
    =======================================================*/    
    
    static public function mdlMostrarRutaAplicaciones($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    
    /*======================================
    *==        ACTUALIZAR PROMOCION PRODUCTO        ==*
    ======================================*/
    static public function mdlActualizarPromocionProd($tabla,$idProducto,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE idProducto = :idProducto");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        $stmt -> bindParam(":idProducto", $idProducto, PDO::PARAM_INT);
        
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
    *==        ACTUALIZAR PROMOCION SUBCATEGORIA        ==*
    ======================================*/
    static public function mdlActualizarPromocionSub($tabla,$idSubcategoria,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE idSubcategoria = :idSubcategoria");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        $stmt -> bindParam(":idSubcategoria", $idSubcategoria, PDO::PARAM_INT);
        
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
    *==        ACTUALIZAR PROMOCION CATEGORIA        ==*
    ======================================*/
    static public function mdlActualizarPromocionCat($tabla,$idCategoria,$item,$valor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE idCategoria = :idCategoria");
        
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        
        $stmt -> bindParam(":idCategoria", $idCategoria, PDO::PARAM_INT);
        
        if($stmt -> execute()){
            return "ok";
        }
        else{
            return "error";
        }
        
        $stmt -> close();
        
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR CATALOGOS
    =======================================================*/
    static public function mdlMostrarCatalogos($tabla, $ordenar, $item, $valor, $base, $tope, $modo){
        
        if($item != null){
            
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar $modo LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla LIMIT $base, $tope");//hacemos una consulta a la tabla, el cual va a estar ordenado por la variable $ordenar en modo descendente, limitando a 4 registros
            $stmt -> execute();

            return $stmt -> fetchAll();
        }
        
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        LISTAR CATALOGOS
    =======================================================*/
    
    static public function mdlListarCatalogos($tabla, $ordenar, $item, $valor){
        if($item != null){
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $ordenar DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        else{
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            
            return $stmt -> fetchAll();
        }
        $stmt -> close();
        $stmt = null;
    }
    
    /*=======================================================
                        MOSTRAR RUTA CATALOGOS
    =======================================================*/    
    
    static public function mdlMostrarRutaCatalogos($tabla, $item, $valor){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        //Vamos a enlazar parámetros con el metodo bindParam en donde item es igual al parametro recibido :$item y decimos que el parametro es entero
        $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $stmt -> execute();
        
        return $stmt -> fetch();
        $stmt -> close();
        $stmt = null;
    }
    
    /*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    
}
