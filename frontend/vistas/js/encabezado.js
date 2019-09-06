/*==============================
            ENCABEZADO
==============================*/

/*Al presionar el boton categorias va a ejecutar la siguiente función, en la que, se obtendra el ancho de la pantalla y ejecutara la siguiente condición: Si el ancho masximo de la pantalla es de 767 px, la caja categoria aparecerá debajo de la caja boton categoria, si no es así, aparecerá la caja categorias debajo de la caja encabezado de forma rapida.*/
$("#btnCategorias").click(function(){
    if(window.matchMedia("(max-width: 767px)").matches){
        $("#btnCategorias").after($("#categorias").slideToggle("fast"))
    }
    else{
        $("#encabezado").after($("#categorias").slideToggle("fast"))
    }
})