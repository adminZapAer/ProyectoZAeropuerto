class LocalStorageJSON {

    static getItems(key) {
        return JSON.parse(
            localStorage.getItem(key)
        );
    }

}

function insertarProductoAListaHTML(item) {

    if (localStorage.getItem('paginaEnvio') != 1) {
        input = '<input type="number" class="form-control cantidadItem" min="1" value="' + item.cantidad + '" tipo="' + item.tipo + '" precio ="' + item.precio + '" idProducto="' + item.idProducto + '" costoEnvio="' + item.costoEnvio + '">';
    } else {
        input = '<input type="number" readonly class="form-control cantidadItem" min="1" value="' + item.cantidad + '" tipo="' + item.tipo + '" precio ="' + item.precio + '" idProducto="' + item.idProducto + '" costoEnvio="' + item.costoEnvio + '">';
    }

    $(".cuerpoCarrito").append(
        '<div clas="row itemCarrito">' +

        '<div class="col-sm-1 col-xs-12">' +

        '<br>' +

        '<center>' +

        '<button class="btn btn-default backColor quitarItem" idProducto="' + item.idProducto + '" tipo="' + item.tipo + '" peso="' + item.peso + '">' +

        '<i class="fa fa-times"></i>' +

        '</button>' +

        '</center>' +

        '</div>' +

        '<div class="col-sm-1 col-xs-12">' +

        '<figure>' +

        '<img src="' + item.imagen + '" class="img-thumbnail">' +

        '</figure>' +

        '</div>' +

        '<div class="col-sm-2 col-xs-12">' +

        '<br>' +

        '<p class="tituloCarritoCompra text-left">' + item.titulo + '</p>' +

        '</div>' +

        '<div class="col-md-2 col-sm-1 col-xs-12">' +

        '<br>' +

        '<p class="precioCarritoCompra text-center">MXN $<span>' + item.precio + '</span></p>' +

        '</div>' +

        '<div class="col-md-2 col-sm-2 col-xs-8 text-center">' +

        '<br>' +

        '<div class="col-xs-12">' +

        '<center>' +

        input +

        '</center>' +

        '</div>' +

        '</div>' +



        '<div class="col-md-2 col-sm-1 col-xs-4 text-center envios">' +

        '<br>' +

        '<p>' +

        // '<strong>MXN $<span>'+0+'</span></strong>'+
        '<strong>MXN $<span>' + (parseFloat(item.costoEnvio)).toFixed(2) + '</span></strong>' +

        '</p>' +

        '</div>' +

        '<div class="col-md-2 col-sm-1 col-xs-4 text-center">' +

        '<br>' +

        '<p class="subTotal' + item.idProducto + ' subtotales">' +

        '<strong>MXN $<span>' + (parseFloat(item.precio) * parseInt(item.cantidad) + parseFloat(item.costoEnvio)).toFixed(2) + '</span></strong>' +

        '</p>' +

        '</div>' +

        '</div>' +

        '<div class="clearfix"></div>' +

        '<hr>'
    );
}

function actualizarProducto(item) {

    // OBTENEMOS PRODUCTOS EN FORMATO JSON
    productos = LocalStorageJSON.getItems('listaProductos');

    // ARREGLO CON EL PRODUCTO ACTUALIZADO
    productosActualizados = productos.filter(
        producto => producto.idProducto != item.idProducto
    );
    productosActualizados.push(item);

    // GUARDAMOS LOS PRODUCTOS ACTUALIZADOS EN MEMORIA
    localStorage.setItem(
        'listaProductos',
        JSON.stringify(productosActualizados)
    );
}



/*=============================================
VISUALIZAR LA CESTA DEL CARRITO DE COMPRAS
=============================================*/

if (localStorage.getItem("cantidadCesta") != null) {

    $(".cantidadCesta").html(localStorage.getItem("cantidadCesta"));
    $(".sumaCesta").html(localStorage.getItem("sumaCesta"));
}
else {

    $(".cantidadCesta").html("0");
    $(".sumaCesta").html("0");
}

/*=====================================================
VISUALIZAR LOS PRODUCTOS EN LA PÁGINA CARRITO DE COMPRAS
====================================================*/

