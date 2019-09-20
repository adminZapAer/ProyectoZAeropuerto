<?php

$url = Ruta::ctrRuta();

//disable-card=visa,mastercard
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $_ENV['PAYPAL_SANDBOX_CLIENT_ID']?>&currency=USD&debug=false"></script>
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
			
			<div class="panel-heading cabeceraCarrito backColor">

				<p >REALIZAR PAGO</p>
				
			</div>
			
			<!--=====================================
			CUERPO CARRITO DE COMPRAS
			======================================-->
			
			<div class="panel-body cuerpoCarrito">
	            
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
			
			
			<!--=====================================
			BOTÓN CHECKOUT
			======================================-->
			
			<div class="panel-heading cabeceraCheckout">
				
				<?php
                
                if(isset($_SESSION["validarSesion"])){
                    
                    if($_SESSION["validarSesion"] == "ok"){
                        
                        echo '
                        <a id="btnCheckout" href="#modalCheckout" data-toggle="modal" idUsuario="'.$_SESSION["idUsuario"].'">
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
        script 
======================================-->
<script>
	paypal.Buttons({
		createOrder: function() {
			return fetch(rutaFrontEnd + 'ajax/checkout.ajax.php', {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				}
			}).then(function(res) {
				res.text().then(res => {
					console.log('res', res.toLocaleString());

				})
				// res.body.getReader().read().then((done, value) => {
				// 	if (done) {
			 //            // Tell the browser that we have finished sending data
			 //            console.log('done', done.value);
			 //          }
				// });
				return res.json();
			}).then(function(data) {
				console.log('data', data);
				return data.orderID; // Use the same key name for order ID on the client and server
			}).catch(function(except) {
				console.log('except', except);
				return false;
			});
		},onError: function (err) {
		    console.log('err', err);
		}

    // createOrder: function(data, actions) {
    //   // Set up the transaction
    //   return actions.order.create({
    //     purchase_units: [{
    //       amount: {
    //         value: '0.01'
    //       }
    //     }]
    //   });
    // },
    // onApprove: function(data, actions) {
    // 	actions.order.get().then(function(data){
    // 		console.log(data);
    // 	});
    // 	// Capture the funds from the transaction
    // 	return actions.order.capture().then(function(details) {
    //     // Show a success message to your buyer
    //     console.log('details', details);
    //     alert('Transaction completed by ' + details.payer.name.given_name);
    //     return fetch('/paypal-transaction-complete', {
    //       method: 'post',
    //       headers: {
    //         'content-type': 'application/json'
    //       },
    //       body: JSON.stringify({
    //         orderID: data.orderID
    //       })
    //     });
    //   });
    // }

  }).render('#paypal-button-container');
</script>