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
            
            <li class="active">                
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
            *==         PESTAÑA PERFIL         ==*
            ===================================-->
            
            <div id="perfil" class="tab-pane fade in active">
                <div class="row">
                    
                    <form method="post" enctype="multipart/form-data">
                        
                        <div class="col-md-3 col-sm-4 col-xs-12 text-center">
                            
                            <br>
                            
                            <figure id="imgPerfil">
                                
                                <?php
                                
                                echo'
                                <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">
                                <input type="hidden" value="'.$_SESSION["password"].'" name="passUsuario">
                                <input type="hidden" value="'.$_SESSION["foto"].'" name="fotoUsuario" id="fotoUsuario">
                                <input type="hidden" value="'.$_SESSION["modo"].'" name="modoUsuario" id="modoUsuario">
                                ';
                                
                                if($_SESSION["modo"] == "directo"){
                                    if($_SESSION["foto"] != ""){
                                        echo '<img src="'.$url.$_SESSION["foto"].'" class="img-thumbnail">';
                                    }
                                    else{
                                        echo '<img src="'.$servidor.'vistas/img/usuarios/default/anonymous.png" class="img-thumbnail">';
                                    }
                                }
                                else{
                                    echo '<img src="'.$_SESSION["foto"].'" class="img-thumbnail">';
                                }
                                
                                ?>
                                
                            </figure>
                            
                            <?php

							if($_SESSION["modo"] == "directo"){
							
                                echo '
                                <button type="button" class="btn btn-default" id="btnCambiarFoto">
                                    
                                    Cambiar foto de perfil
                                    
                                </button>';

							}
							?>
                            
                            <div id="subirImagen">
								<input type="file" class="form-control" id="datosImagen" name="datosImagen">
								<img class="previsualizar">
							</div>
                            
                        </div>
                        
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            
                            <br>
                            
                            <?php

                            if($_SESSION["modo"] != "directo"){
                                
                                echo '
                                
                                <label class="control-label text-muted text-uppercase">Nombre:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control"  value="'.$_SESSION["nombre"].'" readonly>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase">Correo electrónico:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
									<input type="text" class="form-control"  value="'.$_SESSION["email"].'" readonly>
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase">Modo de registro en el sistema:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-'.$_SESSION["modo"].'"></i>
                                    </span>
									<input type="text" class="form-control text-uppercase"  value="'.$_SESSION["modo"].'" readonly>
                                </div>
                                
                                <br>
                                ';
                                
                            }
                            else{
                                
                                echo '
                                
                                <label class="control-label text-muted text-uppercase" for="editarNombre">Cambiar Nombre:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="'.$_SESSION["nombre"].'">
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="editarEmail">Cambiar Correo Electrónico:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="editarEmail" name="editarEmail" value="'.$_SESSION["email"].'">
                                </div>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="editarPassword">Cambiar Contraseña:</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                    </span>
                                    <input type="text" class="form-control" id="editarPassword" name="editarPassword" placeholder="Escribe la nueva contraseña">
                                </div>
                                
                                <br>
                                
                                <button type="submit" class="btn btn-default backColor btn-md pull-left">Actualizar Datos</button>
                                
                                ';          
                                
                            }
                            
                            ?>
                            
                        </div>
                        
                        <?php

							$actualizarPerfil = new ControladorUsuarios();
							$actualizarPerfil->ctrActualizarPerfil();

						?>
                        
                    </form>
                    
                    <button class="btn btn-danger btn-md pull-right" id="eliminarUsuario">Eliminar cuenta</button>
                    
                    <?php
                    
                    $borrarUsuario = new ControladorUsuarios();
                    $borrarUsuario -> ctrEliminarUsuario();
                    
                    ?>
                    
                </div>
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