<?php
/*Se crea una clase personalizada llamada conexión, en ella se declara una función conectar de tipo publica, despues se crea una variable llamada link donde instanciamos una clase PDO. Dentro de la clase pdo declaramos los siguientes parametros:

- declaramos la conexión con la base de datos de mysql, al servidor o host, separado con ";" colocamos el nombre de la base de datos
- declaramos el nombre de usuario para conectarnos a la base de datos.
- declaramos la contraseña de usuario
- declaramos el siguiente script, el cual nos traera todo lo que sea en esccritura latina (ñ, tildes, etc.) sin problemas

luego retornamos la variable link
*/

require_once __DIR__ . "/../../vendor/autoload.php";
// if (file_exists(__DIR__ . "/../../../.env")){
    $dotenv = Dotenv\Dotenv::create(__DIR__ . "/../../");
    $dotenv->overload();
// }


class Conexion{
    public function conectar(){
        $link = new PDO($_SERVER['STRING_CONECT'],
                        $_SERVER['DB_USER'],
                        $_SERVER['DB_PASSWORD'],
                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		                      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                       );
        return $link;
    }
}    
?>