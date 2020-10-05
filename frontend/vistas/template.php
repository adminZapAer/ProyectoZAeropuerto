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
        <meta property="og:image"  content="<?php echo $url.$cabeceras['portada'];?>">
        <meta property="og:type"  content="website">	
        <meta property="og:site_name" content="Refaccionaria On line Zapata">
        <meta property="og:locale" content="es_MX">

        <!--=====================================
            MARCADO DATOS ESTRUCTURADOS GOOGLE
        ======================================-->

        <meta itemprop="name" content="<?php echo $cabeceras['titulo'];?>">
        <meta itemprop="url" content="<?php echo $url.$cabeceras['ruta'];?>">
        <meta itemprop="description" content="<?php echo $cabeceras['descripcion'];?>">
        <meta itemprop="image" content="<?php echo $url.$cabeceras['portada'];?>">

        <meta name="google-site-verification" content="GHe1O_0c_e91stCPyBNpydKiW5y3toTLz5gQfAVR4Rg" />

        <!--=====================================
                    MARCADO TWITTER
        ======================================-->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo $cabeceras['titulo'];?>">
        <meta name="twitter:url" content="<?php echo $url.$cabeceras['ruta'];?>">
        <meta name="twitter:description" content="<?php echo $cabeceras['descripcion'];?>">
        <meta name="twitter:image" content="<?php echo $url.$cabeceras['portada'];?>">
        <meta name="twitter:site" content="@ZAeropuerto">
        
        <!--++++++++++++++++++++++++++++++++++++++++++++++++++-->
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162197239-1"></script>
        
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-162197239-1');
            gtag('config', 'AW-847442689');
            gtag('config', 'UA-163216960-1');
        </script>

        <!-- Google Tag Manager -->
        <script>
            (function(w,d,s,l,i)
                {w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});
                var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);}
            )(window,document,'script','dataLayer','GTM-WL5MQDR');
        </script>
        <!-- End Google Tag Manager -->

        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window,document,'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '114370469366571'); 
                fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" 
                src="https://www.facebook.com/tr?id=114370469366571&ev=PageView
                &noscript=1"/>
        </noscript>
            <!-- End Facebook Pixel Code -->

        <!--++++++++++++++++++++++++++++++++++++++++++++++++++-->
        
        <script src="//code.jivosite.com/widget/ja5kigTXc8" async></script>
        
        <!--==================================
                    PLUGGINS DE CSS
        ===================================-->
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/bootstrap.min.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/font-awesome.min.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/flexslider.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/sweetalert.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/dscountdown.css">
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/plugins/bootstrap-datetimepicker.min.css">
        
        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css?family=Anton&display=swap" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Oswald:300&display=swap" rel="stylesheet">
        
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
        
        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/banner.css">

        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/fonts/post-scriptum/stylesheet.css">

        <link rel="stylesheet" href="<?php echo $url;?>vistas/css/fonts/arial-bold/stylesheet.css">
        
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
        
        <script src="<?php echo $url;?>vistas/js/plugins/moment.min.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/plugins/bootstrap-datetimepicker.min.js"></script>
        
    </head>
    <body>
        
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v8.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <!-- Your Chat Plugin code -->
        <div class="fb-customerchat"
          attribution=install_email
          page_id="104927631189643"
            logged_in_greeting="Bienvenido/a a nuestra Refaccionaria Zapata. &#xbf;en que podemos ayudarte?"
            logged_out_greeting="Bienvenido/a a nuestra Refaccionaria Zapata. &#xbf;en que podemos ayudarte?">
        </div>
        <!-- Load Facebook SDK for JavaScript -->
        
        <!-- WhatsApp widget -->
        <a target="_blank" href="https://api.whatsapp.com/send?phone=525951069120&amp;text=%C2%BFTienes+dudas+sobre+tu+pieza%3F+o+%C2%BFNecesitas+una+cotizaci%C3%B3n%3F+Env%C3%ADanos+un+mensaje+y+nos+comunicaremos+con+usted." id="whatsapp-button" style="position: fixed; right: 22px; width: 55px; z-index: 999; bottom: 98px;"><img style="width:100%;" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPHBhdGggc3R5bGU9ImZpbGw6I0VERURFRDsiIGQ9Ik0wLDUxMmwzNS4zMS0xMjhDMTIuMzU5LDM0NC4yNzYsMCwzMDAuMTM4LDAsMjU0LjIzNEMwLDExNC43NTksMTE0Ljc1OSwwLDI1NS4xMTcsMCAgUzUxMiwxMTQuNzU5LDUxMiwyNTQuMjM0UzM5NS40NzYsNTEyLDI1NS4xMTcsNTEyYy00NC4xMzgsMC04Ni41MS0xNC4xMjQtMTI0LjQ2OS0zNS4zMUwwLDUxMnoiLz4KPHBhdGggc3R5bGU9ImZpbGw6IzU1Q0Q2QzsiIGQ9Ik0xMzcuNzEsNDMwLjc4Nmw3Ljk0NSw0LjQxNGMzMi42NjIsMjAuMzAzLDcwLjYyMSwzMi42NjIsMTEwLjM0NSwzMi42NjIgIGMxMTUuNjQxLDAsMjExLjg2Mi05Ni4yMjEsMjExLjg2Mi0yMTMuNjI4UzM3MS42NDEsNDQuMTM4LDI1NS4xMTcsNDQuMTM4UzQ0LjEzOCwxMzcuNzEsNDQuMTM4LDI1NC4yMzQgIGMwLDQwLjYwNywxMS40NzYsODAuMzMxLDMyLjY2MiwxMTMuODc2bDUuMjk3LDcuOTQ1bC0yMC4zMDMsNzQuMTUyTDEzNy43MSw0MzAuNzg2eiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRkVGRUZFOyIgZD0iTTE4Ny4xNDUsMTM1Ljk0NWwtMTYuNzcyLTAuODgzYy01LjI5NywwLTEwLjU5MywxLjc2Ni0xNC4xMjQsNS4yOTcgIGMtNy45NDUsNy4wNjItMjEuMTg2LDIwLjMwMy0yNC43MTcsMzcuOTU5Yy02LjE3OSwyNi40ODMsMy41MzEsNTguMjYyLDI2LjQ4Myw5MC4wNDFzNjcuMDksODIuOTc5LDE0NC43NzIsMTA1LjA0OCAgYzI0LjcxNyw3LjA2Miw0NC4xMzgsMi42NDgsNjAuMDI4LTcuMDYyYzEyLjM1OS03Ljk0NSwyMC4zMDMtMjAuMzAzLDIyLjk1Mi0zMy41NDVsMi42NDgtMTIuMzU5ICBjMC44ODMtMy41MzEtMC44ODMtNy45NDUtNC40MTQtOS43MWwtNTUuNjE0LTI1LjZjLTMuNTMxLTEuNzY2LTcuOTQ1LTAuODgzLTEwLjU5MywyLjY0OGwtMjIuMDY5LDI4LjI0OCAgYy0xLjc2NiwxLjc2Ni00LjQxNCwyLjY0OC03LjA2MiwxLjc2NmMtMTUuMDA3LTUuMjk3LTY1LjMyNC0yNi40ODMtOTIuNjktNzkuNDQ4Yy0wLjg4My0yLjY0OC0wLjg4My01LjI5NywwLjg4My03LjA2MiAgbDIxLjE4Ni0yMy44MzRjMS43NjYtMi42NDgsMi42NDgtNi4xNzksMS43NjYtOC44MjhsLTI1LjYtNTcuMzc5QzE5My4zMjQsMTM4LjU5MywxOTAuNjc2LDEzNS45NDUsMTg3LjE0NSwxMzUuOTQ1Ii8+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo="></a>
        <!-- /WhatsApp widget -->
        <!--=========================================================-->
        
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
            
            else if($rutas[0] == "buscador" || $rutas[0] == "verificar" || $rutas[0] == "salir" || $rutas[0] == "compras" || $rutas[0] == "favoritos" || $rutas[0] == "perfil" || $rutas[0] == "direcciones" || $rutas[0] == "facturacion" || $rutas[0] == "ofertas" || $rutas[0] == "carrito-de-compras" || $rutas[0] === "proceder-pago" || $rutas[0] == "editarDireccion" || $rutas[0] == "pagoTransferencia" || $rutas[0] == "terminos-y-condiciones" || $rutas[0] == "politicas-privacidad"){
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
                include "modulos/banner.php";
                include "modulos/promociones.php";
                include "modulos/aplicacion.php";
                include "modulos/marca.php";
                include "modulos/tipo-de-sistema.php";
                include "modulos/infoZapata.php";
            }
            else{
                include "modulos/error404.php";
            }//ERROR404
        }
        else{
            //include "modulos/slide.php";
            //include "modulos/destacados.php";
            include "modulos/banner.php";
            include "modulos/promociones.php";
            include "modulos/aplicacion.php";
            include "modulos/marca.php";
            include "modulos/tipo-de-sistema.php";
            include "modulos/infoZapata.php";
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

        <script src="<?php echo $url;?>vistas/js/services/CotizadorEstafetaService.js"></script>

        <script src="<?php echo $url;?>vistas/js/carrito-de-compras.js"></script>
        
        <script src="<?php echo $url;?>vistas/js/banner.js"></script>
        
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