
var lsVista = "Cambiar_Clave";

$(function() {
	ObtenerPreguntas();
	ObtenerPreguntas(2);
});

// funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor) {
	let clave = $("#pswClaveN, .new-password"),
		clave2 = $("#pswClaveNConfirma, .confirm-password");
	let arrFormulario = $("#formCambiarClave");
	let vsRespuesta1 = document.getElementById("ctxRespuesta1");
	let vsRespuesta2 = document.getElementById("ctxRespuesta2");
	let vbComprobar = true; // verifica que todo este true o un solo false no envía

	if (pvValor === "Guardar" ) {
		if (vsRespuesta1.value.trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>"
					+ pvValor.toUpperCase() + "</b>",
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then((result) => {
				vsRespuesta1.focus(); // enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
		if (vsRespuesta2.value.trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>"
					+ pvValor.toUpperCase() + "</b>",
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then((result) => {
				vsRespuesta2.focus(); // enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	}
	if (clave.val() !== clave2.val()) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: "Las claves no coinciden, debe ser corregido antes de <b>"
				+ pvValor.toUpperCase() + "</b>",
			type: 'error',
			confirmButtonText: 'Ok',
			showCloseButton: true
		});
		return false;
	}

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
} // cierre de la función enviar