function getCostoEnvio(item, direccionId) {

    // SOLICITAR COSTO DE ENVIO DE PRODUCTO
    $.ajax({
        method: "GET",
        url: rutaFrontEnd + 'ajax/costoEnvio.php',
        data: { id: item.idProducto, direccionId: direccionId, cantidad: item.cantidad }
    })
        .done(function (response) {

            respuesta = JSON.parse(response);

            if( respuesta.error != null ){
                swal({
                    title: "Error al cotizar",
                    text: respuesta.error,
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "¡Volver!",
                    closeOnConfirm: true
                })

                $('.cabeceraCheckout #btnCheckout').hide();

            }else{
                $('.cabeceraCheckout #btnCheckout').show();
            }

            console.log('RESPUESTA',JSON.parse(response));

            const origen = JSON.parse(response).origen;

            if (origen == 'planta') {
                $('.aviso').append(`
                    - El producto ${item.titulo} será enviado desde planta<hr>
                `);
            }

            // console.log('RESPONSE ENVIO',JSON.parse(response).origen);

            // ACTUALIZAMOS EL PRODUCTO CON EL NUEVO COSTO DE ENVIO
            if (localStorage.getItem('paginaEnvio') != 1) {
                item.costoEnvio = JSON.parse(response).costoEnvio;
                item.origen = JSON.parse(response).origen;
                actualizarProducto(item);
            }

            insertarProductoAListaHTML(item);

            $(".cantidadItem[tipo='virtual']").attr("readonly", "true");
            sumaSubtotales();

        });
}

async function showProducts(direccion = null) {

    $('.aviso').html('');

    // SI NO HAY PRODUCTOS EN LA CESTA, MOSTRAMOS MENSAJE
    if (localStorage.getItem("listaProductos") == null) {
        $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
        $(".sumaCarrito").hide();
        $(".cabeceraCheckout").hide();
        return;
    }

    var listaCarrito = LocalStorageJSON.getItems("listaProductos");

    await listaCarrito.forEach(
        function (item, index) {
            getCostoEnvio(item, direccion);
            $(".cantidadItem[tipo='virtual']").attr("readonly", "true");
        }
    );

    // $('.aviso').html('');
    // listaCarrito.forEach(
    //     function (item, index) {
    //         console.log('ORIGEN: ',item.origen);
    //         console.log('ORIGEN: ',item);
    //         if(item.origen == 'planta'){
    //             $('.aviso').html(`
    //                 <div class="panel panel-default">
    //                     Tu pedido será solicitado desde planta
    //                 </div>
    //             `);
    //         }
    //     }
    // );

}

if (localStorage.getItem('paginaEnvio') == 0) {
    showProducts();
} else {

    direccionEnvio = JSON.parse(localStorage.getItem("direccionEnvio"));
    if (direccionEnvio != null) {
        direccionId = direccionEnvio[0].id;
    } else {
        direccionId = "no";
    }

    showProducts(direccionId);
}

/*=============================================
AGREGAR AL CARRITO
=============================================*/

$(".agregarCarrito").click(function () {

    nuevoProducto = {
        "idProducto":$(this).attr("idProducto"),
        "imagen":$(this).attr("imagen"),
        "titulo":$(this).attr("titulo"),
        "precio":$(this).attr("precio"),
        "tipo":$(this).attr("tipo"),
        "peso":$(this).attr("peso"),
        "cantidad":"1"
    };

    var agregarAlCarrito = false;

    /*=============================================
                   CAPTURAR DETALLES
    =============================================*/

    if (nuevoProducto.tipo == "fisico") {

        agregarAlCarrito = true;

    }
    else {

    }

    /*=============================================
           ALMACENAR EN EL LOCALSTARGE LOS 
            PRODUCTOS AGREGADOS AL CARRITO
    =============================================*/
    if (agregarAlCarrito) {

        if (CarritoComprasService.tieneProducto(nuevoProducto.idProducto)) {
            swal({
                title: "El producto ya está agregado al carrito de compras",
                text: "",
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "¡Volver!",
                closeOnConfirm: false
            })
            return;
        }

        /*=============================================
          RECUPERAR ALMACENAMIENTO DEL LOCALSTORAGE
        =============================================*/

        // listaCarrito = [];

        if (CarritoComprasService.estaVacio()) {
            listaCarrito = [];
        }
        else {
            listaCarrito = JSON.parse(localStorage.getItem("listaProductos"));
        }
        listaCarrito.push(nuevoProducto);

        localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

        /*=============================================
                    ACTUALIZAR LA CESTA
        =============================================*/
        var cantidadCesta = Number($(".cantidadCesta").html()) + 1;
        var sumaCesta = Number($(".sumaCesta").html()) + Number(nuevoProducto.precio);

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
            function (isConfirm) {
                if (isConfirm) {
                    window.location = rutaFrontEnd + "carrito-de-compras";
                }
            });

    }

})

