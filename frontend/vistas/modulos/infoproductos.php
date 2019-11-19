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
                else{
                    echo'<img id="lupa1" src="'.$servidor.'/vistas/img/plantilla/imagenProducto.jpg" alt="imagenMuestra" class="img-thumbnail">';
                
                echo'
                </figure>
                
                <div class="flexslider">

                    <ul class="slides">';
                        echo'<li><img value="1" src="'.$servidor.'/vistas/img/plantilla/imagenProducto.jpg" alt="imagenPrueba" class="img-thumbnail"></li>';
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
                ====================================
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
                ====================================-->
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
                        
                        //$detalles = json_decode($infoProducto["detalles"],true);
                        
                        if($infoProducto["tipo"] == "fisico"){
                            echo'
                            <div class="col-xs-12">
                            ';
                            if($infoProducto["sku"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i>SKU: '.$infoProducto["sku"].'
                                </li>
                                ';
                            }
                            if($infoProducto["marca"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i>Marca: '.$infoProducto["marca"].'
                                </li>
                                ';
                            }
                            if($infoProducto["tipoAplicacion"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i>Aplicación: '.$infoProducto["tipoAplicacion"].'
                                </li>
                                ';
                            }
                            if($infoProducto["alto"]!="" && $infoProducto["largo"]!="" && $infoProducto["ancho"]!=""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i>Dimensiones: Alto '.round($infoProducto["alto"],1).' cm. Largo '.round($infoProducto["largo"],1).' cm. Ancho '.round($infoProducto["ancho"],1).' cm.
                                </li>
                                ';
                            }
                            if($infoProducto["aplicacion"] != ""){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i>Compatible con: '.$infoProducto["aplicacion"].'
                                </li>
                                ';
                            }
                            if($infoProducto["stock"] != "0"){
                                echo'
                                <li>
                                    <i style="margin-right:10px" class="fa fa-check"></i> '.$infoProducto["stock"].'
                                </li>
                                ';
                            }
                            echo'
                            </div>
                            ';
                            
                        }
                        else{
                            //echo'producto virtual';
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
        <br>
        <div class="clearfix"></div>
        <!--===========================================
        *==          TERMINOS Y CONDICIONES         ==*
        ============================================-->
        <div class="row politicas">
            
            <div class="container">
                
                <ul class="nav nav-tabs">
                    
                    <li><a data-toggle="tab" href="#opc1">DEVOLUCIONES</a></li>
                    <li><a data-toggle="tab" href="#opc2">GARANTIAS</a></li>
                    
                </ul>
                
                <div class="tab-content">
                    
                    <div id="opc1" class="tab-pane fade">
                        <h3>DEVOLUCIONES</h3>
                        <br>
                        <p>Al momento de hacer una devolución por favor considere que al ser nuevo el producto, usted lo regresara intacto para que un nuevo comprador lo requiera, Puntos a tomar en consideración al aplicar una devolución.</p>
                        <ul>
                            <li>Puede devolver el producto, sin embargo, se le restara el 20% de su compra por manejo de tiempo y personal</li>
                            <li>Si la caja al llegar esta dañada o rota <strong>NO ACEPTE POR NINGÚN MOTIVO LA ENTREGA</strong>, ya que si lo acepta perderá en automático <span style="text-decoration: underline">la garantía</span>, <span style="text-decoration: underline">la devolución</span> y por ende <span style="text-decoration: underline">su dinero</span></li>
                            <li>El envió de devolución corre por su cuenta</li>
                            <li>No dañar ni pegar cintas en la caja del producto y si lo hace que sea sobre la cinta antes cortada</li>
                            <li>No instalar la refacción ya que si está sucia o dañada no se aceptará la devolución</li>
                            <li>No se acepta material sin caja por ningún motivo</li>
                        </ul>
                    </div>
                    
                    <div id="opc2" class="tab-pane fade">
                        
                        <h3>GARANTIAS</h3>
                        <br>
                        <p>La garantía se puede aplicar antes de 6 meses de uso de la pieza, si pasa ese tiempo la garantía se perderá con nosotros y tendrá que llamar a proveedor directamente, esta garantía aplicara con las siguientes condiciones:</p>
                        
                        <ul>
                            <li>La garantía puede tardar en ser aplicada</li>
                            <li>Producto instalado incorrectamente, si el producto es colocado sin cuidado, a la fuerza, o sin las herramientas necesarias la garantía se pierde, sin embargo, si el producto es colocado en nuestras instalaciones <strong>la garantía se aplica al 100%</strong> si es falla de la pieza antes comprada</li>
                            <li>Producto que se reparó, pierde en automático la garantía</li>
                            <li>Favor de no limpiar el producto: es importante no limpiar le producto ya que si es lavada o limpiada la evidencia se perderá y tardará más el dictamen de garantía</li>
                            <li>Si el producto contiene liquido como aceite, anticongelante, agua favor de drenarlo o se le penalizara monetariamente</li>
                            <li>El producto al entrar en garantía será evaluado por el personal correspondiente y dependiendo del dictamen se aplicará la garantía.</li>
                        </ul>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        <br><br>
    
        
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