<?php

$servidor = Ruta::ctrRutaServidor();

$url = Ruta::ctrRuta();

/*=============================================
INICIO DE SESIÓN USUARIO
=============================================*/

if(isset($_SESSION["validarSesion"])){

	if($_SESSION["validarSesion"] == "ok"){

		echo '<script>
		
			localStorage.setItem("usuario","'.$_SESSION["idUsuario"].'");

		</script>';

	}

}


?>
<!--=================================
                TOP
==================================-->
<div class="container-fluid barraSuperior" id="top">
    <div class="container">
        <div class="row">
            <!--==============================
            REDES SOCIALES
            ==============================-->
            <!--En escritorio grande ocupara 9 columnas, en escritorio mediano 9 columnas, en escritorio pequeño ocupara 8 columnas y en dispositivos moviles ocupara 12 columnas -->
            <div class="col-lg-8 col-md-7 col-sm-8 col-xs-12 social">
                <ul>
                    <!--==========CAMBIAR LOS ESTILOS DE LA SECCION SOCIAL Y LAS URL-->
                    <?php
                    /*Se realizara una solicitud al controlador para que cambie las caracteristicas de redes sociales*/
                    $social = ControladorPlantilla::ctrEstiloPlantilla();
                    
                    $jsonRedesSociales = json_decode($social["redesSociales"],true);
                    
                    foreach ($jsonRedesSociales as $key => $value){ 
                        echo '
                        <li>
                           <a href="'.$value["url"].'" target="_blank">
                               <i class="fa '.$value["red"].' redSocial '.$value["estilo"].'" aria-hidden="true"></i>
                           </a>
                        </li>
                        ';
                    }?>
                </ul>
            </div>
            <!--==============================
            REGISTRO DE USUARIOS
            ==============================-->
            <div class="col-lg-4 col-md-5 col-sm-4 col-xs-12 registro">
                <ul>
                    
                    <?php
                    //Preguntamos si esta creada la variable sesion
                    if(isset($_SESSION["validarSesion"])){
                        //Si esta validada la sesion
                        if($_SESSION["validarSesion"] == "ok"){
                            //de que modo fue que se inicio sesion
                            if($_SESSION["modo"] == "directo"){
                                if($_SESSION["foto"] != ""){
                                    echo'
                                    <li>
                                        <img class="img-circle" src="'.$url.$_SESSION["foto"].'" width="10%">
                                    </li>
                                    ';
                                }
                                else{
                                    echo'
                                    <li>
                                        <img class="img-circle" src="'.$servidor.'vistas/img/usuarios/default/anonymous.png" width="10%">
                                    </li>
                                    ';
                                }
                                echo'
                                <li>Bienvenido '.strtok($_SESSION["nombre"]," ").' |</li>
                                <li>
                                    <a href="'.$url.'perfil">Ver perfil</a>
                                </li>
                                <li> | </li>
                                <li>
                                    <a href="'.$url.'salir">Cerrar Sesión</a>
                                </li>
                                ';
                            }
                            
                        }
                    }
                    else{
                        echo '
                        
                        <li><a href="#modalIngreso" data-toggle="modal">Iniciar Sesión</a></li>
                        <li>|</li>
                        <li><a href="#modalRegistro" data-toggle="modal">Crear Cuenta</a></li>
                        
                        ';
                    }
                    
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--=================================
                HEADER
