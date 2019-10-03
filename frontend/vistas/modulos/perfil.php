<!--=====================================
VALIDAR SESIÓN
======================================-->

<?php

$url = Ruta::ctrRuta();
$servidor = Ruta::ctrRutaServidor();

if(!isset($_SESSION["validarSesion"])){

	echo '<script>
	
		window.location = "'.$url.'";

	</script>';

	exit();

}

?>

<!--=====================================
BREADCRUMB PERFIL
======================================-->

<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">INICIO</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>

		</div>

	</div>

</div>

<!--=====================================
SECCIÓN PERFIL
======================================-->

<div class="container-fluid">
    
    <div class="container">
        
        <ul class="nav nav-tabs">
            
            <li class="active">
                <a data-toggle="tab" href="#compras">
                    <i class="fa fa-list-ul"></i> MIS COMPRAS
                </a>
            </li>
            
            <li>
                <a data-toggle="tab" href="#deseos">
                    <i class="fa fa-gift"></i> MI LISTA DE DESEOS
                </a>
            </li>
            
            <li>				
                <a data-toggle="tab" href="#perfil">
                    <i class="fa fa-user"></i> EDITAR PERFIL
                </a>
            </li>

            <li>                
                <a data-toggle="tab" href="#direccion">
                    <i class="fa fa-map-marker"></i>  MIS DIRECCIONES
                </a>
            </li>

            <li>                
                <a data-toggle="tab" href="#facturacion">
                    <i class="fa fa-map-marker"></i>  FACTURACIÓN
                </a>
            </li>
            
            <li>				
                <a href="<?php echo $url; ?>ofertas">
                    <i class="fa fa-star"></i>	VER OFERTAS
                </a>
            </li>

            
		</ul>
        
        <div class="tab-content">
            <!--==================================
            *==       PESTAÑA MIS COMPRAS      ==*
            ===================================-->
            <div id="compras" class="tab-pane fade in active">
                
                <div class="panel-group">
                    
                    <?php
                    
                    $item = "idUsuario";
                    $valor = $_SESSION["idUsuario"];
                    
                    $compras = ControladorUsuarios::ctrMostrarCompras($item, $valor);
                    
                    if(!$compras){
                        echo '
                        <div class="col-xs-12 text-center error404">
                            <h1>
                                <small>¡Oops!</small>
                            </h1>
                            <h2>Aún no tienes compras realizadas en esta tienda</h2>
                        </div>';
                    }
                    else{
                        
                        foreach ($compras as $key => $value1) {
                            
                            $ordenar = "idProducto";
                            $item = "idProducto";
                            $valor = $value1["idProducto"];
                            
                            $productos = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);
                            
                            foreach ($productos as $key => $value2) {
                                
                                echo '
                                <div class="panel panel-default">
                                    
                                    <div class="panel-body">
                                        
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                            
                                            <figure>
                                                
                                                <img class="img-thumbnail" src="'.$servidor.$value2["portada"].'">
                                                
                                            </figure>
                                            
                                        </div>
                                        
                                        <div class="col-sm-6 col-xs-12">
                                            
                                            <h1>
                                                <small>'.$value2["titulo"].'</small>
                                            </h1>
                                            
                                            <p>'.$value2["titular"].'</p>';
                                            
                                            if($value2["tipo"] == "virtual"){
                                                
                                                echo'
                                                
                                                <a href="'.$url.'curso">
                                                    
                                                    <button class="btn btn-default pull-left">Ir al curso</button>
                                                
                                                </a>
                                                
                                                ';
                                                
                                            }
                                            else{
                                                
                                                echo '<h6>Proceso de entrega: '.$value2["entrega"].' días hábiles</h6>';
                                                
                                                if($value1["envio"] == 0){
                                                    
                                                    echo'
                                                    <div class="progress">
                                                        
                                                        <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
                                                            <i class="fa fa-check"></i> Despachado
                                                        </div>
                                                        
                                                        <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
                                                            <i class="fa fa-clock-o"></i> Enviando
                                                        </div>
                                                        
                                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
                                                            <i class="fa fa-clock-o"></i> Entregado
                                                        </div>
                                                        
                                                    </div>
                                                    ';
                                                    
                                                }
                                                if($value1["envio"] == 1){
                                                    echo'
                                                    <div class="progress">
                                                        
                                                        <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
                                                            <i class="fa fa-check"></i> Despachado
                                                        </div>
                                                        
                                                        <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
                                                            <i class="fa fa-check"></i> Enviando
                                                        </div>
                                                        
                                                        <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
                                                            <i class="fa fa-clock-o"></i> Entregado
                                                        </div>
                                                        
                                                    </div>
                                                    ';
                                                }
                                                if($value1["envio"] == 2){
                                                        
                                                        echo'
                                                        <div class="progress">
                                                        
                                                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-check"></i> Despachado
                                                            </div>
                                                            
                                                            <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-check"></i> Enviando
                                                            </div>
                                                            
                                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-check"></i> Entregado
                                                            </div>
                                                            
                                                        </div>
                                                        ';
                                                        
                                                    }
                                                    
                                                }
                                            
                                            echo'
                                                <h4 class="pull-right">
                                                    <small>
                                                        Comprado el '.substr($value1["fecha"],0,-8).'
                                                    </small>
                                                </h4>
                                                
                                            </div>
                                            
                                            <div class="col-md-4 col-xs-12">';
                                            
                                            $datos = array("idUsuario"=>$_SESSION["idUsuario"], "idProducto"=>$value2["idProducto"] );
                                            
                                            $comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);
                                            
                                            echo '
                                            
                                            <div class="pull-right">
                                                
                                                <a class="calificarProducto" href="#modalComentarios" data-toggle="modal" idComentario="'.$comentarios["idComentario"].'">
                                                    <button class="btn btn-default backColor">Calificar Producto</button>
                                                </a>
                                                
                                            </div>
                                            
                                            <br><br>
                                            
                                            <div class="pull-right">
                                                
                                                <h3 class="text-right">';
                                                
                                                if($comentarios["calificacion"] == 0 && $comentarios["comentario"] == ""){
                                                    echo'
                                                    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                    ';
                                                }
                                                else{
                                                    
                                                    switch($comentarios["calificacion"]){
                                                        case 0.5:
                                                            echo '
                                                            <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i><i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>'; 
                                                        break;
                                                        
                                                        case 1.0:
                                                            echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;
                                                        
                                                        case 1.5:
															echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

												        case 2.0:
															echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

												        case 2.5:
															echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

												        case 3.0:
															echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

												        case 3.5:
                                                            echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

												        case 4.0:
															echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
															break;

												        case 4.5:
                                                            echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>';
															break;

												        case 5.0:
                                                            echo '
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>
                                                            <i class="fa fa-star text-success" aria-hidden="true"></i>';
															break;
                                                        
                                                    }
                                                    
                                                }
                                            echo'
                                                </h3>
                                                
                                                <p class="panel panel-default text-right" style="padding:5px">
                                                    
                                                    <small>
                                                        '.$comentarios["comentario"].'
                                                    </small>
                                                    
                                                </p>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                
                                </div>
                                ';
                                    
                                }
                            }
                        }
                        
                        
                    ?>
                    
                </div>
                
            </div>
            
            <!--==================================
            *==         PESTAÑA DESEOS         ==*
            ===================================-->
            
            <div id="deseos" class="tab-pane fade">
                <?php
                
                $item = $_SESSION["idUsuario"];
                
                $deseos = ControladorUsuarios::ctrMostrarDeseos($item);
                
                if(!$deseos){
                    echo '
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center error404">
                        <h1><small>¡Oops!</small></h1>
                        
                        
                    </div>';
                }
                else{
                    
                    foreach ($deseos as $key => $value1) {
                        
                        $ordenar = "idProducto";
                        $valor = $value1["idProducto"];
                        $item = "idProducto";
                        
                        $productos = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);
                        
                        echo '<ul class="grid0">';
                        
                        foreach ($productos as $key => $value2) {
                            
                            echo '
                            <li class="col-md-3 col-sm-6 col-xs-12">
                                
                                <figure>
                                    
                                    <a href="'.$url.$value2["ruta"].'" class="pixelProducto">
                                        
                                        <img src="'.$servidor.$value2["portada"].'" class="img-responsive">
                                        
                                    </a>
                                    
                                </figure>
                                
                                <h4>
                                    
                                    <small>
                                        
                                        <a href="'.$url.$value2["ruta"].'" class="pixelProducto">
                                        
                                            '.$value2["titulo"].'<br>
                                            
                                            <span style="color:rgba(0,0,0,0)">-</span>';
                                                if($value2["nuevo"] != 0){
                                                    echo '<span class="label label-warning fontSize">Nuevo</span> ';
                                                }
                                                
                                                if($value2["oferta"] != 0){
                                                    echo '<span class="label label-warning fontSize">'.$value2["descuentoOferta"].'% de descuento</span>';
                                                } 
                                        
                                        echo'
                                        </a>
                                        
                                    </small>
                                    
                                </h4>
                                <div class="col-xs-6 precio">';
                                
                                if($value2["precio"] == 0){
                                    echo '<h2 style="margin-top:-10px"><small>GRATIS</small></h2>';
                                }
                                else{
                                    
                                    if($value2["oferta"] != 0){
                                        
                                        echo '
                                        <h2 style="margin-top:-10px">
                                            
                                            <small>
                                                <strong class="oferta" style="font-size:12px">MXN $'.$value2["precio"].'</strong>
                                            </small>
                                            
                                            <small>$'.$value2["precioOferta"].'</small>
                                            
                                        </h2>';
                                        
                                    }
                                    else{
                                        
                                        echo '<h2 style="margin-top:-10px"><small>MXN $'.$value2["precio"].'</small></h2>';
                                        
                                    }
                                    
                                }
                                
                                echo'
                                </div>
                                
                                <div class="col-xs-6 enlaces">
                                
                                    <div class="btn-group pull-right">
                                        
                                        <button type="button" class="btn btn-danger btn-xs quitarDeseo" idDeseo="'.$value1["idDeseo"].'" data-toggle="tooltip" title="Quitar de mi lista de deseos">
                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                        </button>';
                                        
                                        if($value2["tipo"] == "virtual" && $value2["precio"] != 0){
                                            
                                            if($value2["oferta"] != 0){
                                                echo '
                                                <button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value2["idProducto"].'" imagen="'.$servidor.$value2["portada"].'" titulo="'.$value2["titulo"].'" precio="'.$value2["precioOferta"].'" tipo="'.$value2["tipo"].'" peso="'.$value2["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">
                                                    
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                    
                                                </button>';
                                            }
                                            else{
                                                echo '
                                                <button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value2["idProducto"].'" imagen="'.$servidor.$value2["portada"].'" titulo="'.$value2["titulo"].'" precio="'.$value2["precio"].'" tipo="'.$value2["tipo"].'" peso="'.$value2["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">
                                                    
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                    
                                                </button>';
                                            }
                                            
                                        }
                                        
                                        echo'
                                        <a href="'.$url.$value2["ruta"].'" class="pixelProducto">
                                            
                                            <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">
                                                
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                
                                            </button>
                                            
                                        </a>
                                        
                                        
                                    </div>
                                    
                                </div>
                            
                            </li>
                            ';
                            
                        }
                        echo'
                        </ul>';
                        
                    }
                    
                }
                
                ?>
                
            </div>
            
            <!--==================================
            *==         PESTAÑA PERFIL         ==*
            ===================================-->
            
            <div id="perfil" class="tab-pane fade">
                <div class="row">
                    
                    <form method="post" enctype="multipart/form-data">
                        
                        <div class="col-md-3 col-sm-4 col-xs-12 text-center">
                            
                            <br>
                            
                            <figure id="imgPerfil">
                                
                                <?php
                                
                                echo'
                                <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">
                                <input type="hidden" value="'.$_SESSION["password"].'" name="passUsuario">
                                <input type="hidden" value="'.$_SESSION["foto"].'" name="fotoUsuario" id="fotoUsuario">
                                <input type="hidden" value="'.$_SESSION["modo"].'" name="modoUsuario" id="modoUsuario">
                                ';
                                
                                if($_SESSION["modo"] == "directo"){
                                    if($_SESSION["foto"] != ""){
                                        echo '<img src="'.$url.$_SESSION["foto"].'" class="img-thumbnail">';
                                    }
                                    else{
                                        echo '<img src="'.$servidor.'vistas/img/usuarios/default/anonymous.png" class="img-thumbnail">';
                                    }
                                }
                                else{
                                    echo '<img src="'.$_SESSION["foto"].'" class="img-thumbnail">';
                                }
                                
                                ?>
                                
                            </figure>
                            
                            <?php

							if($_SESSION["modo"] == "directo"){
							
                                echo '
                                <button type="button" class="btn btn-default" id="btnCambiarFoto">
                                    
                                    Cambiar foto de perfil
                                    
                                </button>';

							}
							?>
                            
                            <div id="subirImagen">
								<input type="file" class="form-control" id="datosImagen" name="datosImagen">
								<img class="previsualizar">
							</div>
                            
                        </div>
                        
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            
                            <br>
                            
                            <?php

                            if($_SESSION["modo"] != "directo"){
                                
                                echo '
                                
                                <label class="control-label text-muted text-uppercase">Nombre:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control"  value="'.$_SESSION["nombre"].'" readonly>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase">Correo electrónico:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
									<input type="text" class="form-control"  value="'.$_SESSION["email"].'" readonly>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase">Modo de registro en el sistema:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-'.$_SESSION["modo"].'"></i>
                                    </span>
									<input type="text" class="form-control text-uppercase"  value="'.$_SESSION["modo"].'" readonly>
                                </div>
                                
                                <br>
                                ';
                                
                            }
                            else{
                                
                                echo '
                                
                                <label class="control-label text-muted text-uppercase" for="editarNombre">Cambiar Nombre:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="'.$_SESSION["nombre"].'">
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="editarEmail">Cambiar Correo Electrónico:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="editarEmail" name="editarEmail" value="'.$_SESSION["email"].'">
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="editarPassword">Cambiar Contraseña:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                    </span>
                                    <input type="text" class="form-control" id="editarPassword" name="editarPassword" placeholder="Escribe la nueva contraseña">
                                </div>
                                
                                <br>
                                
                                <button type="submit" class="btn btn-default backColor btn-md pull-left">Actualizar Datos</button>
                                
                                ';          
                                
                            }
                            
                            ?>
                            
                        </div>
                        
                        <?php

							$actualizarPerfil = new ControladorUsuarios();
							$actualizarPerfil->ctrActualizarPerfil();

						?>
                        
                    </form>
                    
                    <button class="btn btn-danger btn-md pull-right" id="eliminarUsuario">Eliminar cuenta</button>
                    
                    <?php
                    
                    $borrarUsuario = new ControladorUsuarios();
                    $borrarUsuario -> ctrEliminarUsuario();
                    
                    ?>
                    
                </div>
            </div>

            <!--==================================
            *==         PESTAÑA DIRECCIÓN      ==*
            ===================================-->

            
            <div id="direccion" class="tab-pane fade">
                <div class="row">
                    
                    <form method="post" enctype="multipart/form-data" onsubmit="return validarFormDireccion(this)">
                        
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            
                            <br>
                            
                            <?php
                                                          
                                echo '

                                <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">

                                <h3>Los campos marcados con * son obligatorios.</h3>

                                <label class="control-label text-muted text-uppercase" for="nombreCompleto">Nombre completo *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Nombre completo" required>
                                </div>

                                <br>

                                <label class="control-label text-muted text-uppercase" for="telefono">Telefono celular:</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono celular" pattern="[0-9]{10}" title="10 Digitos ej. 5546417896">
                                </div>

                                <br>

                                <label class="control-label text-muted text-uppercase" for="cp">Código postal *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="cp" name="cp" placeholder="Código postal" required>
                                </div>

                                <br>

                                <label class="control-label text-muted text-uppercase" for="estado">Estado *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required>
                                </div>
                                
                                <br>

                                <label class="control-label text-muted text-uppercase" for="municipio">Municipio/Alcaldia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-university" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" required>
                                </div>

                                <br>

                                <label class="control-label text-muted text-uppercase" for="colonia">Colonia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Municipio" required>
                                </div>
                                
                                <br>

                                <label class="control-label text-muted text-uppercase" for="calle">Calle *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle de la dirección" required>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-6 col-sm-5 col-xs-12">
                                        <label class="control-label text-muted text-uppercase" for="numext">Número exterior *</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-home"></i>
                                            </span>
                                            <input type="text" class="form-control" id="numext" name="numext" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-5 col-xs-12">
                                        <label class="control-label text-muted text-uppercase" for="numint">Núumero interior</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-home"></i>
                                            </span>
                                            <input type="text" class="form-control" id="numint" name="numint" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                
                                <button type="submit" class="btn btn-success btn-md pull-left">Agregar Dirección</button>
                                <br>
                                <br>
                                <br>
                                <br>
                                ';
                            
                            ?>
                            
                        </div>
                        <div class="col-md-6 col-sm-5 col-xs-12" style="padding: 3%;">
                            <?php
                            $item = $_SESSION["idUsuario"];

                            $direcciones = ControladorUsuarios::ctrMostrarDirecciones($item);
                
                            if(!$direcciones){
                                echo '
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    <h3><small>No tiene direcciones agregadas</small></h3>
                                    
                                    
                                </div>';
                            }
                            else{
                    
                                foreach ($direcciones as $key => $value) {
                                        
                                    echo "
                                    <div class='panel panel-default'>
                                        <div class='panel-heading'>Dirección ". ($key + 1). "</div>
                                        <div class='panel-body'>
                                            <div class='row'>
                                                <div class='col-md-6'>
                                                    <label>Nombre:</label>
                                                    <p>{$value['nombre']}</p>
                                                    <label>Teléfono:</label>
                                                    <p>{$value['celular']}</p>
                                                    <label>Código postal:</label>
                                                    <p>{$value['cp']}</p>
                                                    <label>Estado:</label>
                                                    <p>{$value['estado']}</p>
                                                </div>
                                                <div class='col-md-6'>
                                                    <label>Municipio / Alcaldía:</label>
                                                    <p>{$value['municipio']}</p>
                                                    <label>Colonia:</label>
                                                    <p>{$value['colonia']}</p>
                                                    <label>Calle:</label>
                                                    <p>{$value['calle']}</p>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            <label>No. interior:</label>
                                                            <p>{$value['numext']}</p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label>No. exterior:</label>
                                                            <p>{$value['numint']}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class='btn btn-danger btn-md pull-right delete-direccion' id='{$value['id']}'>Eliminar dirección</button>
                                        </div>
                                    </div>
                                    ";
                                    
                                }
                            }

                            ?>

                        </div>
                        
                        
                        <?php

                            $agregarDireccion = new ControladorUsuarios();
                            $agregarDireccion->ctrAgregarDireccion();

                        ?>
                    </form>
                    
                    
                    <?php
                    
                    $borrarDireccion = new ControladorUsuarios();
                    $borrarDireccion -> ctrEliminarDireccion();
                    
                    ?>
                    
                </div>
            </div>

            <!--==================================
            *==         PESTAÑA FACTURACCION      ==*
            ===================================-->

            
            <div id="facturacion" class="tab-pane fade">
                <div class="row">
                    
                    <form method="post">
                                                   
                        <br>
                        
                        <?php
                                                      
                            echo '

                            <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">

                            <h3>Los campos marcados con * son obligatorios.</h3>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="">Nombre *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class=""></i>
                                    </span>
                                    <input type="text" class="form-control" id="" name="" placeholder="" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="">Apellido paterno *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class=""></i>
                                    </span>
                                    <input type="text" class="form-control" id="" name="" placeholder="" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="">Apellido Materno *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class=""></i>
                                    </span>
                                    <input type="text" class="form-control" id="" name="" placeholder="" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="">RFC *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class=""></i>
                                    </span>
                                    <input type="text" class="form-control" id="" name="" placeholder="Telefono celular">
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="cp">Código postal *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="cp" name="cp" placeholder="Código postal" required>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="estado">Estado *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required>
                                </div>
                            
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="municipio">Municipio/Alcaldia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-university" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" required>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="colonia">Colonia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Municipio" required>
                                </div>
                            
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <label class="control-label text-muted text-uppercase" for="calle">Calle *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle de la dirección" required>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label text-muted text-uppercase" for="numext">Número exterior *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="numext" name="numext" placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label class="control-label text-muted text-uppercase" for="numint">Núumero interior</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="numint" name="numint" placeholder="">
                                </div>
                            </div>     
                            <br>
                            <br>
                            <br>
                            
                            <div class="col-md-12 col-sm-12 col-xs-12" style="margin:3%;">
                                <button class="btn btn-success btn-md pull-left">Agregar Datos Facturación</button>
                            </div>
                            <br>
                            ';
                        
                        ?>                     
                        
                    </form>
                    
                    
                </div>
            </div>
            
        </div>
        
    </div>
    
</div>

<!--=====================================
VENTANA MODAL PARA COMENTARIOS
======================================-->

<div  class="modal fade modalFormulario" id="modalComentarios" role="dialog">
	
    <div class="modal-content modal-dialog">
    
        <div class="modal-body modalTitulo">
			
            <h3 class="backColor">CALIFICA ESTE PRODUCTO</h3>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>

			<form method="post" onsubmit="return validarComentario()">
			    
                <input type="hidden" value="" id="idComentario" name="idComentario">
				    
                <h1 class="text-center" id="estrellas">
                    
                    <i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>

				</h1>
                
                <div class="form-group text-center">
                
                    <label class="radio-inline"><input type="radio" name="puntaje" value="0.5">0.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="1.0">1.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="1.5">1.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="2.0">2.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="2.5">2.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="3.0">3.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="3.5">3.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="4.0">4.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="4.5">4.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="5.0" checked>5.0</label>
					
				</div>
				
				<div class="form-group">
                  
                    <label for="comment" class="text-muted">Tu opinión acerca de este producto: <span><small>(máximo 300 caracteres)</small></span></label>
                    
                    <textarea class="form-control" rows="5" id="comentario" name="comentario" maxlength="300" required></textarea>
                    
                    <br>
					
					<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">
					
                </div>
                
				<?php
                
                    $actualizarComentario = new ControladorUsuarios();
                    $actualizarComentario -> ctrActualizarComentario();
                
				?>
				
			</form>

		</div>

		<div class="modal-footer">
      	
      	</div>

	</div>

</div>