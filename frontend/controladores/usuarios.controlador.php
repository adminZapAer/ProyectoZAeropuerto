<?php

class ControladorUsuarios{
    /*=============================================
	               REGISTRO DE USUARIO
	=============================================*/
    public function ctrRegistroUsuario(){
        
        if(isset($_POST["regUsuario"])){
            
            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario"]) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["regPassword"])){
                
                $encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                
                $encriptarEmail = md5($_POST["regEmail"]);
                
                $datos = array("nombre" => $_POST["regUsuario"],
                               "password" => $encriptar,
                               "email" => $_POST["regEmail"],
                               "modo" => "directo",
                               "foto" => "",
                               "verificacion" => 1,
                               "emailEncriptado"=> $encriptarEmail);
                
                $tabla = "usuarios";
                
                $respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);
                
                if($respuesta == "ok"){
                    /*=============================================
					VERIFICACIÓN CORREO ELECTRÓNICO
					=============================================*/
                    date_default_timezone_set("America/Mexico_City");
                    
                    $url = Ruta::ctrRuta();
                    
                    $mail = new PHPMailer;
                    
                    $mail->CharSet = 'UTF-8';
                    
                    $mail->isMail();
                    //El correo es enviado por
                    $mail->setFrom('zapata.camiones.redes@gmail.com', 'Refaccionaria Zapata Aeropuerto');
                    //Para que responda al Correo
                    $mail->addReplyTo('zapata.camiones.redes@gmail.com', 'Refaccionaria Zapata Aeropuerto');
                    //El siguiente correo no es para que responda, es solo informativo
                    $mail->Subject = "Por favor verifique su dirección de correo electrónico.";
                    //Agregamos el correo electronico al cual haremos llegar el mensaje
                    $mail->addAddress($_POST["regEmail"]);
                    //Enviaremos el contenido del Correo
                    $mail->msgHTML('
                    <div style="width:100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">
                        <center>
                            <img src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png" alt="logo-zapata" style="width: 20%; padding: 20px;">
                        </center>
                        <div style="position:relative; margin: auto; width: 600px; background: white; padding: 20px;">
                        
                            <center>
                                <img src="https://www.zapataaeropuerto.com/img/mail/icon-email.png" alt="icono-mail" style="padding: 20px; width: 15%;">
                                
                                <h3 style="font-weight: 100; color: #999;">VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO</h3>
                                
                                <hr style="border:1px solid #ccc; width:80%;">
                                
                                <h4 style="font-weight: 100; color: #999; padding: 0 20px;">Para comenzar a usar su cuenta de <strong>Refaccionaria ZAPATA AEROPUERTO</strong>, debe confirmar su dirección de correo electrónico.</h4>
                                
                                <a href="'.$url.'verificar/'.$encriptarEmail.'" target="_blank" style="text-decoration: none">
                                    <div style="line-height: 60px; background: #0aa; width: 60%; color: white;">Verifíque su dirección de correo electrónico</div>
                                </a>
                                
                                <br>
                                
                                <hr style="border:1px solid #ccc; width:80%;">
                                
                                <h5 style="font-weight: 100; color: #999;">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>
                                
                            </center>
                            
                        </div>
                        
                    </div>
                    ');
                    
                    $envio= $mail->Send();
                    
                    //Si no se envio el correo
                    if(!$envio){
                        echo '
                        <script> 
                            swal({
                                title: "¡ERROR!",
                                text: "¡Ha ocurrido un problema enviando verificación de correo electrónico a '.$_POST["regEmail"].$mailail->ErrorInfo.'!.",
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
                    else{
                        echo '
                        <script> 
                            swal({
                                title: "¡OK!",
                                text: "¡Por favor revise la bandeja de entrada o la carpeta SPAM de su correo electrónico '.$_POST["regEmail"].' para verificar la cuenta!.",
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
            else{
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
    static public function ctrMostrarUsuario($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

		return $respuesta;

	}
    
    /*=============================================
	               ACTUALIZAR USUARIO
	=============================================*/
    static public function ctrActualizarUsuario($idUsuario, $item, $valor){
        $tabla = "usuarios";
        
        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla,$idUsuario,$item,$valor);
        
        return $respuesta;
    }
    
    /*=============================================
	               INGRESO DE USUARIO
	=============================================*/
    public function ctrIngresoUsuario(){
        if(isset($_POST["ingEmail"])){
            
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingEmail"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
                
                $encriptar = crypt($_POST["ingPassword"],'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                
                $tabla = "usuarios";
                
                $item = "email";
                
                $valor = $_POST["ingEmail"];
                
                $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla,$item,$valor);
                
                //Si correo y contraseña coinciden vamos a acceder al sistema
                if($respuesta["email"] == $_POST["ingEmail"] && $respuesta["password"] == $encriptar){
                    
                    //Si el usuario no há verificado la cuenta
                    if($respuesta["verificacion"] == 1){
                        echo'
                        <script>
                            
                            swal({
                                title: "¡NO HA VERIFICADO SU CORREO ELECTRONICO!",
                                text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo para verificar la dirección de correo electrónico '.$respuesta["email"].'!.",
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
                    }
                    else{
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
                        echo '
                        <script>
                            
                            window.location = localStorage.getItem("rutaActual");
                            
                        </script>
                        ';
                        
                    }
                    
                }
                else{
                    echo'
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
                }
                
            }
            else{
                
                echo '
                <script>
                    
                    swal({
                        
                        title: "¡ERROR!",
                        text: "¡Error al ingresar al sistema, no se permiten caracteres especiales!.",
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
	               OLVIDA CONTRASEÑA
	=============================================*/
    public function ctrOlvidoPassword(){
        
        //preguntamos si viene un correo electronico
        if(isset($_POST["passEmail"])){
            
            //Evaluamos que el correo no venga con caracteres especiales
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["passEmail"])){
                
                /*=============================================
                GENERAR CONTRASEÑAS ALEATORIAS
                =============================================*/
                function generarPassword($longitud){
                    
					$key = "";
                    
					$patron = "1234567890abcdefghijklmnopqrstuvwxyz";
                    
					$max = strlen($patron)-1;
                    
					for($i = 0; $i < $longitud; $i++){
                        
						$key .= $patron{mt_rand(0,$max)};
                        
					}
                    
					return $key;
                    
				}
                
                $nuevaPassword = generarPassword(11);
                
                $encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                
                $tabla = "usuarios";
                
				$item1 = "email";
                
				$valor1 = $_POST["passEmail"];
                
				$respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item1, $valor1);
                
                if($respuesta1){
                    //Actuualiza la informacion del usuario, usuario y la contraseña temporal
					$id = $respuesta1["idUsuario"];
					$item2 = "password";
					$valor2 = $encriptar;
                    $respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item2, $valor2);
                    
                    if($respuesta2  == "ok"){
                        
                        /*=============================================
						CAMBIO DE CONTRASEÑA
						=============================================*/
                        
                        date_default_timezone_set("America/Mexico_City");
						$url = Ruta::ctrRuta();	
                        
						$mail = new PHPMailer;
                        
						$mail->CharSet = 'UTF-8';
                        
						$mail->isMail();
                        
						$mail->setFrom('zapata.camiones.redes@gmail.com', 'Refaccionaria Zapata Aeropuerto');
                        
						$mail->addReplyTo('zapata.camiones.redes@gmail.com', 'Refaccionaria Zapata Aeropuerto');
                        
						$mail->Subject = "Solicitud de nueva contraseña";
                        
						$mail->addAddress($_POST["passEmail"]);
                        
						$mail->msgHTML('
                        <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">    
				            
                            <center>
							
                                <img style="padding:20px; width:10%" src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.png">
                                
				            </center>
                            <div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
								<center>
									<img style="padding:20px; width:15%" src="https://www.zapataaeropuerto.com/img/logo/logoZapataNegro.pngicon-pass.png">
                                    
                                    <h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>
                                    
                                    <hr style="border:1px solid #ccc; width:80%">
                                    
                                    <h4 style="font-weight:100; color:#999; padding:0 20px">
                                        <strong>Su nueva contraseña: </strong>'.$nuevaPassword.'
                                    </h4>
                                    
                                    <a href="'.$url.'" target="_blank" style="text-decoration:none">
                                        
                                        <div style="line-height:60px; background:#0aa; width:60%; color:white">Ingrese nuevamente al sitio</div>
                                    </a>
                                    
                                    <br>
                                    
                                    <hr style="border:1px solid #ccc; width:80%">
                                    
                                    <h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>
                                    
                                </center>
                                
                            </div>
                            
                        </div>'
                        );
                        
						$envio = $mail->Send();
                        
                        if(!$envio){
                            
                            echo '
                            <script> 
                                
                                swal({
                                    title: "¡ERROR!",
                                    text: "¡Ha ocurrido un problema enviando cambio de contraseña a '.$_POST["passEmail"].$mail->ErrorInfo.'!",
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
                        else{
                            
                            echo '
                            <script>
                            
                                swal({
                                    title: "¡OK!",
                                    text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["passEmail"].' para su cambio de contraseña!",
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
                else{
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
                
            }
            else{
                
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
	public function ctrActualizarPerfil(){

		if(isset($_POST["editarNombre"])){

			/*=============================================
			VALIDAR IMAGEN
			=============================================*/
			$ruta = $_POST["fotoUsuario"];
            //Preguntamos si viene un archivo
			if(isset($_FILES["datosImagen"]["tmp_name"]) && !empty($_FILES["datosImagen"]["tmp_name"])){
                
				/*=============================================
				PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
				=============================================*/
                //Creamos la direccion donde se van a guardar las imagenes
				$directorio = "vistas/img/usuarios/".$_POST["idUsuario"];
                //Si hay imagen en la base de datos
				if(!empty($_POST["fotoUsuario"])){
                    //borrara del servidor la imagen existente
					unlink($_POST["fotoUsuario"]);
                    
				}else{
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
                
				if($_FILES["datosImagen"]["type"] == "image/jpeg"){
                    //Mandamos a llamar el nuevo directoro de la imagen y le asignaremos un nombre a la imagen
					$ruta = "vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".jpg";
                    
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

				if($_FILES["datosImagen"]["type"] == "image/png"){

					$ruta = "vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".png";

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
			if($_POST["editarPassword"] == ""){

				$password = $_POST["passUsuario"];

			}
            else{

				$password = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			}

			$datos = array("nombre" => $_POST["editarNombre"],
						   "email" => $_POST["editarEmail"],
						   "password" => $password,
						   "foto" => $ruta,
						   "idUsuario" => $_POST["idUsuario"]);


			$tabla = "usuarios";

			$respuesta = ModeloUsuarios::mdlActualizarPerfil($tabla, $datos);

			if($respuesta == "ok"){

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

	static public function ctrMostrarCompras($item, $valor){

		$tabla = "compras";

		$respuesta = ModeloUsuarios::mdlMostrarCompras($tabla, $item, $valor);

		return $respuesta;

	}
    
    /*=============================================
	           MOSTRAR DETALLES DE COMPRAS
	=============================================*/
    
    static public function ctrMostrarDetallesCompras($idCompra){
        
        $tabla = "detalle_compra";
        
        $respuesta = ModeloUsuarios::mdlMostrarDetallesCompras($tabla, $idCompra);
        
        return $respuesta;
    }
    
    /*=============================================
	MOSTRAR COMENTARIOS EN PERFIL
	=============================================*/

	static public function ctrMostrarComentariosPerfil($datos){

		$tabla = "comentarios";

		$respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla, $datos);

		return $respuesta;

	}
    
    /*=============================================
	ACTUALIZAR COMENTARIOS
	=============================================*/

	public function ctrActualizarComentario(){

		if(isset($_POST["idComentario"])){
            
			if(preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["comentario"])){
                
				if($_POST["comentario"] != ""){
                    
					$tabla = "comentarios";
                    
					$datos = array("idComentario"=>$_POST["idComentario"],
								   "calificacion"=>$_POST["puntaje"],
								   "comentario"=>$_POST["comentario"]);
                    
					$respuesta = ModeloUsuarios::mdlActualizarComentario($tabla, $datos);
                    
					if($respuesta == "ok"){
                        
						echo'
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

				}else{

					echo'
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

			}else{

				echo'
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

	static public function ctrAgregarDeseo($datos){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlAgregarDeseo($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LISTA DE DESEOS
	=============================================*/

	static public function ctrMostrarDeseos($item){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlMostrarDeseos($tabla, $item);

		return $respuesta;

	}

	/*=============================================
	QUITAR PRODUCTO DE LISTA DE DESEOS
	=============================================*/
	static public function ctrQuitarDeseo($datos){

		$tabla = "deseos";

		$respuesta = ModeloUsuarios::mdlQuitarDeseo($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	ELIMINAR USUARIO
	=============================================*/

	public function ctrEliminarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla1 = "usuarios";		
			$tabla2 = "comentarios";
			$tabla3 = "compras";
			$tabla4 = "deseos";

			$idUsuario = $_GET["idUsuario"];
            
            //Eliminamos la foto y la carpeta del servidor
			if($_GET["foto"] != ""){

				unlink($_GET["foto"]);
				rmdir('vistas/img/usuarios/'.$_GET["idUsuario"]);

			}

			$respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla1, $idUsuario);
			
			ModeloUsuarios::mdlEliminarComentarios($tabla2, $idUsuario);

			ModeloUsuarios::mdlEliminarCompras($tabla3, $idUsuario);

			ModeloUsuarios::mdlEliminarListaDeseos($tabla4, $idUsuario);

			if($respuesta == "ok"){

		    	$url = Ruta::ctrRuta();

		    	echo'<script>

						swal({
							  title: "¡SU CUENTA HA SIDO BORRADA!",
							  text: "¡Debe registrarse nuevamente si desea ingresar!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   window.location = "'.$url.'salir";
								  } 
						});

					  </script>';

		    }

		}

	}

    /*=============================================
    AGREGAR DIRECCIÓN
    =============================================*/

    public function ctrAgregarDireccion(){

        $tabla = "direccion";

        if(isset($_POST["cp"])){
            
            $idUsuario = $_POST["idUsuario"];

            // Guardamos los datos en un arreglo para manejarlo mejor.
            $datos = [
                'nombre'=>$_POST["nombreCompleto"],
                'celular'=>$_POST["telefono"],
                'cp'=>$_POST["cp"],
                'estado'=>$_POST["estado"],
                'municipio'=>$_POST["municipio"],
                'colonia'=>$_POST["colonia"],
                'calle'=>$_POST["calle"],
                'numext'=>$_POST["numext"],
                'numint'=>$_POST["numint"],
                'id_usuario'=>$idUsuario,
                'entreCalle'=>$_POST["entreCalle"],
                'yCalle'=>$_POST["yCalle"],
                'referencia'=>$_POST["referencia"]
            ];

            $respuesta = ModeloUsuarios::mdlAgregarDireccion($tabla, $datos);
            
            if($respuesta == "ok"){

                $url = Ruta::ctrRuta();

                echo'<script>

                        swal({
                              title: "¡Agregada correctamente!",
                              text: "Su dirección fue agregada",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "'.$url.'perfil";
                                  } 
                        });

                      </script>';

            }

        }

    }
    
    static public function ctrModificarDireccion($idDireccion){

        $tabla = "direccion";

        if(isset($_POST["cp"])){
            
            $idUsuario = $_POST["idUsuario"];

            // Guardamos los datos en un arreglo para manejarlo mejor.
            $datos = [
                'nombre'=>$_POST["nombreCompleto"],
                'celular'=>$_POST["telefono"],
                'cp'=>$_POST["cp"],
                'estado'=>$_POST["estado"],
                'municipio'=>$_POST["municipio"],
                'colonia'=>$_POST["colonia"],
                'calle'=>$_POST["calle"],
                'numext'=>$_POST["numext"],
                'numint'=>$_POST["numint"],
                'id_usuario'=>$idUsuario,
                'entreCalle'=>$_POST["entreCalle"],
                'yCalle'=>$_POST["yCalle"],
                'referencia'=>$_POST["referencia"]
            ];

            $respuesta = ModeloUsuarios::mdlModificarDireccion($tabla, $datos, $idDireccion);
            
            if($respuesta == "ok"){

                $url = Ruta::ctrRuta();

                echo'<script>

                        swal({
                              title: "¡Modificado correctamente!",
                              text: "Su dirección fue modificada",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "'.$url.'perfil";
                                  } 
                        });

                      </script>';

            }

        }

    }

    /*=============================================
    MOSTRAR LISTA DE DIRECCIONES
    =============================================*/

    static public function ctrMostrarDirecciones($item){

        $tabla = "direccion";

        $respuesta = ModeloUsuarios::mdlMostrarDirecciones($tabla, $item);

        return $respuesta;

    }
    
    static public function ctrMostrarDireccion($item, $idDireccion){

        $tabla = "direccion";

        $respuesta = ModeloUsuarios::mdlMostrarDireccion($tabla, $item, $idDireccion);

        return $respuesta;

    }
    
    /*=============================================
            MOSTRAR LISTA DE CODIGO POSTAL
    =============================================*/
    static public function ctrMostrarCP($item){
        
        $tabla = "codigo_postal";
        
        $respuesta = ModeloUsuarios::mdlMostrarCP($item, $tabla);
        
        return $respuesta;
    }
    /*=============================================
    ELIMINAR Direccion
    =============================================*/

    public function ctrEliminarDireccion(){

        if(isset($_GET["deletedir"])){

            $tabla = "direccion";

            $idDireccion = $_GET["deletedir"];
            
            $respuesta = ModeloUsuarios::mdlEliminarDireccion($tabla, $idDireccion);

            if($respuesta == "ok"){

                $url = Ruta::ctrRuta();

                echo'<script>

                        swal({
                              title: "¡SU DIRECCIÓN HA SIDO BORRADA!",
                              text: "",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "'.$url.'perfil";
                                  } 
                        });

                      </script>';

            }

        }

    }
    
    
    /*=============================================
	FORMULARIO CONTACTENOS
	=============================================*/

	public function ctrFormularioContactenos(){

		if(isset($_POST['mensajeContactenos'])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombreContactenos"]) &&
			preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["mensajeContactenos"]) &&
			preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["emailContactenos"])){

				/*=============================================
				ENVÍO CORREO ELECTRÓNICO
				=============================================*/

					date_default_timezone_set("America/Bogota");

					$url = Ruta::ctrRuta();	

					$mail = new PHPMailer;

					$mail->CharSet = 'UTF-8';

					$mail->isMail();

					$mail->setFrom('cursos@tutorialesatualcance.com', 'Tutoriales a tu Alcance');

					$mail->addReplyTo('cursos@tutorialesatualcance.com', 'Tutoriales a tu Alcance');

					$mail->Subject = "Ha recibido una consulta";

					$mail->addAddress("contacto@tiendaenlinea.com");

					$mail->msgHTML('

						<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">

						<center><img style="padding:20px; width:10%" src="http://www.tutorialesatualcance.com/tienda/logo.png"></center>

						<div style="position:relative; margin:auto; width:600px; background:white; padding-bottom:20px">

							<center>

							<img style="padding-top:20px; width:15%" src="http://www.tutorialesatualcance.com/tienda/icon-email.png">


							<h3 style="font-weight:100; color:#999;">HA RECIBIDO UNA CONSULTA</h3>

							<hr style="width:80%; border:1px solid #ccc">

							<h4 style="font-weight:100; color:#999; padding:0px 20px; text-transform:uppercase">'.$_POST["nombreContactenos"].'</h4>

							<h4 style="font-weight:100; color:#999; padding:0px 20px;">De: '.$_POST["emailContactenos"].'</h4>

							<h4 style="font-weight:100; color:#999; padding:0px 20px">'.$_POST["mensajeContactenos"].'</h4>

							<hr style="width:80%; border:1px solid #ccc">

							</center>

						</div>

					</div>');

					$envio = $mail->Send();

					if(!$envio){

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

					}else{

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

			}else{

				echo'<script>

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

    public function ctrAgregarFacturacion(){

        $tabla = "facturacion";

        if(isset($_POST["rfcPersona"])){
            
            $idUsuario = $_POST["idUsuario"];

            // Guardamos los datos en un arreglo para manejarlo mejor.
            $datos = [
                'idUsuario'=>$idUsuario,
                'nombreRazon'=>$_POST["nombreRazon"],
                'rfc'=>$_POST["rfcPersona"],
                'tipoPersona'=>$_POST["tipoPersona"],
                'calle'=>$_POST["calle"],
                'numExterior'=>$_POST["numext"],
                'numInterior'=>$_POST["numint"],
                'colonia'=>$_POST["colonia"],
                'municipio'=>$_POST["municipio"],
                'estado'=>$_POST["estado"],
                'codigoPostal'=>$_POST["codigoPostal"],
                'telefono'=>$_POST["telefono"],
                'email'=>$_POST["email"]
                
                
            ];
            
            $respuesta = ModeloUsuarios::mdlAgregarFacturacion($tabla, $datos);
            
            if($respuesta == "ok"){

                $url = Ruta::ctrRuta();

                echo'<script>

                        swal({
                              title: "¡Excelente!",
                              text: "Sus datos de facturacion fueron agregados correctamente",
                              type: "success",
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                        },

                        function(isConfirm){
                                 if (isConfirm) {      
                                   window.location = "'.$url.'perfil";
                                  } 
                        });

                      </script>';

            }

        }

    }
    
    /*=============================================
    MOSTRAR LISTA DE FACTURACIÓN
    =============================================*/
    
    static public function ctrMostrarDatosFacturacion($item){
        
        $tabla = "facturacion";
        
        $respuesta = ModeloUsuarios::mdlMostrarDatosFacturacion($tabla, $item);
        
        return $respuesta;
        
    }
    
    /*=============================================
    ELIMINAR DATOS CATURACION
    =============================================*/

    public function ctrEliminarDatosFacturacion(){
        
        if(isset($_GET["deletefact"])){
            
            $tabla = "facturacion";
            
            $idFactura = $_GET["deletefact"];
            
            $respuesta = ModeloUsuarios::mdlEliminarDatosFacturacion($tabla, $idFactura);
            
            
            if($respuesta == "ok"){
                
                $url = Ruta::ctrRuta();
                
                echo'
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
                            window.location = "'.$url.'perfil";
                        } 
                    });
                      
                </script>';
                
            }

        }
        
    }

    /*=============================================
    ANADIR VISTAS DE PRODUCTO
    =============================================*/

    public function ctrAnadirVistaProducto($datos){
        $tabla = "vistas_usuarios";

		$respuesta = ModeloUsuarios::mdlAgregarVistaProducto($tabla, $datos);

		return $respuesta;
    }
    
    /*=============================================
	ELIMINAR DATOS FACTURACION TEMPORAL
	=============================================*/
    static public function ctrEliminarFacturacionTemporal($rfcTemp, $idUsuario){
        
        $tabla = "facturacion";
        
        $respuesta = ModeloUsuarios::mdlEliminarFacturacionTemporal($tabla, $rfcTemp, $idUsuario);
        
        return $respuesta;
        
    }
    
    
    /*---------------------------------------------------------------*/
    
    
}
