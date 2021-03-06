/*=============================================
            CAPTURAR RUTA
=============================================*/

var rutaActual = location.href;

$(".btnIngreso, .facebook, .google").click(function(){
    //Almacenamos la ruta actual
    localStorage.setItem("rutaActual", rutaActual);
})

/*=============================================
            FORMATEAR LOS INPUT
=============================================*/
$("input").focus(function(){
    $(".alert").remove();
})

/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/

var validarEmailRepetido = false;

$("#regEmail").change(function(){

	var email = $("#regEmail").val();

	var datos = new FormData();
	datos.append("validarEmail", email);
    
	$.ajax({
        
		url:rutaFrontEnd+"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){
			
            console.log("respuesta", respuesta);
            
			if(respuesta == "false"){
                $(".alert").remove();
				validarEmailRepetido = false;
			}else{
                var modo = JSON.parse(respuesta).modo;
                
                if(modo == "directo"){
                    modo = "esta página";
                }
                
                $("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, fue registrado a través de '+modo+', por favor ingrese otro diferente</div>')
                
                validarEmailRepetido = true;
                
			}
            
		}
        
	})
    
})

/*=============================================
VALIDAR EL REGISTRO DE USUARIO
=============================================*/
function registroUsuario(){

	/*=============================================
	VALIDAR EL NOMBRE
	=============================================*/

	var nombre = $("#regUsuario").val();

	if(nombre != ""){

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(nombre)){

			$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR EL EMAIL
	=============================================*/

	var email = $("#regEmail").val();

	if(email != ""){

		var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

		if(!expresion.test(email)){

			$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Escriba correctamente el correo electrónico</div>')

			return false;

		}

		if(validarEmailRepetido){

			$("#regEmail").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

			return false;

		}

	}else{

		$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}


	/*=============================================
	VALIDAR CONTRASEÑA
	=============================================*/

	var password = $("#regPassword").val();

	if(password != ""){

		var expresion = /^[a-zA-Z0-9*+-]*$/;

		if(!expresion.test(password)){

			$("#regPassword").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales. <strong>Solo se permiten los siguientes caracteres especiales: "+ - *"</strong></div>')

			return false;

		}

	}else{

		$("#regPassword").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR POLÍTICAS DE PRIVACIDAD
	=============================================*/

	var politicas = $("#regPoliticas:checked").val();
	
	if(politicas != "on"){

		$("#regPoliticas").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Debe aceptar nuestras condiciones de uso y políticas de privacidad</div>')

		return false;

	}

	return true;
}
/*=============================================
CAMBIAR FOTO
=============================================*/

$("#btnCambiarFoto").click(function(){

	$("#imgPerfil").toggle();
	$("#subirImagen").toggle();

})

$("#datosImagen").change(function(){
    
    var imagen = this.files[0];
    
    /*=============================================
	VALIDAMOS EL FORMATO DE LA IMAGEN
	=============================================*/
    if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
        
        $("#datosImagen").val("");
        
        swal({
            title: "Error al subir la imagen",
            text: "¡La imagen debe estar en formato JPG o PNG!",
            type: "error",
            confirmButtonText: "¡Cerrar!",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {	   
                window.location = rutaFrontEnd+"perfil";
            } 
        });
        
    }
    /*Si la imagen es superior a los 2 MB*/
    else if(Number(imagen["size"]) > 2000000){
        $("#datosImagen").val("");
        
        swal({
            title: "Error al subir la imagen",
            text: "¡La imagen no debe pesar más de 2 MB!",
            type: "error",
            confirmButtonText: "¡Cerrar!",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {	   
                window.location = rutaFrontEnd+"perfil";
            } 
        });
    }
    /*Si cumple con las condiciones la imagen, se sube la imagen*/
    else{
        
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);/*Leer como dato url*/
        
        $(datosImagen).on("load", function(event){
            
            var rutaImagen = event.target.result;
            $(".previsualizar").attr("src",  rutaImagen);
            
        })
        
    }

})

/*=============================================
COMENTARIOS ID
=============================================*/

$(".calificarProducto").click(function(){

	
	var idProducto = $(this).attr("idProducto");

	
	$("#idProducto").val(idProducto);

})

$(".actualizaCalificacion").click(function(){

	
	var idComentario = $(this).attr("idComentario");

	
	$("#idComentario").val(idComentario);

})

/*=============================================
COMENTARIOS CAMBIO DE ESTRELLAS
=============================================*/

