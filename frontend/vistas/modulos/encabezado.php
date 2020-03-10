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
                HEADER
==================================-->
<header class="container-fluid"> <!-- Contenedor Fluido -->
    
    <div class="container"> <!--Contenedor estatico-->
        
        <div class="row" id="encabezado"> <!-- Sistema de filas y columnas de bootstrap-->
            
            <?php
            
            $social = ControladorPlantilla::ctrEstiloPlantilla();
            
            ?>
            
            <!--=================================
                            LOGOTIPO
            ==================================-->
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="logotipo">
                
                <a href="<?php echo $url; ?>">
                    <img src="<?php echo $servidor;?>vistas/img/logo-online-blaco.png" alt="logo Refaccionaria">
                </a>
                
            </div>
            
            <!--=================================
                 BLOQUE CATEGORIAS Y BUSCADOR
            ==================================-->
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <!--=================================
                            BOTON CATEGORIAS
                ==================================-->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" id="btnCategorias">
                    <p>Catálogo</p>
                    <span class="pull-right icon-categ">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </span>
                </div>
                <!--=================================
                           COMPRAS Y SESION
                ==================================-->
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" id="compras-y-sesion">
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="carrito">
                        
                        <a href="<?php echo $url;?>carrito-de-compras" class="icon-compras">
                            
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            
                        </a>
                        <p class="tituloSeccion">
                            COMPRAS <span class="cantidadCesta"></span>
                            <br>
                            MX $ <span class="sumaCesta"></span>
                        </p>
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="registro">
                        
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
                                                <img class="img-usuario" src="'.$url.$_SESSION["foto"].'">
                                            </li>
                                            ';
                                        }
                                        else{
                                            echo'
                                            <li>
                                                <img class="img-usuario" src="'.$servidor.'vistas/img/usuarios/default/anonymous.png">
                                            </li>
                                            ';
                                        }
                                        echo'
                                        <!--<li>'.strtok($_SESSION["nombre"]," ").' |</li>-->
                                        <span class="dropdown">
                                            
                                            <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" style="color: #fff" onclick="this.blur();">
                                                
                                                <span class="tituloSeccionDrop">'.strtok($_SESSION["nombre"]," ").'</span>
                                                <span class="arrow-down" style=""><i class="caret"></i></span> 
                                                
                                            </button>
                                            
                                            <ul class="dropdown-menu">
                                                <li><a href="'.$url.'perfil">Perfil</a></li>
                                                <li class="divider"></li>
                                                <li><a href="'.$url.'salir">Salir</a></li>
                                            </ul>
                                            
                                        </span>
                                        <!--<span class="tituloSeccion">
                                            <li>
                                                <a href="'.$url.'perfil">Ver perfil</a>
                                            </li>
                                            <li>
                                                <a href="'.$url.'salir">Cerrar Sesión</a>
                                            </li>
                                        </span>-->
                                        ';
                                    }

                                }
                            }
                            else{
                                echo '
                                <li>
                                    <span class="icon-usuario">
                                        <a href="#modalIngreso" data-toggle="modal"><i class="fa fa-user" aria-hidden="true"></i></a>
                                    </span>
                                </li>
                                <span class="tituloSeccion">
                                    <li><a href="#modalIngreso" data-toggle="modal">Iniciar Sesión</a></li>
                                    <li><a href="#modalRegistro" data-toggle="modal">Crear Cuenta</a></li>
                                </span>
                                ';
                            }
                            
                            ?>
                            
                        </ul>
                        
                    </div>
                    
                </div>
                
            </div>
            <!--=================================
                      PROMOCIONES
            ==================================-->
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="camion">
                <a href="#modalPromociones" data-toggle="modal" style="text-decoration: none;"><img src="<?php echo $servidor;?>vistas/img/ofertas.png" alt="logo Refaccionaria"></a>
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
        
        <div class="container tipo-aplicaciones">
            
            <div class="row">
                
                <div class="col-lg-2 col-md-2"></div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block">
                    
                    <div class="col-lg-3 col-md-3 temporal"></div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 aplicaciones">
                        <a href="<?php echo $url;?>aplicacion">APLICACION</a>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 aplicaciones">
                        <a href="<?php echo $url;?>marca">MARCA</a>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 aplicaciones">
                        <a href="<?php echo $url;?>tipo-de-sistema">TIPO DE SISTEMA</a>
                    </div>
                    
                </div>
                <div class="col-lg-2 col-md-2"></div>
                
            </div>
            
        </div>
        
        
    </div>
</header>

<div class="container-fluid">
    
    <div class="container">
        
        <div class="row">
            
            <!------------------------BUSCADOR------------------------>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            <div class="input-group col-lg-8 col-md-8 col-sm-8 col-xs-12" id="buscador">
                <input type="search" name="buscar" class="form-control" id="busca" placeholder="Buscar..." value="">
                <span class="input-group-btn">
                    <a href="<?php echo $url; ?>buscador/1/recientes">
                        <button class="btn btn-default backColor" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </a>
                </span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
            
        </div>
        
    </div>
    
</div>


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


<!--==============================================-->
<div class="modal fade modalOferta" id="modalPromociones" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-body img-Promocion">
            <a href="<?php echo $url;?>ofertas"><img src="<?php echo $servidor;?>vistas/img/promo.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>