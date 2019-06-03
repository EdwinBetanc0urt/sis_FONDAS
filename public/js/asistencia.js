
var lsVista = "Asistencia";
var horario = {
    e1: 8,
    s1: 12,
    e2: 13,
    s2: 14
}

$(function () {
	startTime();
	consultaMarcaje();
	fjMostrarLista(lsVista);
});

function startTime() {
	let today = new Date();
	let h = today.getHours();
	let m = today.getMinutes();
	let s = today.getSeconds();
	m = checkTime(m);
	s = checkTime(s);
	//document.getElementById('divReloj').innerHTML = h + ":" + m + ":" + s;
	document.getElementById('ctxTiempoMarcaje').value = h + ":" + m + ":" + s;
	document.getElementById('hidHora').value = h;
	document.getElementById('hidMinuto').value = m;
	setTimeout(startTime, 500);
}

function checkTime(i) {
	if (i < 10) {
		i = "0" + i
	};  // add zero in front of numbers < 10
	return i;
}

function enviar() {
    let campo;
    let hora = $("#hidHora").val();
    let minuto = $("#hidMinuto").val();
    let tiempo = zeroPad(hora) + ':' + zeroPad(minuto);

    let entrada1 = $('#chkEntrada1').is(':checked');
    let salida1 = $('#chkSalida1').is(':checked');
    let entrada2 = $('#chkEntrada2').is(':checked');
    let salida2 = $('#chkSalida2').is(':checked');

    let comprobar = true;

    // turno de la mañana
    if (tiempo >= '06:45' && tiempo <= '12:30') {
        if (!entrada1 && tiempo >= '06:45' && tiempo <= '07:30') {
            campo = "entrada1";
        }
        else if (!entrada1 && tiempo > '07:30' && tiempo < '12:00') {
            comprobar = false
            swal({
                title: '¡Atención!:',
                html: 'Ha perdidido la entrada para el turno de la mañana.',
                footer: 'Por favor regrese en el turno de la tarde.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            })
            return comprobar;
        }
        else if (entrada1 && !salida1 && tiempo >= '06:45' && tiempo <= '12:30') {
            campo = "salida1";
        }
        else if (entrada1 && salida1 && tiempo > '06:45' && tiempo < '12:30') {
            comprobar = false
            swal({
                title: '¡Atención!:',
                html: 'Ya tiene marcada una entrada y una salida en este turno.',
                footer: 'Por favor regrese en el turno de la tarde.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            })
            return comprobar;
        }
    }
    // turno de la tarde
    else if (tiempo >= '12:45' && tiempo <= '17:30') {
        if (!entrada2 && tiempo >= '12:45' && tiempo <= '13:30') {
            campo = "entrada2";
        }
        else if (!entrada2 && tiempo > '13:30' && tiempo < '17:30') {
            comprobar = false
            swal({
                title: '¡Atención!:',
                html: 'Ha perdidido la entrada para el turno de la tarde.',
                footer: 'Por favor regrese mañana en su primer turno.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            })
            return comprobar;
        }
        else if (entrada2 && !salida2 && tiempo >= '12:45' && tiempo <= '17:30') {
            campo = "salida2";
        }
        else if (entrada2 && salida2 && tiempo >= '12:45' && tiempo <= '17:30') {
            comprobar = false
            swal({
                title: '¡Atención!:',
                html: 'Ya tiene marcada una entrada y una salida en este turno.',
                footer: 'Por favor regrese en el siguiente turno.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            })
            return comprobar;
        }
    }
    // horario fuera de jornada
    else {
        comprobar = false
        swal({
            title: '¡Atención!:',
            html: 'No esta en su rango de jornada laboral.',
            footer: 'Por favor regrese y marque cuando este dentro de su horario.',
            type: 'warning',
            showCloseButton: true,
            confirmButtonText: 'Ok'
        })
        return comprobar;
    }
    	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
    if (comprobar) {
		$("#form" + lsVista + " #operacion").val('marcar'); //valor.vista.Opcion del hidden
        $("#form" + lsVista + " #campo").val(campo); //valor.vista.Opcion del hidden
		$("#form" + lsVista).submit(); //valor.vista.Opcion del hidden
	}
}


function consultaMarcaje() {
    limpiarCheck();

    let arrFormulario = $('#form' + lsVista);
	$("#form" + lsVista + " #operacion").val('consulta'); //valor.vista.Opcion del hidden
    $.ajax({
        method: "POST",
        url: arrFormulario.attr("action"),
        data: arrFormulario.serialize()
    })
    .done(function (arrRespuesta) {
        if (arrRespuesta.datos.entrada1 && String(arrRespuesta.datos.entrada1).trim() != '') {
            $('#chkEntrada1')
                .prop('checked', true)
                .attr('checked', true);
        }
        if (arrRespuesta.datos.salida1 && String(arrRespuesta.datos.salida1).trim() != '') {
            $('#chkSalida1')
                .prop('checked', true)
                .attr('checked', true);
        }
        if (arrRespuesta.datos.entrada2 && String(arrRespuesta.datos.entrada2).trim() != '') {
            $('#chkEntrada2')
                .prop('checked', true)
                .attr('checked', true);
        }
        if (arrRespuesta.datos.salida2 && String(arrRespuesta.datos.salida2).trim() != '') {
            $('#chkSalida2')
                .prop('checked', true)
                .attr('checked', true);
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        swal({
            title: 'Estatus: ' + textStatus,
            html: 'La petición para <b>' + pvValor.toUpperCase() + '</b> no ha sido procesada correctamente',
            type: 'error',
            showCloseButton: true,
            confirmButtonText: 'Ok',
            footer: '<b>Error http:</b> ' + errorThrown + " / " + jqXHR.status
        }).then((result) => {
            vsDescripcion.focus();
        });
        //$("#resultado").html("Se ha producido un error y no se han podido procesar los datos");
    });
}



function limpiarCheck() {
    $('#chkEntrada1, #chkSalida1, #chkEntrada2, #chkSalida2')
        .prop('checked', false)
        .attr('checked', false);
}
