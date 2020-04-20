class CotizadorEstafetaService{

    static async cotizar(item, direccionId){

        console.log(item)

        const response = await $.ajax({
            method: "GET",
            url: rutaFrontEnd + 'ajax/costoEnvio.php',
            data: { id: item.idProducto, direccionId: direccionId, cantidad: item.cantidad }
        });

        costoEnvio = JSON.parse( response );

        if( parseFloat(item.precio) > 5500.00 ){
            costoEnvio.costoEnvio = 0
        }

        if( parseFloat(item.precio) > 2500.00 ){
            costoEnvio.costoEnvio = costoEnvio.costoEnvio / 2
        }

        console.log('costoEnvio', costoEnvio);
        return costoEnvio;

    }

}