<?php

$url = Ruta::ctrRuta();

//disable-card=visa,mastercard
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php echo $_ENV['PAYPAL_SANDBOX_CLIENT_ID']?>&currency=MXN&debug=false"></script>
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
	                        
	                        <img src="<?php echo $url; ?>vistas/img/plantilla/bbva.jpg" alt="" class="img-thumbnail">
	                        
	                    </figure>
	                    
	                </div>
	                
	                <br>
	                
	                <div class="col-xs-12 col-md-4 col-md-offset-5">
	                	<button class="btn btn-lg btn-default backColor btnPagar">REALIZAR PAGO</button>
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
  	/* OBTENCION DE LOS ELEMENTOS A COMPRAR */
	function getItems() {
	    if(localStorage.getItem("listaProductos") != null){	    
		    let listaCarrito = JSON.parse(localStorage.getItem("listaProductos"));
		    let data = [];
		    listaCarrito.forEach((item, index) => {
		    	data.push({
		    		"idProducto": item.idProducto,
		    		"titulo": item.titulo,
		    		"precio": item.precio,
		    		"tipo": item.tipo,
		    		"cantidad": item.cantidad
		    	});
		    });

		    console.log('data',JSON.stringify(data));
		    return JSON.stringify(data);
	    
	    }
	    else{
	        $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
	        $(".sumaCarrito").hide();
	        $(".cabeceraCheckout").hide();
	    }
	}

	paypal.Buttons({
		createOrder: function() {
			return fetch(rutaFrontEnd + 'ajax/checkout.ajax.php', {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				},
				body: getItems()
			}).then(function(res) {
				return res.json();
			}).then(function(data) {
				console.log('data', data);
				return data.result.id; // Use the same key name for order ID on the client and server
			}).catch(function(except) {
				console.log('except', except);
				return false;
			});
		},onApprove: function(data, actions) {
	    	actions.order.get().then(function(data){
	    		console.log(data);
	    	});
	    	// Capture the funds from the transaction
	    	return actions.order.capture().then(function(details) {
	        // Show a success message to your buyer
	        console.log('details', details);
	        alert('Transaction completed by ' + details.payer.name.given_name);
	        return fetch('/paypal-transaction-complete', {
	          method: 'post',
	          headers: {
	            'content-type': 'application/json'
	          },
	          body: JSON.stringify({
	            orderID: details.id
	          })
	        })
	      });
	    },onError: function (err) {
		    console.log('err', err);
		}
  	}).render('#paypal-button-container');


	
</script>