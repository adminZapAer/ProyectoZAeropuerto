/*===================================
            CARRUCEL
===================================*/
$(".flexslider").flexslider({
    
    animation: "slide",
    controlNav: true,
    animationLoop: false,
    slideshow: false,
    itemWidth: 100,
    itemMargin:5
    
});

/*============================================
            MOSTRAR IMAGENES EN VISOR
============================================*/
$(".flexslider ul li img").click(function(){
    var capturaIndice = $(this).attr("value");//capturamos el valor indice del atributo value en la variable capturaIndice
    //pediremos que se oculte la imagen del visor
    $(".infoproducto figure.visor img").hide();
   //lo que haremos es que con el id lupa le vamos a concatenar la variable id
    $("#lupa"+capturaIndice).show();
});

/*============================================
                EFECTO LUPA
============================================*/

$(".infoproducto figure.visor img").mouseover(function(event){
    
    /* Al pasar el mouse por la imagen capturara la direccion de la imagen, esto para poder agregarlo
    al atributo img en el archivo infoproducto.php para el visor de lupa*/
    var capturaImg = $(this).attr("src");
    //Vamos a agregar el valor de capturaImg en el atributo scr (la ruta de la imagen)
    $(".lupa img").attr("src", capturaImg);
    //Cuando el mouse se posicione sobre la imagen que muestre la seccion lupa
    $(".lupa").fadeIn("fast");
    
    $(".lupa").css({
        
        "height":$("visorImg").height() +"px",
        "background":"#f8f8f8",
        "width":"100%"
        
    })
})

$(".infoproducto figure.visor img").mouseout(function(event){
    $(".lupa").fadeOut("fast");
})

$(".infoproducto figure.visor img").mousemove(function(event){
    var posX = event.offsetX;
    
    var posY = event.offsetY;
    
    $(".lupa img").css({
        
        "margin-left": -posX +"px",
        "margin-top": -posY +"px"
        
    })
    
})

/*============================================
            CONTADOR DE VISTAS
============================================*/
//Cuando la ventana se cargue, ejecutará la siguiente funcion
var contador = 0;

$(window).on("load",function(){
    
    var vistas = $("span.vistas").html();//Capturamos el valor de visitas del producto
    var precio = $("span.vistas").attr("tipo");//Capturamos el contenido del atributo tipo
    
    contador = Number(vistas) + 1;
    
    $("span.vistas").html(contador);
    
    //Evaluamos el precio  para definir campo a actualizar
    
    if(precio == 0){
        var item = "vistasGratis";
    }
    else{
        var item = "vistas";
    }
    
    //Evaluamos la ruta  para definir el producto a actualizar
    
    var urlActual = location.pathname;
    var ruta = urlActual.split("/");
    
    var datos = new FormData();
    
    datos.append("valor", contador);
    datos.append("item", item);
    datos.append("ruta", ruta.pop());
    
    $.ajax({
        url:rutaFrontEnd+"ajax/producto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType:false,
        processData:false,
        success: function(respuesta){}
    });

    data = new FormData();

    data.append("producto_id", $('#inputProductoId').val());
    data.append("usuario_id", $('#inputUsuarioId').val());

    $.ajax({
        url:rutaFrontEnd+"ajax/usuarios.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType:false,
        processData:false,
        success: function(respuesta){
        }
    });
    
})

/*=============================================
ALTURA COMENTARIOS
=============================================*/

$(".comentarios").css({
    "height":$(".comentarios .alturaComentarios").height()+"px",
	"overflow":"hidden",
	"margin-bottom":"20px"
})

//Cuando le demos clic al boton ver mas
$("#verMas").click(function(e){

    //Anularemos todas las acciones por defecto que nos pueda traer 
	e.preventDefault();
    //Si ver mas en el html es igual al texto ver mas
	if($("#verMas").html() == "Ver más"){
        //Visualizamos los demas comentarios en la seccion y cambiamos de nombre al boton, nombrandolo como verMenos
		$(".comentarios").css({"overflow":"inherit"});

		$("#verMas").html("Ver menos"); 
	   
	}else{
        
		$(".comentarios").css({
            "height":$(".comentarios .alturaComentarios").height()+"px",
			"overflow":"hidden",
			"margin-bottom":"20px"
        })
        
		$("#verMas").html("Ver más"); 
	}

})