/*=============================================
QUITAR PRODUCTOS DEL CARRITO
=============================================*/
$(document).on("click", ".quitarItem", function () {

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

    if (idProducto.length != 0) {

        for (var i = 0; i < idProducto.length; i++) {

            var idProductoArray = $(idProducto[i]).attr("idProducto");
            var imagenArray = $(imagen[i]).attr("src");
            var tituloArray = $(titulo[i]).html();
            var precioArray = $(precio[i]).html();
            var pesoArray = $(idProducto[i]).attr("peso");
            var tipoArray = $(cantidad[i]).attr("tipo");
            var cantidadArray = $(cantidad[i]).val();

            listaCarrito.push({
                "idProducto": idProductoArray,
                "imagen": imagenArray,
                "titulo": tituloArray,
                "precio": precioArray,
                "tipo": tipoArray,
                "peso": pesoArray,
                "cantidad": cantidadArray
            });

        }

        localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

        sumaSubtotales();
        cestaCarrito(listaCarrito.length);

    }
    else {

        /*=============================================
        SI YA NO QUEDAN PRODUCTOS HAY QUE REMOVER TODO
        =============================================*/

        localStorage.removeItem("listaProductos");

        localStorage.setItem("cantidadCesta", "0");

        localStorage.setItem("sumaCesta", "0");

        $(".cantidadCesta").html("0");
        $(".sumaCesta").html("0");

        $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
        $(".sumaCarrito").hide();
        $(".cabeceraCheckout").hide();
    }

});

/*=============================================
GENERAR SUBTOTAL DESPUES DE CAMBIAR CANTIDAD
=============================================*/

// EVENTO QUE OCURRA AL CAMBIAR LA CANTIDAD DEL CARRITO
$(document).on("change", ".cantidadItem", function () {

    // CADA UNO DE LOS PRODUCTOS LOS GUARDAMOS EN LOCALSTORAGE
    var idProducto = $(".cuerpoCarrito button");
    var imagen = $(".cuerpoCarrito img");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
    var precio = $(".cuerpoCarrito .precioCarritoCompra span");
    var cantidad = $(".cuerpoCarrito .cantidadItem");

    listaCarrito = [];
    for (var i = 0; i < idProducto.length; i++) {
        listaCarrito.push(
            {
                "idProducto": $(idProducto[i]).attr("idProducto"),
                "imagen": $(imagen[i]).attr("src"),
                "titulo": $(titulo[i]).html(),
                "precio": $(precio[i]).html(),
                "tipo": $(cantidad[i]).attr("tipo"),
                "peso": $(idProducto[i]).attr("peso"),
                "cantidad": $(cantidad[i]).val(),
            }
        );
    }
    localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

    sumaSubtotales();
    cestaCarrito(listaCarrito.length);

    $('.cuerpoCarrito').html('');

    direccionEnvio = JSON.parse(localStorage.getItem("direccionEnvio"));
    if (direccionEnvio != null) {
        direccionId = direccionEnvio[0].id;
    } else {
        direccionId = "no";
    }

    showProducts(direccionId);
})


