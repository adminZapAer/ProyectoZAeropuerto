<?php

class ControladorUsuarios
{
    /*=============================================
	               REGISTRO DE USUARIO
	=============================================*/
    public function ctrRegistroUsuario()
    {

        if (isset($_POST["regUsuario"])) {

            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario"]) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"]) && preg_match('/^[a-zA-Z0-9*+-]+$/', $_POST["regPassword"])) {

                $encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $encriptarEmail = md5($_POST["regEmail"]);

                $datos = array(
                    "nombre" => $_POST["regUsuario"],
                    "password" => $encriptar,
                    "email" => $_POST["regEmail"],
                    "modo" => "directo",
                    "foto" => "",
                    "verificacion" => 1,
                    "emailEncriptado" => $encriptarEmail
                );

                $tabla = "usuarios";

                $respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

                if ($respuesta == "ok") {
                    /*=============================================
					VERIFICACIÓN CORREO ELECTRÓNICO
					=============================================*/
                    date_default_timezone_set("America/Mexico_City");

                    $fecha = date('Y');

                    $url = Ruta::ctrRuta();

                    $mail = new PHPMailer;

                    $mail->CharSet = 'UTF-8';

                    $mail->isMail();
                    //El correo es enviado por
                    $mail->setFrom('no-replay@refaccionariazapata.com', 'Refaccionaria Online Zapata');
                    //Para que responda al Correo
                    $mail->addReplyTo('no-replay@refaccionariazapata.com', 'Refaccionaria Online Zapata');
                    //El siguiente correo no es para que responda, es solo informativo
                    $mail->Subject = "Por favor verifique su correo electrónico.";
                    //Agregamos el correo electronico al cual haremos llegar el mensaje
                    $mail->addAddress($_POST["regEmail"]);
                    //Enviaremos el contenido del Correo
                    $mail->msgHTML('
                    <header style="background: linear-gradient(0deg, rgba(193,39,45,1) 10%, rgba(0,0,0,1) 10%, rgba(0,0,0,0.8015581232492998) 15%, rgba(67,71,74,0) 30%), url(https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/fondo-cabez.jpg); width: 100%; height: 70px;">

                        <img src="https://www.refaccionariazapata.com/frontend/vistas/img/logo-online.png" alt="" style="width: 135px; float: left; margin-top:11px; margin-left:25px;">

                    </header>
                    
                    <div class="correo" style="align-content: center; justify-content: center; text-align: center; font-family: Arial; margin-top: 40px;">
                        
                        <center>
                            
                            <br>
                            
                            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/sobre-gris57x39.png" alt="">
                            
                            <h3 style="font-size: 18px;">Verifique su Correo Electrónico</h3>
                            
                            <hr style="border:1px solid #ccc; width:92%;">
                            
                        </center>
                        
                    </div>
                    
                    <body style="align-content: center; justify-content: center; text-align: center; font-family: Arial;">
                    
                        <p>Saludos '.$_POST["regUsuario"].'</p>
                        
                        <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Para comenzar a usar su cuenta de <strong>Refaccionaria Online ZAPATA</strong>, debe confirmar su dirección de correo electrónico.</h4>
                        
                        <center>
                            
                            <a href="'.$url.'verificar/'.$encriptarEmail.'" target="_blank" style="text-decoration: none">
                                <div style="line-height: 35px; background: rgba(193,39,45,1); width: 60%; color: white;">Verifíque su dirección de correo electrónico</div>
                            </a>
                            
                        </center>
                        
                        <br>
                        
                    </body>
                    
                    <footer style="background: linear-gradient(to top, black 30% ,white 80%);">
                        
                        <hr style="border:1px solid #ccc; width:80%;">
                        
                        <h5 style="font-weight: 100; color: 5d5d5d;">Si usted no se registró en esta pagina, puede ignorar este correo electrónico y la cuenta será eliminada.</h5>
                        
                        <br><br><br>
                        
                        <div style="text-align: center; align-content: center; align-items: center; justify-content: center;">
                        
                            <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 25px;">Conócenos... </a>
                            
                            <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 18px;">¿Quienes somos?</a>
                            
                            <br><br>
                            
                            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/logob.png" alt="" style="display: flex; margin: 0 auto; width: 100%; max-width: 160px;">
                            
                            <p style="color: #ffffff; font-size: 12px;">&copy; '.$fecha.'. Todos los derechos reservados.</p>
                            
                            <a href="https://www.refaccionariazapata.com/frontend/terminos-y-condiciones" target="_blank" style="color: #ffffff; font-size: 12px;">Términos y Condiciones</a>
                            
                            <br><br>
                            
                        </div>
                        
                    </footer>
                    ');

                    $envio = $mail->Send();

                    //Si no se envio el correo
                    if (!$envio) {
                        echo '
                        <script> 
                            swal({
                                title: "¡ERROR!",
                                text: "¡Ha ocurrido un problema enviando verificación de correo electrónico a ' . $_POST["regEmail"] . $mailail->ErrorInfo . '!.",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if(isConfirm){
                                    history.back();
                                }
                            });
                        </script>';
                    }
                    //Si se envía el correo se mostrara el siguiente mensaje
                    else {
                        echo '
                        <script> 
                            swal({
                                title: "¡OK!",
                                text: "¡Por favor revise la bandeja de entrada o la carpeta SPAM de su correo electrónico ' . $_POST["regEmail"] . ' para verificar la cuenta!.",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if(isConfirm){
                                    history.back();
                                }
                            });
                        </script>';
                    }
                }
            } else {
                echo '
                <script> 
                    swal({
                        title: "¡ERROR!",
                        text: "¡Error al registrar el usuario, no se permiten caracteres especiales!.",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if(isConfirm){
                            history.back();
                        }
                    });
				</script>';
            }
        }
    }
    /*=============================================
	               MOSTRAR USUARIO
	=============================================*/
    static public function ctrMostrarUsuario($item, $valor)
    {

        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	               ACTUALIZAR USUARIO
	=============================================*/
    static public function ctrActualizarUsuario($idUsuario, $item, $valor)
    {
        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $idUsuario, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	               INGRESO DE USUARIO
	=============================================*/
    public function ctrIngresoUsuario()
    {

        // print_r(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"]));
        // return;

        if (!isset($_POST["opcionInicio"])) {
            return;
        }

        if ($_POST['opcionInicio'] == 'ENVIAR' && !isset($_POST["ingEmail"])) {
            return;
        }

        if ($_POST['opcionInicio'] == 'ENVIAR' && !isset($_POST["ingPassword"])) {
            return;
        }

        if($_POST['opcionInicio'] == 'COMPRA AL MOMENTO' && !isset($_POST["ingEmailAlMomento"])){

        }

        if($_POST['opcionInicio'] == 'COMPRA AL MOMENTO'){
            $correo = $_POST["ingEmailAlMomento"];
        }else{
            $correo = $_POST["ingEmail"];
        }

        if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correo) || ($_POST['opcionInicio'] == 'ENVIAR' && !preg_match('/^[a-zA-Z0-9*+-]+$/', $_POST["ingPassword"]))) {
            echo '
            <script>
                
                swal({
                    
                    title: "¡ERROR!",
                    text: "¡Error al ingresar al sistema, no se permiten caracteres especiales, a excepción de *+-. !.",
                    type:"error",
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    
                },
                function(isConfirm){
                    
                    if(isConfirm){
                        
                        history.back();
                        
                    }
                    
                });
            </script>';
            return;
        }

        // print_r($_POST['opcionInicio']);
        // return;

        if ($_POST['opcionInicio'] == 'COMPRA AL MOMENTO') {



            $datos = array(
                "nombre" => 'INVITADO',
                "password" => crypt('', '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
                "email" => $_POST['ingEmailAlMomento'],
                "modo" => "directo",
                "foto" => "",
                "verificacion" => 0,
                "emailEncriptado" => ''
            );

            $tabla = "usuarios";

            $respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

            $email = $datos['email'];

            $password = '';
        }


        if ($_POST['opcionInicio'] == 'ENVIAR' && isset($_POST["ingEmail"])) {
            $email = $_POST["ingEmail"];
            $password = $_POST["ingPassword"];
        }

        $tabla = "usuarios";

        $item = "email";

        $valor = $email;

        $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

        //Si el usuario no há verificado la cuenta
        if ($respuesta["verificacion"] == 1) {
            echo '
                <script>
                    
                    swal({
                        title: "¡NO HA VERIFICADO SU CORREO ELECTRONICO!",
                        text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo para verificar la dirección de correo electrónico ' . $respuesta["email"] . '!.",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if(isConfirm){
                            history.back();
                        }
                    });
                    
                </script>
                ';
            return;
        }

        $encriptar = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

        // print_r(' 1: '.$respuesta["email"]);
        // print_r(' 2: '.$email);
        // print_r(' 3: '.$respuesta["password"]);
        // print_r(' 4: '.$encriptar);
        // return;

        //Si correo y contraseña no coinciden vamos a acceder al sistema


        if ($respuesta["email"] != $email || $respuesta["password"] != $encriptar) {
            echo '
                <script>

                    swal({
                        title: "¡ERROR AL INGRESAR!",
                        text: "¡Por favor revise que el email exista o la contraseña coincida con la registrada!",
                        type: "error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {	   
                            window.location = localStorage.getItem("rutaActual");
                        } 
                    });
                </script>';
            return;
        }



        //Se crean variables de sesion para validar la sesion
        $_SESSION["validarSesion"] = "ok";

        $_SESSION["idUsuario"] = $respuesta["idUsuario"];

        $_SESSION["nombre"] = $respuesta["nombre"];

        $_SESSION["foto"] = $respuesta["foto"];

        $_SESSION["email"] = $respuesta["email"];

        $_SESSION["password"] = $respuesta["password"];

        $_SESSION["modo"] = $respuesta["modo"];

        //Despues de iniciar sesion lo redireccionará a la página en donde esta la persona y no a la pagina de inicio

        //se crea un local sotorage para que almacene la direccion en donde estamos

        
        if( $_POST['opcionInicio'] == 'COMPRA AL MOMENTO' ){
            $redireccion = '"/frontend/proceder-pago"';
        }else{
            $redireccion = 'localStorage.getItem("rutaActual")';
        }

        echo '
                <script>
                    
                    window.location = '. $redireccion .';

                </script>
                ';

        
    }
    /*=============================================
	               OLVIDA CONTRASEÑA
	=============================================*/
    public function ctrOlvidoPassword()
    {

        //preguntamos si viene un correo electronico
        if (isset($_POST["passEmail"])) {

            //Evaluamos que el correo no venga con caracteres especiales
            if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["passEmail"])) {

                /*=============================================
                GENERAR CONTRASEÑAS ALEATORIAS
                =============================================*/
                function generarPassword($longitud)
                {

                    $key = "";

                    $patron = "1234567890abcdefghijklmnopqrstuvwxyz";

                    $max = strlen($patron) - 1;

                    for ($i = 0; $i < $longitud; $i++) {

                        $key .= $patron{
                            mt_rand(0, $max)};
                    }

                    return $key;
                }

                $nuevaPassword = generarPassword(11);

                $encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                $tabla = "usuarios";

                $item1 = "email";

                $valor1 = $_POST["passEmail"];

                $respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item1, $valor1);

                if ($respuesta1) {
                    //Actuualiza la informacion del usuario, usuario y la contraseña temporal
                    $id = $respuesta1["idUsuario"];
                    $item2 = "password";
                    $nombre = strtok($respuesta1["nombre"]," ");
                    $valor2 = $encriptar;
                    $respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item2, $valor2);

                    if ($respuesta2  == "ok") {

                        /*=============================================
						CAMBIO DE CONTRASEÑA
						=============================================*/

                        date_default_timezone_set("America/Mexico_City");

                        $fecha = date('Y');

                        $url = Ruta::ctrRuta();

                        $mail = new PHPMailer;

                        $mail->CharSet = 'UTF-8';

                        $mail->isMail();

                        $mail->setFrom('no-replay@refaccionariazapata.com', 'Refaccionaria Online Zapata');

                        $mail->addReplyTo('no-replay@refaccionariazapata.com', 'Refaccionaria Online Zapata');

                        $mail->Subject = "Solicitud de nueva contraseña";

                        $mail->addAddress($_POST["passEmail"]);

                        $mail->msgHTML('
                        
                        <header style="background: linear-gradient(0deg, rgba(193,39,45,1) 10%, rgba(0,0,0,1) 10%, rgba(0,0,0,0.8015581232492998) 15%, rgba(67,71,74,0) 30%), url(https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/fondo-cabez.jpg); width: 100%; height: 70px;">

                            <img src="https://www.refaccionariazapata.com/frontend/vistas/img/logo-online.png" alt="" style="width: 135px; float: left; margin-top:11px; margin-left:25px;">

                        </header>
                        
                        <div class="correo" style="align-content: center; justify-content: center; text-align: center; font-family: Arial; margin-top: 40px;">
                            
                            <center>
                                
                                <br>
                                
                                <img src="https://www.refaccionariazapata.com/frontend/vistas/img/padlock.png" alt="" style="width: 100%; max-width: 80px;">
                                
                                <h3 style="font-size: 18px;">Solicitud de nueva contraseña</h3>
                                
                                <hr style="border:1px solid #ccc; width:92%;">
                                
                            </center>
                            
                        </div>
                        
                        <body style="align-content: center; justify-content: center; text-align: center; font-family: Arial;">
                            
                            <p>Saludos '.$nombre.'</p>
                            
                            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Hemos recibido una solicitud de cambio de contraseña.</h4>
                            
                            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Su nueva contraseña es:</h4>
                            
                            <h4 style="font-weight: 100; color: #000000; padding: 0 20px;"><strong>'.$nuevaPassword.'</strong></h4>
                            
                            <center>
                                
                                <a href="'.$url.'" target="_blank" style="text-decoration:none">
                                
                                    <div style="line-height:35px; background: rgba(193,39,45,1); width:60%; color:white">Ingrese nuevamente al sitio</div>
                                
                                </a>
                                
                            </center>
                            
                            <br>
                            
                        </body>
                        
                        <footer style="background: linear-gradient(to top, black 30% ,white 80%);">
                            
                            <hr style="border:1px solid #ccc; width:80%;">
                            
                            <h4 style="font-weight: 100; color: 5d5d5d;">Favor de cambiar esta contraseña por una clave <strong>segura</strong> que pueda recordar.
                            <br><br>
                            Para cambiar la contraseña, presione la pestaña donde dice su nombre y seleccione la sección <strong>Perfil</strong>, despues dirijase a la sección <strong>Editar perfil</strong>, en ese apartado cambie la contraseña. 
                            <br><br>
                            Solo se aceptan <strong>Letras, Numeros</strong> y los siguientes <strong>caracteres especiales: "+ * /"</strong> para cambiar la contraseña.</h4>
                            
                            <br><br><br>
                            
                            <div style="text-align: center; align-content: center; align-items: center; justify-content: center;">
                                
                                <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 25px;">Conócenos... </a>
                                
                                <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 18px;">¿Quienes somos?</a>
                                
                                <br><br>
                                
                                <img src="https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/logob.png" alt="" style="display: flex; margin: 0 auto; width: 100%; max-width: 160px;">
                                
                                <p style="color: #ffffff; font-size: 12px;">&copy; '.$fecha.'. Todos los derechos reservados.</p>
                                
                                <a href="https://www.refaccionariazapata.com/frontend/terminos-y-condiciones" target="_blank" style="color: #ffffff; font-size: 12px;">Términos y Condiciones</a>
                                
                                <br><br>
                                
                            </div>
                            
                        </footer>

                        ');

                        $envio = $mail->Send();

                        if (!$envio) {

                            echo '
                            <script> 
                                
                                swal({
                                    title: "¡ERROR!",
                                    text: "¡Ha ocurrido un problema enviando cambio de contraseña a ' . $_POST["passEmail"] . $mail->ErrorInfo . '!",
                                    type:"error",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function(isConfirm){
                                    
                                    if(isConfirm){
                                        history.back();
                                    }
                                });
                                
                            </script>';
                        } else {

                            echo '
                            <script>
                            
                                swal({
                                    title: "¡OK!",
                                    text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico ' . $_POST["passEmail"] . ' para su cambio de contraseña!",
                                    type:"success",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function(isConfirm){
                                    
                                    if(isConfirm){
                                        history.back();
                                    }
                                });
                                
                            </script>';
                        }
                    }
                } else {
                    echo '
                    <script> 
                        
                        swal({
                            title: "¡ERROR!",
                            text: "¡El correo electrónico no existe!",
                            type:"error",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if(isConfirm){
                                history.back();
                            }
                        });
                        
                    </script>';
                }
            } else {

                echo '
                <script> 
				    
                    swal({
                        title: "¡ERROR!",
						text: "¡Error al enviar el correo electrónico, está mal escrito!",
						type:"error",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
                    },
                    function(isConfirm){
                        if(isConfirm){
                            history.back();
                        }
				    });
                    
				</script>';
            }
        }
    }

    /*=============================================
	ACTUALIZAR PERFIL
	=============================================*/
    public function ctrActualizarPerfil()
    {

        if (isset($_POST["editarNombre"])) {

            /*=============================================
			VALIDAR IMAGEN
			=============================================*/
            $ruta = $_POST["fotoUsuario"];
            //Preguntamos si viene un archivo
            if (isset($_FILES["datosImagen"]["tmp_name"]) && !empty($_FILES["datosImagen"]["tmp_name"])) {

                /*=============================================
				PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
				=============================================*/
                //Creamos la direccion donde se van a guardar las imagenes
                $directorio = "vistas/img/usuarios/" . $_POST["idUsuario"];
                //Si hay imagen en la base de datos
                if (!empty($_POST["fotoUsuario"])) {
                    //borrara del servidor la imagen existente
                    unlink($_POST["fotoUsuario"]);
                } else {
                    //Si no hay imagen en la base de datos creamos un nuevo directorio, en donde se va a guardar la imagen
                    mkdir($directorio, 0755);
                }

                /*=============================================
				GUARDAMOS LA IMAGEN EN EL DIRECTORIO
				=============================================*/
                //En un list almacenamos las dimensiones de la imagen
                list($ancho, $alto) = getimagesize($_FILES["datosImagen"]["tmp_name"]);

                $nuevoAncho = 500;
                $nuevoAlto = 500;

                $aleatorio = mt_rand(100, 999);

                if ($_FILES["datosImagen"]["type"] == "image/jpeg") {
                    //Mandamos a llamar el nuevo directoro de la imagen y le asignaremos un nombre a la imagen
                    $ruta = "vistas/img/usuarios/" . $_POST["idUsuario"] . "/" . $aleatorio . ".jpg";

                    /*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/
                    //creamos una nueva imagen jpg
                    $origen = imagecreatefromjpeg($_FILES["datosImagen"]["tmp_name"]);
                    //asignamos un nuevo alto y ancho a la nueva imagen
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    //definimos de donde vamos a cortar la imagen con las dimensiones para generar la nueva imagen de perfil
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    //enviamos la imagen nueva a la ruta destino
                    imagejpeg($destino, $ruta);
                }

                if ($_FILES["datosImagen"]["type"] == "image/png") {

                    $ruta = "vistas/img/usuarios/" . $_POST["idUsuario"] . "/" . $aleatorio . ".png";

                    /*=============================================
					MOFICAMOS TAMAÑO DE LA FOTO
					=============================================*/

                    $origen = imagecreatefrompng($_FILES["datosImagen"]["tmp_name"]);

                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagealphablending($destino, FALSE);

                    imagesavealpha($destino, TRUE);

                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagepng($destino, $ruta);
                }
            }

            //Si no cambia la contraseña, almacena la contraseña actual en una variable para enviarla a la bd
            if ($_POST["editarPassword"] == "") {

                $password = $_POST["passUsuario"];
            } else {

                $password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
            }

            $datos = array(
                "nombre" => $_POST["editarNombre"],
                "email" => $_POST["editarEmail"],
                "password" => $password,
                "foto" => $ruta,
                "idUsuario" => $_POST["idUsuario"]
            );


            $tabla = "usuarios";

            $respuesta = ModeloUsuarios::mdlActualizarPerfil($tabla, $datos);

            if ($respuesta == "ok") {

                $_SESSION["validarSesion"] = "ok";
                $_SESSION["idUsuario"] = $datos["idUsuario"];
                $_SESSION["nombre"] = $datos["nombre"];
                $_SESSION["foto"] = $datos["foto"];
                $_SESSION["email"] = $datos["email"];
                $_SESSION["password"] = $datos["password"];
                $_SESSION["modo"] = $_POST["modoUsuario"];

                echo '
                <script> 
				    swal({
                        title: "¡OK!",
                        text: "¡Su cuenta ha sido actualizada correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if(isConfirm){
							history.back();
						}
                    });
				</script>';
            }
        }
    }

    /*=============================================
	MOSTRAR COMPRAS
	=============================================*/

    static public function ctrMostrarCompras($item, $valor)
    {

        $tabla = "compras";

        $respuesta = ModeloUsuarios::mdlMostrarCompras($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	           MOSTRAR DETALLES DE COMPRAS
	=============================================*/

    static public function ctrMostrarDetallesCompras($idCompra)
    {

        $tabla = "detalle_compra";

        $respuesta = ModeloUsuarios::mdlMostrarDetallesCompras($tabla, $idCompra);

        return $respuesta;
    }

    /*=============================================
	MOSTRAR COMENTARIOS EN PERFIL
	=============================================*/

    static public function ctrMostrarComentariosPerfil($datos)
    {

        $tabla = "comentarios";

        $respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla, $datos);

        return $respuesta;
    }

    /*=============================================
	ACTUALIZAR COMENTARIOS
	=============================================*/

    public function ctrActualizarComentario()
    {

        if (isset($_POST["idComentario"])) {

            if (preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["comentario"])) {

                if ($_POST["comentario"] != "") {

                    $tabla = "comentarios";

                    $datos = array(
                        "idComentario" => $_POST["idComentario"],
                        "calificacion" => $_POST["puntaje"],
                        "comentario" => $_POST["comentario"]
                    );

                    $respuesta = ModeloUsuarios::mdlActualizarComentario($tabla, $datos);

                    if ($respuesta == "ok") {

                        echo '
                        <script>
				            swal({
                                title: "¡GRACIAS POR COMPARTIR SU OPINIÓN!",
                                text: "¡Su calificación y comentario ha sido guardado!",
                                type: "success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
							},
							function(isConfirm){
                                if (isConfirm) {	   
                                    history.back();
                                } 
							});
                            
                        </script>';
                    }
                } else {

                    echo '
                    <script>
						swal({
                            title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
                            text: "¡El comentario no puede estar vacío!",
                            type: "error",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
						},

						function(isConfirm){
                            if (isConfirm) {	   
                                history.back();
                            } 
						});
                    </script>';
                }
            } else {

                echo '
                <script>
                    swal({
                        title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
                        text: "¡El comentario no puede llevar caracteres especiales!",
                        type: "error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
				    },
                    function(isConfirm){
				        if (isConfirm) {	   
                            history.back();
                        } 
				    });
                </script>';
            }
        }
    }

    /*=============================================
	AGREGAR A LISTA DE DESEOS
	=============================================*/

    static public function ctrAgregarDeseo($datos)
    {

        $tabla = "deseos";

        $respuesta = ModeloUsuarios::mdlAgregarDeseo($tabla, $datos);

        return $respuesta;
    }

    /*=============================================
	MOSTRAR LISTA DE DESEOS
	=============================================*/

    static public function ctrMostrarDeseos($item)
    {

        $tabla = "deseos";

        $respuesta = ModeloUsuarios::mdlMostrarDeseos($tabla, $item);

        return $respuesta;
    }

    /*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/
    static public function ctrQuitarDeseo($datos)
    {

        $tabla = "deseos";

        $respuesta = ModeloUsuarios::mdlQuitarDeseo($tabla, $datos);

        return $respuesta;
    }

    /*=============================================
	ELIMINAR USUARIO
	=============================================*/

    public function ctrEliminarUsuario()
    {

        if (isset($_GET["idUsuario"])) {

            $tabla1 = "usuarios";
            $tabla2 = "comentarios";
            $tabla3 = "compras";
            $tabla4 = "deseos";

            $idUsuario = $_GET["idUsuario"];

            //Eliminamos la foto y la carpeta del servidor
            if ($_GET["foto"] != "") {

                unlink($_GET["foto"]);
                rmdir('vistas/img/usuarios/' . $_GET["idUsuario"]);
            }

            $respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla1, $idUsuario);

            ModeloUsuarios::mdlEliminarComentarios($tabla2, $idUsuario);

            ModeloUsuarios::mdlEliminarCompras($tabla3, $idUsuario);

            ModeloUsuarios::mdlEliminarListaDeseos($tabla4, $idUsuario);

            if ($respuesta == "ok") {

                $url = Ruta::ctrRuta();

                echo '<script>

						swal({
							  title: "¡SU CUENTA HA SIDO BORRADA!",
							  text: "¡Debe registrarse nuevamente si desea ingresar!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   window.location = "' . $url . 'salir";
								  } 
						});

					  </script>';
            }
        }
    }

    /*=============================================
    AGREGAR DIRECCIÓN
    =============================================*/

    public function ctrAgregarDireccion()
    {

        $tabla = "direccion";

        if (isset($_POST["cp"])) {

            $idUsuario = $_POST["idUsuario"];

            // Guardamos los datos en un arreglo para manejarlo mejor.
            $datos = [
                'nombre' => $_POST["nombreCompleto"],
                'celular' => $_POST["telefono"],
                'cp' => $_POST["cp"],
                'estado' => $_POST["estado"],
                'municipio' => $_POST["municipio"],
                'colonia' => $_POST["colonia"],
                'calle' => $_POST["calle"],
                'numext' => $_POST["numext"],
                'numint' => $_POST["numint"],
                'id_usuario' => $idUsuario,
                'entreCalle' => $_POST["entreCalle"],
                'yCalle' => $_POST["yCalle"],
                'referencia' => $_POST["referencia"]
            ];

            $respuesta = ModeloUsuarios::mdlAgregarDireccion($tabla, $datos);

            if ($respuesta == "ok") {

                $url = Ruta::ctrRuta();

                echo '<script>

                        swal({
                              title: "¡Agregada correctamente!",
                              text: "Su dirección fue agregada",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "' . $url . 'perfil";
                                  } 
                        });

                      </script>';
            }
        }
    }

    static public function ctrModificarDireccion($idDireccion)
    {

        $tabla = "direccion";

        if (isset($_POST["cp"])) {

            $idUsuario = $_POST["idUsuario"];

            // Guardamos los datos en un arreglo para manejarlo mejor.
            $datos = [
                'nombre' => $_POST["nombreCompleto"],
                'celular' => $_POST["telefono"],
                'cp' => $_POST["cp"],
                'estado' => $_POST["estado"],
                'municipio' => $_POST["municipio"],
                'colonia' => $_POST["colonia"],
                'calle' => $_POST["calle"],
                'numext' => $_POST["numext"],
                'numint' => $_POST["numint"],
                'id_usuario' => $idUsuario,
                'entreCalle' => $_POST["entreCalle"],
                'yCalle' => $_POST["yCalle"],
                'referencia' => $_POST["referencia"]
            ];

            $respuesta = ModeloUsuarios::mdlModificarDireccion($tabla, $datos, $idDireccion);

            if ($respuesta == "ok") {

                $url = Ruta::ctrRuta();

                echo '<script>

                        swal({
                              title: "¡Modificado correctamente!",
                              text: "Su dirección fue modificada",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "' . $url . 'perfil";
                                  } 
                        });

                      </script>';
            }
        }
    }

    /*=============================================
    MOSTRAR LISTA DE DIRECCIONES
    =============================================*/

    static public function ctrMostrarDirecciones($item)
    {

        $tabla = "direccion";

        $respuesta = ModeloUsuarios::mdlMostrarDirecciones($tabla, $item);

        return $respuesta;
    }

    static public function ctrMostrarDireccion($item, $idDireccion)
    {

        $tabla = "direccion";

        $respuesta = ModeloUsuarios::mdlMostrarDireccion($tabla, $item, $idDireccion);

        return $respuesta;
    }

    /*=============================================
            MOSTRAR LISTA DE CODIGO POSTAL
    =============================================*/
    static public function ctrMostrarCP($item)
    {

        $tabla = "codigo_postal";

        $respuesta = ModeloUsuarios::mdlMostrarCP($item, $tabla);

        return $respuesta;
    }
    /*=============================================
    ELIMINAR Direccion
    =============================================*/

    public function ctrEliminarDireccion()
    {

        if (isset($_GET["deletedir"])) {

            $tabla = "direccion";

            $idDireccion = $_GET["deletedir"];

            $respuesta = ModeloUsuarios::mdlEliminarDireccion($tabla, $idDireccion);

            if ($respuesta == "ok") {

                $url = Ruta::ctrRuta();

                echo '<script>

                        swal({
                              title: "¡SU DIRECCIÓN HA SIDO BORRADA!",
                              text: "",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "' . $url . 'perfil";
                                  } 
                        });

                      </script>';
            }
        }
    }


    /*=============================================
	FORMULARIO CONTACTENOS
	=============================================*/

    public function ctrFormularioContactenos()
    {

        if (isset($_POST['mensajeContactenos'])) {

            if (
                preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreContactenos"]) &&
                preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["mensajeContactenos"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailContactenos"])
            ) {

                /*=============================================
				ENVÍO CORREO ELECTRÓNICO
				=============================================*/

                date_default_timezone_set("America/Mexico_City");

                $fecha = date('Y');

                $url = Ruta::ctrRuta();

                $mail = new PHPMailer;

                $mail->CharSet = 'UTF-8';

                $mail->isMail();

                $mail->setFrom('no-replay@refaccionariazapata.com', 'Refaccionaria Online Zapata');

                $mail->addReplyTo('no-replay@refaccionariazapata.com', 'Refaccionaria Online Zapata');

                $mail->Subject = "Ha recibido una consulta";

                $mail->addAddress("jmolina@zapata.com.mx");

                $mail->msgHTML('
                
                <header style="background: linear-gradient(0deg, rgba(193,39,45,1) 10%, rgba(0,0,0,1) 10%, rgba(0,0,0,0.8015581232492998) 15%, rgba(67,71,74,0) 30%), url(https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/fondo-cabez.jpg); width: 100%; height: 70px;">

                    <img src="https://www.refaccionariazapata.com/frontend/vistas/img/logo-online.png" alt="" style="width: 135px; float: left; margin-top:11px; margin-left:25px;">

                </header>
                
                <div class="correo" style="align-content: center; justify-content: center; text-align: center; font-family: Arial; margin-top: 40px;">
                    
                    <br>
                    
                    <img src="https://www.refaccionariazapata.com/frontend/vistas/img/discuss-issue.png" alt="" style="width: 100%; max-width: 80px;">
                    
                    <h3 style="font-size: 18px;">Ha recibido una nueva consulta</h3>
                    
                    <hr style="border:1px solid #ccc; width:92%;">
                    
                </div>
                
                <body style="align-content: center; justify-content: center; text-align: center; font-family: Arial;">
                    
                    <p>Saludos Jose Antonio</p>
                    
                    <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">Te hicieron una pregunta en <a href="https://www.refaccionariazapata.com">Refaccionaria Online Zapata</a>.</h4>
                    
                    <h4 style="font-weight: 100; color: #000000; padding: 0 20px;">'.$_POST["mensajeContactenos"].'</h4>
                    
                    <h5 style="font-weight: 100; color: #000000; padding: 0 20px;"><strong>Estos son los datos del interesado:</strong></h5>
                    
                    <h5 style="font-weight: 100; color: #000000; padding: 0 20px;"><strong>Nombre: </strong>'.$_POST["nombreContactenos"].'</h5>
                    
                    <h5 style="font-weight: 100; color: #000000; padding: 0 20px;"><strong>E-mail: </strong>'.$_POST["emailContactenos"].'</h5>
                    
                    <br>
                    
                </body>
                
                <footer style="background: linear-gradient(to top, black 50% ,white 100%);">
                    
                    <hr style="border:1px solid #ccc; width:80%;">
                    
                    <br><br><br><br><br><br>
                    
                    <div style="text-align: center; align-content: center; align-items: center; justify-content: center;">
                        
                        <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 25px;">Conócenos... </a>
                        
                        <a href="https://www.zapataaeropuerto.com/about.html" target="_blank" style="text-decoration: none; color: #ffffff; font-size: 18px;">¿Quienes somos?</a>
                        
                        <br><br>
                        
                        <img src="https://www.refaccionariazapata.com/frontend/vistas/img/plantilla/logob.png" alt="" style="display: flex; margin: 0 auto; width: 100%; max-width: 160px;">
                        
                        <p style="color: #ffffff; font-size: 12px;">&copy; '.$fecha.'. Todos los derechos reservados.</p>
                        
                        <a href="https://www.refaccionariazapata.com/frontend/terminos-y-condiciones" target="_blank" style="color: #ffffff; font-size: 12px;">Términos y Condiciones</a>
                        
                        <br><br>
                        
                    </div>
                    
                </footer>

				');

                $envio = $mail->Send();

                if (!$envio) {

                    echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha ocurrido un problema enviando el mensaje!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';
                } else {

                    echo '<script> 

							swal({
							  title: "¡OK!",
							  text: "¡Su mensaje ha sido enviado, muy pronto le responderemos!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){
									 if (isConfirm) {	  
											history.back();
										}
							});

						</script>';
                }
            } else {

                echo '<script>

					swal({
						  title: "¡ERROR!",
						  text: "¡Problemas al enviar el mensaje, revise que no tenga caracteres especiales!",
						  type: "error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							   	window.location =  history.back();
							  } 
					});

					</script>';
            }
        }
    }

    /*---------------------------------------------------------------*/

    /*=============================================
    AGREGAR DATOS FACTURACION
    =============================================*/

    public function ctrAgregarFacturacion()
    {

        $tabla = "facturacion";

        if (isset($_POST["rfcPersona"])) {

            $idUsuario = $_POST["idUsuario"];

            // Guardamos los datos en un arreglo para manejarlo mejor.
            $datos = [
                'idUsuario' => $idUsuario,
                'nombreRazon' => $_POST["nombreRazon"],
                'rfc' => $_POST["rfcPersona"],
                'tipoPersona' => $_POST["tipoPersona"],
                'calle' => $_POST["calle"],
                'numExterior' => $_POST["numext"],
                'numInterior' => $_POST["numint"],
                'colonia' => $_POST["colonia"],
                'municipio' => $_POST["municipio"],
                'estado' => $_POST["estado"],
                'codigoPostal' => $_POST["codigoPostal"],
                'telefono' => $_POST["telefono"],
                'email' => $_POST["email"]


            ];

            $respuesta = ModeloUsuarios::mdlAgregarFacturacion($tabla, $datos);

            if ($respuesta == "ok") {

                $url = Ruta::ctrRuta();

                echo '<script>

                        swal({
                              title: "¡Excelente!",
                              text: "Sus datos de facturacion fueron agregados correctamente",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "' . $url . 'perfil";
                                  } 
                        });

                      </script>';
            }
        }
    }

    /*=============================================
    MOSTRAR LISTA DE FACTURACIÓN
    =============================================*/

    static public function ctrMostrarDatosFacturacion($item)
    {

        $tabla = "facturacion";

        $respuesta = ModeloUsuarios::mdlMostrarDatosFacturacion($tabla, $item);

        return $respuesta;
    }

    /*=============================================
    ELIMINAR DATOS CATURACION
    =============================================*/

    public function ctrEliminarDatosFacturacion()
    {

        if (isset($_GET["deletefact"])) {

            $tabla = "facturacion";

            $idFactura = $_GET["deletefact"];

            $respuesta = ModeloUsuarios::mdlEliminarDatosFacturacion($tabla, $idFactura);


            if ($respuesta == "ok") {

                $url = Ruta::ctrRuta();

                echo '
                <script>    
                    swal({
                        title: "¡SUS DATOS DE FACTURACIÓN HAN SIDO BORRADOS!",
                        text: "",
                        type: "success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {      
                            window.location = "' . $url . 'perfil";
                        } 
                    });
                      
                </script>';
            }
        }
    }

    /*=============================================
    ANADIR VISTAS DE PRODUCTO
    =============================================*/

    public function ctrAnadirVistaProducto($datos)
    {

        $tabla = "vistas_usuarios";
        $respuesta = ModeloUsuarios::mdlAgregarVistaProducto($tabla, $datos);
        return $respuesta;
    }

    /*=============================================
	ELIMINAR DATOS FACTURACION TEMPORAL
	=============================================*/
    static public function ctrEliminarFacturacionTemporal($rfcTemp, $idUsuario)
    {

        $tabla = "facturacion";

        $respuesta = ModeloUsuarios::mdlEliminarFacturacionTemporal($tabla, $rfcTemp, $idUsuario);

        return $respuesta;
    }


    /*---------------------------------------------------------------*/
}
