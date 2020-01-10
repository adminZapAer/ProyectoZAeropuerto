<!--==================================
                FOOTER
===================================-->
<footer class="container-fluid footer">
    
    <div class="container">
        
        <div class="row">
            
            <!--==================================
                           CATEGORIAS
            ===================================-->
            
            <div class="col-lg-5 col-md-6 col-sm-4 col-xs-12 footerCategorias">
                
                
            </div>
            
            <!--==================================
                           CATEGORIAS
            ===================================-->
            <div class="col-md-3 col-sm-6 col-xs-12 text-left infoContacto">
                
                <h5>Dudas e inquietudes, contactenos en:</h5>
                
                <h5>
                    
                    <i class="fa fa-phone-square" aria-hidden="true"></i>&#160;&#160;(595) 954-99-33
                    
                    <br><br>
                    
                    <i class="fa fa-envelope" aria-hidden="true"></i>&#160;&#160;contacto@zapata.com.mx
                    
                    <br><br>
                    
                    <i class="fa fa-map-marker" aria-hidden="true"></i>&#160;   Carretera Los Reyes - Lechería Km. 23
                    <br>
                    &#160;&#160;&#160;Colonia La Magdalena Panoaya
                    <br>
                    &#160;&#160;&#160;Municipio Texcoco | Estado de México
                    
                    <br><br>
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3760.3769915836965!2d-98.90006268552393!3d19.525421986831656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1e63c8098f3db%3A0x6f30d8d92669587!2sZAPATA%20CAMIONES%20AEROPUERTO!5e0!3m2!1ses-419!2smx!4v1567935421889!5m2!1ses-419!2smx" width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    
                </h5>
                
            </div>
            
            <!--==================================
                    FORMULARIO CONTÁCTENOS
            ===================================-->
            
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 formContacto">
				
                <h4>RESUELVA SU INQUIETUD</h4>

				<form role="form" method="post" onsubmit="return validarContactenos()">

                    <input type="text" id="nombreContactenos" name="nombreContactenos" class="form-control" placeholder="Escriba su nombre" required>
                    
                    <br>
                    
                    <input type="email" id="emailContactenos" name="emailContactenos" class="	form-control" placeholder="Escriba su correo electrónico" required>  
                    
                    <br>
                    
                    <textarea id="mensajeContactenos" name="mensajeContactenos" class="form-control" placeholder="Escriba su mensaje" rows="5" required></textarea>
                    
                    <br>
                    
                    <input type="submit" value="Enviar" class="btn btn-default backColor pull-right" id="enviar">         
                    
                </form>
                
                <?php
                    
				$contactenos = new ControladorUsuarios();
				$contactenos -> ctrFormularioContactenos();
                
				?>
                
			</div>
            
        </div>
        
    </div>
    
</footer>

<!--==================================
                FIN
===================================-->
<div class="container-fluid final">
    
    <div class="container">
        
        <div class="row">
            
            <div class="col-sm-4 col-xs-12 text-center text-muted">
                
                <img src="<?php echo $servidor;?>vistas/img/plantilla/logob.png" alt="Zapata Aeropuerto" style="width:100%; max-width:200px;">
                
            </div>
            
            <div class="col-sm-4 col-xs-12 text-center text-muted">
                
                <?php
                
                date_default_timezone_set('America/Mexico_City');
                
                $fecha = date('Y');
                
                echo'<h5>&copy; '.$fecha.'. Todos los derechos reservados.</h5>';
                
                ?>
                    
            </div>
            
            <div class="col-sm-4 col-xs-12 text-center social">
                
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
            
        </div>
        
    </div>
    
</div>