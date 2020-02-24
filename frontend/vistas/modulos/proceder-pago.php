<?php

require_once __DIR__ . '/../modelos/compras.modelo.php';

$url = Ruta::ctrRuta();
$servidor = Ruta::ctrRutaServidor();

//disable-card=visa,mastercard

echo ModeloCompras::mdlGetCompras();

?>
<script>
    localStorage.setItem("paginaEnvio", 1);
</script>
<script src="https://www.paypal.com/sdk/js?client-id=<?php if (getenv('PAYPAL_SANDBOX_CLIENT_ID')) {
                                                            echo getenv('PAYPAL_SANDBOX_CLIENT_ID');
                                                        } else {
                                                            echo getenv('CLIENT_ID');
                                                        } ?>&currency=MXN&disable-card=visa,mastercard,amex"></script>
<!--=====================================
BREADCRUMB CARRITO DE COMPRAS
======================================-->

<div class="container-fluid well well-sm">

    <div class="container">

        <div class="row">

            <ul class="breadcrumb fondoBreadcrumb text-uppercase">

                <li><a href="<?php echo $url;  ?>">Inicio</a></li>
                <li class="active pagActiva"><?php echo $rutas[0] ?></li>

            </ul>


        </div>

    </div>

</div>

<!--=====================================
			BOTÓN CHECKOUT
======================================-->
<?php
if (isset($_SESSION["validarSesion"])) {

    $url = Ruta::ctrRuta();

    if ($_SESSION["validarSesion"] == "ok") {
        $idUsuario = $_SESSION["idUsuario"];



        $usuarioTemp = $_SESSION["idUsuario"];

        $compruebaFacturacion = ModeloCarrito::mdlComprobarDatosFacturacion($idUsuario, "facturacion");

        $user = ModeloUsuarios::mdlMostrarUsuario("usuarios", $idUsuario, $idUsuario);

        if ($compruebaFacturacion != false) {
        } else {
            $datos = [
                'idUsuario' => $idUsuario,
                'nombreRazon' => $user["nombre"],
                'rfc' => "XAXX010101000",
                'tipoPersona' => "Fisica",
                'calle' => "Carretera Los Reyes Lechería Km 23",
                'numExterior' => "0",
                'numInterior' => "0",
                'colonia' => "La Magdalena Panoaya",
                'municipio' => "Texcoco",
                'estado' => "Estado de México",
                'codigoPostal' => "56200",
                'telefono' => "5959549933",
                'email' => "jmolina@zapata.com.mx"
            ];

            $factTemp = ModeloUsuarios::mdlAgregarFacturacion("facturacion", $datos);
        }
        $FacturacionUser=ModeloUsuarios::mdlMostrarDatosFacturacion('facturacion', $idUsuario);
    }
}
?>

<!--=====================================
TABLA CARRITO DE COMPRAS
======================================-->

