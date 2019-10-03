/*=============================================
BOTÓN FACEBOOK
=============================================*/

$(".facebook").click(function(){
    //Ejecuta una funcion propia
	FB.login(function(response){
        
		validarUsuario();
        //indica que voy a capturar de ese usuario, perfil publico y email
	}, {scope: 'public_profile, email'})
    
})

/*=============================================
VALIDAR EL INGRESO
=============================================*/

function validarUsuario(){

	FB.getLoginStatus(function(response){
        //Validamos el cambio de estado en facebook
		statusChangeCallback(response);

	})

}

/*=============================================
VALIDAMOS EL CAMBIO DE ESTADO EN FACEBOOK
=============================================*/
//Traera unas propiedades
function statusChangeCallback(response){
    //
	if(response.status === 'connected'){

		testApi();

	}else{

		swal({
          title: "¡ERROR!",
          text: "¡Ocurrió un error al ingresar con Facebook, vuelve a intentarlo!",
          type: "error",
          confirmButtonText: "Cerrar",
          closeOnConfirm: false
        },
        function(isConfirm){
           	if (isConfirm) {    
              	window.location = localStorage.getItem("rutaActual");
            } 
      	});

	}

}

/*=============================================
INGRESAMOS A LA API DE FACEBOOK
=============================================*/

function testApi(){
    //Vamos a capturar los campos que necesitamos del perfil del usuario(id, nombre, email y foto)
	FB.api('/me?fields=id,name,email,picture',function(response){
        
		if(response.email == "undefined"){
            
			swal({
                title: "¡ERROR!",
                text: "¡Para poder ingresar al sistema debe proporcionar la información del correo electrónico!",
                type: "error",
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            },
            function(isConfirm){
                if (isConfirm) {    
                    window.location = localStorage.getItem("rutaActual");
                } 
            });

		}else{

			var email = response.email;
            console.log("email", email);
			var nombre = response.name;
            console.log("nombre", nombre);
			var foto = "http://graph.facebook.com/"+response.id+"/picture?type=large";
            console.log("foto", foto);
            
			var datos = new FormData();
			datos.append("email", email);
			datos.append("nombre",nombre);
			datos.append("foto",foto);
            
            $.ajax({
                
                
                
            })

		}

	})

}