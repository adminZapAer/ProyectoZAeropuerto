<?php

$servidor = Ruta::ctrRutaServidor();

$url = Ruta::ctrRuta();

/*=============================================
INICIO DE SESIÓN USUARIO
=============================================*/

if (isset($_SESSION["validarSesion"])) {

    if ($_SESSION["validarSesion"] == "ok") {

        echo '<script>
        
            localStorage.setItem("usuario","' . $_SESSION["idUsuario"] . '");

        </script>';
    }
}

?>
<!--=================================
                HEADER
==================================-->
<header class="container-fluid">
    <!-- Contenedor Fluido -->

    <div class="container">
        <!--Contenedor estatico-->

        <div class="row" id="encabezado">
            <!-- Sistema de filas y columnas de bootstrap-->

            <?php

            $social = ControladorPlantilla::ctrEstiloPlantilla();

            ?>

            <!--=================================
                            LOGOTIPO
            ==================================-->
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="logotipo">

                <a href="https://www.refaccionariazapata.com/">
                    <img src="<?php echo $servidor; ?>vistas/img/logo-online.png" alt="logo Refaccionaria">
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

                        <a href="<?php echo $url; ?>carrito-de-compras" class="icon-compras">

                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <div class="cantidadCesta text-center"></div>

                        </a>
                        <p class="tituloSeccion">
                            Mi carrito
                            <!--COMPRAS <span class="cantidadCesta"></span>
                            <br>
                            MX $ <span class="sumaCesta"></span>-->
                        </p>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="registro">

                        <ul>

                            <?php

                            //Preguntamos si esta creada la variable sesion
                            if (isset($_SESSION["validarSesion"])) {
                                //Si esta validada la sesion
                                if ($_SESSION["validarSesion"] == "ok") {
                                    //de que modo fue que se inicio sesion
                                    if ($_SESSION["modo"] == "directo") {
                                        if ($_SESSION["foto"] != "") {
                                            echo '
                                            <li>
                                                <img class="img-usuario" src="' . $url . $_SESSION["foto"] . '">
                                            </li>
                                            ';
                                        } else {
                                            echo '
                                            <li>
                                                <img class="img-usuario" src="' . $servidor . 'vistas/img/usuarios/default/anonymous.png">
                                            </li>
                                            ';
                                        }
                                        echo '
                                        <!--<li>' . strtok($_SESSION["nombre"], " ") . ' |</li>-->
                                        <span class="dropdown">
                                            
                                            <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" style="color: #fff" onclick="this.blur();">
                                                
                                                <span class="tituloSeccionDrop">' . strtok($_SESSION["nombre"], " ") . '</span>
                                                <span class="arrow-down" style=""><i class="caret"></i></span> 
                                                
                                            </button>
                                            
                                            <ul class="dropdown-menu">
                                                <li><a href="' . $url . 'perfil">Perfil</a></li>
                                                <li class="divider"></li>
                                                <li><a href="' . $url . 'salir">Salir</a></li>
                                            </ul>
                                            
                                        </span>
                                        <!--<span class="tituloSeccion">
                                            <li>
                                                <a href="' . $url . 'perfil">Ver perfil</a>
                                            </li>
                                            <li>
                                                <a href="' . $url . 'salir">Cerrar Sesión</a>
                                            </li>
                                        </span>-->
                                        ';
                                    }
                                }
                            } else {
                                echo '
                                <li>
                                    <a href="#modalIngreso" data-toggle="modal">
                                        <span class="icon-usuario"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </a>
                                    
                                </li>
                                <span class="tituloSeccion">
                                    <li><a href="#modalIngreso" data-toggle="modal">Iniciar Sesión</a></li>
                                    <li><a href="#modalRegistro" data-toggle="modal">Registrarse</a></li>
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
                <img src="<?php echo $servidor; ?>vistas/img/camion.png" alt="logo Refaccionaria">
            </div>

        </div>
        <!--=================================
                      CATEGORIAS
        ==================================-->
        <div class="col-xs-12 backColor" id="categorias">
            <?php

            $item = null;
            $valor = null;

            $sistema = ControladorProductos::ctrMostrarSistema($item, $valor);

            //Crearemos un foreach para recorrer el contenido del arreglo almacenado en la variable categoria
            foreach ($sistema as $key => $value) {
                //var_dump($value["categoria"]);
                echo '
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
            
                    <h5>
                        <a href="' . $url . "buscador/1/recientes/" . $value["ruta"] . '" class="">' . $value["titulo"] . '</a>
                    </h5>

                </div>
                ';
            }
            //var_dump($categorias);
            ?>
        </div>



    </div>
</header>

<div class="container-fluid">
    <div class="container">

        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-2"></div>
            <div class="col-lg-6 col-md-6 col-sm-7 col-xs-8 aplicaciones">
                <ul class="horizontal">
                    <li><a href="<?php echo $url; ?>aplicacion">Aplicaciones</a></li>
                    <li><a href="<?php echo $url; ?>marca">Marca</a></li>
                    <li><a href="<?php echo $url; ?>tipo-de-sistema">Tipo de Sistema</a></li>
                    <li><a href="<?php echo $url; ?>buscador/1/recientes/Kit">Kits</a></li>
                </ul>
            </div>
            <div class="col-sm-1 col-xs-2"></div>
        </div>

    </div>
</div>

<div class="container-fluid">

    <div class="container">

        <div class="row">

            <div class="envio">
                <span>Envíos a todo México</span>
            </div>

        </div>

    </div>

    <div class="container">

        <div class="row">

            <!------------------------BUSCADOR------------------------>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>

                <div class="input-group col-lg-9 col-md-9 col-sm-8 col-xs-12" id="buscador">
                    <input type="search" name="buscar" class="form-control" id="busca" placeholder="Buscar..." value="">
                    <span class="input-group-btn">
                        <a href="<?php echo $url; ?>buscador/1/recientes">
                            <button class="btn btn-default backColor" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </a>
                    </span>
                </div>

                <div class="col-lg-1 col-md-2 col-sm-1 col-xs-12"></div>

            </div>

            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 estafeta">
                <a href="https://www.estafeta.com/Herramientas/Rastreo" style="">Rastrear mi envío</a>
                <a href="https://www.estafeta.com/Herramientas/Rastreo"><img src="<?php echo $servidor; ?>vistas/img/estafeta.jpg" alt=""></a>
            </div>

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
            <form method="post" onsubmit="return registroUsuario()">

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
                        <input type="checkbox" id="regPoliticas">
                        <small>
                            Al registrarse, usted acepta nuestras condiciones de uso y políticas de privacidad.
                            <br>
                            <a href="https://www.iubenda.com/privacy-policy/63598317" class="iubenda iubenda-black iubenda-embed" title="condiciones de uso y políticas de privacidad">Leer más</a>
                            <script type="text/javascript">
                                (function(w, d) {
                                    var loader = function() {
                                        var s = d.createElement("script"),
                                            tag = d.getElementsByTagName("script")[0];
                                        s.src = "https://cdn.iubenda.com/iubenda.js";
                                        tag.parentNode.insertBefore(s, tag);
                                    };
                                    if (w.addEventListener) {
                                        w.addEventListener("load", loader, false);
                                    } else if (w.attachEvent) {
                                        w.attachEvent("onload", loader);
                                    } else {
                                        w.onload = loader;
                                    }
                                })(window, document);
                            </script>

                        </small>
                    </label>
                </div>

                <?php

                //Creamos un objeto ControladorUsuarios y mandamos a llamar el metodo ctrRegistro Usuario
                $registro = new ControladorUsuarios();
                $registro->ctrRegistroUsuario();

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

    <div class="modal-content modal-dialog modal-lg">

        <div class="modal-body modalTitulo">

            <h3 class="backColor">REALIZAR COMPRA</h3>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <!--=====================================
            INGRESO DIRECTO
            ======================================-->
            <form method="post">

                <div class="form-group">

                    <div class="row">

                        <!-- 
                            ============================
                                INICIO DE SESION
                            ============================
                            -->

                        <div class="col-md-6" style="border-right: 1px solid gray;">

                            <h4 class="text-center">INICIAR SESIÓN</h4>

                            <div style="height: 5em">
                                    <p class="text-muted">
                                        Al iniciar sesión, tu compra será guardada en tu historial de usuario, ¡podrás configurar tus direcciones de envío y podrás facturar!.
                                    </p>
                            </div>

                            <div class="input-group">

                                <span class="input-group-addon">

                                    <i class="glyphicon glyphicon-envelope"></i>

                                </span>

                                <input type="email" class="form-control" id="ingEmail" name="ingEmail" placeholder="Correo Electrónico">

                            </div>

                            <br>

                            <div class="form-group">

                                <div class="input-group">

                                    <span class="input-group-addon">

                                        <i class="glyphicon glyphicon-lock"></i>

                                    </span>

                                    <input type="password" class="form-control" id="ingPassword" name="ingPassword" placeholder="Contraseña">

                                </div>

                            </div>


                            <input type="submit" name="opcionInicio" class="btn btn-default backColor btn-block btnIngreso" value="ENVIAR">

                        </div>

                        <div class="col-md-6">
                            
                            <h4 class="text-center">REGISTRO</h4>

                            <p class="text-muted text-center">¿No tienes una cuenta?</p>

                            <a href="#modalRegistro" data-dismiss="modal" data-toggle="modal" class="btn btn-default backColor btn-block btnIngreso" style="padding-top: 15px; padding-bottom: 15px;">REGISTRATE</a>

                            <hr>

                            <h4 class="text-center">COMPRA AL MOMENTO</h4>

                            <div style="height: 5em">
                                <p class="text-muted">
                                    Si no deseas registrarte, sólo coloca tu correo electrónico y realiza tu compra.
                                </p>
                            </div>

                            <a href="#modalCompraMom" data-dismiss="modal" data-toggle="modal" class="btn btn-default btn-block btnIngreso" style="padding-top: 15px; padding-bottom: 15px;background-color:#686de0; color: white">COMPRA RAPIDA</a>



                            <p class="text-muted">
                                <small>Al elegir esta opción la entrega del producto será realizada únicamente en Zapata Camiones.</small>
                            </p>

                        </div>

                    </div>

                    <!-- ====================================== -->



                </div>
                <center>
                    <a href="#modalPassword" data-dismiss="modal" data-toggle="modal">¿Ovidaste tu contraseña?</a>
                </center>


                <?php

                //Creamos un objeto ControladorUsuarios y mandamos a llamar el metodo ctrRegistro Usuario
                $ingreso = new ControladorUsuarios();
                $ingreso->ctrIngresoUsuario();

                ?>


                <br>

            </form>

        </div>

        <div class="modal-footer">

            <!--¿No tienes una cuenta? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Regístrate</a></strong>-->

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

                <label class="text-muted">Escribe el correo electrónico con el que estás registrado. Se enviará un correo con una nueva contraseña:</label>

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
                $Password->ctrOlvidoPassword();

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

<!--==============================================
*==   VENTANA MODAL PARA COMPRA RAPIDA  ==*
===============================================-->

<div class="modal fade modalFormulario" id="modalCompraMom" role="dialog">

    <div class="modal-content modal-dialog">

        <div class="modal-body modalTitulo">

            <h3 class="backColor">COMPRA RAPIDA</h3>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <!--==================================
            OLVIDO CONTRASEÑA
            ===================================-->
            <form method="post">

                <label class="text-muted">Si no deseas registrarte, sólo coloca tu correo electrónico y realiza tu compra.</label>

                <div class="form-group">

                    <div class="input-group">

                        <span class="input-group-addon">

                            <i class="glyphicon glyphicon-envelope"></i>

                        </span>

                        <input type="email" class="form-control" id="ingEmailAlMomento" name="ingEmailAlMomento" placeholder="Correo Electrónico" required>

                    </div>

                    <br>

                    <input type="submit" name="opcionInicio" class="btn btn-default btn-block btnIngreso" value="COMPRA AL MOMENTO" style="background-color:#686de0; color: white">
                    <p class="text-muted">
                        <small>Al elegir esta opción la entrega del producto será realizada únicamente en Zapata Camiones.</small>
                    </p>

                </div>

                <?php

                //Creamos un objeto ControladorUsuarios y mandamos a llamar el metodo ctrRegistro Usuario
                $ingreso = new ControladorUsuarios();
                $ingreso->ctrIngresoUsuario();

                ?>

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
            <a href="<?php echo $url; ?>ofertas"><img src="<?php echo $servidor; ?>vistas/img/promo.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>