<div class="container-fluid">

    <div class="container">

        <!-- DIRECCIONES DEL USUARIO -->
        <div class="row direccionesResumen">

        </div>


        <!-- .......................... -->

        <div class="panel panel-default">

            <!--=====================================
			CABECERA CARRITO DE COMPRAS
			======================================-->

            <div class="panel-heading cabeceraCarrito">

                <div class="col-md-4 col-sm-7 col-xs-12 text-center">

                    <h3>
                        <small>Producto</small>
                    </h3>

                </div>

                <div class="col-md-2 col-sm-1 col-xs-0 text-center">

                    <h3>
                        <small>Precio</small>
                    </h3>

                </div>

                <div class="col-sm-2 col-xs-0 text-center">

                    <h3>
                        <small>Cantidad</small>
                    </h3>

                </div>

                <div class="col-sm-2 col-xs-0 text-center">

                    <h3>
                        <small>Envío</small>
                    </h3>

                </div>

                <div class="col-sm-2 col-xs-0 text-center">

                    <h3>
                        <small>Subtotal</small>
                    </h3>

                </div>

            </div>

            <!--=====================================
			CUERPO CARRITO DE COMPRAS
			======================================-->

            <div class="panel-body cuerpoCarrito">



            </div>

            <!--=====================================
			SUMA DEL TOTAL DE PRODUCTOS
			======================================-->

            <div class="panel-body sumaCarrito">

                <div class="col-md-4 col-sm-6 col-xs-12 pull-right well">

                    <div class="col-xs-6">

                        <h4>TOTAL:</h4>

                    </div>

                    <div class="col-xs-6">

                        <h4 class="sumaSubTotal">

                            <strong>MXN $<span id="totalCompra">0.00</span></strong>

                        </h4>

                    </div>

                </div>

            </div>

            <!--=====================================
			BOTÓN CHECKOUT
			======================================-->

            <!-- <div class="panel-heading cabeceraCheckout">

				<?php

                if (isset($_SESSION["validarSesion"])) {

                    $url = Ruta::ctrRuta();

                    if ($_SESSION["validarSesion"] == "ok") {

                        $idUsuario = $_SESSION["idUsuario"];
                        $existeDatosFacturacion = new ControladorCarrito();
                        $existeDatosFacturacion->ctrComprobarDatosFacturacion();
                    }
                } else {
                    // echo'
                    // <a href="#modalIngreso" data-toggle="modal">
                    //     <button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button>
                    // </a>
                    // ';
                }


                ?>
				
			</div> -->

        </div>

        <!-- .......................... -->

        <p class="text-primary">Para activar el botón de pago, es necesario aceptar las politicas de términos y condiciones</p>
        <div class="panel panel-default">
            <div class="panel-heading">
                <small>
                    <center>TERMINOS Y CONDICIONES</center>
                </small>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel panel-body">
                                <div class="form-check">
                                    <input type="checkbox" class="politicas form-check-input" id="input-terminos">
                                    <label class="form-check-label" for="input-terminos">
                                        He leído y acepto los <a href="#">términos y condiciones.</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="panel panel-default" id="componente-realizar-pago" style="display: none;">

            <!--=====================================
			CABECERA CARRITO DE COMPRAS
			======================================-->

            <div class="panel-heading cabeceraCarrito ">

                <p class="text-center">REALIZAR PAGO</p>
            </div>

            <!--=====================================
			CUERPO CARRITO DE COMPRAS
			======================================-->

            <div class="panel-body">

                <div class="contenidoCheckout">

                    <br>
                    <!-- FORMAS DE PAGO -->
                    <div class="formPago row">

                        <h4 class="text-center well text-muted text-uppercase">Elige una forma de pago</h4>

                        <figure class="col-xs-6 col-xs-offset-3">

                            <center>

                                <input type="radio" id="checkPaypal" name="pago" value="paypal" checked>

                            </center>

                            <div id="paypal-button-container"></div>

                        </figure>
                        <br>
                        <figure class="col-xs-6 col-xs-offset-3">

                            <center>

                                <input type="radio" id="checkBBVA" name="pago" value="BBVA">

                            </center>

                            <!--<img src="<?php echo $url; ?>vistas/img/plantilla/bbva.jpg" alt="" class="img-thumbnail">-->
                            <center>
                                <a href="#modalTransferencia" data-toggle="modal"><button type="button" class="btn btn-warning" style="height: 100%; max-height: 45px; width: 100%; max-width: 498.75px; border-radius:15px 15px 15px 15px;">TRANSFERENCIA ELECTRONICA</button></a>
                            </center>
                            <br>
                            <center>
                                <a href="#modalNetPay" id="botonPagoNetPay"><button type="button" class="btn btn-info" style="height: 100%; max-height: 45px; width: 100%; max-width: 498.75px; border-radius:15px 15px 15px 15px;">PAGO CON NETPAY</button></a>
                            </center>
                        </figure>

                    </div>

                    <br>

                </div>

            </div>


            <!--=====================================
			BOTÓN CHECKOUT
			======================================-->

        </div>

    </div>

    <!--=====================================
    VENTANA MODAL PARA CHECKOUT NETPAY
