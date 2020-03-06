<!------------------------------------
                BANNER
------------------------------------->
<?php

$servidor = Ruta::ctrRutaServidor();
$url = Ruta::ctrRuta();

$ruta = "sin-categoria";

$eliminarFactTemp = new ControladorCarrito();
$eliminarFactTemp -> ctrComprobarFactTemporal();

//var_dump($_GET["datosT"]);

/*
$banner = ControladorProductos::ctrMostrarBanner($ruta);

$titulo1 = json_decode($banner["titulo1"],true);
$titulo2 = json_decode($banner["titulo2"],true);
$titulo3 = json_decode($banner["titulo3"],true);

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

*/
?>

<?php

$titulosModulos = array("TIPO DE SISTEMA");

$rutaModulos = array("tipo-de-sistema");

$base = 0;

$tope = 4;

if($titulosModulos[0] == "TIPO DE SISTEMA"){
    
    $ordenar = "sistemas";//esta variable va a ser la que defina como va a ser ordenada la tabla
    $item = null;
    $valor = null;
    $modo = "DESC";
    
    $tipoSistema = ControladorProductos::ctrMostrarSistemas($ordenar, $item, $valor, $base, $tope, $modo);
    
}

$modulos = array($tipoSistema);

for ($i = 0; $i < count($titulosModulos); $i++){
    echo '
    <!--=======================================================================-->
    
    <!--=======================================================================-->
    <div class="container-fluid productos">
    
        <div class="container">
        
            <div class="row">
            
                <!--=====================================
                                BARRA TÍTULO
                ======================================-->
                
                <div class="col-xs-12 tituloDestacado">
                
                    <!--===============================================-->
                    
                    <div class="col-sm-6 col-xs-12">
                    
                        <h1><small>'.$titulosModulos[$i].'</small></h1>
                        
                    </div>
                    
                    <!--===============================================-->
                    
                    <div class="col-sm-6 col-xs-12">
                    
                        <a href="'.$rutaModulos[$i].'">
                        
                            <button class="btn btn-default backColor pull-right">
                            
                                VER MÁS <span class="fa fa-chevron-right"></span>
                                
                            </button>
                            
                        </a>
                        
                    </div>
                    
                    <!--===============================================-->
                    
                </div>
                
                <div class="clearfix"></div>
                
                <hr>
                
            </div>
            
            <!--=====================================
                VITRINA DE PRODUCTOS EN CUADRÍCULA
            ======================================-->
            
            <ul class="grid'.$i.'">';
            
            foreach ($modulos[$i] as $key => $value)
            {
                echo '
                
                <!-- Producto -->
                
                <li class="col-md-3 col-sm-6 col-xs-6 familias">
                
                    <!--===============================================-->
                    
                    <figure>
                    
                        <a href="'.$url."buscador/1/recientes/".$value["ruta"].'" class="pixelProducto">
                        
                            <img src="'.$servidor.$value["portada"].'" class="img-responsive">
                            
                        </a>
                        
                    </figure>
                    
                    <!--===============================================-->
                    <!--
                    <h4>
                    
                        <small>
                        
                            <a href="'.$url."buscador/1/recientes/".$value["ruta"].'" class="pixelProducto">
                            
                                '.$value["titulo"].'<br>
                                
                            </a>
                            
                        </small>
                        
                    </h4>-->
                    
                    <!--===============================================-->
                    
                    
                    <!--===============================================-->
                    
                    
                </li>
                ';
            }
            
            echo '
            </ul>
            
        </div>
        
    </div>
    ';
}

?>