<!------------------------------------
                BANNER
------------------------------------->

<?php

$servidor = Ruta::ctrRutaServidor();

$url = Ruta::ctrRuta();

$ruta = $rutas[0];
/*
$banner = ControladorProductos::ctrMostrarBanner($ruta);

$titulo1 = json_decode($banner["titulo1"],true);
$titulo2 = json_decode($banner["titulo2"],true);
$titulo3 = json_decode($banner["titulo3"],true);

if($banner != null){
    
    echo '
    <figure class="banner">
    
        <img src="'.$servidor.$banner["img"].'" class="img-responsive" style="width:100%;" alt="">
        
        <div class="textoBanner '.$banner["estilo"].'">
        
            <h1 style="color:'.$titulo1["color"].';">'.$titulo1["texto"].'</h1>
            
            <h2 style="color:'.$titulo2["color"].';"><strong>'.$titulo2["texto"].'</strong></h2>
            
            <h3 style="color:'.$titulo3["color"].'">'.$titulo3["texto"].'</h3>    
            
        </div>
        
    </figure>
    ';
}
*/
?>

<!--=====================================
BARRA PRODUCTOS
======================================-->

<div class="container-fluid well well-sm barraProductos">
    
    <div class="container">
        
	    <div class="row">
	    
	        <div class="col-sm-6 col-xs-12">
	           
	            
	        </div>
		    <!--<div class="col-sm-6 col-xs-12 organizarProductos">
                
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
				
			</div>-->
			
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
                
            </ul>
            
            <?php
            /*======================================
                    LLAMADO DE PAGINACION
            ======================================*/
            //Preguntaremos si viene la variable rutas en su indice 1
            if(isset($rutas[1])){
                
                /*if(isset($rutas[2])){//se pregunta si se esta usando ruta 2
                    
                    if($rutas[2] == "antiguos"){//Si viene valor antiguo mostrara los datos ascendentes
                        $modo = "ASC";
                        $_SESSION["ordenar"] = "ASC";
                    }
                    else{//de lo contrario mostrara los datos descendentes
                        $modo = "DESC";
                        $_SESSION["ordenar"] = "DESC";
                    }
                }
                else{*///Si no viene ruta 2 con la paginación, mostrara los datos descendentes
                    //Si existen datos en la variable ordenar
                    if(isset($_SESSION["ordenar"])){
                        $modo = $_SESSION["ordenar"];
                    }
                    else{
                        $modo = "DESC";
                    }
                    
                /*}*/
                
                $base = ($rutas[1] - 1)*20;
                $tope = 20;
            }
            else{
                $rutas[1]= 1;
                $base = 0;
                $tope = 20;
                $modo = "DESC";
            }
            
            /*========================================================
            LLAMADO DE PRODUCTOS CATEGORIAS SUBCATEGORIAS Y DESTACADOS
            ========================================================*/
            if($rutas[0] == "catalogo"){
                $item1 = null;
                $valor1 = null;
                $ordenar = "catalogos";
                
            }
            $catalogos = ControladorProductos::ctrMostrarCatalogos($ordenar, $item1, $valor1, $base, $tope, $modo);/*Mandamos a llamar*/
            
            $listaCatalogos = ControladorProductos::ctrListarCatalogos($ordenar, $item1, $valor1);
            
            if (!$catalogos)
            {
                echo '
                
                <div class = "col-xs-12 text-center error404">
                    
                    <h1><small>¡Oops!</small></h1>
                    <h2>No hay catalogos que mostrar.</h2>
                    
                </div>
                
                ';
            }
            else{
                
                echo'
                    <!--=====================================
                        VITRINA DE PRODUCTOS EN CUADRICULA
                    ======================================-->
                    <ul class = "grid0">';
                        
                        foreach ($catalogos as $key => $value)
                        {
                            echo '
                            <!-- Producto -->
                            
                            <li class="col-md-3 col-sm-6 col-xs-12">
                            
                                <!--===============================================-->
                                <figure>
                                    
                                    <a href="'.$servidor.$value["enlaceCat"].'" class="pixelProducto">
                                        
                                        <img src="'.$servidor.$value["portada"].'" class="img-responsive">
                                        
                                    </a>
                                    
                                </figure>
                                
                                <!--'.$value["id"].'-->
                                
                                <!--===============================================-->
                                
                                <h4>
                                    
                                    <small>
                                        
                                        <a href="'.$servidor.$value["enlaceCat"].'" class="pixelProducto">
                                            
                                            '.$value["titulo"].'<br>
                                            
                                            <span style = "color:rgba(0,0,0,0);">-</span>';
                                            
                                        echo'
                                        </a>
                                        
                                    </small>
                                    
                                </h4>
                                
                                <!--===============================================-->
                                
                                <!--===============================================-->
                                
                            </li>
                            ';
                        }
                        
                    echo '
                    </ul>
                    <!--=====================================
                          VITRINA DE PRODUCTOS EN LISTA
                    ======================================-->
                    
                    ';
                    
                
                
            }
            
            //var_dump(count($listaProductos));
            
            ?>
            
            <div class="clearfix"></div>
            
            <center>
                <!--==================================
                *==          PAGINACION            ==*
                ===================================-->
                <?php
                
                if(count($listaCatalogos) != 0){
                    
                    $pagCatalogos = ceil(count($listaCatalogos)/20); /**/
                    
                    if($pagCatalogos > 4){
                        
                        /*======================================
                        BOTONES DE LAS PRIMERAS 4 PAGINAS Y LA ULTIMA PAGINA
                        ======================================*/
                        
                        if($rutas[1] == 1){
                            echo '
                            <ul class="pagination">
                            ';
                            
                            for ($i = 1; $i <= 4; $i++)
                            {
                                echo '<li id = "item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'">'.$i.'</a></li>';
                            }
                            
                            echo '
                                <li class = "disabled"><a>...</a></li>
                                <li id = "item'.$pagCatalogos.'"><a href="'.$url.$rutas[0].'/'.$pagCatalogos.'">'.$pagCatalogos.'</a></li>
                                <li><a href="'.$url.$rutas[0].'/2"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>';
                        }
                        
                        /*======================================
                        BOTONES DE LAS ULTIMAS 4 PAGINAS Y LA PRIMERA PAGINA
                        ======================================*/
                        else if ($rutas[1] == $pagCatalogos)
                        {
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($pagCatalogos-1).'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="item1"><a href="'.$url.$rutas[0].'/1">1</a></li>
                                <li class = "disabled"><a>...</a></li>
                            ';
                            
                            for ($i = ($pagCatalogos-3); $i <= $pagCatalogos; $i++)
                            {
                                echo '<li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'">'.$i.'</a></li>';
                            }
                            
                            echo '</ul>';
                        }
                        /*======================================
                        BOTONES DE LA MITAD DE PAGINAS HACIA ABAJO
                        ======================================*/
                        else if($rutas[1] != $pagCatalogos &&
                                $rutas[1] != 1 &&
                                $rutas[1] < ($pagCatalogos / 2) &&
                                $rutas[1] < ($pagCatalogos - 3)
                               ){
                            
                            $numPagActual = $rutas[1];
                            
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual-1).'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';
                            
                            for ($i = $numPagActual; $i <= ($numPagActual+3); $i++)
                            {
                                echo '
                                <li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'">'.$i.'</a></li>';
                            }
                            
                            echo '
                                <li class = "disabled"><a>...</a></li>
                                <li id="item'.$pagCatalogos.'"><a href="'.$url.$rutas[0].'/'.$pagCatalogos.'">'.$pagCatalogos.'</a></li>
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual+1).'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>';
                        }
                        /*=========================================
                        BOTONES DE LA MITAD DE PAGINAS HACIA ARRIBA
                        =========================================*/
                        else if($rutas[1] != $pagCatalogos &&
                                $rutas[1] != 1 &&
                                $rutas[1] >= ($pagCatalogos / 2) &&
                                $rutas[1] < ($pagCatalogos - 3)
                               ){
                            
                            $numPagActual = $rutas[1];
                            
                            echo '
                            <ul class="pagination">
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual-1).'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="item1"><a href="'.$url.$rutas[0].'/1">1</a></li>
                                <li class = "disabled"><a>...</a></li>
                            ';
                            
                            for ($i = $numPagActual; $i <= ($numPagActual+3); $i++)
                            {
                                echo '
                                <li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'">'.$i.'</a></li>';
                            }
                            
                            echo '
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual+1).'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
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
                                <li><a href="'.$url.$rutas[0].'/'.($numPagActual-1).'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li id="item1"><a href="'.$url.$rutas[0].'/1">1</a></li>
                                <li class = "disabled"><a>...</a></li>
                            ';
                            
                            for ($i = ($pagCatalogos-3); $i <= $pagCatalogos; $i++)
                            {
                                echo '<li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'">'.$i.'</a></li>';
                            }
                            
                            echo '</ul>';
                        }
                    }
                    else{
                        echo '
                        <ul class="pagination">
                        ';
                        
                        for ($i = 1; $i <= $pagCatalogos; $i++)
                        {
                            echo '<li id="item'.$i.'"><a href="'.$url.$rutas[0].'/'.$i.'">'.$i.'</a></li>';
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