======================================-->
    <br>
    <br>
    <br>
    <div id="modalNetPay" class="modal fade modalFormulario" role="dialog">


        <div class="modal-content modal-dialog modal-lg">

            <div class="modal-body modalTitulo">

                <h3 class="backColor">PAGO CON NETPAY</h3>

                <button type="button" data-dismiss="modal" class="close">&times;</button>

                <div class="contenidoCheckout">

                    <h4>Puede realizar su pago con transferencia a cualquiera de nuestras cuentas bancarias:</h4>

                    <!-- FORMAS DE PAGO -->
                    <div class="formPago row">

                        <form id="formu" method="POST" target="_blank" style="display: none;">
                            JWT: <input type="text" name="jwt"><br>
                            <input type="submit" value="Submit">
                        </form>
                        <p>Click on the submit button, and the input will be sent to a page on
                            the server called "/action_page.php".</p>

                        <!-- <iframe name="my_iframe" src="not_submitted_yet.aspx" style="width: 100%; height: 1000px"> -->

                        </iframe>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!--=====================================
    VENTANA MODAL PARA CHECKOUT
======================================-->
    <div id="modalTransferencia" class="modal fade modalFormulario" role="dialog">


        <div class="modal-content modal-dialog">

            <div class="modal-body modalTitulo">

                <h3 class="backColor">PAGO CON TRANSFERENCIA</h3>

                <button type="button" data-dismiss="modal" class="close">&times;</button>

                <div class="contenidoCheckout">

                    <h4>Puede realizar su pago con transferencia a cualquiera de nuestras cuentas bancarias:</h4>

                    <!-- FORMAS DE PAGO -->
                    <div class="formPago row">

                        <h4 class="text-center well text-muted text-uppercase">BBVA Bancomer</h4>

                        <figure class="col-xs-6">

                            <center>

                                <img src="<?php echo $servidor; ?>vistas/img/logo-bancomer.jpg" alt="" style="width:100%; max-width:200px; min-width">

                            </center>

                        </figure>

                        <figure class="col-xs-6">

                            <center>

                                <ul>
                                    <li><b>Sucursal:</b> BANCOMER</li>
                                    <li><b>N° de Cuenta:</b> 0191032844</li>
                                    <li><b>CLABE INTERVANCARIA:</b> 012580001910328444</li>
                                    <li><b>Sucursal:</b> 1838</li>
                                </ul>

                            </center>

                        </figure>

                    </div>

                    <br>

                    <div class="formPago row">

                        <h4 class="text-center well text-muted text-uppercase">Banamex</h4>

                        <figure class="col-xs-6">

                            <center>

                                <img src="<?php echo $servidor; ?>vistas/img/logo-citibanamex.png" alt="" style="width:100%; max-width:200px; min-width">

                            </center>


                        </figure>

                        <figure class="col-xs-6">

                            <center>

                                <ul>
                                    <li><b>Sucursal:</b> BANAMEX</li>
                                    <li><b>N° de Cuenta:</b> 4375127</li>
                                    <li><b>CLABE INTERVANCARIA:</b> 002180025843751273</li>
                                </ul>

                            </center>

                        </figure>

                    </div>

                    <br>

                    <div class="formPago row">

                        <h4 class="text-center well text-muted text-uppercase">Datos de la Empresa</h4>

                        <figure class="col-xs-6">

                            <center>

                                <ul>
                                    <li><b>Beneficiario:</b> ZAPATA CAMIONES S.A. DE C.V. (AEROPUERTO)</li>
                                    <li><b>R.F.C.:</b> ZCA861009RX3</li>
                                    <li><b>Dirección:</b> Carretera Los Reyes - Lechería Km. 23 Localidad La Magdalena Panoay, Texcoco Edo. de México.</li>
                                    <li><b>Codigo Postal:</b> 56200</li>
                                </ul>

                            </center>



                        </figure>

                        <figure class="col-xs-6">

                            <center>

                                <ul>
                                    <li><b>Teléfono:</b> 595 106 9120</li>
                                    <li><b>Contacto:</b> José Antonio Molina Botello</li>
                                    <li><b>Email:</b> jmolina@zapata.com.mx</li>
                                    <li><b>Sucursal:</b> 1838</li>
                                </ul>

                            </center>

                        </figure>

                        <div class="clearfix"></div>



                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <p>* Si ya realizó su pago, favor de continuar con el proceso de pago</p>

                <button class="btn btn-block btn-lg btn-default backColor btnPagarTransferencia" id="<?php echo $_SESSION["idUsuario"]; ?>">REALIZAR PAGO</button>

            </div>

        </div>

    </div>

    <!--=====================================
    script 
