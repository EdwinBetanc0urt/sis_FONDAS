
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
    limpiarValores();
    if(jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if(typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM

    $("#btnHabilitar").attr('disabled', false);

    // $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + lsVista + " #numId").val(parseInt(arrFilas[1].trim()));
    $("#form" + lsVista + " #ctxNombre").val(
        arrFilas[2].trim() + ' ' + arrFilas[3].trim()
    );

    $("#form" + lsVista + " #ctxEntrada1").val(arrFilas[4].trim());
    $("#form" + lsVista + " #ctxSalida1").val(arrFilas[5].trim());
    $("#form" + lsVista + " #ctxEntrada2").val(arrFilas[6].trim());
    $("#form" + lsVista + " #ctxSalida2").val(arrFilas[7].trim());
    $("#form" + lsVista + " #ctxNota1").val(arrFilas[8].trim());
    $("#form" + lsVista + " #ctxNota2").val(arrFilas[9].trim());
    $("#form" + lsVista + " #ctxNota3").val(arrFilas[10].trim());
    $("#form" + lsVista + " #ctxNota4").val(arrFilas[11].trim());
    $("#form" + lsVista + " #ctxObservacion").val(arrFilas[12].trim());

    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}

function limpiarValores() {
    $("#form" + lsVista + " #ctxEntrada1").val('');
    $("#form" + lsVista + " #ctxSalida1").val('');
    $("#form" + lsVista + " #ctxEntrada2").val('');
    $("#form" + lsVista + " #ctxSalida2").val('');
    $("#form" + lsVista + " #ctxNota1").val('');
    $("#form" + lsVista + " #ctxNota2").val('');
    $("#form" + lsVista + " #ctxNota3").val('');
    $("#form" + lsVista + " #ctxNota4").val('');
    $("#form" + lsVista + " #ctxObservacion").val('');
}

function enviar() {
    let entrada1 = $('#ctxEntrada1').val();
    let salida1 = $('#ctxSalida1').val();
    let entrada2 = $('#ctxEntrada2').val();
    let salida2 = $('#ctxSalida2').val();
    let nota1 = $('#ctxNota1');
    let nota2 = $('#ctxNota2');
    let nota3 = $('#ctxNota3');
    let nota4 = $('#ctxNota4');
    let comprobar = true;

    if (entrada1.trim() == '' && nota1.val().trim() == '') {
        swal({
            title: '¡Atención!:',
            html: 'La hora de la primera entrada esta vacia, por favor agregue una nota.',
            footer: 'La nota debe estar relacionada solo a la primera hora de entrada.',
            type: 'info',
            showCloseButton: true,
            confirmButtonText: 'Ok'
        })
        .then(() => {
            nota1.focus()
        })
        nota1.focus()
        return;
    }
    if (salida1.trim() == '' && nota2.val().trim() == '') {
        swal({
            title: '¡Atención!:',
            html: 'La hora de la primera salida esta vacia, por favor agregue una nota.',
            footer: 'La nota debe estar relacionada solo a la primera hora de salida.',
            type: 'info',
            showCloseButton: true,
            confirmButtonText: 'Ok'
        })
        .then(() => {
            $('#ctxNota2').focus()
        })
        $('#ctxNota2').focus()
        return;
    }
    if (entrada2.trim() == '' && nota3.val().trim() == '') {
        swal({
            title: '¡Atención!:',
            html: 'La hora de la segunda entrada esta vacia, por favor agregue una nota.',
            footer: 'La nota debe estar relacionada solo a la segunda hora de entrada.',
            type: 'info',
            showCloseButton: true,
            confirmButtonText: 'Ok'
        })
        .then(() => {
            $('#ctxNota3').focus()
        })
        $('#ctxNota3').focus()
        return;
    }
    if (salida2.trim() == '' && nota4.val().trim() == '') {
        swal({
            title: '¡Atención!:',
            html: 'La hora de la segunda salida esta vacia, po favor agregue una nota.',
            footer: 'La nota debe estar relacionada solo a la segunda hora de salida.',
            type: 'info',
            showCloseButton: true,
            confirmButtonText: 'Ok'
        })
        .then(() => {
            $('#ctxNota4').focus()
        })
        $('#ctxNota4').focus()
        return;
    }
    // Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
    if (comprobar) {
		$("#form" + lsVista + " #operacion").val('ajustar'); //valor.vista.Opcion del hidden
		$("#form" + lsVista).submit(); //valor.vista.Opcion del hidden
	}
}
