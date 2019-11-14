/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
VISUALIZAR LA CESTA DEL CARRITO DE COMPRAS
=============================================*/

if(localStorage.getItem("cantidadCesta") != null){

    $(".cantidadCesta").html(localStorage.getItem("cantidadCesta"));
    $(".sumaCesta").html(localStorage.getItem("sumaCesta"));
    $(".sumaSubTotal span").html(localStorage.getItem("sumaCesta"));

}
else{

    $(".cantidadCesta").html("0");
    $(".sumaCesta").html("0");
}

$(document).ready( function(){
    subtotales = $('.subtotales span');
    var total = 0;

    console.log('subtotales',subtotales);

    $(subtotales).each( function(subtotal){
        total += parseFloat(subtotal.html());
    } );


    console.log(total);
} );

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
VISUALIZAR LOS PRODUCTOS EN LA PÁGINA CARRITO DE COMPRAS
=============================================*/
if(localStorage.getItem("listaProductos") != null){
    
    var listaCarrito = JSON.parse(localStorage.getItem("listaProductos"));
    // alert('Hola');
    
    listaCarrito.forEach(funcionForEach);
    
    function funcionForEach(item, index){


        function getCostoEnvio(item){

            $.ajax({
                method: "GET",
                url: rutaFrontEnd + 'ajax/costoEnvio.php',
                data: { id: item.idProducto }
              })
                .done(function( cotizacion ) {
                  console.log(JSON.parse(cotizacion));
                  costoEnvio = JSON.parse(cotizacion).FrecuenciaCotizadorResult.Respuesta.TipoServicio.TipoServicio[2].CostoTotal;
                  console.log(costoEnvio);
                  $(".cuerpoCarrito").append(
                    '<div clas="row itemCarrito">'+
                        
                        '<div class="col-sm-1 col-xs-12">'+
                            
                            '<br>'+
                            
                            '<center>'+
                                
                                '<button class="btn btn-default backColor quitarItem" idProducto="'+item.idProducto+'" tipo="'+item.tipo+'" peso="'+item.peso+'">'+
                                    
                                    '<i class="fa fa-times"></i>'+
                                    
                                '</button>'+
                                
                            '</center>'+
                            
                        '</div>'+
                        
                        '<div class="col-sm-1 col-xs-12">'+
                            
                            '<figure>'+
                                
                                '<img src="'+item.imagen+'" class="img-thumbnail">'+
                                
                            '</figure>'+
                            
                        '</div>'+
                        
                        '<div class="col-sm-2 col-xs-12">'+
                            
                            '<br>'+
                            
                            '<p class="tituloCarritoCompra text-left">'+item.titulo+'</p>'+
                            
                        '</div>'+
                        
                        '<div class="col-md-2 col-sm-1 col-xs-12">'+
                            
                            '<br>'+
                            
                            '<p class="precioCarritoCompra text-center">MXN $<span>'+item.precio+'</span></p>'+
                            
                        '</div>'+
                        
                        '<div class="col-md-2 col-sm-2 col-xs-8 text-center">'+
                            
                            '<br>'+
                            
                            '<div class="col-xs-12">'+
                                
                                '<center>'+
                                
                                    '<input type="number" class="form-control cantidadItem" min="1" value="'+item.cantidad+'" tipo="'+item.tipo+'" precio ="'+item.precio+'" idProducto="'+item.idProducto+'" costoEnvio="'+costoEnvio+'">'+
                                    
                                '</center>'+
                                
                            '</div>'+
                            
                        '</div>'+
                        
                        
            
                        '<div class="col-md-2 col-sm-1 col-xs-4 text-center envios">'+
                            
                            '<br>'+
                            
                            '<p>'+
                                
                            // '<strong>MXN $<span>'+0+'</span></strong>'+
                                '<strong>MXN $<span>'+costoEnvio+'</span></strong>'+
                                
                            '</p>'+
                            
                        '</div>'+

                        '<div class="col-md-2 col-sm-1 col-xs-4 text-center">'+
                            
                            '<br>'+
                            
                            '<p class="subTotal'+item.idProducto+' subtotales">'+
                                
                                '<strong>MXN $<span>'+( parseFloat(item.precio) + parseFloat(costoEnvio) ).toFixed(2) +'</span></strong>'+
                                
                            '</p>'+
                            
                        '</div>'+
                        
                    '</div>'+
                    
                    '<div class="clearfix"></div>'+
                        
                    '<hr>'
                    );

                    $(".cantidadItem[tipo='virtual']").attr("readonly","true");
                });

            

        }

        getCostoEnvio(item);

        /*=============================================
                EVITAR MANIPULAR LA CANTIDAD EN 
                    PRODUCTOS VIRTUALES
        =============================================*/
        $(".cantidadItem[tipo='virtual']").attr("readonly","true");
        
    }
    
}
else{
    $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
    $(".sumaCarrito").hide();
    $(".cabeceraCheckout").hide();
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
AGREGAR AL CARRITO
=============================================*/

$(".agregarCarrito").click(function(){
    
    var idProducto = $(this).attr("idProducto");
    var imagen = $(this).attr("imagen");
    var titulo = $(this).attr("titulo");
    var precio = $(this).attr("precio");
    var tipo = $(this).attr("tipo");
    var peso = $(this).attr("peso");
    
    var agregarAlCarrito = false; 
    
    /*=============================================
                   CAPTURAR DETALLES
    =============================================*/
    
    if(tipo == "fisico"){
        
        agregarAlCarrito = true;
        
    }
    else{
        
    }

    /*=============================================
           ALMACENAR EN EL LOCALSTARGE LOS 
            PRODUCTOS AGREGADOS AL CARRITO
    =============================================*/
    if(agregarAlCarrito){
        
        /*=============================================
          RECUPERAR ALMACENAMIENTO DEL LOCALSTORAGE
        =============================================*/
        
        if(localStorage.getItem("listaProductos") == null){
            
            listaCarrito = [];
            
        }
        else{
            
            var listaProductos = JSON.parse(localStorage.getItem("listaProductos"));
            
            for(var i = 0; i < listaProductos.length; i++){
                
                if(listaProductos[i]["idProducto"] == idProducto){
                    
                    swal({
                        title: "El producto ya está agregado al carrito de compras",
                        text:"",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "¡Volver!",
                        closeOnConfirm:false
                    })
                    return;
                }
            }
            
            listaCarrito.concat(localStorage.getItem("listaProductos"));
            
        }
        
        listaCarrito.push({
            "idProducto":idProducto,
            "imagen":imagen,
            "titulo":titulo,
            "precio":precio,
            "tipo":tipo,
            "peso":peso,
            "cantidad":"1"
        });
        
        localStorage.setItem("listaProductos",JSON.stringify(listaCarrito));
        
        /*=============================================
                    ACTUALIZAR LA CESTA
        =============================================*/
        var cantidadCesta = Number($(".cantidadCesta").html()) + 1;
        var sumaCesta = Number($(".sumaCesta").html()) + Number(precio);
        
        $(".cantidadCesta").html(cantidadCesta);
        $(".sumaCesta").html(sumaCesta.toFixed(2));
        
        localStorage.setItem("cantidadCesta", cantidadCesta);
        localStorage.setItem("sumaCesta", sumaCesta.toFixed(2));
        
        /*=============================================
              MOSTRAR ALERTA DE QUE EL PRODUCTO 
                        YA FUE AGREGADO
        =============================================*/
        swal({
              title: "",
              text: "¡Se ha agregado un nuevo producto al carrito de compras!",
              type: "success",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              cancelButtonText: "¡Continuar comprando!",
              confirmButtonText: "¡Ir a mi carrito de compras!",
              closeOnConfirm: false
            },
            function(isConfirm){
                if (isConfirm) {       
                     window.location = rutaFrontEnd+"carrito-de-compras";
                } 
        });
        
    }
    
})

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
QUITAR PRODUCTOS DEL CARRITO
=============================================*/
$(document).on("click", ".quitarItem", function(){
    
    $(this).parent().parent().parent().remove();
    
    var idProducto = $(".cuerpoCarrito button");
    var imagen = $(".cuerpoCarrito img");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
    var precio = $(".cuerpoCarrito .precioCarritoCompra span");
    var cantidad = $(".cuerpoCarrito .cantidadItem");
    
    /*=============================================
           SI AÚN QUEDAN PRODUCTOS VOLVERLOS 
            AGREGAR AL CARRITO (LOCALSTORAGE)
    =============================================*/
    
    listaCarrito = [];
    
    if(idProducto.length != 0){

        for(var i = 0; i < idProducto.length; i++){

            var idProductoArray = $(idProducto[i]).attr("idProducto");
            var imagenArray = $(imagen[i]).attr("src");
            var tituloArray = $(titulo[i]).html();
            var precioArray = $(precio[i]).html();
            var pesoArray = $(idProducto[i]).attr("peso");
            var tipoArray = $(cantidad[i]).attr("tipo");
            var cantidadArray = $(cantidad[i]).val();

            listaCarrito.push({"idProducto":idProductoArray,
                           "imagen":imagenArray,
                           "titulo":tituloArray,
                           "precio":precioArray,
                           "tipo":tipoArray,
                           "peso":pesoArray,
                           "cantidad":cantidadArray});

        }

        localStorage.setItem("listaProductos",JSON.stringify(listaCarrito));
        
        sumaSubtotales();
        cestaCarrito(listaCarrito.length);
        
    }
    else{

        /*=============================================
        SI YA NO QUEDAN PRODUCTOS HAY QUE REMOVER TODO
        =============================================*/    

        localStorage.removeItem("listaProductos");

        localStorage.setItem("cantidadCesta","0");
        
        localStorage.setItem("sumaCesta","0");

        $(".cantidadCesta").html("0");
        $(".sumaCesta").html("0");

        $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
        $(".sumaCarrito").hide();
        $(".cabeceraCheckout").hide();
    }
    
})

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
GENERAR SUBTOTAL DESPUES DE CAMBIAR CANTIDAD
=============================================*/

$(document).on("change",".cantidadItem",function(){
    
    var cantidad = $(this).val();
    var precio = $(this).attr("precio");
    var idProducto = $(this).attr("idProducto");
    var costoEnvio = parseFloat($(this).attr("costoenvio"));
    var cantidadItem = $(".cantidadItem");
    
    $(".subTotal"+idProducto).html('<strong>MXN $<span>'+Number((cantidad*precio)+costoEnvio).toFixed(2)+'</span></strong>');
    
    console.log(costoEnvio);

    /*=============================================
    ACTUALIZAR LA CANTIDAD EN EL LOCALSTORAGE
    =============================================*/
    var idProducto = $(".cuerpoCarrito button");
    var imagen = $(".cuerpoCarrito img");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
    var precio = $(".cuerpoCarrito .precioCarritoCompra span");
    var cantidad = $(".cuerpoCarrito .cantidadItem");
    
    listaCarrito = [];
    
    for(var i = 0; i < idProducto.length; i++){
        
        var idProductoArray = $(idProducto[i]).attr("idProducto");
        var imagenArray = $(imagen[i]).attr("src");
        var tituloArray = $(titulo[i]).html();
        var precioArray = $(precio[i]).html();
        var pesoArray = $(idProducto[i]).attr("peso");
        var tipoArray = $(cantidad[i]).attr("tipo");
        var cantidadArray = $(cantidad[i]).val();
        
        listaCarrito.push(
            {
                "idProducto":idProductoArray,
                "imagen":imagenArray,
                "titulo":tituloArray,
                "precio":precioArray,
                "tipo":tipoArray,
                "peso":pesoArray,
                "cantidad":cantidadArray
            }
        );
    }
    
    localStorage.setItem("listaProductos",JSON.stringify(listaCarrito));
    
    sumaSubtotales();
    cestaCarrito(listaCarrito.length);
    
})

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
SUMA DE TODOS LOS SUBTOTALES
=============================================*/
function sumaSubtotales(){
    
    var subtotales = $(".subtotales span");
    
    var arraySumaSubtotales = [];
    // console.log(arraySumaSubtotales);
    
    for(var i = 0; i < subtotales.length; i++){
        
        var subtotalesArray = $(subtotales[i]).html();
        arraySumaSubtotales.push(Number(subtotalesArray));
        
    }
    
    function sumaArraySubtotales(total, numero){
        
        console.log(total, numero);
        return total + numero;
        
    }
    
    var sumaTotal = arraySumaSubtotales.reduce(sumaArraySubtotales);
    
    $(".sumaSubTotal").html('<strong>MXN $<span>'+(sumaTotal).toFixed(2)+'</span></strong>');
    
    $(".sumaCesta").html((sumaTotal).toFixed(2));
    
    localStorage.setItem("sumaCesta", (sumaTotal).toFixed(2));
    
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
ACTUALIZAR CESTA AL CAMBIAR CANTIDAD
=============================================*/

function cestaCarrito(cantidadProductos){
    
    /*=============================================
           SI HAY PRODUCTOS EN EL CARRITO
    =============================================*/
    
    if(cantidadProductos != 0){
        
        var cantidadItem = $(".cuerpoCarrito .cantidadItem");
        
        var arraySumaCantidades = [];
        
        for(var i = 0; i < cantidadItem .length; i++){
            
            var cantidadItemArray = $(cantidadItem[i]).val();
            arraySumaCantidades.push(Number(cantidadItemArray));
        }
        
        function sumaArrayCantidades(total, numero){

            return total + numero;

        }
        
        var sumaTotalCantidades = arraySumaCantidades.reduce(sumaArrayCantidades);
        
        $(".cantidadCesta").html(sumaTotalCantidades);
        localStorage.setItem("cantidadCesta", sumaTotalCantidades);
        
    }
    
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
                ACTUALIZAR SUBTOTAL
=============================================*/
var precioCarritoCompra = $(".cuerpoCarrito .precioCarritoCompra span");
var cantidadItem = $(".cuerpoCarrito .cantidadItem");
var costoEnvio = $(".cuerpoCarrito .cantidadItem");
console.log(costoEnvio);
for(var i = 0; i < precioCarritoCompra.length; i++){
    var precioCarritoCompraArray = $(precioCarritoCompra[i]).html();
    var cantidadItemArray = $(cantidadItem[i]).val();
    var idProductoArray = $(cantidadItem[i]).attr("idProducto");
    var envioItem = parseFloat($(costoEnvio[i]).attr("costoenvio"));
    $(".subTotal"+idProductoArray).html('<strong>MXN $<span>'+Number(cantidadItemArray*precioCarritoCompraArray+envioItem).toFixed(2)+'</span></strong>');
    sumaSubtotales();
    cestaCarrito(precioCarritoCompra.length);
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
CHECKOUT
=============================================*/
$("#btnCheckout").click(function(){
    
    //Cada vez que le den click al boton checkout se va a limpiar la lista productos y que pueda traer de nuevo la lista de carrito
    $(".listaProductos table.tablaProductos tbody").html("");
    
    $(".listaProductos table.tablaProductos tbody")
    
    var idUsuario = $(this).attr("idUsuario");
    
    var peso = $(".cuerpoCarrito button, .comprarAhora button");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra, .comprarAhora .tituloCarritoCompra");
    var cantidad = $(".cuerpoCarrito .cantidadItem, .comprarAhora .cantidadItem");
    var subtotal = $(".cuerpoCarrito .subtotales span, .comprarAhora .subtotales span");
    var tipoArray =[];
    var cantidadPeso = [];
    var sumaSubTotal = $(".sumaSubTotal span");
    
    
    /*=============================================
                    SUMA SUBTOTAL
    =============================================*/
    
    $(".valorSubtotal").html($(sumaSubTotal).html());
    
    /*=============================================
                TASAS DE IMPUESTO
    var impuestoTotal = ($(".valorSubtotal").html()*$("#tasaImpuesto").val()) / 100;
    
    $(".valorTotalImpuesto").html($(impuestoTotal).html());
    
    =============================================*/
    
    //Ejecuta la funcion de sumar el total de la compra
    sumaTotalCompra();
    
    /*=============================================
                    VARIABLES ARRAY
    =============================================*/
    for(var i = 0; i < titulo.length; i++){
        
        var pesoArray = $(peso[i]).attr("peso");
        var tituloArray = $(titulo[i]).html();
        var cantidadArray = $(cantidad[i]).val();        
        var subtotalArray = $(subtotal[i]).html();
        
        /*=============================================
                EVALUAR PESO DE ACUERDO A LA 
                    CANTIDAD DE PRODUCTOS
        =============================================*/
        //Multiplicamos el peso del producto por la cantidad de los mismos
        cantidadPeso[i] = pesoArray * cantidadArray;
        
        function sumaArrayPeso(total,numero){
            return total+numero;
        }
        
        var sumaTotalPeso = cantidadPeso.reduce(sumaArrayPeso);
        
        /*=============================================
            MOSTRAR PRODUCTOS DEFINITIVOS A COMPRAR
        =============================================*/
        
        $(".listaProductos table.tablaProductos tbody").append(
            '<tr>'+
                '<td class="valorTitulo">'+tituloArray+'</td>'+
                '<td class="valorCantidad">'+cantidadArray+'</td>'+
                '<td>MXN $ <span class="valorItem" valor="'+subtotalArray+'">'+subtotalArray+'</span></td>'+
            '<tr>'
        );
        
        /*=============================================
                  SELECCIONAR PAIS DE ENVÍO SI 
                       HAY PRODUCTO FISICO
        =============================================*/
        tipoArray.push($(cantidad[i]).attr("tipo"));
        
        function checkTipo(tipo){
            
            return tipo == "fisico";
        }
    }
    /*=============================================
                EXISTEN PRODUCTO FISICO
    =============================================*/
    if(tipoArray.find(checkTipo) == "fisico"){
        
        $(".formEnvio").show();
        
        $(".btnPagar").attr("tipo","fisico");
        
        $.ajax({
            
            url: rutaFrontEnd+"vistas/js/plugins/countries.json",
            type: "GET",
            cache: false,
            contentType: false,
            dataType: "json",
            success: function(respuesta){
                respuesta.forEach(seleccionarPais);
                
                function seleccionarPais(item,index){
                    
                    var pais = item.name;
                    var codPais = item.code;
                    $("#seleccionarPais").append('<option value="'+codPais+'">'+pais+'</option>');
                }
            }
            
        })
        
        /*=============================================
                    EVALUAR TASAS DE ENVIO
                      A PRODUCTOS FISICOS
        =============================================*/
        $("#seleccionarPais").change(function(){
            
            $(".alerta").remove();
            
            var pais = $(this).val();
            var tasaPais = $("#tasaPais").val();
            
            if(pais == tasaPais){
                
                //Nesecito multiplicar la tasa de envio nacional por la cantidad de kg del producto
                var resultadoPeso = Number(sumaTotalPeso * $("#envioNacional").val());
                //console.log("resultadoPeso",resultadoPeso);
                //Valor de tasa minima
                var valorTasaMin =Number($("#tasaMinimaNal").val());
                
                //si el resultado peso es menos a la tasa minima nacional
                if(resultadoPeso < $("#tasaMinimaNal").val()){
                    //Mantenemos el valor de la tasa de envio
                    $(".valorTotalEnvio").html(valorTasaMin.toFixed(2));
                    
                }
                else{
                    $(".valorTotalEnvio").html(resultadoPeso.toFixed(2));
                }
                
            }
            //Ejecuta la funcion de sumar el total de la compra
            sumaTotalCompra();
            
        })
        
    }
    else{
        //$(".btnPagar").attr("tipo","virtual");
    }
    
})

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
SUMA TOTAL COMPRA
=============================================*/

function sumaTotalCompra(){
    
    var sumaTotalTasas = 
                        Number($(".valorSubtotal").html())+
                        Number($(".valorTotalEnvio").html());
    $(".valorTotalCompra").html(sumaTotalTasas.toFixed(2));
    
}

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
CAMBIO DE DIVISA
=============================================*/
var divisaBase = "MXN";

/*=============================================
/*=============================================
/*=============================================
/*=============================================
/*=============================================
BOTON PAGAR
=============================================*/
$(".btnPagar").click(function(){
    
    var tipo = $(this).attr("tipo");
    
    if(tipo == "fisico" && $("#seleccionarPais").val() == ""){
        
        $(".btnPagar").after('<span class="alerta"><br><div class="alert alert-warning">No ha seleccionado el país de Envío</div></span>');
        
        return;
        
    }
    console.log("PAGADO");
    
})