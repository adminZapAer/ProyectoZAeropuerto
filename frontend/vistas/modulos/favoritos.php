<!--=====================================
VALIDAR SESIÓN
======================================-->

<?php

$url = Ruta::ctrRuta();
$servidor = Ruta::ctrRutaServidor();

if(!isset($_SESSION["validarSesion"])){

	echo '<script>
	
		window.location = "'.$url.'";

	</script>';

	exit();

}

?>

<!--=====================================
BREADCRUMB PERFIL
======================================-->

<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">INICIO</a></li>
				<li class="active pagActiva"><?php echo $rutas[0] ?></li>

			</ul>

		</div>

	</div>

</div>

<!--=====================================
SECCIÓN PERFIL
======================================-->

<div class="container-fluid">
    
    <div class="container">
        
        <ul class="nav nav-tabs">
            
            <li>
                <a href="<?php echo $url; ?>compras">
                    <i class="fa fa-list-ul"></i> MIS COMPRAS
                </a>
            </li>
            
            <li class="active">
                <a href="<?php echo $url; ?>favoritos">
                    <i class="fa fa-gift"></i> MIS FAVORITOS
                </a>
            </li>
            
            <li>                
                <a href="<?php echo $url; ?>perfil">
                    <i class="fa fa-user"></i> EDITAR PERFIL
                </a>
            </li>

            <li>                
                <a href="<?php echo $url; ?>direcciones">
                    <i class="fa fa-map-marker"></i>  DIRECCIÓN DE ENVÍO
                </a>
            </li>

            <li>                
                <a href="<?php echo $url; ?>facturacion">
                    <i class="fa fa-map-marker"></i>  FACTURACIÓN
                </a>
            </li>
            
            <li>                
                <a href="<?php echo $url; ?>ofertas">
                    <i class="fa fa-star"></i>  VER OFERTAS
                </a>
            </li>

            
		</ul>
        
        <div class="tab-content">
            
            <!--==================================
            *==        PESTAÑA FAVORITOS       ==*
            ===================================-->
            
            <div id="deseos" class="tab-pane fade in active">
                <?php
                
                $item = $_SESSION["idUsuario"];
                
                $deseos = ControladorUsuarios::ctrMostrarDeseos($item);
                
                if(!$deseos){
                    echo '
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center error404">
                        <h1><small>¡Oops!</small></h1>
                        
                        
                    </div>';
                }
                else{
                    
                    foreach ($deseos as $key => $value1) {
                        
                        $ordenar = "idProducto";
                        $valor = $value1["idProducto"];
                        $item = "idProducto";
                        
                        $productos = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);
                        
                        echo '<ul class="grid0">';
                        
                        foreach ($productos as $key => $value2) {
                            
                            echo '
                            <li class="col-md-3 col-sm-6 col-xs-12">
                                
                                <figure>
                                    
                                    <a href="'.$url.$value2["ruta"].'" class="pixelProducto">
                                        
                                        <img src="'.$servidor.$value2["portada"].'" class="img-responsive">
                                        
                                    </a>
                                    
                                </figure>
                                
                                <h4>
                                    
                                    <small>
                                        
                                        <a href="'.$url.$value2["ruta"].'" class="pixelProducto">
                                        
                                            '.$value2["titulo"].'<br>
                                            
                                            <span style="color:rgba(0,0,0,0)">-</span>';
                                                if($value2["nuevo"] != 0){
                                                    echo '<span class="label label-warning fontSize">Nuevo</span> ';
                                                }
                                                
                                                if($value2["oferta"] != 0){
                                                    echo '<span class="label label-warning fontSize">'.$value2["descuentoOferta"].'% de descuento</span>';
                                                } 
                                        
                                        echo'
                                        </a>
                                        
                                    </small>
                                    
                                </h4>
                                <div class="col-xs-6 precio">';
                                
                                if($value2["precio"] == 0){
                                    echo '<h2 style="margin-top:-10px"><small>GRATIS</small></h2>';
                                }
                                else{
                                    
                                    if($value2["oferta"] != 0){
                                        
                                        echo '
                                        <h2 style="margin-top:-10px">
                                            
                                            <small>
                                                <strong class="oferta" style="font-size:12px">MXN $'.$value2["precio"].'</strong>
                                            </small>
                                            
                                            <small>$'.$value2["precioOferta"].'</small>
                                            
                                        </h2>';
                                        
                                    }
                                    else{
                                        
                                        echo '<h2 style="margin-top:-10px"><small>MXN $'.$value2["precio"].'</small></h2>';
                                        
                                    }
                                    
                                }
                                
                                echo'
                                </div>
                                
                                <div class="col-xs-6 enlaces">
                                
                                    <div class="btn-group pull-right">
                                        
                                        <button type="button" class="btn btn-danger btn-xs quitarDeseo" idDeseo="'.$value1["idDeseo"].'" data-toggle="tooltip" title="Quitar de mis favoritos">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        </button>';
                                        
                                        if($value2["tipo"] == "virtual" && $value2["precio"] != 0){
                                            
                                            if($value2["oferta"] != 0){
                                                echo '
                                                <button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value2["idProducto"].'" imagen="'.$servidor.$value2["portada"].'" titulo="'.$value2["titulo"].'" precio="'.$value2["precioOferta"].'" tipo="'.$value2["tipo"].'" peso="'.$value2["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">
                                                    
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                    
                                                </button>';
                                            }
                                            else{
                                                echo '
                                                <button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="'.$value2["idProducto"].'" imagen="'.$servidor.$value2["portada"].'" titulo="'.$value2["titulo"].'" precio="'.$value2["precio"].'" tipo="'.$value2["tipo"].'" peso="'.$value2["peso"].'" data-toggle="tooltip" title="Agregar al carrito de compras">
                                                    
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                    
                                                </button>';
                                            }
                                            
                                        }
                                        
                                        echo'
                                        <a href="'.$url.$value2["ruta"].'" class="pixelProducto">
                                            
                                            <button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">
                                                
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                
                                            </button>
                                            
                                        </a>
                                        
                                        
                                    </div>
                                    
                                </div>
                            
                            </li>
                            ';
                            
                        }
                        echo'
                        </ul>';
                        
                    }
                    
                }
                
                ?>
                
            </div>
            
        </div>
        
    </div>
    