/*=============================================
SUMA DE TODOS LOS SUBTOTALES
=============================================*/
function sumaSubtotales() {

    // SUMAMOS CADA UNO DE LOS SUBTOTALES
    var subtotales = $(".subtotales span");
    var arraySumaSubtotales = [];
    for (var i = 0; i < subtotales.length; i++) {
        var subtotalesArray = $(subtotales[i]).html();
        arraySumaSubtotales.push(Number(subtotalesArray));

    }
    function sumaArraySubtotales(total, numero) {
        return total + numero;
    }
    var sumaTotal = arraySumaSubtotales.reduce(sumaArraySubtotales);

    // ACTUALIZAMOS EL TOTAL DE LA COMPRA
    $(".sumaSubTotal").html('<strong>MXN $<span>' + (sumaTotal).toFixed(2) + '</span></strong>');

    // ACTUALIZAR SUMA SESTA
    $(".sumaCesta").html((sumaTotal).toFixed(2));
    localStorage.setItem("sumaCesta", (sumaTotal).toFixed(2));

}

/*=============================================
ACTUALIZAR CESTA AL CAMBIAR CANTIDAD
=============================================*/

function cestaCarrito(cantidadProductos) {

    /*=============================================
           SI HAY PRODUCTOS EN EL CARRITO
    =============================================*/

    if (cantidadProductos != 0) {

        // OBTENEMOS LAS CANTIDADES SOLICITADAS DE CADA PRODUCTO
        var cantidadItem = $(".cuerpoCarrito .cantidadItem");
        var arraySumaCantidades = [];
        for (var i = 0; i < cantidadItem.length; i++) {
            var cantidadItemArray = $(cantidadItem[i]).val();
            arraySumaCantidades.push(Number(cantidadItemArray));
        }

        // SUMAR TODAS LAS CANTIDADES DE TODOS LOS PRODUCTOS
        function sumaArrayCantidades(total, numero) {
            return total + numero;
        }
        var sumaTotalCantidades = arraySumaCantidades
            .reduce(sumaArrayCantidades);

        // ACTUALIZAR LA CANTIDAD DE PRODUCTOS
        $(".cantidadCesta").html(sumaTotalCantidades);

        // GUARDAR LA CANTIDAD DE PRODUCTOS
        localStorage.setItem("cantidadCesta", sumaTotalCantidades);

    }

}



if (localStorage.getItem('paginaEnvio') == 0) {
    var precioCarritoCompra = $(".cuerpoCarrito .precioCarritoCompra span");
    var cantidadItem = $(".cuerpoCarrito .cantidadItem");
    var costoEnvio = $(".cuerpoCarrito .cantidadItem");
    for (var i = 0; i < precioCarritoCompra.length; i++) {
        var precioCarritoCompraArray = $(precioCarritoCompra[i]).html();
        var cantidadItemArray = $(cantidadItem[i]).val();
        var idProductoArray = $(cantidadItem[i]).attr("idProducto");
        var envioItem = parseFloat($(costoEnvio[i]).attr("costoenvio"));
        $(".subTotal" + idProductoArray).html('<strong>MXN $<span>' + Number(cantidadItemArray * precioCarritoCompraArray + envioItem).toFixed(2) + '</span></strong>');
        sumaSubtotales();
        cestaCarrito(precioCarritoCompra.length);
    }
}



