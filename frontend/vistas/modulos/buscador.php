<!--=====================================
BARRA PRODUCTOS
======================================-->

<div class="container-fluid well well-sm barraProductos">
    
    <div class="container">
        
        <div class="row">
        
            <div class="col-sm-6 col-xs-12">
                
                <div class="btn-group">
                    
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        
                        Ordenar Productos <span class="caret"></span>
                        
                    </button>
                    
                    <ul class="dropdown-menu" role="menu">
                        <?php
                        
                        echo '
                        <li><a href="'.$url.$rutas[0].'/1/recientes/'.$rutas[3].'">Más Reciente</a></li>
                        <li><a href="'.$url.$rutas[0].'/1/antiguos/'.$rutas[3].'">Más Antiguo</a></li>
                        ';
                        
                        
                        ?>
                        
                    </ul>
                    
                </div>
                
            </div>
            <div class="col-sm-6 col-xs-12 organizarProductos">
                
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default btnGrid" id="btnGrid0">
                        
                        <i class="fa fa-th" aria-hidden="true"></i>
                        
                        <span class="col-xs-0 pull-right"> GRID</span>
                        
                    </button>
                    
                    <button type="button" class="btn btn-default btnList" id="btnList0">
                       
                        <i class="fa fa-list" aria-hidden="true"></i>
                        
                        <span class="col-xs-0 pull-right"> LIST</span>
                        
                    </button>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</div>