</div>

<!--=====================================
VENTANA MODAL PARA COMENTARIOS
======================================-->

<div  class="modal fade modalFormulario" id="modalComentarios" role="dialog">
	
    <div class="modal-content modal-dialog">
    
        <div class="modal-body modalTitulo">
			
            <h3 class="backColor">CALIFICA ESTE PRODUCTO</h3>
            
            <button type="button" class="close" data-dismiss="modal">&times;</button>

			<form method="post" onsubmit="return validarComentario()">
			    
                <input type="hidden" value="" id="idComentario" name="idComentario">
				    
                <h1 class="text-center" id="estrellas">
                    
                    <i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>
					<i class="fa fa-star text-success" aria-hidden="true"></i>

				</h1>
                
                <div class="form-group text-center">
                
                    <label class="radio-inline"><input type="radio" name="puntaje" value="0.5">0.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="1.0">1.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="1.5">1.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="2.0">2.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="2.5">2.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="3.0">3.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="3.5">3.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="4.0">4.0</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="4.5">4.5</label>
					<label class="radio-inline"><input type="radio" name="puntaje" value="5.0" checked>5.0</label>
					
				</div>
				
				<div class="form-group">
                  
                    <label for="comment" class="text-muted">Tu opinión acerca de este producto: <span><small>(máximo 300 caracteres)</small></span></label>
                    
                    <textarea class="form-control" rows="5" id="comentario" name="comentario" maxlength="300" required></textarea>
                    
                    <br>
					
					<input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">
					
                </div>
                
				<?php
                
                    $actualizarComentario = new ControladorUsuarios();
                    $actualizarComentario -> ctrActualizarComentario();
                
				?>
				
			</form>

		</div>

		<div class="modal-footer">
      	
      	</div>

	</div>

</div>


<script>

$(document).on( 'change', '#cp', function(){

    const cp = $(this).val();

    $.ajax({
        method: "GET",
        url: rutaFrontEnd + 'ajax/codigoPostal.php',
        data: { cp: cp  }
    })
        .done(function (response) {
            respuesta = JSON.parse(response);
            console.log( respuesta );

            if(respuesta.status == 'success'){
                $('#estado').val(respuesta.direccion.estado);
                $('#municipio').val(respuesta.direccion.municipio);
                $('#colonia').val(respuesta.direccion.poblacion);
                return;
            }

            $('#estado').val('');
            $('#municipio').val('');
            $('#colonia').val('');
            

        });

} );

</script>