
var lsVista = "Supervisar_Asistencias";

$(function() {
    $("#ctxFechaInicio")
        .attr('max', clientDateTime('d'))
        .on('change', function() {
            $("#ctxFechaFin")
                .val(null)
                .attr('min', this.value);
        });

    $("#ctxFechaFin").attr('max', clientDateTime('d'));
	fjMostrarLista(lsVista);
	fjMostrarLista(lsVista, '', '', '', 'listaInasistente');
});

function fjSeleccionarRegistro(pvDOM) {
    if(jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if(typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM

    $("#btnHabilitar").attr('disabled', false);

    // $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    // $("#form" + lsVista + " #numId").val( parseInt(arrFilas[2].trim()));
    // $("#form" + lsVista + " #ctxNombre").val(arrFilas[3].trim());

    // $("#form" + lsVista + " #hidEstado").val(arrFilas[4].trim());
    // fjComboGeneral("Estado");

    // $("#operacion").val(arrFilas[0].trim());
}