$("input[name='puntaje']").change(function(){

	var puntaje = $(this).val();
	
	switch(puntaje){

		case "0.5":
		$("#estrellas").html('<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "1.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "1.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "2.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "2.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "3.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "3.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "4.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
                             '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
		break;

		case "4.5":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i>');
		break;

		case "5.0":
		$("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i> '+
							 '<i class="fa fa-star text-success" aria-hidden="true"></i>');
		break;

	}

})

/*=============================================
VALIDAR EL COMENTARIO
=============================================*/

function validarComentario(){

	var comentario = $("#comentario").val();

	if(comentario != ""){

		var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(comentario)){

			$("#comentario").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> No se permiten caracteres especiales como por ejemplo !$%&/?¡¿[]*</div>');

			return false;

		}

	}else{

		$("#comentario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Campo obligatorio</div>');

		return false;

	}

	return true;

}

function validarComentarioActualizado(){

	var comentario = $("#nComentario").val();

	if(comentario != ""){

		var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(comentario)){

			$("#nComentario").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> No se permiten caracteres especiales como por ejemplo !$%&/?¡¿[]*</div>');

			return false;

		}

	}else{

		$("#nComentario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Campo obligatorio</div>');

		return false;

	}

	return true;

}
/*=============================================
LISTA DE DESEOS
=============================================*/

$(".deseos").click(function(){

	var idProducto = $(this).attr("idProducto");
	console.log("idProducto", idProducto);

	var idUsuario = localStorage.getItem("usuario");
	console.log("idUsuario", idUsuario);

	if(idUsuario == null){

		swal({
		  title: "Debe ingresar al sistema",
		  text: "¡Para agregar un producto a la 'lista de deseos' debe primero ingresar al sistema!",
		  type: "warning",
		  confirmButtonText: "¡Cerrar!",
		  closeOnConfirm: false
		},
		function(isConfirm){
				 if (isConfirm) {	   
				    window.location = rutaFrontEnd;
				  } 
		});

	}else{

		$(this).addClass("btn-danger");

		var datos = new FormData();
        //Almacenaremos los datos de usuario y producto y lo enviaremos al archivo ajax
		datos.append("idUsuario", idUsuario);
		datos.append("idProducto", idProducto);

		$.ajax({
			url:rutaFrontEnd+"ajax/usuarios.ajax.php",
			method:"POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(respuesta){
				
							
			}

		})

	}

})

/*=============================================
BORRAR PRODUCTO DE LISTA DE DESEOS
=============================================*/
//Cuando demos clic en el boton quitar deseo
$(".quitarDeseo").click(function(){

    //Almacenamos el attr en donde viene el id deseo
	var idDeseo = $(this).attr("idDeseo");
    //remueve del html el productos
	$(this).parent().parent().parent().remove();

	var datos = new FormData();
    //Almacenamos en una variable datos un formdata y adicionamos la variable idDeseo
	datos.append("idDeseo", idDeseo);
    
	$.ajax({
			url:rutaFrontEnd+"ajax/usuarios.ajax.php",
			method:"POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(respuesta){
			
			}

		});


})

/*=============================================
ELIMINAR USUARIO
=============================================*/

$("#eliminarUsuario").click(function(){

	var idUsuario = $("#idUsuario").val();

	if($("#modoUsuario").val() == "directo"){

		if($("#fotoUsuario").val() != ""){

			var foto = $("#fotoUsuario").val();

		}

	}

	swal({
        title: "¿Está usted seguro(a) de eliminar su cuenta?",
		text: "¡Si borrar esta cuenta ya no se puede recuperar los datos!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "¡Si, borrar cuenta!",
		closeOnConfirm: false
    },
	function(isConfirm){
        if (isConfirm) {	   
		    window.location = "index.php?ruta=perfil&idUsuario="+idUsuario+"&foto="+foto;
		} 
    });

})

/*=============================================
VALIDAR DATOS DE DIRECCION
=============================================*/

function validarFormDireccion(form) {
	console.log(form);
	let nombre = $(form).find('input#nombreCompleto').val();
	let telefono = $(form).find('input#telefono').val();
	let cp = $(form).find('input#cp').val();
	let estado = $(form).find('input#estado').val();
	let municipio = $(form).find('input#municipio').val();
	let calle = $(form).find('input#calle').val();

	if (nombre != "" && cp != "" && estado != "" && municipio != "" && calle != "") {
		if (telefono != "" && !isNaN(telefono)) 
			return true;
		else if(telefono == "")
			return true;
		else 
			false;
	}
	else{
		return false;
	}
	return false;
}


/*=============================================
ELIMINAR Dirección
=============================================*/

$(".delete-direccion").click(function(event){
	event.preventDefault();
	let  idUsuario = $("#idUsuario").val();
	let idDireccion = $(this).prop('id');
	console.log(idDireccion);
	swal({
        title: "¿Está usted seguro(a) de eliminar esta dirección?",
		text: "¡Si borrar esta direccion ya no se puede recuperar los datos!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "¡Si, borrar dirección!",
		closeOnConfirm: false
    },
	function(isConfirm){
        if (isConfirm) {	   
		    window.location = "index.php?ruta=direcciones&deletedir="+idDireccion;
		} 
    });

})