==================================-->
<header class="container-fluid"> <!-- Contenedor Fluido -->
    <div class="container"> <!--Contenedor estatico-->
        <div class="row" id="encabezado"> <!-- Sistema de filas y columnas de bootstrap-->
            <!--=================================
                            LOGOTIPO
            ==================================-->
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12" id="logotipo">
                <a href="<?php echo $url; ?>">
                    <img src="<?php echo $servidor.$social["logo"];?>" class="img-responsive" alt="logo">
                </a>
            </div>
            <!--=================================
                 BLOQUE CATEGORIAS Y BUSCADOR
            ==================================-->
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                <!--=================================
                            BOTON CATEGORIAS
                ==================================-->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 backColor" id="btnCategorias">
                    <p>CATÁLOGO
                        <span class="pull-right">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </span>
                    </p>
                </div>
                <!--=================================
                                BUSCADOR
                ==================================-->
                <div class="input-group col-lg-8 col-md-8 col-sm-8 col-xs-12" id="buscador">
                    <input type="search" name="buscar" class="form-control" placeholder="Buscar...">
                    <span class="input-group-btn">
                        <a href="<?php echo $url; ?>buscador/1/recientes">
                           
                            <button class="btn btn-default backColor" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </a>
                    </span>
                </div>
                
                <br>
                <div class="col-md-3 col-sm-3" id="freightliner">
                    <figure>
                        <a href="<?php echo $url."buscador/1/recientes/freightliner"; ?>">
                            <img src="<?php echo $servidor; ?>vistas/img/freightliner-logo.png" style="display:flex;  align-items: center; ">
                        </a>
                    </figure>
                </div>
                <div class="col-md-3 col-sm-3" id="mercedes">
                    <figure>
                        <a href="<?php echo $url."buscador/1/recientes/mercedes-benz"; ?>">
                            <img src="<?php echo $servidor; ?>vistas/img/logo-mercedes.png" style="display:flex;  align-items: center;">
                        </a>
                    </figure>
                </div>
                
                <div class="col-md-3 col-sm-3" id="greatdane">
                    <figure>
                        <a href="<?php echo $url."buscador/1/recientes/great-dane"; ?>">
                            <img src="<?php echo $servidor; ?>vistas/img/logo-great-dane.png" style="display:flex;  align-items: center;">
                        </a>
                    </figure>
                </div>
                
            </div>
            <!--=================================
                      CARRITO DE COMPRAS
            ==================================-->
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12" id="carrito">
                <a href="<?php echo $url;?>carrito-de-compras">
                    <button class="btn btn-default pull-left backColor">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                </a>
                <p>MI CARRITO 
                    <span class="cantidadCesta"></span>
                    <br>
                    MXN $ <span class="sumaCesta"></span>
                </p>
            </div>
            
            <br>
                
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                
                <a href="https://bit.ly/2EX1eXS" class="pull-right" target="_blank"><img src="<?php echo $servidor?>vistas/img/contacto.png" style="width: 100%; max-width: 240px;"></a>
                
            </div>
            
        </div>
        <!--=================================
                      CATEGORIAS
        ==================================-->
        <div class="col-xs-12 backColor" id="categorias">
            <?php
            
            $item = null;
            $valor = null;
            
            $categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);
            
            //Crearemos un foreach para recorrer el contenido del arreglo almacenado en la variable categoria
            foreach ($categorias as $key => $value){
                //var_dump($value["categoria"]);
                echo '
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
            
                    <h4>
                        <a href="'.$url.$value["ruta"].'" class="pixelCategorias">'.$value["categoria"].'</a>
                    </h4>
                    
                    <hr>
                    <ul>';
                
                    $item = "idCategoria";
                    
                    $valor = $value["idCategoria"];
                
                    $limite = true;
                
                    $base=0;
                
                    $tope=4;
                    
                    $subcategorias = ControladorProductos::ctrMostrarSubcategorias($item, $valor, $limite, $base, $tope);
                
                    foreach ($subcategorias as $key => $value){
                        
                        echo '<li><a href="'.$url.$value["ruta"].'" class="pixelSubCategorias">'.$value["subcategoria"].'</a></li>';
                        
                    }
                    //var_dump($subcategorias);
                    echo '
                    </ul>
                </div>
                ';
            }
            //var_dump($categorias);
            ?>
        </div>
    </div>
</header>


<!--==================================
*==   VENTANA MODAL PARA REGISTRO  ==*
===================================-->

<div class="modal fade modalFormulario" id="modalRegistro" role="dialog">
    
    <div class="modal-content modal-dialog">
        
        <div class="modal-body modalTitulo">
            
            <h3 class="backColor">REGISTRO</h3>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            <!--==================================
            *==   VENTANA MODAL PARA REGISTRO  ==*
            ===================================-->
            <!--
            <div class="col-sm-6 col-xs-12 facebook" >
                
                <p>
                    
                    <i class="fa fa-facebook"></i>
                    Registro con Facebook
                    
                </p>
                
            </div>
                
            <!--==================================
            *==   VENTANA MODAL PARA REGISTRO  ==*
            ===================================--
            
            <div class="col-sm-6 col-xs-12 google" >
                
                <p>
                    
                    <i class="fa fa-google"></i>
                    Registro con Google
                    
                </p>
                
            </div>
            -->
            <!--=====================================
			REGISTRO DIRECTO
			======================================-->
            <form method="post"  onsubmit="return registroUsuario()">
               
                <hr>
                
                <div class="form-group">
                    
                    <div class="input-group">
                       
                        <span class="input-group-addon">
                           
                            <i class="glyphicon glyphicon-user"></i>
                            
                        </span>
                        
                        <input type="text" class="form-control text-uppercase" id="regUsuario" name="regUsuario" placeholder="Nombre Completo" required>
                        
                    </div>
                    
                </div>
                
                <div class="form-group">
                   
                    <div class="input-group">
                       
                        <span class="input-group-addon">
                           
                            <i class="glyphicon glyphicon-envelope"></i>
                            
                        </span>
                        
                        <input type="email" class="form-control" id="regEmail" name="regEmail" placeholder="Correo Electrónico" required>
                        
                    </div>
                    
                </div>
                
                <div class="form-group">
                   
                    <div class="input-group">
                       
                        <span class="input-group-addon">
                           
                            <i class="glyphicon glyphicon-lock"></i>
                            
                        </span>
                        
                        <input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Contraseña" required>
                        
                    </div>
                    
                </div>
                <!--==================================
                *==   Condiciones de Uso y Politicas de Seguridad   ==*
                ===================================-->
                <div class="checkBox">
                    <label>
                        <input type="checkbox" id = "regPoliticas">
                        <small>
                            Al registrarse, usted acepta nuestras condiciones de uso y políticas de privacidad.
                            <br>
                            <a href="https://www.iubenda.com/privacy-policy/63598317" class="iubenda iubenda-black iubenda-embed" title="condiciones de uso y políticas de privacidad">Leer más</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src="https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
                            
                        </small>
                    </label>
                </div>
                
                <?php
                
                //Creamos un objeto ControladorUsuarios y mandamos a llamar el metodo ctrRegistro Usuario
                $registro = new ControladorUsuarios();
                $registro -> ctrRegistroUsuario();
                
                ?>
                
                <input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">
                
            </form>
            
        </div>
            
        <div class="modal-footer">
            
            ¿Ya tienes una cuenta registrada? | <strong><a href="#modalIngreso" data-dismiss="modal" data-toggle="modal">Inicia Sesión</a></strong>
            
        </div>
        
    </div>
    
