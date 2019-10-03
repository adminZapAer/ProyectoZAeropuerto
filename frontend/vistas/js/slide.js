/*=============================================
VARIABLES
=============================================*/

var item = 0;
var itemPaginacion = $("#paginacion li");
var interrumpirCiclo = false;
var imgProducto = $(".imgProducto");
var titulos1 = $("#slide h1");
var titulos2 = $("#slide h2");
var titulos3 = $("#slide h3");
var btnVerProducto = $("#slide button");
var detenerIntervalo = false;
var toogle = false;

$("#slide ul li").css({"width":100/$("#slide ul li").length + "%"})
$("#slide ul").css({"width":$("#slide ul li").length*100 + "%"})

/*=============================================
ANIMACIÓN INICIAL
=============================================*/

$(imgProducto[item]).animate({"top":-10 +"%", "opacity": 0},100)
$(imgProducto[item]).animate({"top":30 +"px", "opacity": 1},600)

$(titulos1[item]).animate({"top":-10 +"%", "opacity": 0},100)
$(titulos1[item]).animate({"top":30 +"px", "opacity": 1},600)

$(titulos2[item]).animate({"top":-10 +"%", "opacity": 0},100)
$(titulos2[item]).animate({"top":30 +"px", "opacity": 1},600)

$(titulos3[item]).animate({"top":-10 +"%", "opacity": 0},100)
$(titulos3[item]).animate({"top":30 +"px", "opacity": 1},600)

$(btnVerProducto[item]).animate({"top":-10 +"%", "opacity": 0},100)
$(btnVerProducto[item]).animate({"top":30 +"px", "opacity": 1},600)

/*========================================
                PAGINACION
========================================*/
/*Se creará una funcion, la cual al momento de hacer clic en cualquier elemento de paginación, se guardara en una variable global el atributo del item que se está oprimiendo y que los item se resten en -1.

Al capturar el item, este resultado se enviara a una funcion bajo un parámetro.
*/
$("#paginacion li").click(function(){
    
    item = $(this).attr("item")-1;
    
    movimientoSlide(item);
})

/*======================================
                AVANZAR
======================================*/

function Avanzar(){
    if(item == $("#slide ul li").length-1){
        item = 0;
    }
    else{
        item++;
    }
    
    interrumpirCiclo = true;
    
    movimientoSlide(item);
}

$("#slide #avanzar").click(function(){
    
    Avanzar();
    
})

/*======================================
                RETROCEDER
======================================*/
function Retroceder(){
    if(item == 0){
        item = $("#slide ul li").length-1;
    }
    else{
        item--;
    }
    movimientoSlide(item);
}

$("#slide #retroceder").click(function(){
    Retroceder();
})

/*========================================
            MOVIMIENTO SLIDE
========================================*/
/*Se crea la funcion llamada movimientoSlide, el cual recibirá como parámetro un item. La tarea que hara la funcion es pedir al ul que está dentro de slide que ejecute una animación en una propiedad css llamada left y pedira que tome el valor de item, que lo multiplíque por -100 y que se mueva en porcentajes.

De esta manera le está diciendo que el ul debe modificar su css en la propiedad left y si esto es 1, que sea 1 * -100 %, como se está utiliozando la propiedad animate se le puede aplicar un tiempo en milisegundos para que ejecute el movimiento (1 segundo es equivalente a mil milisegundos)*/
function movimientoSlide(item){
    
    $("#slide ul li").finish();
    
    $("#slide ul").animate({"left": item * -100 +"%"}, 1000, "easeOutQuart");
    //Al momento de hacer click en cualquier item de paginación se ilumine
    $("#paginacion li").css({"opacity": .5});
    
    $(itemPaginacion[item]).css({"opacity": 1});
    
    interrumpirCiclo = true;
    
    $(imgProducto[item]).animate({"top":-10 + "%","opacity":0},100)
    $(imgProducto[item]).animate({"top":30 + "px","opacity":1},600)
    
    $(titulos1[item]).animate({"top": -10 + "%","opacity":0},100)
    $(titulos1[item]).animate({"top": 30 + "px","opacity":1},600)

    $(titulos2[item]).animate({"top": -10 + "%","opacity":0},100)
    $(titulos2[item]).animate({"top": 30 + "px","opacity":1},600)

    $(titulos3[item]).animate({"top": -10 + "%","opacity":0},100)
    $(titulos3[item]).animate({"top": 30 + "px","opacity":1},600)
    
    $(btnVerProducto[item]).animate({"top": -10 + "%","opacity":0},100)
    $(btnVerProducto[item]).animate({"top": 30 + "px","opacity":1},600)
    
}

/*========================================
                INTERVALO
========================================*/
//Funcion cuya tarea es que avanzaran los slides en un cierto intervalo de tiempo.

setInterval(function(){
    if(interrumpirCiclo){
        interrumpirCiclo = false;
        detenerIntervalo = false;
        $("#slide ul li").finish();
    }
    else{
        if(!detenerIntervalo){
            Avanzar();
        }
    }
}, 3000)

/*========================================
            APARECER FLECHAS
========================================*/

$("#slide").mouseover(function(){
    $("#slide #retroceder").css({"opacity":1})
    $("#slide #avanzar").css({"opacity":1})
    
    detenerIntervalo = true;
})

$("#slide").mouseout(function(){
    $("#slide #retroceder").css({"opacity":0})
    $("#slide #avanzar").css({"opacity":0})
    detenerIntervalo = false;
})
/*======================================
            ESCONDER SLIDE
======================================*/
$("#btnSlide").click(function(){
    if(!toogle){
        toogle = true;
        $("#slide").slideUp("fast");
        $("#btnSlide").html('<i class="fa fa-angle-down"></i>');
    }
    else{
        toogle = false;
        $("#slide").slideDown("fast");
        $("#btnSlide").html('<i class="fa fa-angle-up"></i>');
    }
    
})
