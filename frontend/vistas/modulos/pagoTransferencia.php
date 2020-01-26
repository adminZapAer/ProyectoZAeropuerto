
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
BREADCRUMB TRANSFERENCIA
======================================-->

<div class="container-fluid well well-sm">
	
	<div class="container">
		
		<div class="row">
			
			<ul class="breadcrumb fondoBreadcrumb text-uppercase">
				
				<li><a href="<?php echo $url;  ?>">INICIO</a></li>
				<li class="active pagActiva"><?php echo "TRANSFERENCIA ELECTRÓNICA" ?></li>

			</ul>

		</div>

	</div>

</div>

<div class="container-fluid">
    
    <div class="container">
        
        <div class="tab-content">
            
            <div id="transferencia" class="tab-pane fade in active">
                
                <div class="row">
                    
                    <form method="post" enctype="multipart/form-data" >
                        
                        <div class="col-md-6 col-sm-5 col-xs-12">
                            
                            <br>
                            
                            <?php
                                    
                                    $item = $_SESSION["idUsuario"];
                                    
                                    $user = ControladorUsuarios::ctrMostrarUsuario("idUsuario", $item);
                                    //var_dump($user);
                                    
                                    //var_dump($direccion[0]);
                                    
                                    echo '
                                    
                                    <input type="hidden" value="'.$_SESSION["idUsuario"].'" id="idUsuario" name="idUsuario">

                                    <h3>Los campos marcados con * son obligatorios.</h3>

                                    <label class="control-label text-muted text-uppercase" for="usuarioComprobante">Nombre del Usuario *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="usuarioComprobante" name="usuarioComprobante" placeholder="Nombre completo" value = "'.$user["nombre"].'" readonly>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="fechaPago">Fecha de Pago *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="fechaPago" name="fechaPago" placeholder="0000-00-00 00:00:00" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="banco">Banco *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-home"></i>
                                        </span>
                                        <div class="form-group">
                                            <select class="form-control" id="banco" name="banco" placeholder="Banco" required>
                                                <option>Elije una opción</option>
                                                <option>BBVA Bancomer</option>
                                                <option>Banamex</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="montoExacto">Monto Exacto *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-home" aria-hidden="true"></i>

                                        </span>
                                        <input type="text" class="form-control" id="montoExacto" name="montoExacto" placeholder="Monto Exacto" required>
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="referencia">Referencia *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-home" aria-hidden="true"></i>

                                        </span>
                                        <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Referencia">
                                    </div>

                                    <br>

                                    <label class="control-label text-muted text-uppercase" for="datosRecibo">Subir Foto de Recibo *</label>

                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-university" aria-hidden="true"></i>

                                        </span>
                                        <input type="file" class="form-control" id="datosRecibo" name="datosRecibo">
                                        
                                    </div>
                                    <img class="previsualizarRecibo">
                                    
                                    <br>
                                    <br>
                                    <br>
                                    
                                    <button class="btn btn-success btn-md pull-left updat">Cargar Datos de Recibo</button>
                                    
                                    <br>
                                    <br>
                                    ';
                                    
                                
                                
                            
                            ?>
                            
                        </div>
                        
                        <?php
                        
                        $cargarComprobante = new ControladorCarrito();
                        $cargarComprobante->ctrCargarComprobante();
                        
                        ?>
                    </form>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</div>

<script>
    let listaProducto = JSON.parse(localStorage.getItem('listaProductos'));
    console.log(listaProducto);
    /*$(document).ready(function() {
        $.ajax({
            url: rutaFrontEnd + "pagoTransferencia.php",
            type: 'POST',
            dataType: 'json',
            data:{productos: listaProducto},
            success: function(data){
                alert('datos enviados a php correctamente');
            }
        });

        console.log(listaProducto);
    }*/
</script>