======================================-->
    <script>
        var direccionEnvio = JSON.parse(localStorage.getItem("direccionEnvio"));

        

        $('#email').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                    url: rutaFrontEnd + 'ajax/checkout.ajax.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        detalles: getItems(),
                        usuario: JSON.stringify(localStorage.getItem("usuario"))
                    },
                })
                .done(function(res) {
                    console.log("success", res);
                })
                .fail(function(err) {
                    console.log("error", err);
                });

        });

        $('.btnPagarTransferencia').on('click', function() {
            $.ajax({
                url: rutaFrontEnd + 'pagoTransferencia.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    detalles: getItems()
                }
            });

        });

        /*OBTENCIÓN DE LA DIRECCIÓN DE ENVIO*/
        function getDireccionEnvio() {
            return JSON.parse(
                localStorage.getItem("direccionEnvio")
            );
        }

        /* OBTENCION DE LOS ELEMENTOS A COMPRAR */
        function getItems() {
            if (localStorage.getItem("listaProductos") != null) {
                let listaCarrito = JSON.parse(localStorage.getItem("listaProductos"));
                let data = [];
                listaCarrito.forEach((item, index) => {
                    data.push({
                        "idProducto": item.idProducto,
                        "titulo": item.titulo,
                        "precio": item.precio,
                        "tipo": item.tipo,
                        "cantidad": item.cantidad,
                        "costoEnvio": item.costoEnvio,
                        "origen": item.origen,
                    });
                });

                console.log('data', JSON.stringify(data));
                return JSON.stringify(data);

            } else {
                $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
                $(".sumaCarrito").hide();
                $(".cabeceraCheckout").hide();
            }
        }

        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'pill',
                size: '55',
                label: 'paypal'
            },
            createOrder: function() {
                return fetch(rutaFrontEnd + 'ajax/checkout.ajax.php', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: getItems()
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    return data.result.id; // Use the same key name for order ID on the client and server
                }).catch(function(except) {
                    return false;
                });
            },
            onApprove: function(data, actions) {
                actions.order.get().then(function(data) {});
                // Capture the funds from the transaction
                return actions.order.capture().then(function(details) {
                    // Show a success message to your buyer
                    console.log('details', details);
                    $.ajax({
                        url: rutaFrontEnd + 'ajax/checkout.ajax.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            detalles: details,
                            usuario: JSON.stringify(localStorage.getItem("usuario")),
                            productos: getItems(),
                            direccion: getDireccionEnvio(),
                            metodo: 'paypal'
                        },
                    }).done(function(res) {
                        console.log("success", res);
                        swal({
                            title: "¡Tu compra ha sido realizada con éxito!",
                            text: "Gracias por preferir a zapata camiones. Se ha enviado un correo a tu cuenta con los detalles de la compra.",
                            type: "success",
                            confirmButtonText: "Aceptar",
                            closeOnConfirm: false
                        }, function(isConfirm) {
                            if (isConfirm) {
                                localStorage.removeItem("listaProductos");
                                localStorage.removeItem("sumaCesta");
                                localStorage.removeItem("cantidadCesta");
                                window.location = rutaFrontEnd;
                            }
                        });
                    }).fail(function(err) {
                        console.log("error", err);
                    });

                    //swal({
                    //title: "Transacción aceptada",
                    //text: "Compra realizada con éxito",
                    //type: "success",
                    //confirmButtonText: "Aceptar",
                    //closeOnConfirm: false
                    //},function(isConfirm){
                    //if (isConfirm) {
                    //localStorage.removeItem("listaProductos");
                    //localStorage.removeItem("sumaCesta");
                    //localStorage.removeItem("cantidadCesta");
                    //window.location = rutaFrontEnd;
                    //} 
                    //});

                });
            },
            onCancel: function(data) {
                window.location = rutaFrontEnd + 'carrito-de-compras';
            },
            onError: function(err) {
                console.log('err', err);
                swal({
                    title: "Ocurrio un error",
                    text: "Favor de intentar de nuevo o más tarde, disculpe las molestias.",
                    type: "warning",
                    confirmButtonText: "¡Cerrar!",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        window.location = rutaFrontEnd;
                    }
                });
            }
        }).render('#paypal-button-container');

        $(document).on('click', '.politicas', function() {
            if ($('#input-terminos').is(':checked')) {
                $('#componente-realizar-pago').show('slow');
            } else {
                $('#componente-realizar-pago').hide('slow');
            }
        });
    </script>

    <script>

        const baseUrl = 'https://ecommerce.netpay.com.mx/gateway-ecommerce';
        const storeIdAcq = '483131';
        const userName = "ecommerce@netpay.com.mx";
        const password = "ec0m12";
        const url2 = "https://ecommerce.netpay.com.mx";

        console.log({
            credenciales: {
                baseUrl,
                storeIdAcq,
                userName,
                password,
                url2
            }
        });

        $(document).ready(function() {

            


            // ===============
            // PAGO CON NETPAY
            // ===============
            
            console.log(baseUrl);

            $.ajax({
                url: `${baseUrl}/v1/auth/login`,
                contentType: 'Application/Json',
                type: 'POST',
                data: `
            {
                "security":
                    {
                        "userName": "${userName}",
                        "password": "${password}"
                    }
            }
            `,
                    success: function(data) {
                        console.log(data.token)

                        // ================================================
                        // PROCESO CUANDO LA COMPRA SE REALIZO EXITOSAMENTE
                        // ================================================

                        $.ajax({
                            url: `${baseUrl}/v1/transaction-report/transaction/${getUrlVars()['transactionToken']}/${storeIdAcq}`,
                            contentType: 'Application/Json',
                            headers: {
                                    'content-Type': "Application/Json",
                                    'Authorization': `Bearer ${data.token}`,
                                },
                            type: 'GET',
                            success: function(detalles) {

                                console.log({
                                    detalles,
                                    status: detalles.transaction.status
                                })

                                // ================================================
                                // GUARDAR COMPRA EN LA BASE DE DATOS SI FUE EXITOSA
                                // ================================================

                                if(detalles.transaction.status == 'DONE'){
                                    $.ajax({
                                    url: rutaFrontEnd + 'ajax/checkout.ajax.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        detalles: detalles,
                                        usuario: JSON.stringify(localStorage.getItem("usuario")),
                                        productos: getItems(),
                                        direccion: getDireccionEnvio(),
                                        metodo: 'netpay'
                                    },
                                    }).done(function(res) {
                                        console.log("success", res);
                                        swal({
                                            title: "¡Tu compra ha sido realizada con éxito!",
                                            text: "Gracias por preferir a zapata camiones. Se ha enviado un correo a tu cuenta con los detalles de la compra.",
                                            type: "success",
                                            confirmButtonText: "Aceptar",
                                            closeOnConfirm: false
                                        }, function(isConfirm) {
                                            if (isConfirm) {
                                                localStorage.removeItem("listaProductos");
                                                localStorage.removeItem("sumaCesta");
                                                localStorage.removeItem("cantidadCesta");
                                                window.location = rutaFrontEnd;
                                            }
                                        });
                                    }).fail(function(err) {
                                        console.log("error", err);
                                    });
                                }else{
                                    swal({
                                        title: "¡Tu compra ha sido rechazada!",
                                        // text: "Gracias por preferir a zapata camiones. Se ha enviado un correo a tu cuenta con los detalles de la compra.",
                                        type: "warning",
                                        confirmButtonText: "Aceptar",
                                        closeOnConfirm: false
                                    });
                                }

                                console.log('Funciona');

                                

                                // =========================
                                // 
                                // ==========================

                                console.log({
                                    'MESSAGE': 'RESPUESTA DE COMPRA',
                                    ruta: rutaFrontEnd + 'ajax/netpay.ajax.php',
                                    data: data,
                                    items: JSON.parse( getItems('listaProductos') ),
                                    usuario: JSON.stringify(localStorage.getItem("usuario"))
                                });

                                
                            }
                        });

                        // =========================

                        datosNetPay = 
                                {
                                    "storeIdAcq": storeIdAcq,
                                    "transType":"Auth",
                                    "promotion":"000000",
                                    "checkout":{
                                        "merchantReferenceCode":"145000494",
                                        "bill":{
                                        "city":"Guadalupe",
                                        "country":"MX",
                                        "firstName":"<?php echo $user["nombre"] ?>",
                                        "lastName":"<?php echo $user["nombre"] ?>",
                                        // "email":"<?php echo $user["email"]; ?>",
                                        "email":"accept@netpay.com.mx",
                                        "phoneNumber":"<?php echo $FacturacionUser[0]["telefono"]; ?>",
                                        "postalCode":"<?php echo $FacturacionUser[0]["codigoPostal"]; ?>",
                                        "state":"<?php echo $FacturacionUser[0]["estado"]; ?>",
                                        "street1":"<?php echo $FacturacionUser[0]["calle"]; ?>",
                                        "street2":"<?php echo $FacturacionUser[0]["calle"]; ?>",
                                        "ipAddress":"127.0.0.1"
                                    },
                                    "ship":{
                                        "city":"Guadalupe",
                                        "country":"MX",
                                        "firstName":"<?php echo $user["nombre"]; ?>",
                                        "lastName":"<?php echo $user["nombre"]; ?>",
                                        "phoneNumber":"<?php echo $FacturacionUser[0]["telefono"]; ?>",
                                        "postalCode":"<?php echo $FacturacionUser[0]["codigoPostal"]; ?>",
                                        "state":"<?php echo $FacturacionUser[0]["estado"]; ?>",
                                        "street1":"<?php echo $FacturacionUser[0]["calle"]; ?>",
                                        "street2":"<?php echo $FacturacionUser[0]["calle"]; ?>",
                                        "shippingMethod":"flatrate_flatrate"
                                    },
                                    "itemList":[
                                        
                                    ],
                                    "purchaseTotals":{
                                    "grandTotalAmount":localStorage.getItem("sumaCesta"),
                                    "currency":"MXN"
                                    },
                                    "merchanDefinedDataList":[
                                    {"id":2,
                                    "value":"Web"},
                                    {"id":4,
                                    "value":"515"},
                                    {"id":5,
                                    "value":"0"},
                                    {"id":6,
                                    "value":"0"},
                                    {"id":7,
                                    "value":"0"},
                                    {"id":9,
                                    "value":"Retail"},
                                    {"id":10,
                                    "value":"3D"},
                                    {"id":11,
                                    "value":"flatrate_flatrate"},
                                    {"id":13,
                                    "value":"N"},
                                    {"id":14,
                                    "value":"Domicilio"},
                                    {"id":"16",
                                    "value":"50000"}
                                    ]
                                    }
                                }
                        
                        productos = JSON.parse(
                            localStorage.getItem('listaProductos')
                        );
                        
                        console.log({
                            datosNetPay:datosNetPay,
                        });

                        productos.forEach( function(producto){
                            datosNetPay.checkout.itemList.push({
                                "id":producto.idProducto,
                                "productSKU":"SKU1",
                                "unitPrice":producto.precio,
                                "productName":producto.titulo,
                                "quantity":producto.cantidad,
                                "productCode":"Tops & Blouses"
                            })
                            // console.log({
                            //     PRODUCTO: producto.idProducto
                            // })
                        } );

                        console.log(datosNetPay.checkout.itemList.push())
                        console.log(datosNetPay)
                        console.log($('#totalCompra').html())

                        $.ajax({
                            url: `${baseUrl}/v2/checkout`,
                            headers: {
                                'content-Type': "Application/Json",
                                'Authorization': `Bearer ${data.token}`,
                            },
                            type: 'POST',
                            data: JSON.stringify(datosNetPay),
                            success: function(data2) {

                                console.log({
                                    datosAlRealizarCompra: data2
                                });

                                const MerchantResponseURL = btoa(window.location.origin + window.location.pathname);
                                console.log(MerchantResponseURL)
                                

                                // const ruta = `http://certificaciones.netpay.com.mx:7092/a-webapp/e-commerce/web-authorizer?checkoutTokenId=${response2.response.checkoutTokenId}`;
                                // const ruta = `http://certificaciones.netpay.com.mx:7092/a-webapp/e-commerce/web-authorizer?checkoutTokenId=${response2.response.checkoutTokenId}&checkoutDetail=true&MerchantResponseURL=${MerchantResponseURL}`;
                                const ruta = `${url2}/a-webapp3/e-commerce/web-authorizer?checkoutTokenId=${data2.response.checkoutTokenId}&checkoutDetail=true&MerchantResponseURL=${MerchantResponseURL}`;

                                console.log({
                                    ruta
                                });

                                $('#formu').attr('action', ruta);
                                // $('#formu').submit();
                            },
                            error: function(err) {
                                // console.log(err)
                            }
                        });

                    },
                    error: function(err) {
                        // console.log(err)
                    }
                });





                $('.cantidadItem').each(function() {
                    $(this).attr('readonly', 'true');
                });

                // MOSTRAMOS LA DIRECCION SELECCIONADA POR EL USUARIO PREVIAMENTE
                if (JSON.parse(localStorage.getItem('direccionEnvio')) != null) {
                    console.log('DIRECCION DE USUARIO', JSON.parse(localStorage.getItem('direccionEnvio')));
                    $('#direccionesResumen').html(`
                <div class="panel panel-default">
                    <div class="panel panel-heading">
                        DIRECCIÓN DE ENVÍO
                    </div>
                    <div class="panel-body" id="direccionEnvioBody">
                        <div class="panel panel-default">
                            ${JSON.parse(localStorage.getItem('direccionEnvio'))[0].colonia}
                        </div>
                    </div>
                </div>`);
                }
            });

            // =====================
            // VALIDAR COMPRA NETPAY
            // =====================

            console.log({
            'VARIABLES URL': getUrlVars()['transactionToken']
        })

        
        

        $(document).on('click', '#botonPagoNetPay', function() {

            // alert(localStorage.getItem("sumaCesta"));

            // console.log(datosNetPay.checkout.purchaseTotals.grandTotalAmount);
            datosNetPay.checkout.purchaseTotals.grandTotalAmount = localStorage.getItem("sumaCesta");
            $('#formu').submit();
        });

        function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

        $(document).ready(function() {});
    </script>