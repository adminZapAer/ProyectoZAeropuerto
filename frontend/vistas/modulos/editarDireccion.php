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
				<li class="active pagActiva"><?php echo "EDITAR DIRECCIÓN" ?></li>

			</ul>

		</div>

	</div>

</div>

<div class="container-fluid">
    
    <div class="container">
        
        <div class="tab-content">
            
            <div id="compras" class="tab-pane fade in active">
                
                <div class="row">
                    
                    <form method="post" enctype="multipart/form-data" onsubmit="return validarFormDireccion(this)">
                        
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            
                            <br>
                            
                            <?php
                                
                                if(isset($_GET["updatedir"])){
                                    
                                    $item = $_SESSION["idUsuario"];
                                    
                                    $idDireccion = $_GET["updatedir"];
                                    
                                    //var_dump("idDireccion: ",$_GET["updatedir"]);
                                    
                                    $direccion = ControladorUsuarios::ctrMostrarDireccion($item, $idDireccion);
                                    
                                    //var_dump($direccion[0]);
                                    
                                    echo '
                                    
                                    <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">

                                    <h3>Los campos marcados con * son obligatorios.</h3>

                                    <label class="control-label text-muted text-uppercase" for="nombreCompleto">Nombre de la persona quien recibirá el pedido *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Nombre completo" value = "'.$direccion[0]["nombre"].'" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="cp">Código postal *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                        </span>
                                        <input type="text" class="form-control cp" id="cp" name="cp" placeholder="Código postal" value = "'.$direccion[0]["cp"].'" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="calle">Calle *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-home"></i>
                                        </span>
                                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle de la dirección" value = "'.$direccion[0]["calle"].'" required>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-5 col-xs-12">
                                            <label class="control-label text-muted text-uppercase" for="numext">Número exterior *</label>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-home"></i>
                                                </span>
                                                <input type="text" class="form-control" id="numext" name="numext" placeholder="" value = "'.$direccion[0]["numext"].'" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-5 col-xs-12">
                                            <label class="control-label text-muted text-uppercase" for="numint">Número interior</label>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-home"></i>
                                                </span>
                                                <input type="text" class="form-control" id="numint" name="numint" value = "'.$direccion[0]["numint"].'" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="colonia">Colonia *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-home" aria-hidden="true"></i>

                                        </span>
                                        <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" value = "'.$direccion[0]["colonia"].'" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="municipio">Municipio/Alcaldia *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-university" aria-hidden="true"></i>

                                        </span>
                                        <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" value = "'.$direccion[0]["municipio"].'" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="estado">Estado *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-map" aria-hidden="true"></i>

                                        </span>
                                        <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" value = "'.$direccion[0]["estado"].'" required>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-5 col-xs-12">
                                            <label class="control-label text-muted text-uppercase" for="entreCalle">Entre Calle *</label>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-home"></i>
                                                </span>
                                                <input type="text" class="form-control" id="entreCalle" name="entreCalle" placeholder="Cerrada, Avenida, Calle" value = "'.$direccion[0]["entreCalle"].'">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-5 col-xs-12">

                                            <label class="control-label text-muted text-uppercase" for="yCalle">Y Calle</label>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-home"></i>
                                                </span>
                                                <input type="text" class="form-control" id="yCalle" name="yCalle" placeholder="Cerrada, Avenida, Calle" value = "'.$direccion[0]["yCalle"].'">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="referencia">Alguna Referencia *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-home"></i>
                                        </span>
                                        <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Caracteristica del lugar" value = "'.$direccion[0]["referencia"].'" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="telefono">Telefono celular:</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-earphone"></i>
                                        </span>
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono celular" pattern="[0-9]{10}" title="10 Digitos ej. 5546417896" value = "'.$direccion[0]["celular"].'">
                                    </div>

                                    <br>

                                    <button type="submit" class="btn btn-success btn-md pull-left">Midificar Dirección</button>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    ';
                                    
                                }
                                
                                
                            
                            ?>
                            
                        </div>
                        
                        <?php
                        
                        $agregarNuevaDireccion = new ControladorUsuarios();
                        $agregarNuevaDireccion->ctrModificarDireccion($_GET["updatedir"]);
                        
                        ?>
                    </form>
                    
                </div>
                
            </div>
            
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

<?php 



?>