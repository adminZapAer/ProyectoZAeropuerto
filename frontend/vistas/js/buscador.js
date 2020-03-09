/*=========================================
                BUSCADOR
=========================================*/
$("#buscador a").click(function(){
    if($("#buscador input").val() == ""){
        $("#buscador a").attr("href", "");
    }
})


$("#buscador input").change(function(){
   
    var busqueda = $("#buscador input").val();
    
    var expresion = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ -]*$/;
    
    if(!expresion.test(busqueda)){
        //Si no coinciden con la busqueda  va a limpiar el buscador
        $("#buscador input").val("");
    }
    else{
        //Si coincide con la busqueda, se realizará un test a la busqueda
        //lo que sucedera es que todo lo que se haya escrito y que contenga espacios en blanco los reemplazará con guiones -
        //asi generamos una url amigable con la busqueda que se está haciendo
        var evaluarBusqueda = busqueda.replace(/[áéíóúÁÉÍÓÚ ]/g,"_");
        
        //Al evaluar la busqueda y pasarlo a una url necesitamos  capturar la busqueda del buscador
        //Esto es para dar un nuevo atributo al href , concatenar
        var rutaBuscador = $("#buscador a").attr("href");
        
        //si la busqueda es diferente de vacio lo que realizará es lo siguiente
        if($("#buscador input").val() != ""){
            //le podemos asignar a buscador su atributo href una nueva información
            $("#buscador a").attr("href", rutaBuscador+"/"+evaluarBusqueda);
            
        }
        
    }
    
});

/*=========================================
            BUSCADOR CON ENTER
=========================================*/
$("#buscador input").focus(function(){
    
    $(document).keyup(function(event){
        
        event.preventDefault();
        
        if(event.keyCode == 13 && $("#buscador input").val() != ""){
            
            var rutaBuscador = $("#buscador a").attr("href");
            
            window.location.href = rutaBuscador;
            
        }
        
    })
    
})