

var lsVista = "Motivo_Reposo";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor) {
	let arrFormulario = $("#form" + lsVista);
	let viCodigo = document.getElementById("numId");
    let vsNombre = document.getElementById("ctxNombre");
    let vsCantidad_Dias = document.getElementById("ctxCantidad_Dias");
        
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registar o Modificar no enviara el formulario
	if (vsNombre.value.trim() === "" &&(pvValor === "Incluir" || pvValor === "Modificar")) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>",
			type: 'error',
			confirmButtonText: 'Ok',
			showCloseButton: true
		}).then((result) => {
			vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}


	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if(vbComprobar) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}



$(function () {

	fjMostrarLista(lsVista);

});




function fjNuevoRegistro() {
	$("#form" + lsVista)[0].reset();
	fjUltimoID(lsVista);
	if($("#Registar")) {
		$("#Registar").css("display", "");
	}

	if($("#Modificar")) {
		$("#Modificar").css("display", "none");
	}

	if($("#Borrar")) {
		$("#Borrar").css("display", "none");
	}

	if($("#Restaurar")) {
		$("#Restaurar").css("display", "none");
	}
}
function fjEditarRegistro() {
	if($("#Registar")) {
		$("#Registar").css("display", "none");
	}

	if($("#Modificar")) {
		$("#Modificar").css("display", "");
	}

	if($("#Borrar")) {
		$("#Borrar").css("display", "");
	}

	if($("#Restaurar")) {
		$("#Restaurar").css("display", "none");
	}
}






function fjSeleccionarRegistro(pvDOM) {
    console.log(pvDOM);
    
    if(jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if(typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM
    
    console.log(arrFilas);

    $("#btnHabilitar").attr('disabled', false);

    $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + lsVista + " #numId").val( parseInt(arrFilas[2].trim()));
    $("#form" + lsVista + " #ctxNombre").val(arrFilas[3].trim());
    $("#form" + lsVista + " #ctxCantidad_Dias").val(arrFilas[4].trim());

    $("#operacion").val(arrFilas[0].trim());

    if(arrFilas[1].trim() === "activo") {
		if($("#Registar"))
			$("#Registar").css("display", "none");

		if($("#Modificar"))
			$("#Modificar").css("display", "");

		if($("#Borrar"))
			$("#Borrar").css("display", "");

		if($("#Restaurar"))
			$("#Restaurar").css("display", "none");
    }
    //anulado o cerrado
    else {
		if($("#Registar"))
			$("#Registar").css("display", "none");

		if($("#Modificar"))
			$("#Modificar").css("display", "none");

		if($("#Borrar"))
			$("#Borrar").css("display", "none");

		if($("#Restaurar"))
			$("#Restaurar").css("display", "");
    }

    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}