</div>

<!--=======================================
*==   VENTANA MODAL PARA INICIO SESION  ==*
========================================-->

<div class="modal fade modalFormulario" id="modalIngreso" role="dialog">
    
    <div class="modal-content modal-dialog">
        
        <div class="modal-body modalTitulo">
            
            <h3 class="backColor">Iniciar Sesión</h3>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            <!--==================================
            *==   INICIAR SESION FACEBOOK  ==*
            ===================================
            
            <div class="col-sm-6 col-xs-12 facebook">
                
                <p>
                    
                    <i class="fa fa-facebook"></i>
                    Ingresa con Facebook
                    
                </p>
                
            </div>
                
            <!--==================================
            *==   INICIAR SESION GOOGLE  ==*
            ===================================
            
            <div class="col-sm-6 col-xs-12 google">
                
                <p>
                    
                    <i class="fa fa-google"></i>
                    Ingresa con Google
                    
                </p>
                
            </div>
            <!--=====================================
			INGRESO DIRECTO
			======================================-->
            <form method="post">
               
                <hr>
                
                <div class="form-group">
                   
                    <div class="input-group">
                       
                        <span class="input-group-addon">
                           
                            <i class="glyphicon glyphicon-envelope"></i>
                            
                        </span>
                        
                        <input type="email" class="form-control" id="ingEmail" name="ingEmail" placeholder="Correo Electrónico" required>
                        
                    </div>
                    
                </div>
                
                <div class="form-group">
                   
                    <div class="input-group">
                       
                        <span class="input-group-addon">
                           
                            <i class="glyphicon glyphicon-lock"></i>
                            
                        </span>
                        
                        <input type="password" class="form-control" id="ingPassword" name="ingPassword" placeholder="Contraseña" required>
                        
                    </div>
                    
                </div>
                
                <?php
                
                //Creamos un objeto ControladorUsuarios y mandamos a llamar el metodo ctrRegistro Usuario
                $ingreso = new ControladorUsuarios();
                $ingreso -> ctrIngresoUsuario();
                
                ?>
                
                <input type="submit" class="btn btn-default backColor btn-block btnIngreso" value="ENVIAR">
                
                <br>
                
                <center>
                    <a href="#modalPassword" data-dismiss="modal" data-toggle="modal">¿Ovidaste tu contraseña?</a>
                </center>
                
            </form>
            
        </div>
            
        <div class="modal-footer">
            
            ¿No tienes una cuenta? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Regístrate</a></strong>
            
        </div>
        
    </div>
    
</div>



<!--==============================================
*==   VENTANA MODAL PARA OLVIDO DE CONTRASEÑA  ==*
===============================================-->

<div class="modal fade modalFormulario" id="modalPassword" role="dialog">
    
    <div class="modal-content modal-dialog">
        
        <div class="modal-body modalTitulo">
            
            <h3 class="backColor">SOLICITA UNA NUEVA CONTRASEÑA</h3>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            <!--==================================
            OLVIDO CONTRASEÑA
            ===================================-->
            <form method="post">
                
                <label class = "text-muted">Escribe el correo electrónico con el que estás registrado. Se enviará un correo con una nueva contraseña:</label>
                
                <div class="form-group">
                   
                    <div class="input-group">
                       
                        <span class="input-group-addon">
                           
                            <i class="glyphicon glyphicon-envelope"></i>
                            
                        </span>
                        
                        <input type="email" class="form-control" id="passEmail" name="passEmail" placeholder="Correo Electrónico" required>
                        
                    </div>
                    
                </div>
                
                <?php
                
                //Creamos un objeto ControladorUsuarios y mandamos a llamar el metodo ctrRegistro Usuario
                $Password = new ControladorUsuarios();
                $Password -> ctrOlvidoPassword();
                
                ?>
                
                <input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">
                
                <br>

            </form>
            
        </div>
            
        <div class="modal-footer">
            
            ¿No tienes una cuenta? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Regístrate</a></strong>
            
        </div>
        
    </div>
    
</div>