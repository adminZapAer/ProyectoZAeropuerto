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
            
            <li>
                <a href="<?php echo $url; ?>favoritos">
                    <i class="fa fa-gift"></i> MIS FAVORITOS
                </a>
            </li>
            
            <li>                
                <a href="<?php echo $url; ?>perfil">
                    <i class="fa fa-user"></i> EDITAR PERFIL
                </a>
            </li>

            <li class="active">                
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
            *==         PESTAÑA DIRECCIÓN      ==*
            ===================================-->

            
            <div id="direccion" class="tab-pane fade in active">
                <div class="row">
                    
                    <form method="post" enctype="multipart/form-data" onsubmit="return validarFormDireccion(this)">
                        
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            
                            <br>
                            
                            <?php
                                                          
                                echo '

                                <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">

                                <h3>Los campos marcados con * son obligatorios.</h3>

                                <label class="control-label text-muted text-uppercase" for="nombreCompleto">Nombre de la persona quien recibirá el pedido *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Nombre completo" required>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="cp">Código postal *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control cp" id="cp" name="cp" placeholder="Código postal" required>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="calle">Calle *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle de la dirección" required>
                                </div>
                                
                                <br>

                                <div class="row">
                                    <div class="col-md-6 col-sm-5 col-xs-12">
                                        <label class="control-label text-muted text-uppercase" for="numext">Número exterior *</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-home"></i>
                                            </span>
                                            <input type="text" class="form-control" id="numext" name="numext" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-5 col-xs-12">
                                        <label class="control-label text-muted text-uppercase" for="numint">Número interior</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-home"></i>
                                            </span>
                                            <input type="text" class="form-control" id="numint" name="numint" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                
                                <br>

                                <label class="control-label text-muted text-uppercase" for="colonia">Colonia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Municipio" required>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="municipio">Municipio/Alcaldia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-university" aria-hidden="true"></i>

                                    </span>
                                    <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" required>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="estado">Estado *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map" aria-hidden="true"></i>
                                        
                                    </span>
                                    <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required>
                                </div>
                                
                                <br>
                                
                                <div class="row">
                                    <div class="col-md-6 col-sm-5 col-xs-12">
                                        <label class="control-label text-muted text-uppercase" for="entreCalle">Entre Calle *</label>

                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-home"></i>
                                            </span>
                                            <input type="text" class="form-control" id="entreCalle" name="entreCalle" placeholder="Cerrada, Avenida, Calle" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-5 col-xs-12">
                                        
                                        <label class="control-label text-muted text-uppercase" for="yCalle">Y Calle</label>
                                        
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-home"></i>
                                            </span>
                                            <input type="text" class="form-control" id="yCalle" name="yCalle" placeholder="Cerrada, Avenida, Calle">
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="referencia">Alguna Referencia *</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Caracteristica del lugar" required>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="telefono">Telefono celular:</label>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono celular" pattern="[0-9]{10}" title="10 Digitos ej. 5546417896">
                                </div>
                                
                                <br>
                                
                                <button type="submit" class="btn btn-success btn-md pull-left">Agregar Dirección</button>
                                <br>
                                <br>
                                <br>
                                <br>
                                ';
                            
                            ?>
                            
                        </div>
                        <div class="col-md-6 col-sm-5 col-xs-12" style="padding: 3%;">
                            <?php
                            $item = $_SESSION["idUsuario"];

                            $direcciones = ControladorUsuarios::ctrMostrarDirecciones($item);
                
                            if(!$direcciones){
                                echo '
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    <h3><small>No tiene direcciones agregadas</small></h3>
                                    
                                    
                                </div>';
                            }
                            else{
                    
                                foreach ($direcciones as $key => $value) {
                                        
                                    echo "
                                    <div class='panel panel-default'>
                                        <div class='panel-heading'>Dirección ". ($key + 1). "</div>
                                        <div class='panel-body'>
                                            <div class='row'>
                                                <div class='col-md-6'>
                                                    <label>Nombre:</label>
                                                    <p>{$value['nombre']}</p>
                                                    <label>Calle:</label>
                                                    <p>{$value['calle']}</p>
                                                    <label>Colonia:</label>
                                                    <p>{$value['colonia']}</p>
                                                    <label>Estado:</label>
                                                    <p>{$value['estado']}</p>
                                                    <label>Entre Calle:</label>
                                                    <p>{$value['entreCalle']}</p>
                                                    <label>Referencias:</label>
                                                    <p>{$value['referencia']}</p>
                                                </div>
                                                <div class='col-md-6'>
                                                    <label>Teléfono:</label>
                                                    <p>{$value['celular']}</p>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            <label>No. Exterior:</label>
                                                            <p>{$value['numext']}</p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label>No. Interior:</label>
                                                            <p>{$value['numint']}</p>
                                                        </div>
                                                    </div>
                                                    <label>Municipio / Alcaldía:</label>
                                                    <p>{$value['municipio']}</p>
                                                    <label>Código postal:</label>
                                                    <p>{$value['cp']}</p>
                                                    <label>Y Calle:</label>
                                                    <p>{$value['yCalle']}</p>
                                                    
                                                </div>
                                            </div>
                                            <br>
                                            <button class='btn btn-md pull-right update-direccion' id='{$value['id']}'>Editar Dirección</button>
                                            <button class='btn btn-danger btn-md pull-right delete-direccion' id='{$value['id']}'>Eliminar dirección</button>
                                        </div>
                                    </div>
                                    ";
                                    
                                }
                            }

                            ?>

                        </div>
                        
                        
                        <?php

                            $agregarDireccion = new ControladorUsuarios();
                            $agregarDireccion->ctrAgregarDireccion();

                        ?>
                    </form>
                    
                    
                    <?php
                    
                    $borrarDireccion = new ControladorUsuarios();
                    $borrarDireccion -> ctrEliminarDireccion();
                    
                    ?>
                    
                </div>
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