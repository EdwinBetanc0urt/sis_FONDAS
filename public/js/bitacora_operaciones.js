
var lsVista = "Bitacora_Operaciones";

$(function () {
	fjMostrarLista(lsVista);
});

function fjSeleccionarRegistro(pvDOM) {
    //debe ser con jquery porque es recibido como tal con jquery
    if(jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|');
    //debe ser con javascript porque es recibido directamete del DOM
    if(typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|');

    $("#form" + lsVista + " #numId").val( parseInt(arrFilas[1].trim()));
    $("#form" + lsVista + " #ctxNombre").val(arrFilas[2].trim());
    $("#form" + lsVista + " #ctxOperacion").val(arrFilas[3].trim());
    $("#form" + lsVista + " #ctxFecha").val(arrFilas[4].trim());
    $("#form" + lsVista + " #txaData").val(arrFilas[5].trim());

    $("#operacion").val(arrFilas[0].trim());
    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}
