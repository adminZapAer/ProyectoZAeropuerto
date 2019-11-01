<?php

$url = Ruta::ctrRuta();

//disable-card=visa,mastercard
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?php if(getenv('PAYPAL_SANDBOX_CLIENT_ID')){echo getenv('PAYPAL_SANDBOX_CLIENT_ID');} else{echo getenv('CLIENT_ID');}?>&currency=MXN&disable-card=visa,mastercard,amex"></script>
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
			
			<div class="panel-body">
	            
	            <button class="btn btn-success" id="email">Send email</button>
	            
	            <div class="contenidoCheckout">
	                	                
	                <br>
	                <!-- FORMAS DE PAGO -->
	                <div class="formPago row">
	                    
	                    <h4 class="text-center well text-muted text-uppercase">Elige una forma de pago</h4>
	                    
	                    <figure class="col-xs-6 col-xs-offset-3">
	                        
	                        <center>
	                           
	                            <input type="radio" id="checkPaypal" name="pago" value="paypal" checked> 
	                            
	                        </center>
	                        
	                        <div id="paypal-button-container"></div>
	                        
	                    </figure>
	                    
	                    <!-- <figure class="col-xs-6">
	                        
	                        <center>
	                            
	                            <input type="radio" id="checkBBVA" name="pago" value="BBVA">
	                            
	                        </center>
	                        
	                        <img src="<?php echo $url; ?>vistas/img/plantilla/bbva.jpg" alt="" class="img-thumbnail">
	                        
	                    </figure> -->
	                    
	                </div>
	                
	                <br>
	                
	            </div>
				
			</div>
			
			
			<!--=====================================
			BOTÓN CHECKOUT
			======================================-->


		</div>

	</div>

</div>

<!--=====================================
        script 
======================================-->
<script>
	$('#email').on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: rutaFrontEnd + 'ajax/checkout.ajax.php',
			type: 'POST',
			dataType: 'json',
			data: {
				detalles: getItems(),
				usuario: JSON.stringify(localStorage.getItem("usuario"))
			},
		})
		.done(function(res) {
			console.log("success", res);
		})
		.fail(function(err) {
			console.log("error", err);
		});
		
	});
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
		style: {
		    layout:  'vertical',
		    color:   'gold',
		    shape:   'pill',
		    size:    '55',
		    label:   'paypal'
		  },
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
				return data.result.id; // Use the same key name for order ID on the client and server
			}).catch(function(except) {
				return false;
			});
		},onApprove: function(data, actions) {
	    	actions.order.get().then(function(data){
	    	});
	    	// Capture the funds from the transaction
	    	return actions.order.capture().then(function(details) {
	        // Show a success message to your buyer
	        console.log('details', details);
	        $.ajax({
				url: rutaFrontEnd + 'ajax/checkout.ajax.php',
				type: 'POST',
				dataType: 'json',
				data: {
					detalles: details,
					usuario: JSON.stringify(localStorage.getItem("usuario"))
				},
			})
			.done(function(res) {
				console.log("success", res);
				swal({
				  title: "Transacción aceptada",
				  text: "Compra realizada con éxito",
				  type: "success",
				  confirmButtonText: "Aceptar",
				  closeOnConfirm: false
				},function(isConfirm){
					if (isConfirm) {
						localStorage.removeItem("listaProductos");
						localStorage.removeItem("sumaCesta");
						localStorage.removeItem("cantidadCesta");
						window.location = rutaFrontEnd;
					} 
				});
			})
			.fail(function(err) {
				console.log("error", err);
			});

	  //       swal({
			//   title: "Transacción aceptada",
			//   text: "Compra realizada con éxito",
			//   type: "success",
			//   confirmButtonText: "Aceptar",
			//   closeOnConfirm: false
			// },function(isConfirm){
			// 	if (isConfirm) {
			// 		localStorage.removeItem("listaProductos");
			// 		localStorage.removeItem("sumaCesta");
			// 		localStorage.removeItem("cantidadCesta");
			// 		window.location = rutaFrontEnd;
			// 	} 
			// });
	        
	      });
	    },onCancel: function (data) {
		    window.location = rutaFrontEnd + 'carrito-de-compras';
		},onError: function (err) {
		    console.log('err', err);
		    swal({
			  title: "Ocurrio un error",
			  text: "Favor de intentar de nuevo o más tarde, disculpe las molestias.",
			  type: "warning",
			  confirmButtonText: "¡Cerrar!",
			  closeOnConfirm: false
			},
			function(isConfirm){
				 if (isConfirm) {	   
				    window.location = rutaFrontEnd;
				  } 
			});
		}
  	}).render('#paypal-button-container');


	
</script>