<div class="container-fluid productos">
    
    <div class="container">
        
        <div class="row">
            
            <!--==================================
            *==   BREADCRUMBS O MIGAS DE PAN   ==*
            ===================================-->
            
            <ul class="breadcrumb fondoBreadcrumb lead text-uppercase">
                
                <li><a href="<?php echo $url; ?>">Inicio</a></li>
                <li class = "active pagActiva"><?php echo $rutas[0]; ?></li>
                <li class = "active"><?php echo str_replace("_"," ",$rutas[3]); ?></li>
                
            </ul>
            
            <?php
            /*======================================
                    LLAMADO DE PAGINACION
            ======================================*/
            //Preguntaremos si viene la variable rutas en su indice 1
            if(isset($rutas[1])){
                
                if(isset($rutas[2])){//se pregunta si se esta usando ruta 2
                    
                    if($rutas[2] == "antiguos"){//Si viene valor antiguo mostrara los datos ascendentes
                        $modo = "ASC";
                        $_SESSION["ordenar"] = "ASC";
                    }
                    else{//de lo contrario mostrara los datos descendentes
                        $modo = "DESC";
                        $_SESSION["ordenar"] = "DESC";
                    }
                }
                else{//Si no viene ruta 2 con la paginación, mostrara los datos descendentes
                    $modo = $_SESSION["ordenar"];
                }
                
                $base = ($rutas[1] - 1)*12;
                $tope = 12;
            }
            else{
                $rutas[1]= 1;
                $base = 0;
                $tope = 12;
                $modo = "DESC";
            }
            
            /*========================================================
            LLAMADO DE PRODUCTOS POR BUSQUEDA
            ========================================================*/
            
            $productos = null;
            $listaProductos = null;
            
            $ordenar = "idProducto";
            
            if(isset($rutas[3])){
                
                $busqueda = $rutas[3];
                
                //echo $busqueda;
                
                $aKeyword = explode ("_", $busqueda);
                
                //echo $aKeyword[0];
                
                $productos = ControladorProductos::ctrBuscarProductos($aKeyword, $ordenar, $modo, $base, $tope);/*Mandamos a llamar*/
                
                $listaProductos = ControladorProductos::ctrListarProductosBusqueda($aKeyword);
                
            }
            
            if (!$productos)
            {
                echo '
                
                <div class = "col-xs-12 text-center error404">
                    
                    <h1><small>¡Oops!</small></h1>
                    <h2>No hay publicaciones que coincidan con tu busqueda</h2>
                    
                </div>
                
                ';
            }
            else{
                
                echo'
                    <!--=====================================
                        VITRINA DE PRODUCTOS EN CUADRICULA
                    ======================================-->
                    <ul class = "grid0 busqueda">';
                        
                        foreach ($productos as $key => $value)
                        {
                            echo '
                            <!-- Producto -->
                            
                            <li class="col-md-3 col-sm-6 col-xs-12" style ="">
                            
                                <!--===============================================-->
                                <figure>
                                    
                                    <a href="'.$url.$value["ruta"].'" class="pixelProducto">';
                                        
                                        if($value["portada"] != ""){
                                            echo '<img src="'.$servidor.$value["portada"].'" class="img-responsive" style="">';
                                        }else{
                                            echo '<img src="'.$servidor.'/vistas/img/plantilla/imagenProducto.jpg" class="img-responsive" style="">';
                                        }
                                    
                                    echo '    
                                    </a>
                                    
                                </figure>
                                
                                <strong>SKU: </strong>'.$value["sku"].'
                                
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
                                                echo'<span class = "label label-warning fontSize">'.$value["descuentoOferta"].'% DESC</span>';
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
                                                <strong class = "oferta">MXN $'.number_format($value["precio"],2).'</strong>
                                            </small>  
                                            
                                            <small>$'.$value["precioOferta"].'</small>
                                            
                                        </h2>
                                        ';
                                    }
                                    else{
                                        echo '
                                        <h2>
                                            
                                            <small>
                                               MXN $'.number_format($value["precio"],2).'
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
                                        
                                        <button type="button" class="btn btn-default btn-xs deseos" idProducto="'.$value["idProducto"].'" data-toggle="tooltip" title="Agregar a mis favoritos">
                                            
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            
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
                    <!--=====================================
                          VITRINA DE PRODUCTOS EN LISTA
                    ======================================-->
                    
                    <ul class="list0" style="display:none;">';
                    
                    foreach ($productos as $key => $value)
                    {
                        echo'
                        
                        <li class="col-xs-12">
                            
                            <!-- ====================================== -->
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                
                                <figure>
                                    
                                    <a href="'.$value["ruta"].'" class="pixelProducto">';
                                        
                                        if($value["portada"] != ""){
                                            echo '<img src="'.$servidor.$value["portada"].'" alt="" class="img-responsive">';
                                        }
                                        else{
                                            echo '<img src="'.$servidor.'/vistas/img/plantilla/imagenProducto.jpg" alt="" class="img-responsive">';
                                        }
                                        
                                    echo '
                                    </a>
                                    
                                </figure>
                                
                            </div>
                            
                            <!--==================================================-->
                            
                            <div class="col-lg-10 col-md-7 col-sm-8 col-xs-12">
                            
                                <h1>
                                    
                                    <small>
                                        
                                        <a href="'.$value["ruta"].'" class="pixelProducto">
                                            
                                            '.$value["titulo"].'<br>';
                                            
                                            if ($value["nuevo"] != 0)
                                            {
                                                echo'<span class = "label label-warning">Nuevo</span>';
                                            }
                                            if ($value["oferta"] != 0)
                                            {
                                                echo'<span class = "label label-warning">'.$value["descuentoOferta"].'% DESC</span>';
                                            }
                                            
                                        echo'
                                        </a>
                                        
                                    </small>
                                    
                                </h1>
                                
                                <p class="text-muted">'.$value["descripcion"].'</p>';
                                
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
                                                <strong class = "oferta">MXN $'.number_format($value["precio"],2).'</strong>
                                            </small>
                                            
                                            <small>MXN $'.number_format($value["precioOferta"],2).'</small>
                                            
                                        </h2>
                                        ';
                                        
                                    }
                                    else{
                                        echo '
                                        <h2>
                                            
                                            <small>
                                               MXN $'.number_format($value["precio"],2).'
                                            </small>
                                            
                                        </h2>
                                        ';
                                    }
                                    
                                }    
                                
                                echo '
                                <div class="btn-group pull-left enlaces">
                                    
                                    <button type="button" class="btn btn-default btn-xs deseos" idProducto="'.$value["idProducto"].'" data-toggle="tooltip" title="Agregar a mis favoritos">
                                        
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        
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
                                    <a href="'.$value["ruta"].'" class="pixelProducto">
                                        
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver Producto">
                                            
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        
                                    </a>
                                    
                                </div>
                                
                            </div>
                            
                            <!--==================================================-->
                            <div class="col-xs-12"><hr></div>
                            <!--==================================================-->
                            
                        </li>
                        ';
                    }
                    echo '
                    </ul>';
                
            }
            
            ?>
            
            <div class="clearfix"></div>
            
            <center>
                <!--==================================
                *==          PAGINACION            ==*
                ===================================-->
                <?php
                
                if(count($listaProductos) != 0){
                    
                    $pagProductos = ceil(count($listaProductos)/12); /**/
                    
                    if($pagProductos > 4){
                        
                        /*======================================
                        BOTONES DE LAS PRIMERAS 4 PAGINAS Y LA ULTIMA PAGINA
                        ======================================*/
                        
                        if($rutas[1] == 1){
                            echo '
                            <ul class="pagination">
                            ';
                            
                            for ($i = 1; $i <= 4; $i++)
                            {
                                echo '<li id = "item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'/'.$rutas[2].'/'.$rutas[3].'">'.$i.'</a></li>';
                            }
                            
                            echo '
                                <li class = "disabled"><a>...</a></li>
                                <li id = "item'.$pagProductos.'"><a href="'.$url.$rutas[0].'/'.$pagProductos.'/'.$rutas[2].'/'.$rutas[3].'">'.$pagProductos.'</a></li>
                                <li><a href="'.$url.$rutas[0].'/2/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>';
                        }
                        
                        /*======================================
                        BOTONES DE LAS ULTIMAS 4 PAGINAS Y LA PRIMERA PAGINA
                        ======================================*/
                        else if ($rutas[1] == $pagProductos)
                        {
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($pagProductos-1).'/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="item1"><a href="'.$url.$rutas[0].'/1/'.$rutas[2].'/'.$rutas[3].'">1</a></li>
                                <li class = "disabled"><a>...</a></li>
                            ';
                            
                            for ($i = ($pagProductos-3); $i <= $pagProductos; $i++)
                            {
                                echo '<li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'/'.$rutas[2].'/'.$rutas[3].'">'.$i.'</a></li>';
                            }
                            
                            echo '</ul>';
                        }
                        /*======================================
                        BOTONES DE LA MITAD DE PAGINAS HACIA ABAJO
                        ======================================*/
                        else if($rutas[1] != $pagProductos &&
                                $rutas[1] != 1 &&
                                $rutas[1] < ($pagProductos / 2) &&
                                $rutas[1] < ($pagProductos - 3)
                               ){
                            
                            $numPagActual = $rutas[1];
                            
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual-1).'/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';
                            
                            for ($i = $numPagActual; $i <= ($numPagActual+3); $i++)
                            {
                                echo '
                                <li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'/'.$rutas[2].'/'.$rutas[3].'">'.$i.'</a></li>';
                            }
                            
                            echo '
                                <li class = "disabled"><a>...</a></li>
                                <li id="item'.$pagProductos.'"><a href="'.$url.$rutas[0].'/'.$pagProductos.'/'.$rutas[2].'/'.$rutas[3].'">'.$pagProductos.'</a></li>
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual+1).'/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>';
                        }
                        /*=========================================
                        BOTONES DE LA MITAD DE PAGINAS HACIA ARRIBA
                        =========================================*/
                        else if($rutas[1] != $pagProductos &&
                                $rutas[1] != 1 &&
                                $rutas[1] >= ($pagProductos / 2) &&
                                $rutas[1] < ($pagProductos - 3)
                               ){
                            
                            $numPagActual = $rutas[1];
                            
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual-1).'/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="item1"><a href="'.$url.$rutas[0].'/1/'.$rutas[2].'/'.$rutas[3].'">1</a></li>
                                <li class = "disabled"><a>...</a></li>
                            ';
                            
                            for ($i = $numPagActual; $i <= ($numPagActual+3); $i++)
                            {
                                echo '
                                <li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'/'.$rutas[2].'/'.$rutas[3].'">'.$i.'</a></li>';
                            }
                            
                            echo '
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual+1).'/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>';
                        }
                        /*=========================================
                            BOTONES DE LAS ULTIMAS 4 PAGINAS
                        =========================================*/
                        else
                        {
                            $numPagActual = $rutas[1];
                            
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual-1).'/'.$rutas[2].'/'.$rutas[3].'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="item1"><a href="'.$url.$rutas[0].'/1/'.$rutas[2].'/'.$rutas[3].'">1</a></li>
                                <li class = "disabled"><a>...</a></li>
                            ';
                            
                            for ($i = ($pagProductos-3); $i <= $pagProductos; $i++)
                            {
                                echo '<li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'/'.$rutas[2].'/'.$rutas[3].'">'.$i.'</a></li>';
                            }
                            
                            echo '</ul>';
                        }
                    }
                    else{
                        echo '
                        <ul class="pagination">
                        ';
                        
                        for ($i = 1; $i <= $pagProductos; $i++)
                        {
                            echo '<li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'/'.$rutas[2].'/'.$rutas[3].'">'.$i.'</a></li>';
                        }
                        
                        echo '
                        </ul>';
                    }
                    
                }
                
                ?>
                
            </center>
        </div>
        
    </div>
    
</div>