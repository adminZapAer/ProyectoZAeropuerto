<!DOCTYPE html>

<html lang="es-us">
   
    <head>
       
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <?php
        
        session_start();
        
        $servidor = Ruta::ctrRutaServidor();
        
        $icono = ControladorPlantilla::ctrEstiloPlantilla();
        
        echo '<link rel="icon" href="'.$servidor.$icono["icono"].'">';
        
        /*========================================
            MANTENER LA RUTA FIJA DEL PROYECTO
        ========================================*/
        
        $url = Ruta::ctrRuta();
        
        /*========================================
                    MARCADO DE CABECERAS
        ========================================*/
        $rutas = array();
        
        if(isset($_GET["ruta"])){
            
            $rutas = explode("/", $_GET["ruta"]);
            
            $ruta = $rutas[0];
            
        }
        else{
            
            $ruta = "inicio";
            
        }
        
        $cabeceras = ControladorPlantilla::ctrTraerCabecera($ruta);
        
        if(!$cabeceras["ruta"]){
            
            $ruta = "inicio";
            
            $cabeceras = ControladorPlantilla::ctrTraerCabecera($ruta);
            
        }
        
        ?>
        
        <!--==================================
                    MARCADO HTML5
        ===================================-->
        <meta name="title" content="<?php echo $cabeceras['titulo']; ?>">
        
        <meta name="description" content="<?php echo $cabeceras['descripcion']; ?>">
        
        <meta name="keywords" content="<?php echo $cabeceras['palabrasClave']; ?>">
        
        <title><?php echo $cabeceras['titulo']; ?></title>
        
        <!--=====================================>
            MARCADO OPEN GRAPH FACEBOOK
        <======================================-->

        <meta property="og:title"   content="<?php echo $cabeceras['titulo'];?>">
        <meta property="og:url" content="<?php echo $url.$cabeceras['ruta'];?>">
        <meta property="og:description" content="<?php echo $cabeceras['descripcion'];?>">
        <meta property="og:image"  content="<?php echo $cabeceras['portada'];?>">
        <meta property="og:type"  content="website">	
        <meta property="og:site_name" content="Refaccionaria On line Zapata">
        <meta property="og:locale" content="es_MX">

        <!--=====================================
            MARCADO DATOS ESTRUCTURADOS GOOGLE
        ======================================-->

        <meta itemprop="name" content="<?php echo $cabeceras['titulo'];?>">
        <meta itemprop="url" content="<?php echo $url.$cabeceras['ruta'];?>">
        <meta itemprop="description" content="<?php echo $cabeceras['descripcion'];?>">
        <meta itemprop="image" content="<?php echo $cabeceras['portada'];?>">

        <!--=====================================
                    MARCADO TWITTER
        ======================================-->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo $cabeceras['titulo'];?>">
        <meta name="twitter:url" content="<?php echo $url.$cabeceras['ruta'];?>">
        <meta name="twitter:description" content="<?php echo $cabeceras['descripcion'];?>">
        <meta name="twitter:image" content="<?php echo $cabeceras['portada'];?>">
        <meta name="twitter:site" content="@ZAeropuerto">
        
        
        
        <!--==================================
                    PLUGGINS DE CSS
        ===================================-->
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/bootstrap.min.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/font-awesome.min.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/flexslider.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/sweetalert.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/dscountdown.css">
        
        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
        
        <!--==================================
            HOJAS DE ESTILO PERSONALIZADAS
        ===================================-->
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plantilla.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/encabezado.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/slide.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/productos.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/infoproducto.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/perfil.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/carrito-de-compras.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/ofertas.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/footer.css">
        
        <!--==================================
                PLUGGINS DE JAVASCRIPT
        ===================================-->
        
        <script src="<?php echo $url;?>vistas/js/plugins/jquery.min.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/bootstrap.min.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/jquery.easing.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/jquery.scrollUp.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/jquery.flexslider.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/sweetalert.min.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/dscountdown.min.js"></script>
        
        <!-- WhatsHelp.io widget -->
        <script type="text/javascript">
            (function () {
                var options = {
                    whatsapp: "+52 595 106 9120", // WhatsApp number
                    call_to_action: "Contáctanos", // Call to action
                    position: "right", // Position may be 'right' or 'left'
                };
                var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
                var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
                s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
                var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
            })();
        </script>
        <!-- /WhatsHelp.io widget -->
        <!--=========================================================-->
        
    </head>
    <body>
        
        <?php
        /*==========================================
                        ENCABEZADO
        ==========================================*/
        include "modulos/encabezado.php";
        
        /*==========================================
                    CONTENIDO DINAMICO
        ==========================================*/
        
        $rutas = array();
        
        $ruta = null;
        
        $infoProducto = null;
        
        if(isset($_GET["ruta"])){
            
            $rutas = explode("/", $_GET["ruta"]);
            
            $item = "ruta";
            
            $valor = $rutas[0];
            
            /*--------CATEGORIAS Y SUBCATEGORIAS------*/
            
            /*==========================================
                    URL´s AMIGABLES DE CATEGORIA
            ==========================================*/
            $rutaCategorias = ControladorProductos::ctrMostrarCategorias($item, $valor);
            
            if($rutas[0] == $rutaCategorias["ruta"]){
                
                $ruta = $rutas[0];
                
            }
            /*============================================
                    URL´s AMIGABLES DE SUBCATEGORIA
            ============================================*/
            $rutaSubcategorias = ControladorProductos::ctrMostrarSubcategorias($item, $valor);
            
            foreach ($rutaSubcategorias as $key => $value){
                
                if($rutas[0] == $value["ruta"]){
                
                    $ruta = $rutas[0];

                }
            }
            
            /*============================================
                    URL´s AMIGABLES DE PRODUCTOS
            ============================================*/
            $rutaProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);
            
            if($rutas[0] == $rutaProductos["ruta"]){
                
                $infoProducto = $rutas[0];
                
            }
            
            /*-----------------------------------------------------------------------------*/
            
            /*============================================
                    URL´s AMIGABLES DE MARCAS
            ============================================*/
            $rutasMarcas = ControladorProductos::ctrMostrarRutaMarcas($item, $valor);
            
            if($rutas[0] == $rutasMarcas["ruta"]){
                
                $rutaMarca = $rutas[0];
                
            }
            
            /*============================================
                    URL´s AMIGABLES DE TIPO DE SISTEMAS
            ============================================*/
            $rutasSistemas = ControladorProductos::ctrMostrarRutaSistemas($item, $valor);
            
            if($rutas[0] == $rutasSistemas["ruta"]){
                
                $rutaSistema = $rutas[0];
                
            }
            
            /*============================================
                    URL´s AMIGABLES DE APLICACIONES
            ============================================*/
            $rutasAplicaciones = ControladorProductos::ctrMostrarRutaAplicaciones($item, $valor);
            
            if($rutas[0] == $rutasAplicaciones["ruta"]){
                
                $rutaAplicacion = $rutas[0];
                
            }
            
            /*-----------------------------------------------------------------------------*/
            
            /*===================================================
                LISTA BLANCA DE URL´s AMIGABLES DE CATEGORIA
            ===================================================*/
            if($ruta != null || $rutas[0] == "articulos-gratuitos" || $rutas[0] == "lo-mas-vendido" || $rutas[0] == "lo-mas-visto"){
                include "modulos/productos.php";
            }//Productos
            
            else if($infoProducto != null){
                include "modulos/infoproductos.php";
            }
            
            else if($rutas[0] == "buscador" || $rutas[0] == "verificar" || $rutas[0] == "salir" || $rutas[0] == "perfil" || $rutas[0] == "carrito-de-compras" || $rutas[0] == "ofertas" || $rutas[0] === "proceder-pago"){
                include "modulos/".$rutas[0].".php";
            }
            
            /*-----------------------------------------------------------------------------*/
            else if($rutas[0] == "marca"){
                include "modulos/marcas.php";
            }
            
            else if($rutas[0] == "tipo-de-sistema"){
                include "modulos/sistemas.php";
            }
            
            else if($rutas[0] == "aplicacion"){
                include "modulos/aplicaciones.php";
            }
            else if($rutaMarca !=null || $rutaSistema !=null ||$rutaAplicacion !=null){
                include "modulos/buscador.php";
            }
            /*-----------------------------------------------------------------------------*/
            
            else if($rutas[0] == "inicio"){
                //include "modulos/slide.php";
                //include "modulos/destacados.php";
                include "modulos/familias.php";
            }
            else{
                include "modulos/error404.php";
            }//ERROR404
        }
        else{
            //include "modulos/slide.php";
            //include "modulos/destacados.php";
            include "modulos/familias.php";
        }
        include "modulos/footer.php";
        ?>
        
        <input type="hidden" value="<?php echo $url;?>" id = "rutaFrontend">
        
        <!--===================================
         PLUGGINS DE JAVASCRIPT PERSONALIZADOS
        ====================================-->
        
        <script src="<?php echo $url;?>vistas/js/encabezado.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plantilla.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/slide.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/buscador.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/infoproducto.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/usuarios.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/CarritoComprasService.js"></script>

        <script src="<?php echo $url;?>vistas/js/carrito-de-compras.js"></script>
        
        <!--<script src="<?php echo $url;?>vistas/js/registroFacebook.js"></script>-->
        
        <script>
            /*============================================
                        COMPARTIR EN FACEBOOK
            ============================================*/
            
            $(".btnFacebook").click(function(){
                FB.ui(
                {
                    method: 'share',
                    display: 'popup',
                    href: '<?php echo $url.$cabeceras["ruta"]; ?>',
                }, function(response){});
                
            });
            
        </script>
        
    </body>
</html>