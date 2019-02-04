
$(function() {
	ObtenerPreguntas();
	ObtenerPreguntas(2);
});


// Función para recuperar la contraseña
function enviar(pvValor) {
	let arrFormulario = "#formCambiarClave";
	let vsRespuesta = $(arrFormulario + " #ctxRespuesta1");
	let vsRespuesta2 = $(arrFormulario + " #ctxRespuesta2");
	let vbComprobar = true; // verifica que todo este true o un solo false no envía

	if (pvValor === "Guardar") {
		//si la respuesta está vacía
		if (vsRespuesta.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'LA RESPUESTA ES OBLIGATORIA <br> Por su seguridad debe colocar ' +
					'la respuesta correcta ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsRespuesta.focus();
			});
			return vbComprobar;
		}
		//si la respuesta está vacía
		if (vsRespuesta2.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'LA RESPUESTA ES OBLIGATORIA <br> Por su seguridad debe colocar ' +
					'la respuesta correcta ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsRespuesta2.focus();
			});
			return vbComprobar;
		}

		vbComprobar = validarClave();
	}
	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#formCambiarClave #operacion").val(pvValor); //valor.vista.Opcion del hidden
		//console.log($(arrFormulario + " #operacion"));
		//$("#formCompletarRegistro").submit(); //Envía el formulario
		$(arrFormulario).submit(); //Envía el formulario
	}
}