/*=============================================
CHECKOUT
=============================================*/
$("#btnCheckout").click(function () {

    //Cada vez que le den click al boton checkout se va a limpiar la lista productos y que pueda traer de nuevo la lista de carrito
    $(".listaProductos table.tablaProductos tbody").html("");

    $(".listaProductos table.tablaProductos tbody")

    var idUsuario = $(this).attr("idUsuario");

    var peso = $(".cuerpoCarrito button, .comprarAhora button");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra, .comprarAhora .tituloCarritoCompra");
    var cantidad = $(".cuerpoCarrito .cantidadItem, .comprarAhora .cantidadItem");
    var subtotal = $(".cuerpoCarrito .subtotales span, .comprarAhora .subtotales span");
    var tipoArray = [];
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
    for (var i = 0; i < titulo.length; i++) {

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

        function sumaArrayPeso(total, numero) {
            return total + numero;
        }

        var sumaTotalPeso = cantidadPeso.reduce(sumaArrayPeso);

        /*=============================================
            MOSTRAR PRODUCTOS DEFINITIVOS A COMPRAR
        =============================================*/

        $(".listaProductos table.tablaProductos tbody").append(
            '<tr>' +
            '<td class="valorTitulo">' + tituloArray + '</td>' +
            '<td class="valorCantidad">' + cantidadArray + '</td>' +
            '<td>MXN $ <span class="valorItem" valor="' + subtotalArray + '">' + subtotalArray + '</span></td>' +
            '<tr>'
        );

        /*=============================================
                  SELECCIONAR PAIS DE ENVÍO SI 
                       HAY PRODUCTO FISICO
        =============================================*/
        tipoArray.push($(cantidad[i]).attr("tipo"));

        function checkTipo(tipo) {

            return tipo == "fisico";
        }
    }
    /*=============================================
                EXISTEN PRODUCTO FISICO
    =============================================*/
    if (tipoArray.find(checkTipo) == "fisico") {

        $(".formEnvio").show();

        $(".btnPagar").attr("tipo", "fisico");

        $.ajax({

            url: rutaFrontEnd + "vistas/js/plugins/countries.json",
            type: "GET",
            cache: false,
            contentType: false,
            dataType: "json",
            success: function (respuesta) {
                respuesta.forEach(seleccionarPais);

                function seleccionarPais(item, index) {

                    var pais = item.name;
                    var codPais = item.code;
                    $("#seleccionarPais").append('<option value="' + codPais + '">' + pais + '</option>');
                }
            }

        })

        /*=============================================
                    EVALUAR TASAS DE ENVIO
                      A PRODUCTOS FISICOS
        =============================================*/
        $("#seleccionarPais").change(function () {

            $(".alerta").remove();

            var pais = $(this).val();
            var tasaPais = $("#tasaPais").val();

            if (pais == tasaPais) {

                //Nesecito multiplicar la tasa de envio nacional por la cantidad de kg del producto
                var resultadoPeso = Number(sumaTotalPeso * $("#envioNacional").val());
                //Valor de tasa minima
                var valorTasaMin = Number($("#tasaMinimaNal").val());

                //si el resultado peso es menos a la tasa minima nacional
                if (resultadoPeso < $("#tasaMinimaNal").val()) {
                    //Mantenemos el valor de la tasa de envio
                    $(".valorTotalEnvio").html(valorTasaMin.toFixed(2));

                }
                else {
                    $(".valorTotalEnvio").html(resultadoPeso.toFixed(2));
                }

            }
            //Ejecuta la funcion de sumar el total de la compra
            sumaTotalCompra();

        })

    }
    else {
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

function sumaTotalCompra() {

    var sumaTotalTasas =
        Number($(".valorSubtotal").html()) +
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
$(".btnPagar").click(function () {

    var tipo = $(this).attr("tipo");

    if (tipo == "fisico" && $("#seleccionarPais").val() == "") {

        $(".btnPagar").after('<span class="alerta"><br><div class="alert alert-warning">No ha seleccionado el país de Envío</div></span>');

        return;

    }

})

$.ajax({
    method: "GET",
    url: rutaFrontEnd + 'ajax/direcciones.php',
})
    .done(function (response) {

        data = JSON.parse(response);

        if (data.error) {
            $(".direcciones").append(`
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    ${data.error}
                </div>
            </div>`);
        }

        if (typeof data.direcciones != 'undefined') {
            data.direcciones.forEach(function (item) {

                // AGREGAMOS CADA UNA DE LAS DIRECCIONES DEL USUARIO
                $(".direcciones").append(`
                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <input type="radio" class="input-direccion" name="inputDireccion" value="${item.id}" colonia="${item.colonia}" cp="${item.cp}" estado="${item.estado}" municipio="${item.municipio}" calle="${item.calle}" numext="${item.numext}" numint="${item.numint}" checked>
                            DIRECCION
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>Colonia</label>
                                    <input type="text" class="form-control" readonly value="${item.colonia}">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>Estado</label>
                                    <input type="text" class="form-control" readonly value="${item.estado}">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>Municipio</label>
                                    <input type="text" class="form-control" readonly value="${item.municipio}">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>CP</label>
                                    <input type="text" class="form-control" readonly value="${item.cp}">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>Calle</label>
                                    <input type="text" class="form-control" readonly value="${item.calle}">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>Num. exterior</label>
                                    <input type="text" class="form-control" readonly value="${item.numext}">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 mt-2">
                                    <label>Num. interior</label>
                                    <input type="text" class="form-control" readonly value="${item.numint}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);

                // GUARDAMOS LA DIRECCIÓN DE ENVÍO ACTUAL
                direccionEnvio = [];
                direccionEnvio.push({
                    "id": item.id,
                    "colonia": item.colonia,
                    "cp": item.cp,
                    "estado": item.estado,
                    "municipio": item.municipio,
                    "calle": item.calle,
                    "colonia": item.colonia,
                    "numext": item.numext,
                    "numint": item.numint
                });
                
                
                // SI NO ES LA PAGINA PARA REALIZAR EL ENVÍO, ALMACENAMOS LA ULTIMA DIRECCIÓN
                if (localStorage.getItem('paginaEnvio') == 0) {
                    localStorage.setItem("direccionEnvio", JSON.stringify(direccionEnvio));
                }

            });
        }

        // AGREGAMOS CADA UNA DE LAS DIRECCIONES DEL USUARIO
        $(".direcciones").append(`
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="radio">
                        <label><input type="radio" class="recoleccionPersonal" name="inputDireccion" value="-1">
                            <span>Recoger en Zapata Camiones Aeropuerto</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>`);

        if (typeof data.direcciones === 'undefined') {
            $('.recoleccionPersonal').prop('checked', true)
            if (localStorage.getItem('paginaEnvio') != 1) {
                localStorage.setItem("direccionEnvio", JSON.stringify(null));
            }
        }

    });


$(document).on('click', '.recoleccionPersonal', function () {
    const direcionId = "no";

    // ACTUALIZAMOS LA DIRECCION EN EL LOCAL STORAGE

    direccionEnvio = [];
    direccionEnvio.push({
        "id": direcionId,
        "colonia": null
    });

    if (localStorage.getItem('paginaEnvio') != 1) {
        localStorage.setItem("direccionEnvio", JSON.stringify(null));
    }

    // REALIZAMOS UNA NUEVA COTIZACION PARA LA NUEVA DIRECCION
    $('.cuerpoCarrito').html('');
    showProducts(direcionId);

    sumaSubtotales();

})

$(document).on('click', '.input-direccion', function () {
    const direcionId = $(this).val();

    // ACTUALIZAMOS LA DIRECCION EN EL LOCAL STORAGE

    direccionEnvio = [];
    direccionEnvio.push({
        "id": $(this).val(),
        "colonia": $(this).attr('colonia'),
        "cp": $(this).attr('cp'),
        "estado": $(this).attr('estado'),
        "municipio": $(this).attr('municipio'),
        "calle": $(this).attr('calle'),
        "numext": $(this).attr('numext'),
        "numint": $(this).attr('numint')
    });

    if (localStorage.getItem('paginaEnvio') != 1) {
        localStorage.setItem("direccionEnvio", JSON.stringify(direccionEnvio));
    }

    // REALIZAMOS UNA NUEVA COTIZACION PARA LA NUEVA DIRECCION
    $('.cuerpoCarrito').html('');
    showProducts(direcionId);

    sumaSubtotales();

})

/*===============================================================*/
/*===============================================================*/
$(".datosFacturacion").click(function () {
    swal(
        {
            title: "FACTURACIÓN",
            text: "¿Desea usted facturar su compra?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si. ¡Deseo Factura!",
            cancelButtonText: "No deseo Facturar.",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if(isConfirm){
                swal("Muy bien", "Dirijase a Perfil > Facturación para llenar los datos correspondientes.","success");
                setTimeout(function(){
                    window.location = rutaFrontEnd + "perfil";
                },2000);
            }
            else{
                swal("OK", "Continue con su compra","success");
                setTimeout(function(){
                    window.location = rutaFrontEnd + "proceder-pago";
                },2000);
            }
        }
    );
    
    /*swal({
        title: "¡Faltan Datos de Facturación!",
        text: "Favor de registrar sus datos en la sección Perfil para continuar con la compra.",
        type: "warning",
        showCancelButton: false,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Cerrar",
        closeOnConfirm: false
    },
        function (isConfirm) {
            if (isConfirm) {
                window.location = rutaFrontEnd + "perfil";
            }
        }
    );
    return;*/
})
