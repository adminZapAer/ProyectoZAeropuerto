/*===================================================
                    PLANTILLA
===================================================*/

var rutaFrontEnd = $("#rutaFrontend").val();

//Herramienta Tooltip
$('[data-toggle="tooltip"]').tooltip();



$.ajax({
    
    url: rutaFrontEnd+"ajax/plantilla.ajax.php",
    
    success: function(respuesta){
        var colorFondo = JSON.parse(respuesta).colorFondo;
        var colorTexto = JSON.parse(respuesta).colorTexto;
        var barraSuperior = JSON.parse(respuesta).barraSuperior;
        var textoSuperior = JSON.parse(respuesta).textoSuperior;
        
        $(".backColor, .backColor a").css({"background": colorFondo,"color": colorTexto})
        
        $(".barraSuperior, .barraSuperior a").css({"background": barraSuperior,"color": textoSuperior})
        
    }
})

/*===================================================
                CUADRICULA O LISTA
===================================================*/

var btnList = $(".btnList");
var btnGrid = $(".btnGrid");

for(var i = 0; i < btnList.length; i++){
    $(btnGrid[i]).addClass("backColor");
    $("#btnGrid"+i).click(function(){
        
        var numero = $(this).attr("id").substr(-1); //Substrae el valor del atributo id de la funcion 
        
        $(".list"+numero).hide();//Cuando demos clic en grid " i ", el List " i " se va a ocultar
        $(".grid"+numero).show();//Mostrara el grid " i "
        
        $("#btnGrid"+numero).blur();
        $("#btnGrid"+numero).addClass("backColor");//Cuando haga click en el boton grid, va a cambiar de color
        $("#btnList"+numero).attr("style","");
        $("#btnList"+numero).removeClass("backColor");//Cuando haga click en el boton grid, al boton list le removeran la clase backcolor si es que tiene asignada la clase.
        
        
    })

    $("#btnList"+i).click(function(){
        
        var numero = $(this).attr("id").substr(-1);
        
        $(".list"+numero).show();//Cuando demos clic en list " i ", el List0 se mostrara
        $(".grid"+numero).hide();//Ocultará el grid " i "
        
        $("#btnList"+numero).blur();
        $("#btnList"+numero).addClass("backColor");
        $("#btnGrid"+numero).attr("style","");
        $("#btnGrid"+numero).removeClass("backColor");
        
    })
}

/*=================================================
                EFECTOS CON EL SCROLL
=================================================*/
$(window).scroll(function(){
    var scrollY =window.pageYOffset;//Captura la possicion en Y del Scroll
    //console.log("scroll Y ",scrollY);
    
    if(window.matchMedia("(min-width:768px)").matches){
        
        if($(".banner").html() != null){
            
            if(scrollY < ($(".banner").offset().top)-100){
                //console.log("Es menor");
                $(".banner img").css({"margin-top": -scrollY/2+"px"})
            }
            else{
                scrollY=0;
            }
            
        }
    }
    //upsetup
    
})

/*=================================================
                    SCROLL UP
=================================================*/

$(function(){
    
});



/*=================================================
                MIGAS DE PAN
=================================================*/

var pagActiva = $(".pagActiva").html();

if(pagActiva != null){
    
    var regPagActiva = pagActiva.replace(/-/g, " ");
    $(".pagActiva").html(regPagActiva);
    
}

/*=================================================
                Enlaces Paginacion
=================================================*/
var url = window.location.href; //Es para saber en que pagina me encuentro

var indice = url.split("/");

if(indice[6].length==1){
    var pagActual = indice[6];
}
else{
    var pagActual = indice[5];
}

if(isNaN(pagActual)){
    $("#item1").addClass("active");
}
else{
    $("#item"+pagActual).addClass("active");
}

/*=================================================
                CONTADOR DE TIEMPO
=================================================*/
var finOferta = $(".countdown");

var fechaFinOferta = [];

for(var i = 0; i < finOferta.length; i++){
    
    fechaFinOferta[i] = $(finOferta[i]).attr("finOferta");
    
    $(finOferta[i]).dsCountDown({
        
        endDate: new Date(fechaFinOferta[i]),
        theme: 'flat',
        titleDays: 'Dias',
        titleHours: 'Horas',
        titleMinutes: 'Minutos',
        titleSeconds:'Segundos'
        
    });
    
}
