class CotizadorEstafetaService{

    static async cotizar(item, direccionId){

        let porcentajeDescuentoTotal = 0

        const response = await $.ajax({
            method: "GET",
            url: rutaFrontEnd + 'ajax/costoEnvio.php',
            data: { id: item.idProducto, direccionId: direccionId, cantidad: item.cantidad }
        });

        costoEnvio = JSON.parse( response );
        const COSTO_ENVIO_ORIGINAL = costoEnvio.costoEnvio;



        if( parseFloat(item.precio) > 5500.00 ){
            porcentajeDescuentoTotal += 100
        }

        if( parseFloat(item.precio) > 2500.00 ){
            porcentajeDescuentoTotal += 50
        }

        if( !isNaN(item.porcentajeDescuentoEnvio) && (Dates.today() <= item.fechaFinDescuentoEnvio) ){
            porcentajeDescuentoTotal += parseFloat(item.porcentajeDescuentoEnvio)
        }

        if(porcentajeDescuentoTotal >= 100){
            costoEnvio.costoEnvio = 0
        }else{
            costoEnvio.costoEnvio = costoEnvio.costoEnvio - costoEnvio.costoEnvio * porcentajeDescuentoTotal / 100
        }

        
        // console.log('CotizadorEstafetaService', {
        //     COSTO_ENVIO_ORIGINAL,
        //     costoEnvio: costoEnvio.costoEnvio,
        //     porcentajeDescuentoTotal
        // });

        return costoEnvio;

    }

}

class Dates{
    static today(){
        let today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        const yyyy = today.getFullYear();

        // today = mm + '/' + dd + '/' + yyyy;
        today = yyyy + '-' + mm + '-' + dd;
        return today;
    }
}