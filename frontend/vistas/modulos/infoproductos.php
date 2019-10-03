<?php

$url = Ruta::ctrRuta();
$servidor = Ruta::ctrRutaServidor();

$ruta = $rutas[0];

?>
<!--==================================
*==   BREADCRUMB INFOPRODUCTO      ==*
===================================-->


<div class="container-fluid well well-sm">
    
    <div class="container">
        
        <div class="row">
            
            <ul class="breadcrumb lead">
                
                <li><a href="<?php echo $url; ?>">INICIO</a></li>
                <li class="active pagActiva fondoBreadcrumb text-uppercase"><?php echo $rutas[0];?></li>
            </ul>
            
        </div>
        
    </div>
    
</div>

<!--==================================
*==     CONTENIDO INFOPRODUCTO     ==*
===================================-->

<div class="container-fluid infoproducto">
    
    <div class="container">
        
        <div class="row">
            
            <?php
            
            $item = "ruta";
            $valor = $rutas[0];
            $infoProducto = ControladorProductos::ctrMostrarInfoProducto($item,$valor);
            $multimedia = json_decode($infoProducto["multimedia"],true);
            
            if($infoProducto["tipo"] == "fisico"){
            /*====================================
            *==        VISOR DE IMAGENES       ==*
            ====================================*/    
            echo '
            
            <div class="col-md-5 col-sm-6 col-xs-12 visorImg">    
                
                <figure class="visor">';
                
                if($multimedia != null){
                for ($i = 0; $i < count($multimedia); $i++)
                {
                    echo'
                    <img id="lupa'.($i+1).'" src="'.$servidor.$multimedia[$i]["foto"].'" alt="'.$infoProducto["titulo"].'" class="img-thumbnail">
                    ';
                }
                
                echo'
                </figure>
                
                <div class="flexslider">

                    <ul class="slides">';
                    for ($i = 0; $i < count($multimedia); $i++){
                        echo'<li><img value="'.($i+1).'" src="'.$servidor.$multimedia[$i]["foto"].'" alt="'.$infoProducto["titulo"].'" class="img-thumbnail"></li>';
                    }
                }
                    echo'
                    </ul>
                    
                </div>
                
            </div>
            
            ';
                
            }
            else{
            /*====================================
            *==         VISOR DE VIDEOS        ==*
            ====================================*/
            }
            
            ?>
            
            
            <!--===================================
            *==            PRODUCTO             ==*
            ====================================-->
            <?php
            /*
            if($infoProducto["tipo"] == "fisico"){
                
            echo '
            <div class="col-md-7 col-sm-6 col-xs-12">
            ';
                
            }*/
            ?>
            <div class="col-md-7 col-sm-6 col-xs-12">
                
                <!--===================================
                *==      REEGRESAR A LA TIENDA      ==*
                ====================================-->
                <div class="col-xs-6">
                    
                    <h6>
                        
                        <a href="javascript:history.back()" class="text-muted"><i class="fa fa-reply"></i> Continuar Comprando</a>
                        
                    </h6>
                    
                </div>
                <!--===================================
                *==   COMPARTIR EN REDES SOCIALES   ==*
                ====================================-->
                <div class="col-xs-6">
                    <h6>
                        <a href="" class="dropdown.toggle pull-right text-muted" data-toggle="dropdown">
                            <i class="fa fa-plus"></i> Compartir
                        </a>
                        <ul class="dropdown-menu pull-right compartirRedes">
                            <li>
                                <p class="btnFacebook">
                                    <i class="fa fa-facebook"></i> Facebook
                                </p>
                            </li>
                            <li>
                                <p class="btnTwitter">
                                    <i class="fa fa-twitter"></i> Twitter
                                </p>
                            </li>
                        </ul>
                    </h6>
                </div>
                
                <div class="clearfix"></div>
                
                <!--==================================
                *==    ESPACIO PARA EL PRODUCTO    ==*
                ===================================-->
                <?php
                
                /*====================================
                *==       TITULO DEL PRODUCTO      ==*
                ====================================*/
                //Si el producto no tiene descuento
                if($infoProducto["oferta"] == 0){
                    //Si el producto no es nuevo
                    if($infoProducto["nuevo"] == 0){
                        echo '
                        <h1 class="text-muted text-uppercase">'.$infoProducto["titulo"].'</h1>
                        ';
                    }
                    //si el producto es nuevo
                    else{
                        echo '
                        <h1 class="text-muted text-uppercase">'.$infoProducto["titulo"].'
                            <br>
                            <small>
                                <span class="label label-warning">NUEVO</span>
                            </small>
                        </h1>
                        ';
                    }
                    
                }
                //Si el producto tiene descuento
                else{
                    //Si el producto no es nuevo
                    if($infoProducto["nuevo"] == 0){
                        echo '
                        <h1 class="text-muted text-uppercase">'.$infoProducto["titulo"].'
                            <br>
                            <small>
                                <span class="label label-warning">'.$infoProducto["descuentoOferta"].'% Descuento</span>
                            </small>
                        </h1>
                        ';
                    }
                    else{
                        echo '
                        <h1 class="text-muted text-uppercase">'.$infoProducto["titulo"].'
                            <br>
                            <small>
                                <span class="label label-warning">NUEVO</span>
                                <span class="label label-warning">'.$infoProducto["descuentoOferta"].'% Descuento</span>
                            </small>
                        </h1>
                        ';
                    }
                }
                
                /*====================================
                *==       PRECIO DEL PRODUCTO      ==*
                ====================================*/
                //Si precio es igual a cero, el producto es gratuito
                if($infoProducto["precio"] == 0){
                    
                    echo '<h2 class="text-muted">GRATIS</h2>';
                    
                }
                //Si precio es mayor a 0
                else{
                    //si no tiene oferta
                    if($infoProducto["oferta"] == 0){
                        echo'<h2 class="text-muted">MXN $'.number_format($infoProducto["precio"],2).' <small>IVA INCLUIDO</small></h2>';   
                    }
                    //si tiene oferta el producto
                    else{
                        echo'
                        <h2 class="text-muted">
                            <span>
                                <strong class="oferta">
                                    MXN $'.number_format($infoProducto["precio"],2).'
                                </strong>
                            </span>
                            <span>
                                $'.number_format($infoProducto["precioOferta"],2).'
                            <small>IVA INCLUIDO</small>
                            </span>
                            
                        </h2>';   
                    }
                }
                
                /*====================================
                *==    DESCRIPCIÓN DEL PRODUCTO    ==*
                ====================================*/
                echo'
                <p>'.$infoProducto["descripcion"].'</p>
                ';
                ?>
                
                <!--==================================
                *==  CARACTERISTICAS DEL PRODUCTO  ==*
                ===================================-->
                <hr>
                
                <div class="form group row">
                    <?php
                    
                    if($infoProducto["detalles"] != null){
                        
                        $detalles = json_decode($infoProducto["detalles"],true);
                        
                        if($infoProducto["tipo"] == "fisico"){
                            echo'
                            <div class="col-xs-12">
                            ';
                            if($detalles["Descripcion1"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$detalles["Descripcion1"].'
                                </li>
                                ';
                            }
                            if($detalles["Descripcion2"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$detalles["Descripcion2"].'
                                </li>
                                ';
                            }
                            if($detalles["Descripcion3"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$detalles["Descripcion3"].'
                                </li>
                                ';
                            }
                            if($detalles["Descripcion4"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$detalles["Descripcion4"].'
                                </li>
                                ';
                            }
                            if($detalles["Descripcion5"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$detalles["Descripcion5"].'
                                </li>
                                ';
                            }
                            if($detalles["Descripcion6"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$detalles["Descripcion6"].'
                                </li>
                                ';
                            }
                            echo'
                            </div>
                            ';
                            
                        }
                        else{
                            echo'producto virtual';
                        }
                        
                    }
                    
                    /*====================================
                    *==            ENTREGA             ==*
                    ====================================*/
                    //Si entrega es igual a 0, la entrega es inmediata
                    if($infoProducto["entrega"] == 0){
                        
                        //si el producto es gratis
                        if($infoProducto["precio"] == 0){
                            echo'
                            <h4 class="col-md-12 col-sm-0 col-xs-0">
                                <hr>
                                <span class="label label-default" style="font-weight:100">
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    Entrega Inmediata |
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventasGratis"].' inscritos |
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistasGratis"].'</span> personas |
                                </span>
                            </h4>
                            
                            <h4 class="col-lg-0 col-md-0 col-xs-12">
                                <hr>
                                <small>
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    Entrega Inmediata <br>
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventasGratis"].' inscritos <br>
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistasGratis"].'</span> personas
                                </small>
                            </h4>
                            ';
                        }
                        else{
                            echo'
                            <h4 class="col-md-12 col-sm-0 col-xs-0">
                                <hr>
                                <span class="label label-default" style="font-weight:100">
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    Entrega Inmediata |
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventas"].' ventas |
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistas"].'</span> personas |
                                </span>
                            </h4>
                            
                            <h4 class="col-lg-0 col-md-0 col-xs-12">
                                <hr>
                                <small>
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    Entrega Inmediata <br>
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventas"].' ventas <br>
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistas"].'</span> personas
                                </small>
                            </h4>
                            ';
                        }
                        
                    }
                    //si tiene dias de entrega 
                    else{
                        //si el producto es gratis
                        if($infoProducto["precio"] == 0){
                            echo'
                            <h4 class="col-md-12 col-sm-0 col-xs-0">
                                <hr>
                                <span class="label label-default" style="font-weight:100">
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    '.$infoProducto["entrega"].' dias habiles para la entrega |
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventasGratis"].' solicitudes |
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistasGratis"].'</span> personas
                                </span>
                            </h4>
                            
                            <h4 class="col-lg-0 col-md-0 col-xs-12">
                                <hr>
                                <small>
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    '.$infoProducto["entrega"].' dias habiles para la entrega <br>
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventasGratis"].' solicitudes <br>
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistasGratis"].'</span> personas
                                </small>
                            </h4>';
                        }
                        else{
                            echo'
                            <h4 class="col-md-12 col-sm-0 col-xs-0">
                                <hr>
                                <span class="label label-default" style="font-weight:100">
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    '.$infoProducto["entrega"].' dias habiles para la entrega |
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventas"].' ventas |
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistas"].'</span> personas
                                </span>
                            </h4>
                            
                            <h4 class="col-lg-0 col-md-0 col-xs-12">
                                <hr>
                                <small>
                                    <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                    '.$infoProducto["entrega"].' dias habiles para la entrega <br>
                                    <i class="fa fa-shopping-cart" style="margin-right: 0px 5px"></i>
                                    '.$infoProducto["ventas"].' ventas <br>
                                    <i class="fa fa-eye" style="margin-right: 0px 5px"></i>
                                    Visto por <span class="vistas" tipo = "'.$infoProducto["precio"].'">'.$infoProducto["vistas"].'</span> personas
                                </small>
                            </h4>
                            ';
                        }
                    }
                    ?>
                </div>
                <!--==================================
                *==       BOTONES DE COMPRA        ==*
                ===================================-->
                <hr>
                <div class="row text-center botonesCompra">
                    <?php
                    
                    if($infoProducto["precio"] == 0){
                        
                        echo'
                        <div class="col-md-6 col-xs-12">';
                            
                        if($infoProducto["tipo"]=="virtual"){
                            echo'<button class="btn btn-default btn-block btn-lg backColor">ACCEDER AHORA</button>';
                        }
                        else{
                            echo'<button class="btn btn-default btn-block btn-lg backColor">SOLICITAR AHORA</button>';
                        }
                        echo'
                        </div>
                        ';
                    }
                    else{
                        if($infoProducto["tipo"]=="virtual"){
                            echo'
                            <div class="col-md-6 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg"><small>COMPRAR AHORA</small></button>
                            </div>
                            
                            <div class="col-md-6 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg backColor agregarCarrito" idProducto ="'.$infoProducto["idProducto"].'" imagen="'.$servidor.$infoProducto["portada"].'" titulo="'.$infoProducto["titulo"].'" precio="'.$infoProducto["precio"].'" precioOferta="'.$infoProducto["precioOferta"].'" tipo="'.$infoProducto["tipo"].'" peso="'.$infoProducto["peso"].'">
                                    <i class="fa fa-shopping-cart col-md-0"></i>
                                    <small>&#160;&#160;AGREGAR AL CARRITO</small>
                                </button>
                            </div>
                            ';
                        }
                        else{
                            $precioProducto = 0;
                            if($infoProducto["precioOferta"] == 0){
                                $precioProducto = $infoProducto["precio"];
                            }
                            else{
                                $precioProducto = $infoProducto["precioOferta"];
                            }
                            echo'
                            <div class="col-lg-6 col-md-8 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg backColor agregarCarrito" idProducto ="'.$infoProducto["idProducto"].'" imagen="'.$servidor.$infoProducto["portada"].'" titulo="'.$infoProducto["titulo"].'" precio="'.$precioProducto.'" tipo="'.$infoProducto["tipo"].'" peso="'.$infoProducto["peso"].'">
                                    <i class="fa fa-shopping-cart col-xs-0"></i>
                                    &#160;&#160;AGREGAR AL CARRITO
                                </button>
                            </div>
                            ';
                        }
                    }
                    ?>
                    
                </div>
                <!--==================================
                *==          ZONA DE LUPA          ==*
                ===================================-->
                <figure class="lupa">
                    <img src="">
                </figure>
                
            </div>
            
        </div>
        
        <!--==================================
    *==          COMENTARIO            ==*
    ===================================-->
    
    <br>
    <div class="row">
        
        <?php
        
        $datos = array("idUsuario"=>"","idProducto"=>$infoProducto["idProducto"]);
        
        $comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);
        
		$cantidad = 0;
        
        foreach ($comentarios as $key => $value){
            
            if($value["comentario"] != ""){
                
                //$cantidad += count($value["idComentario"]);
                $cantidad += 1;
                
            }
        }
        
        ?>
        
        <ul class="nav nav-tabs">
            
            <?php
            
            $cantidadCalificacion = 0;
            
            if($cantidad == 0){
                
                echo '
                <li class="active"><a>ESTE PRODUCTO NO TIENE COMENTARIOS</a></li>
				<l  i></li>';
                
            }
            else{
                echo '
                <li class="active">
                    <a>COMENTARIOS '.$cantidad.'</a>
                </li>
				<li>
                    <a id="verMas" href="">Ver más</a>
                </li>';
                
                $sumaCalificacion = 0;
                
                foreach ($comentarios as $key => $value) {
                    
                    if($value["calificacion"] != 0){
                        
                        //$cantidadCalificacion += count($value["idComentario"]);
                        
                        $sumaCalificacion += $value["calificacion"];
                        
                    }
                    
                }
                //$promedio = round($sumaCalificacion/$cantidadCalificacion,1);
                $promedio = round($sumaCalificacion/$cantidad,1);
                
                echo '
                <li class="pull-right">
                    <a class="text-muted">PROMEDIO DE CALIFICACIÓN: '.$promedio.' | ';
                
                if($promedio >= 0 && $promedio < 0.5){
                    
				    echo '
                    <i class="fa fa-star-half-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
                    <i class="fa fa-star-o text-success"></i>';
                    
				}
                else if($promedio >= 0.5 && $promedio < 1){
                    
                    echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
				}
                else if($promedio >= 1 && $promedio < 1.5){
                    echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star-half-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
				}
                else if($promedio >= 1.5 && $promedio < 2){
                    
					echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
                }
                else if($promedio >= 2 && $promedio < 2.5){
                    
					echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star-half-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
                }
                else if($promedio >= 2.5 && $promedio < 3){
                    
					echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
                }
                else if($promedio >= 3 && $promedio < 3.5){
                    
                    echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star-half-o text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
				}
                else if($promedio >= 3.5 && $promedio < 4){
				    
                    echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star-o text-success"></i>';
                    
				}
                else if($promedio >= 4 && $promedio < 4.5){
                    
                    echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star-half-o text-success"></i>';
                    
				}
                else{
                    
                    echo '
                    <i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>
					<i class="fa fa-star text-success"></i>';
                    
				}
                
            }
            
            ?>
                </a>
            </li>
        </ul>
        
        <br>
        
    </div>
    
    <div class="row comentarios">
        
        <?php
        
        foreach ($comentarios as $key => $value) {
            
            if($value["comentario"] != ""){
                
                $item = "idUsuario";
                $valor = $value["idUsuario"];
                
                $usuario = ControladorUsuarios::ctrMostrarUsuario($item, $valor);
                echo '
                <!-- Nos ayudara a agrupar el contenido de comentarios -->
                <div class="panel-group col-md-3 col-sm-6 col-xs-12 alturaComentarios">
                    
                    <div class="panel panel-default">
                    
                        <div class="panel-heading text-uppercase">
                            
                            '.$usuario["nombre"].'
                            <span class="text-right">';
                                
                                if($usuario["modo"] == "directo"){
                                    
                                    if($usuario["foto"] == ""){
                                        
                                        echo '<img class="img-circle pull-right" src="'.$servidor.'vistas/img/usuarios/default/anonymous.png" width="20%">';
                                        
                                    }
                                    else{
                                        
                                        echo '<img class="img-circle pull-right" src="'.$url.$usuario["foto"].'" width="20%">';	
                                        
                                    }
                                    
                                }
                                else{
                                    
                                    echo '<img class="img-circle pull-right" src="'.$usuario["foto"].'" width="20%">';	
                                    
                                }
                                
                            echo'
                            </span>
                            
                        </div>
                        
                        <div class="panel-body" style="word-wrap:break-word">
                            <small>'.$value["comentario"].'</small>
                        </div>
                        
                        <div class="panel-footer">';
                            
                            switch($value["calificacion"]){
                                case 0.5:
                                    echo '
                                    <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
                                    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
								    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
								    <i class="fa fa-star-o text-success" aria-hidden="true"></i>
								    <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
				                    break;
                                    
				                case 1.0:
				                    echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
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
                            
                        echo'
                        </div>
                        
                    </div>
                    
                </div>';
                
                
            }
            
        }
        
        ?>
        
        </div>
        
    </div>
    
</div>

<!--===================================
        PRODUCTOS RELACIONADOS
====================================-->
<div class="container-fluid productos">
    
    <div class="container">
       
        <div class="row">
            <!--=====================================
                            BARRA TÍTULO
            ======================================-->
            
            <div class="col-xs-12 tituloDestacado">
            
                <!--===============================================-->
                
                <div class="col-sm-6 col-xs-12">
                
                    <h1><small>PRODUCTOS RELACIONADOS</small></h1>
                    
                </div>
                
                <!--===============================================-->
                
                <div class="col-sm-6 col-xs-12">
                
                    <?php
                    
                    $item = "idSubcategoria";
                    $valor = $infoProducto["idSubcategoria"];
                    $limite = true;
                    $base1=null;
                    $tope1=null;
                    $rutaArticulosDestacados = ControladorProductos::ctrMostrarSubcategorias($item,$valor,$limite,$base1,$tope1);
                    
                    echo '
                    <a href="'.$url.$rutaArticulosDestacados[0]["ruta"].'">
                    
                        <button class="btn btn-default backColor pull-right">
                        
                            VER MÁS <span class="fa fa-chevron-right"></span>
                            
                        </button>
                        
                    </a>
                    ';
                    
                    ?>   
                    
                    
                </div>
                
                <!--===============================================-->
                
            </div>
            
            <div class="clearfix"></div>
            
            <hr>
            
        </div>
        
        <!--=====================================
            VITRINA DE PRODUCTOS EN CUADRÍCULA
        ======================================-->
        <?php
        
        $ordenar = "";
        $item="idSubcategoria";
        $valor= $infoProducto["idSubcategoria"];
        $base= 0;
        $tope= 4;
        $modo= "Rand()";
        
        $productosRelacionados = ControladorProductos::ctrMostrarProductos($ordenar,$item,$valor,$base,$tope,$modo);
        
        
        if(!$productosRelacionados){
            
            echo'
            <div class="col-xs-12 error404">
                <h1><small>¡Oops!</small></h1>
                <h2>No hay productos relacionados.</h2>
            </div>
            
            ';
            
        }
        else{
            
            echo'
            <ul class="grid0">';

            foreach ($productosRelacionados as $key => $value)
            {
                echo '

                <!-- Producto -->

                <li class="col-md-3 col-sm-6 col-xs-12">

                    <!--===============================================-->

                    <figure>

                        <a href="'.$url.$value["ruta"].'" class="pixelProducto">

                            <img src="'.$servidor.$value["portada"].'" class="img-responsive">

                        </a>

                    </figure>

                    <!--===============================================-->

                    <h4>

                        <small>

                            <a href="'.$url.$value["ruta"].'" class="pixelProducto">

                                '.$value["titulo"].'<br>
                                <span style = "color:rgba(0,0,0,0);">-</span>';

                                if ($value["nuevo"] != 0)
                                {
                                    echo'<span class = "label label-warning fontSize">Nuevo</span>';
                                }
                                if ($value["oferta"] != 0)
                                {
                                    echo'<span class = "label label-warning fontSize">'.$value["descuentoOferta"].'% OFF</span>';
                                }

                            echo'
                            </a>

                        </small>

                    </h4>

                    <!--===============================================-->

                    <div class="col-xs-6 precio">';

                    if ($value["precio"] == 0)
                    {
                        echo '
                        <h2>
                            <small>
                                GRATIS
                            </small>
                        </h2>
                        ';
                    }
                    else
                    {
                        if($value["oferta"] != 0){
                            echo'
                            <h2>
                                <small>
                                    <strong class = "oferta">MXN $'.$value["precio"].'</strong>
                                </small>  
                                <small>$'.$value["precioOferta"].'</small>
                            </h2>
                            ';
                        }
                        else{
                            echo '
                            <h2>
                                <small>
                                   MXN $'.$value["precio"].'
                                </small>
                            </h2>
                            ';
                        }
                    }
                    echo '
                    </div>
                    <!--===============================================-->
                    <div class="col-xs-6 enlaces">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs deseos" idProducto="'.$value["idProducto"].'" data-toggle="tooltip" title="Agregar a mi lista de deseos">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </button>';
                            if($value["tipo"] == "virtual" && $value["precio"] != 0){
                                if($value["oferta"] != 0){
                                    echo'
                                    <button type="button" class="btn btn-default btn-xs agregarCarrito" idProducto ="'.$value["idProducto"].'" imagen="'.$servidor.$value["portada"].'" titulo="'.$value["titulo"].'" precio="'.$value["precioOferta"].'" tipo="'.$value["tipo"].'" peso="'.$value["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    </button>
                                    ';

                                }
                                else{

                                    echo'
                                    <button type="button" class="btn btn-default btn-xs agregarCarrito" idProducto ="'.$value["idProducto"].'" imagen="'.$servidor.$value["portada"].'" titulo="'.$value["titulo"].'" precio="'.$value["precio"].'" tipo="'.$value["tipo"].'" peso="'.$value["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    </button>
                                    ';

                                }



                            }

                            echo'
                            <a href="'.$url.$value["ruta"].'" class="pixelProducto">

                                <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">

                                    <i class="fa fa-eye" aria-hidden="true"></i>

                                </button>

                            </a>

                        </div>

                    </div>

                </li>
                ';
            }

            echo '
            </ul>
            ';
            
        }
        ?>
    </div>
    
</div>