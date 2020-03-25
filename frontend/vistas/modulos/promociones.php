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
    echo '
    <!--=======================================================================-->
    
    <!--=======================================================================-->
    <div class="container-fluid productos">
    
        <div class="container">
        
            
            
            <!--=====================================
                VITRINA DE PRODUCTOS EN CUADRÍCULA
            ======================================-->
            
            <ul class="grid0">';
                echo '
                
                <!-- Producto -->
                
                <li class="col-md-2 col-sm-2 col-xs-12">
                    
                    <!--===============================================-->
                    
                    <figure>
                        
                        <img src="'.$servidor.'vistas/img/ofertas-esp.jpg" class="img-responsive oferta-e">
                        
                    </figure>
                    
                    <!--===============================================-->
                    
                </li>
                <!-- Producto -->
                
                <li class="col-md-2 col-sm-2 col-xs-6">
                    
                    <!--===============================================-->
                    
                    <figure>
                    
                        <a href="#modalPromociones1" data-toggle="modal" class="pixelProducto">
                        
                            <img src="'.$servidor.'vistas/img/kit-cascadia.jpg" class="img-responsive">
                            
                        </a>
                        
                    </figure>
                    
                    <!--===============================================-->
                    
                </li>
                <!-- Producto -->
                
                <li class="col-md-2 col-sm-2 col-xs-6">
                    
                    <!--===============================================-->
                    
                    <figure>
                    
                        <a href="#modalPromociones2" data-toggle="modal" class="pixelProducto">
                        
                            <img src="'.$servidor.'vistas/img/kit-mbo.jpg" class="img-responsive">
                            
                        </a>
                        
                    </figure>
                    
                    <!--===============================================-->
                    
                </li>
                <!-- Producto -->
                
                <li class="col-md-2 col-sm-2 col-xs-6">
                    
                    <!--===============================================-->
                    
                    <figure>
                    
                        <a href="#modalPromociones3" data-toggle="modal" class="pixelProducto">
                        
                            <img src="'.$servidor.'vistas/img/kit-m2-904.jpg" class="img-responsive">
                            
                        </a>
                        
                    </figure>
                    
                    <!--===============================================-->
                    
                </li>
                <!-- Producto -->
                
                <li class="col-md-2 col-sm-2 col-xs-6">
                    
                    <!--===============================================-->
                    
                    <figure>
                    
                        <a href="#modalPromociones4" data-toggle="modal" class="pixelProducto">
                        
                            <img src="'.$servidor.'vistas/img/kit-m2-906.jpg" class="img-responsive">
                            
                        </a>
                        
                    </figure>
                    
                    <!--===============================================-->
                    
                </li>
                <!-- Producto -->
                
                <li class="col-md-2 col-sm-2 col-xs-6">
                    
                    <!--===============================================-->
                    
                    <figure>
                    
                        <a href="#modalPromociones5" data-toggle="modal" class="pixelProducto">
                        
                            <img src="'.$servidor.'vistas/img/kit-fuso-360.jpg" class="img-responsive">
                            
                        </a>
                        
                    </figure>
                    
                    <!--===============================================-->
                    
                </li>
                ';
            
            echo '
            </ul>
            
        </div>
        
    </div>
    ';


?>
<!--==============================================-->
<div class="modal fade modalOferta" id="modalPromociones1" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-body img-Promocion">
            <a href="<?php echo $url;?>DNX012071"><img src="<?php echo $servidor;?>vistas/img/promo-kit-cascadia.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>
<!--==============================================-->
<div class="modal fade modalOferta" id="modalPromociones2" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-body img-Promocion">
            <a href="<?php echo $url;?>KITZAOM924"><img src="<?php echo $servidor;?>vistas/img/promo-kit-mbo.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>
<!--==============================================-->
<div class="modal fade modalOferta" id="modalPromociones3" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-body img-Promocion">
            <a href="<?php echo $url;?>KITM2904"><img src="<?php echo $servidor;?>vistas/img/promo-kit-m2-904.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>
<!--==============================================-->
<div class="modal fade modalOferta" id="modalPromociones4" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-body img-Promocion">
            <a href="<?php echo $url;?>KITM2906"><img src="<?php echo $servidor;?>vistas/img/promo-kit-m2-906.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>
<!--==============================================-->
<div class="modal fade modalOferta" id="modalPromociones5" role="dialog">
    
    <div class="modal-dialog">
        <div class="modal-body img-Promocion">
            <a href="<?php echo $url;?>KITFUSO360"><img src="<?php echo $servidor;?>vistas/img/promo-kit-fuso-360.jpg"></a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div>¡Aprovecha nuestra oferta de lanzamiento!</div>
        </div>
    </div>
</div>