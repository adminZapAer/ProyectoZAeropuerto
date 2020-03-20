<div class="container-fluid dudasYSugerencias">
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8 metodosPago">
            
        <ul class="horizontal">
            <li><img src="<?php echo $url;?>vistas/img/plantilla/logo-visa.png" alt=""></li>
            <li><img src="<?php echo $url;?>vistas/img/plantilla/logo-mastercard.png" alt=""></li>
            <li><img src="<?php echo $url;?>vistas/img/plantilla/logo-amex.png" alt=""></li>
            <li><img src="<?php echo $url;?>vistas/img/plantilla/logo-paypal.png" alt=""></li>
        </ul>
        
    </div>

    <img class="dudas-sugerencias" src="<?php echo $servidor;?>vistas/img/dudas.png">
    
    <div class="container">
        
        <div class="row">
            
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 telefonoContacto">
                <div class="col-xs-2 datos-i">
                    <img src="<?php echo $servidor;?>vistas/img/telefono-gris49x51.png" alt="">
                </div>
                <div class="col-xs-10 datos-t">
                    (595) 954-99-33
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 correoContacto" style="justify-content: center; align-items: center;">
                <div class="col-xs-2 datos-i">
                    <img src="<?php echo $servidor;?>vistas/img/sobre-gris57x39.png" alt="">
                </div>
                <div class="col-xs-10 datos-t">
                    contacto@zapata.com.mx
                </div>
                
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 direccionContacto" style="justify-content: center; align-items: center;">
                <div class="col-xs-2 datos-i">
                    <img src="<?php echo $servidor;?>vistas/img/ubicacion-gris43x61.png" style="float:left;" alt="">
                </div>
                
                <div class="col-xs-10 datos-t">
                    Carretera Los Reyes - Lechería Km. 23. 
                    <br>
                    Colonia La Magdalena Panoaya
                    <br>
                    Municipio Texcoco | Estado de México
                </div>
                
            </div>
            
        </div>
            
    </div>
    
    <div class="container formularioCont">
        
        <div class="row">
            
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                
                
                
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-center formContacto">
                
                <h1 style="font-size:30px; color: red; text-align: center; text-transform: uppercase; font-family: 'Anton', sans-serif;">¿Cómo podemos ayudarte?</h1>
                <form role="form" method="post" onsubmit="return validarContactenos()">
                    
                    <input type="text" id="nombreContactenos" name="nombreContactenos" class="form-control" placeholder="Escriba su nombre" required>
                    
                    <br>
                    
                    <input type="email" id="emailContactenos" name="emailContactenos" class="   form-control" placeholder="Escriba su correo electrónico" required>  
                    
                    <br>
                    
                    <textarea id="mensajeContactenos" name="mensajeContactenos" class="form-control" placeholder="Escriba su mensaje" rows="5" required></textarea>
                    
                    <br>
                    
                    <input type="submit" value="Enviar" class="btn btn-default backColor" style="text-align:center;" id="enviar">         
                    
                    <br>
                    <br>
                    <br>
                </form>
                
                <?php
                    
                $contactenos = new ControladorUsuarios();
                $contactenos -> ctrFormularioContactenos();
                
                ?>
                
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                
                
            </div>
            
        </div>
            
    </div>
    
    
</div>
<!--==================================
                FOOTER
===================================-->
<footer class="container-fluid footer">
    
    <div class="container">
        
        <div class="row">
            <!--==================================
                           CATEGORIAS
            ===================================-->
            <div class="somos">
                
                <div class="col-xs-12 text-center">
                    
                    <span class="somos-1"><a href="https://www.zapataaeropuerto.com/about.html" target="_blank">Conócenos... </a></span><span class="quien-soy"><a href="https://www.zapataaeropuerto.com/about.html" target="_blank">¿Quienes somos?</a></span>
                    
                </div>
                
            </div>
            <br>
            <br>
            <div class="marcas">
                <div class="col-xs-12" id="zaeropuerto">
                    <figure>
                        <a href="https://www.zapataaeropuerto.com">
                            <img src="<?php echo $servidor;?>vistas/img/plantilla/logob.png">
                        </a>
                    </figure>
                </div>
                
            </div>
            
        </div>
        
    </div>
    
    <br>
    
</footer>

<!--==================================
                FIN
===================================-->
<div class="container-fluid final">
    
    <div class="container">
        
        <div class="row">
            
            <div class="col-sm-4 col-xs-12 text-center text-muted">
                
                <!--<img src="<?php echo $servidor;?>vistas/img/plantilla/logob.png" alt="Zapata Aeropuerto" style="width:100%; max-width:200px;">-->
                
            </div>
            
            <div class="col-sm-4 col-xs-12 text-center text-muted social">
                
                <?php
                
                date_default_timezone_set('America/Mexico_City');
                
                $fecha = date('Y');
                
                echo'<h5>&copy; '.$fecha.'. Todos los derechos reservados.</h5>';
                echo '<h5><a href="'.$url.'terminos-y-condiciones" target="_blank">Términos y Condiciones</a></h5>';
                echo '<br>';
                
                ?>
                
                <ul>
                    
                    <?php
                    
                    $social = ControladorPlantilla::ctrEstiloPlantilla();
                    
                    $jsonRedesSociales = json_decode($social["redesSociales"],true);
                    
                    foreach ($jsonRedesSociales as $key => $value) {

                        echo '
                        <li>
                            <a href="'.$value["url"].'" target="_blank">
                                <i class="fa '.$value["red"].' redSocial '.$value["estilo"].'" aria-hidden="true"></i>
                            </a>
                        </li>
                        ';
                    }
                    
                    ?>
                    
                </ul>
                    
            </div>
            
            <div class="col-sm-4 col-xs-12 text-center social">
                
                
                
            </div>
            
        </div>
        
    </div>
    
</div>