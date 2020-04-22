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
            
            <li class="active">
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

            <li>                
                <a href="<?php echo $url; ?>facturacion">
                    <i class="fa fa-map-marker"></i>  FACTURACIÓN
                </a>
            </li>
            
            <li>				
                <a href="<?php echo $url; ?>ofertas">
                    <i class="fa fa-star"></i>	VER OFERTAS
                </a>
            </li>

            
		</ul>
        
        <div class="tab-content">
            <!--==================================
            *==       PESTAÑA MIS COMPRAS      ==*
            ===================================-->
            <div id="compras" class="tab-pane fade in active">
                
                <div class="panel-group">
                    
                    <?php
                    
                    $item = "idUsuario";
                    $valor = $_SESSION["idUsuario"];
                    $validarCompra=0;
                    
                    $compras = ControladorUsuarios::ctrMostrarCompras($item, $valor);
                    
                    if(!$compras){
                        echo '
                        <div class="col-xs-12 text-center error404">
                            <h1>
                                <small>¡Oops!</small>
                            </h1>
                            <h2>Aún no tienes compras realizadas en esta tienda</h2>
                        </div>';
                    }
                    else{
                        
                        //foreach ($compras as $key => $value1) {
                        for($i=0; $i < count($compras); $i++){
                            
                            //var_dump("idUsuario: ",$valor);
                            
                            //var_dump("idCompra: ",$compras[$i]["idCompra"]);
                            
                            $idCompra = $compras[$i]["idCompra"];
                            
                            $validarCompra = $compras[$i]["validarCompra"];;
                            
                            $idProducto = ControladorUsuarios::ctrMostrarDetallesCompras($idCompra);
                            
                            for($j = 0; $j < count($idProducto); $j++){
                                
                                //var_dump("idProducto: ", $idProducto[$j]["idProducto"]);
                                
                                $ordenar = "idProducto";
                                $item = "idProducto";
                                $valor = $idProducto[$j]["idProducto"];

                                $productos = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

                                foreach ($productos as $key => $value2) {

                                    echo '
                                    <div class="panel panel-default">

                                        <div class="panel-body">

                                            <div class="col-md-2 col-sm-6 col-xs-12">

                                                <figure>
                                                    ';
                                                if($value2["portada"] != ""){
                                                    echo '<img class="img-thumbnail" src="'.$servidor.$value2["portada"].'">';
                                                }
                                                else{
                                                    echo '<img class="img-thumbnail" src="'.$servidor.'/vistas/img/plantilla/imagenProducto.jpg">';
                                                }
                                                    
                                                echo'
                                                </figure>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <h1>
                                                    <small>'.$value2["titulo"].'</small>
                                                </h1>

                                                <p>'.$value2["titular"].'</p>';

                                                if($value2["tipo"] == "virtual"){

                                                    echo'

                                                    <a href="'.$url.'curso">

                                                        <button class="btn btn-default pull-left">Ir al curso</button>

                                                    </a>

                                                    ';

                                                }
                                                else{

                                                    echo '<h6>Proceso de entrega: '.$value2["diasEntrega"].' días hábiles</h6>';

                                                    if($compras[$i]["envio"] == 0){

                                                        echo'
                                                        <div class="progress">

                                                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-check"></i> Despachado
                                                            </div>

                                                            <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-clock-o"></i> Enviando
                                                            </div>

                                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-clock-o"></i> Entregado
                                                            </div>

                                                        </div>
                                                        ';

                                                    }
                                                    if($compras[$i]["envio"] == 1){
                                                        echo'
                                                        <div class="progress">

                                                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-check"></i> Despachado
                                                            </div>

                                                            <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-check"></i> Enviando
                                                            </div>

                                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
                                                                <i class="fa fa-clock-o"></i> Entregado
                                                            </div>

                                                        </div>
                                                        ';
                                                    }
                                                    if($compras[$i]["envio"] == 2){

                                                            echo'
                                                            <div class="progress">

                                                                <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%">
                                                                    <i class="fa fa-check"></i> Despachado
                                                                </div>

                                                                <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%">
                                                                    <i class="fa fa-check"></i> Enviando
                                                                </div>

                                                                <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%">
                                                                    <i class="fa fa-check"></i> Entregado
                                                                </div>

                                                            </div>
                                                            ';

                                                        }

                                                    }

                                                echo'
                                                    <h4 class="pull-right">
                                                        <small>
                                                            Comprado el '.substr($compras[$i]["fecha"],0,-8).'
                                                        </small>
                                                    </h4>

                                                </div>

                                                <div class="col-md-4 col-xs-12">';

                                                $datos = array("idUsuario"=>$_SESSION["idUsuario"], "idProducto"=>$value2["idProducto"] );

                                                $comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);

                                                echo '
                                                <div class="pull-right">';
 
                                                    
                                                    if($validarCompra == 1){
                                                        //$archivoPDF = 'D:/xampp/htdocs/ProyectoZAeropuerto1/backend/compra-'.$idCompra.'.pdf';
                                                        //$archivoXML = 'D:/xampp/htdocs/ProyectoZAeropuerto1/backend/compra-'.$idCompra.'.xml';
                                                        
                                                        //echo file_exists('D:/xampp/htdocs/ProyectoZAeropuerto1/backend/compra-'.$idCompra.'.pdf');
                                                        $archivoPDF = $servidor.'cfdi/compra-'.$idCompra.'.pdf';
                                                        $archivoXML = $servidor.'cfdi/compra-'.$idCompra.'.xml';
                                                        
                                                        //echo file_exists('/home/u319109462/domains/refaccioneszapatacamiones.com/public_html/backend/cfdi/compra-'.$idCompra.'.pdf');
                                                        
                                                        $file_pointer = '/home/u319109462/domains/refaccionariazapata.com/public_html/backend/cfdi/compra-'.$idCompra.'.pdf'; 
                                                        $file_pointer2 = '/home/u319109462/domains/refaccionariazapata.com/public_html/backend/cfdi/compra-'.$idCompra.'.xml';
                                                        
                                                        //$file_pointer = 'D:/xampp/htdocs/ProyectoZAeropuerto1/backend/compra-'.$idCompra.'.pdf'; 
                                                        //$file_pointer2 = 'D:/xampp/htdocs/ProyectoZAeropuerto1/backend/compra-'.$idCompra.'.xml';
                                                        
                                                        if(is_file($file_pointer) && is_file($file_pointer2)){
                                                            //echo 'El archivo '.$archivoPDF.' y '.$archivoXML.'si existe.';
                                                            echo'<a href="'.$archivoPDF.'" class="btn btn-primary btn-lg activate pull-" role="button" aria-pressed="true" download>Factura PDF</a>
                                                                
                                                                <a href="'.$archivoXML.'" class="btn btn-primary btn-lg activate pull-right" role="button" aria-pressed="true" download>Factura XML</a>';
                                                            
                                                        }
                                                        else{
                                                            //echo 'El archivo '.$archivoPDF.' y '.$archivoXML.' no existe.';
                                                            echo'
                                                                <button type="button" class="btn btn-primary btn-lg pull-right" disabled>Factura PDF</button>
                                                                
                                                                <button type="button" class="btn btn-primary btn-lg pull-right" disabled>Factura XML</button>';
                                                        }
                                                    }
                                                    else{
                                                        echo '<p>Procesando Pago</p>';
                                                    }
                                                    

                                                    echo'

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    ';

                                    }
                                
                            }
                            
                        }
                        
                    }
                        
                        
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