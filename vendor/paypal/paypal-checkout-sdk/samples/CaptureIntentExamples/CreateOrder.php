<?php

namespace Sample\CaptureIntentExamples;

require __DIR__.'/../../../../autoload.php';
require_once __DIR__ . '/../../../../../frontend/modelos/productos.modelo.php';


use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class CreateOrder
{
    
    /**
     * Setting up the JSON request body for creating the Order. The Intent in the
     * request body should be set as "CAPTURE" for capture intent flow.
     * 
     */
    private static function buildRequestBody($data)
    {
        $productos = [];
        $total = 0.0;
        foreach ($data as $item) {
            $producto = \ModeloProductos::mdlGetProducto($item['idProducto']);
            if ($producto !== "error") {
                $productos[] = [
                    'name'=>$producto['titulo'],
                    'description'=>$producto['descripcion'],
                    'unit_amount'=> array(
                        'currency_code' => 'MXN',
                        'value' =>strval($producto['precio']),
                    ),
                    'quantity'=> $item['cantidad'],
                    'category'=> 'PHYSICAL_GOODS',
                ];
                $total += (floatval($item['cantidad']) * floatval($producto['precio']));
            }
        }

        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => 'http://localhost/ProyectoZAeropuerto/frontend/proceder-pago',
                    'cancel_url' => 'http://localhost/ProyectoZAeropuerto/frontend/',
                    'brand_name' => 'ZAPATA INC',
                    'locale' => 'es-MX',
                    'landing_page' => 'BILLING',
                    'shipping_preferences' => 'SET_PROVIDED_ADDRESS',
                    'user_action' => 'PAY_NOW',
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'reference_id' => 'PUHF', //Se agrega por nosotros en caso de hacer un PATH (Actualizacion a la orden)
                            'description' => 'Compra en Zapata Camiones Aeropuero online',
                            'custom_id' => 'CUST-ZapataCamiones', // Para conciliar las transacciones de clientes con trasancciones de paypal es dado por nosotros
                            //'soft_descriptor' => 'ZapataCamiones', Se ocupa en el caso de pago de tarjeta de credito.
                            'amount' =>
                                array(
                                    'currency_code' => 'MXN',
                                    'value' => strval($total),
                                    'breakdown' => 
                                        array(
                                            'item_total' =>
                                                array(
                                                    'currency_code' => 'MXN',
                                                    'value' => strval($total),
                                                ),
                                        ),
                                ),
                            'items' => $productos,
                            // 'shipping' => //Envio
                            //     array(
                            //         'method' => 'United States Postal Service',
                            //         'name' =>
                            //             array(
                            //                 'full_name' => 'John Doe',
                            //             ),
                            //         'address' =>
                            //             array(
                            //                 'address_line_1' => '123 Townsend St',
                            //                 'address_line_2' => 'Floor 6',
                            //                 'admin_area_2' => 'San Francisco',
                            //                 'admin_area_1' => 'CA',
                            //                 'postal_code' => '94107',
                            //                 'country_code' => 'US',
                            //             ),
                            //     ),
                        ),
                ),
        );
    }

    /**
     * This is the sample function which can be sued to create an order. It uses the
     * JSON body returned by buildRequestBody() to create an new Order.
     */
    public static function createOrder($debug=false,$data)
    {
        try{
            $request = new OrdersCreateRequest();
            $request->headers["prefer"] = "return=representation";
            $request->body = self::buildRequestBody($data);
            // $p = self::buildRequestBody($data);
            // return $p;

            $client = PayPalClient::client();
            
            $response = $client->execute($request);
        } catch(Exception $e){
            echo json_encode($e,JSON_PRETTY_PRINT);
        }
        if ($debug)
        {
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach($response->result->links as $link)
            {
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            // To toggle printing the whole response body comment/uncomment below line
            echo json_encode($response, JSON_PRETTY_PRINT), "\n";
        }


        return $response;
    }
}


/**
 * This is the driver function which invokes the createOrder function to create
 * an sample order.
 */
// if (!count(debug_backtrace()))
// {
//     CreateOrder::createOrder(true);
// }



