<?php

$url = Ruta::ctrRuta();

?>
<!--=====================================
BREADCRUMB CARRITO DE COMPRAS
======================================-->

<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">Inicio</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>


		</div>

	</div>

</div>

<!--=====================================
TABLA CARRITO DE COMPRAS
======================================-->

<div class="container-fluid">
    
	<div class="container">
	    
		<div class="panel panel-default">
            
			<!--=====================================
			CABECERA CARRITO DE COMPRAS
			======================================-->
			
			<div class="panel-heading cabeceraCarrito">
				
				<div class="col-md-6 col-sm-7 col-xs-12 text-center">
					
					<h3>
						<small>Producto</small>
					</h3>
					
				</div>
				
				<div class="col-md-2 col-sm-1 col-xs-0 text-center">
					
					<h3>
						<small>Precio</small>
					</h3>
					
				</div>
				
				<div class="col-sm-2 col-xs-0 text-center">
					
					<h3>
						<small>Cantidad</small>
					</h3>
					
				</div>
				
				<div class="col-sm-2 col-xs-0 text-center">
					
					<h3>
						<small>Subtotal</small>
					</h3>
					
				</div>
				
			</div>
			
			<!--=====================================
			CUERPO CARRITO DE COMPRAS
			======================================-->
			
			<div class="panel-body cuerpoCarrito">
			
				
				
			</div>
			
			<!--=====================================
			SUMA DEL TOTAL DE PRODUCTOS
			======================================-->
			
			<div class="panel-body sumaCarrito">
			    
				<div class="col-md-4 col-sm-6 col-xs-12 pull-right well">
					
					<div class="col-xs-6">
						
						<h4>TOTAL:</h4>
						
					</div>
					
					<div class="col-xs-6">
					
						<h4 class="sumaSubTotal">
							
							<strong>MXN $<span>0.00</span></strong>
                            
						</h4>
						
					</div> 
					
				</div>
				
			</div>
			
			<!--=====================================
			BOTÓN CHECKOUT
			======================================-->
			
			<div class="panel-heading cabeceraCheckout">
				
				<?php
                
                if(isset($_SESSION["validarSesion"])){
                    
                    if($_SESSION["validarSesion"] == "ok"){
                        
                        echo '
                        <a id="btnCheckout" href="'.$url.'proceder-pago" data-toggle="modal" idUsuario="'.$_SESSION["idUsuario"].'">
                            <button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button>
                        </a>
                        ';
                        
                    }
                    
                }
				else{
                    echo'
                    <a href="#modalIngreso" data-toggle="modal">
                        <button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button>
                    </a>
                    ';
                }
                
                
				?>
				
			</div>

		</div>

	</div>

</div>

<!--=====================================
        VENTANA MODAL PARA CHECKOUT
======================================-->
<div id="modalCheckout" class="modal fade modalFormulario" role="dialog">

    
    <div class="modal-content modal-dialog">
        
        <div class="modal-body modalTitulo">
            
            <h3 class="backColor">REALIZAR PAGO</h3>
            
            <button type="button" data-dismiss="modal" class="close">&times;</button>
            
            <div class="contenidoCheckout">
                
                <?php
                
                $respuesta = ControladorCarrito::ctrMostrarTarifas();
                
                echo'<input type="hidden" id="tasaImpuesto" value ="'.$respuesta["impuesto"].'">';
                echo'<input type="hidden" id="envioNacional" value ="'.$respuesta["envioNacional"].'">';
                echo'<input type="hidden" id="tasaMinimaNal" value ="'.$respuesta["tasaMinimaNal"].'">';
                echo'<input type="hidden" id="tasaPais" value ="'.$respuesta["pais"].'">';
                
                ?>
                
                <div class="formEnvio row">
                    
                    <h4 class="text-center well text-muted text-uppercase">Información de envío</h4>
                    
                    <div class="col-xs-12 seleccionePais">
                        
                        <select id="seleccionarPais" class="form-control" required>
                            <option value="">Seleccione Pais</option>
                        </select>
                        
                        
                    </div>
                    
                </div>
                
                <br>
                <!-- FORMAS DE PAGO -->
                <div class="formPago row">
                    
                    <h4 class="text-center well text-muted text-uppercase">Elige una forma de pago</h4>
                    
                    <figure class="col-xs-6">
                        
                        <center>
                           
                            <input type="radio" id="checkPaypal" name="pago" value="paypal" checked> 
                            
                        </center>
                        
                        <div id="paypal-button-container"></div>
                        
                    </figure>
                    
                    <figure class="col-xs-6">
                        
                        <center>
                            
                            <input type="radio" id="checkBBVA" name="pago" value="BBVA">
                            
                        </center>
                        
                        <img src="<?php echo $url; ?>vistas/img/plantilla/paypal.jpg" alt="" class="img-thumbnail">
                        
                    </figure>
                    
                </div>
                
                <br>
                
                <div class="listaProductos row">
                    
                    <h4 class="text-center well text-muted text-uppercase">Productos a comprar</h4>
                    
                    <table class="table table-striped tablaProductos">
                        
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        
                    </table>
                    
                    <div class="col-sm-6 col-xs-12 pull-right">
                        
                        <table class="table table-striped tablaTasas">
                            
                            <tbody>
                                
                                <tr>
                                    
                                    <td>Subtotal</td>
                                    <td>MXN $ <span class="valorSubtotal">0.00</span></td>
                                    
                                </tr>
                                <tr>
                                    
                                    <td>Envío</td>
                                    <td>MXN $ <span class ="valorTotalEnvio">0.00</span></td>
                                    
                                </tr>
                                <tr>
                                    
                                    <td><strong>Total</strong></td>
                                    <td><strong>MXN $ <span class="valorTotalCompra">0.00</span></strong></td>
                                    
                                </tr>
                            </tbody>
                            
                        </table>
                        
                        <div class="divisa" style = "display:none">
                            
                            <select name="divisa" id="cambiarDivisa" class="form-control">
                                <option value="MXN">MXN</option>
                            </select>
                            
                            <br>
                            
                        </div>
                        
                    </div>
                    
                    <div class="clearfix"></div>
                    
                    <button class="btn btn-block btn-lg btn-default backColor btnPagar">REALIZAR PAGO</button>
                    
                </div>
                
            </div>
            
        </div>
        
        <div class="modal-footer">
            
            
            
        </div>
        
    </div>
     
</div>
<?php
/*
Client ID: ASK-tRIh-stMLfXorejvNakUiOMR7CPyGHlt1AanMtnozv986EPBg0WpjB3sfqtgEFPVhmqOisiXqFcz
Secret: E0mFB4iHR2HFG-amSdXx3o4wjC0dUUfrEEjy56GDHCDUBb4ej97AxvmMk00rg5dwK6INrFtVorggLySm
$_ENV['PAYPAL_APP_ID']

sb-0eq1j132915@personal.example.com
N>6#x+#>

Precio de arnes-de-cabina-para-fuso-1217
13166.8

Precio de arnes-de-motor-cummins
7052.58
 */
?>