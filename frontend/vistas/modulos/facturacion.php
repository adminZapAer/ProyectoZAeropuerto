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

            <li>                
                <a href="<?php echo $url; ?>direcciones">
                    <i class="fa fa-map-marker"></i>  DIRECCIÓN DE ENVÍO
                </a>
            </li>

            <li class="active">                
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
            *==         PESTAÑA FACTURACCION      ==*
            ===================================-->

            <div id="facturacion" class="tab-pane fade in active">
                
                <div class="row">
                    
                    <form method="post"enctype="multipart/form-data" onsubmit="return validarFormFacturacion(this)">
                        
                        <br>
                        <div class="col-md-6 col-sm-5 col-xs-12 datosFactura">
                            
                            <?php
                                
                                $item = $_SESSION["idUsuario"];

                                $direccionFact = ControladorUsuarios::ctrMostrarDirecciones($item);
                                
                                /*if($direccionFact != null){
                                    $calle = $direccionFact[0]["calle"];
                                    $numExterior = $direccionFact[0]["numext"];
                                    $numInterior = $direccionFact[0]["numint"];
                                    $colonia = $direccionFact[0]["colonia"];
                                    $municipio = $direccionFact[0]["municipio"];
                                    $estado = $direccionFact[0]["estado"];
                                    $telefono = $direccionFact[0]["celular"];
                                    $codPostal = $direccionFact[0]["cp"];
                                }
                                else{
                                    $calle = "";
                                    $numExterior = "";
                                    $numInterior = "";
                                    $colonia = "";
                                    $municipio = "";
                                    $estado = "";
                                    $telefono = "";
                                    $codPostal = "";
                                }*/
                            
                                
                                
                                echo '
                                
                                <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">
                                
                                <h3>Los campos marcados con * son obligatorios.</h3>
                                
                                <br>
                                
                                <label class="control-label text-muted text-uppercase" for="nombreRazon">Nombre completo o Razón social *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="nombreRazon" name="nombreRazon" placeholder="Nombre completo o Razón social" required>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="tipoPersona">Tipo de persona (Fisica o Moral) *</label>
                                
                                <div class="input-group col-md-4 col-sm-4 col-xs-12">
                                    <span class="input-group-addon">
                                        <i class=""></i>
                                    </span>
                                    <div class="form-group">
                                        <select class="form-control" id="tipoPersona" name="tipoPersona" placeholder="Fisica o Moral">
                                            <option>Elije una opción</option>
                                            <option>Fisica</option>
                                            <option>Moral</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="codigoPostal">Código postal *</label>
                                
                                <div class="input-group col-md-4 col-sm-4 col-xs-12">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="Código Postal" required>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="rfcPersona">RFC *</label>
                                
                                <div class="input-group col-md-4 col-sm-4 col-xs-12 valrfc">
                                    <span class="input-group-addon">
                                        <i class=""></i>
                                    </span>
                                    <input type="text" class="form-control" id="rfcPersona" name="rfcPersona" placeholder="Ej: RAZE451124HM3" maxlength="13">
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="calle">Calle *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="numext">Número exterior *</label>
                                
                                <div class="input-group col-md-4 col-sm-4 col-xs-12">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="numext" name="numext" placeholder="" required>
                                </div>
                            
                                <label class="control-label text-muted text-uppercase" for="numint">Número interior</label>
                                
                                <div class="input-group col-md-4 col-sm-4 col-xs-12">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="numint" name="numint" placeholder="">
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="colonia">Colonia *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home" aria-hidden="true"></i>
                                        
                                    </span>
                                    <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" required>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="municipio">Municipio/Alcaldia *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-university" aria-hidden="true"></i>
                                        
                                    </span>
                                    <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio" required>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="estado">Estado *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    </span>
                                    <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required>
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="telefono">Teléfono *</label>
                                
                                <div class="input-group col-md-4 col-sm-4 col-xs-12">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required pattern="[0-9]{10}" title="El numero telefónico debe contener 10 digitos">
                                </div>
                                
                                <label class="control-label text-muted text-uppercase" for="email">Correo Electrónico *</label>
                                
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ej: correo@mail.com" required>
                                </div>
                                    
                                <br>
                                <br>
                                <br>

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin:3%;">
                                    <button class="btn btn-success btn-md pull-left enviarDatos">Agregar Datos Facturación</button>
                                </div>
                                <br>
                                ';

                            ?>
                            
                        </div>
                        <div class="col-md-6 col-sm-5 col-xs-12" style="padding: 3%;">
                           
                            <?php
                            $item = $_SESSION["idUsuario"];
                            
                            $facturaciones = ControladorUsuarios::ctrMostrarDatosFacturacion($item);
                            
                            if(!$facturaciones){
                                echo '
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    <h3><small>No tiene direcciones agregadas</small></h3>
                                    
                                    
                                </div>';
                            }
                            else{
                                
                                foreach ($facturaciones as $key => $value) {
                                        
                                    echo "
                                    <div class='panel panel-default'>
                                        <div class='panel-heading'>Datos de facturación ". ($key + 1). "</div>
                                        <div class='panel-body'>
                                            <div class='row'>
                                                
                                                <div class='col-md-6'>
                                                    <label>Nombre o Razón Social:</label>
                                                    <p>{$value['nombreRazon']}</p>
                                                    <label>Tipo de Persona:</label>
                                                    <p>{$value['tipoPersona']}</p>
                                                    <label>Teléfono:</label>
                                                    <p>{$value['telefono']}</p>
                                                    <label>Colonia:</label>
                                                    <p>{$value['colonia']}</p>
                                                    <label>Municipio / Alcaldia:</label>
                                                    <p>{$value['municipio']}</p>
                                                    <label>Código Postal:</label>
                                                    <p>{$value['codigoPostal']}</p>
                                                </div>
                                                
                                                <div class='col-md-6'>
                                                    <label>RFC:</label>
                                                    <p>{$value['rfc']}</p>
                                                    <label>Correo Electronico:</label>
                                                    <p>{$value['email']}</p>
                                                    <label>Calle:</label>
                                                    <p>{$value['calle']}</p>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            <label>No. interior:</label>
                                                            <p>{$value['numInterior']}</p>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label>No. exterior:</label>
                                                            <p>{$value['numExterior']}</p>
                                                        </div>
                                                    </div>
                                                    <label>Estado:</label>
                                                    <p>{$value['estado']}</p>
                                                </div>
                                            </div>
                                            <button class='btn btn-danger btn-md pull-right delete-facturacion' id='{$value['idFactura']}'>Eliminar Datos de Facturación</button>
                                        </div>
                                    </div>
                                    ";
                                    
                                }
                            }
                            
                            ?>
                            
                            
                        </div>
                        
                        <?php
                        
                        $agregarFacturacion = new ControladorUsuarios();
                        $agregarFacturacion -> ctrAgregarFacturacion();
                        
                        ?>
                        
                    </form>
                    
                    <?php
                    
                    $eliminarFacturacion = new ControladorUsuarios();
                    $eliminarFacturacion -> ctrEliminarDatosFacturacion();
                    
                    ?>
                    
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