$(".update-direccion").click(function(event){
	event.preventDefault();
	let  idUsuario = $("#idUsuario").val();
	let idDireccion = $(this).prop('id');
	console.log(idDireccion);
	swal({
        title: "¿Está usted seguro(a) de editar esta dirección?",
		text: "¡Actualizará los datos de dirección!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "¡Si, Actualizar!",
		closeOnConfirm: false
    },
	function(isConfirm){
        if (isConfirm) {	   
		    window.location = "index.php?ruta=editarDireccion&updatedir="+idDireccion;
		} 
    });

})

/*=============================================
VALIDAR DATOS DE FACTURACION
=============================================*/

function validarFormFacturacion(form) {
	console.log(form);
	let nombre = $(form).find('input#nombreRazon').val();
    let rfc = $(form).find('input#rfcPersona').val();
    let tipoPersona = $(form).find('input#tipoPersona').val();
    let calle = $(form).find('input#calle').val();
	let colonia = $(form).find('input#colonia').val();
    let municipio = $(form).find('input#municipio').val();
    let estado = $(form).find('input#estado').val();
	let codPostal = $(form).find('input#codigoPostal').val();
	let telefono = $(form).find('input#telefono').val();
    let email = $(form).find('input#email').val();

	if (nombre != "" && rfc != "" && tipoPersona != "" && codPostal != "" && estado != "" && municipio != "" && calle != "") {
        
        if(rfc.length)
        
		if (telefono != "" && !isNaN(telefono)) 
			return true;
		else if(telefono == "")
			return true;
		else 
			false;
	}
	else{
		return false;
	}
	return false;
}


/*=============================================
ELIMINAR DATOS DE FACTURACION
=============================================*/

$(".delete-facturacion").click(function(event){
	event.preventDefault();
	let  idUsuario = $("#idUsuario").val();
	let idFactura = $(this).prop('id');
    
    console.log(idFactura);
    
	swal({
        title: "¿Está usted seguro(a) de eliminar sus datos de facturación?",
		text: "¡Si borrar sus datos ya no podrá recuperarlos!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "¡Si, borrar Datos de Facturacion!",
		closeOnConfirm: false
    },
	function(isConfirm){
        if (isConfirm) {	   
		    window.location = "index.php?ruta=facturacion&deletefact="+idFactura;
		} 
    });

})

/*=============================================
VALIDAR RFC
=============================================*/
$("#tipoPersona").change(function(){
    
    var rfc = $("#rfcPersona").val();
    var tipoPersona = ($("#tipoPersona").val()).toUpperCase();
    console.log ("tipo persona");
    console.log (tipoPersona);
    console.log (rfc.length);
    if(tipoPersona == "FISICA"){
        if(rfc.length == 13 || rfc.length == 0){
            $(".alerta").remove();
        }
        else if(rfc.length != 13){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA FISICA</strong></div></span>');
        }
        else if(rfc.length < 13 && rfc.length > 0){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA FISICA</strong></div></span>');
        }
    }
    else if (tipoPersona == "MORAL"){
        if(rfc.length == 12 || rfc.length == 0){
            $(".alerta").remove();
        }
        else if(rfc.length < 12 && rfc.length > 0){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA MORAL</strong></div></span>');
        }
        else if(rfc.length > 12){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA MORAL</strong></div></span>');
        }
        
    }
    
})

$("#rfcPersona").change(function(){
    var rfc = $("#rfcPersona").val();
    var tipoPersona = ($("#tipoPersona").val()).toUpperCase();
    console.log ("rfc persona");
    console.log (tipoPersona);
    console.log (rfc.length);
    
    if(rfc.length == 13){
        if(tipoPersona == "FISICA"){
            $(".alerta").remove();
        }
        else{
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA MORAL</strong></div></span>');
        }
    }
    else if(rfc.length == 12){
        if(tipoPersona == "MORAL"){
            $(".alerta").remove();
        }
        else{
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA FISICA</strong></div></span>');
        }
    }
    else if(rfc.length == 0){
        $(".alerta").remove();
    }
    else{
        if(rfc.length < 13 && tipoPersona == "FISICA"){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA FISICA</strong></div></span>');
        }
        else if(rfc.length < 12 && tipoPersona == "MORAL"){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA MORAL</strong></div></span>');
        }
        else if( rfc.length > 12 && tipoPersona == "MORAL"){
            $(".alerta").remove();
            $(".valrfc").after('<span class="alerta"><div style="color:#ff0f00"><strong>El número de caracteres de tu RFC no concuerda con el tipo de PERSONA MORAL</strong></div></span>');
        }
    }
    
})
/*---------------------------------------------------------------------*/