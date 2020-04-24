class CarritoComprasService {

    // 
    // 
    // 

    static productos() {
        return this.estaVacio()
            ? []
            : JSON.parse(localStorage.getItem("listaProductos"));
    }

    // 
    // 
    // 

    static estaVacio() {
        return localStorage.getItem("listaProductos") == null
            ? true
            : false;
    }

    // 
    // 
    // 

    static tieneProducto(idProducto) {

        var listaProductos = this.productos();

        for (var i = 0; i < listaProductos.length; i++) {
            if (listaProductos[i]["idProducto"] == idProducto) {
                return true;
            }
        }

        return false;

    }

    // 
    // 
    // 

}