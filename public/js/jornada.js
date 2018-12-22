

var lsVista = "Jornada";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor) {
	let arrFormulario = $("#form" + lsVista);
	let viCodigo = $( "#form" + lsVista + " #numId");
	let vsNombre = $( "#form" + lsVista + " #ctxNombre");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía


	//console.log (vsEntrada.value.trim());

	//si el cod está vació y el botón pulsado es igual a Registar o Modificar no enviara el formulario
	if (vsNombre.val().trim() === "" && (pvValor === "Incluir" || pvValor === "Modificar")) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
			type: 'error',
			confirmButtonText: 'Ok',
			showCloseButton: true
		}).then((result) => {
			vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}


	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {				
		$( "#form" + lsVista + " #operacion").val(pvValor);
		arrFormulario.submit(); //Envía el formulario
	}
}



$(function () {
	fjMostrarLista(lsVista);
	$("#numTurnos").on("change, input", function(){
		if (this.value > 2 ) {
			this.value = 2;
		}
		else {
			this.value = 1;
		}

		if (this.value == 2){
			$("#ctxHoraEntrada2, #ctxHoraSalida2").attr("disabled", false);
		}
		else {
			$("#ctxHoraEntrada2, #ctxHoraSalida2").attr("disabled", true);
		}
	});
});



function fjNuevoRegistro() {
	$("#form" + lsVista)[0].reset();
	fjUltimoID(lsVista);
	$("#ctxHoraEntrada2, #ctxHoraSalida2").attr("disabled", true);

	//$("#form" + lsVista)[0].reset();
	//if ($(".chkDias").length > 0 ) {
		$(".chkDias").attr("checked", false);
	//}
    fjCargarDias();
	if ($("#Registar")) {
		$("#Registar").css("display" , "");
	}

	if ($("#Modificar")) {
		$("#Modificar").css("display" , "none");
	}

	if ($("#Borrar")) {
		$("#Borrar").css("display" , "none");
	}

	if ($("#Restaurar")) {
		$("#Restaurar").css("display" , "none");
	}
}
function fjEditarRegistro() {
	if ($("#Registar")) {
		$("#Registar").css("display" , "none");
	}

	if ($("#Modificar")) {
		$("#Modificar").css("display" , "");
	}

	if ($("#Borrar")) {
		$("#Borrar").css("display" , "");
	}

	if ($("#Restaurar")) {
		$("#Restaurar").css("display" , "none");
	}
}



function fjSeleccionarRegistro(pvDOM) {
    console.log(pvDOM);
    
    if (jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if (typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM

    console.log(arrFilas);

    $("#btnHabilitar").attr('disabled', false);

    $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + lsVista + " #numId").val( parseInt(arrFilas[2].trim()));
    $("#form" + lsVista + " #ctxNombre").val(arrFilas[3].trim());
	$("#form" + lsVista + " #numTurnos").val(arrFilas[4].trim());
	$("#form" + lsVista + " #ctxHoraEntrada1").val(arrFilas[5].trim());
	$("#form" + lsVista + " #ctxHoraSalida1").val(arrFilas[6].trim());
	$("#form" + lsVista + " #ctxHoraEntrada2").val(arrFilas[7].trim());
	$("#form" + lsVista + " #ctxHoraSalida2").val(arrFilas[8].trim());
	$("#form" + lsVista + " #ctxObservacion").val(arrFilas[9].trim());

	setTimeout(function() {
		fjCargarDias(parseInt(arrFilas[2].trim()));
	}, 1000);


    $("#operacion").val(arrFilas[0].trim());

    if (arrFilas[1].trim() === "activo") {
		if ($("#Registar"))
			$("#Registar").css("display", "none");

		if ($("#Modificar"))
			$("#Modificar").css("display", "");

		if ($("#Borrar"))
			$("#Borrar").css("display", "");

		if ($("#Restaurar"))
			$("#Restaurar").css("display", "none");
    }
    //anulado o cerrado
    else {
		if ($("#Registar"))
			$("#Registar").css("display", "none");

		if ($("#Modificar"))
			$("#Modificar").css("display", "none");

		if ($("#Borrar"))
			$("#Borrar").css("display", "none");

		if ($("#Restaurar"))
			$("#Restaurar").css("display", "");
    }

    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}



function fjCargarDias(piJornada = ""){
	if (piJornada != "")
		$("#numId").val(piJornada);

    $.post("controlador/conJornada.php" , {
            operacion: "ListaDias" ,
            numId: $("#numId").val() 
        },
        function(resultado) {
            if (resultado == false)
                console.log("sin consultas de " + lsVista);
            else {
                $( "#form" + lsVista + " #divListaDias" ).html( resultado ) ;
                console.log(resultado);
            }
        }
   );
}