
$(function() {
	fjComboGeneral("Estado");
	$("#cmbMunicipio").attr("disabled" , true);

	// cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbEstado").change(function() {
		// habilita el combo hijo
		$("#cmbMunicipio").attr("disabled" , false);
		$("#cmbMunicipio").val(""); // deselecciona el campo del combo
		$("#hidMunicipio").val(""); // blanquea el campo del hidden
		fjComboGeneral("Municipio" , "Estado");

		$("#cmbParroquia").val(""); // deselecciona el campo del combo
		$("#hidParroquia").val(""); // blanquea el campo del hidden
		$("#cmbParroquia").attr("disabled" , true); // desabilita el combo de 3er nivel
	});

	$("#cmbParroquia").attr("disabled" , true);

	// cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbMunicipio").change(function() {
		// habilita el combo de 2do nivel
		$("#cmbParroquia").attr("disabled" , false);
		$("#cmbParroquia").val(""); // deselecciona el campo del combo
		$("#hidParroquia").val(""); // blanquea el campo del hidden
		fjComboGeneral("Parroquia" , "Municipio");
	});

	fjComboGeneral("Pregunta" , "" , "Pregunta1");
	fjComboGeneral("Pregunta" , "" , "Pregunta2");
});


// Función para recuperar la contraseña
function enviar(pvValor) {
	let arrFormulario = "#formCompletarRegistro";
	let vsUsuario = $(arrFormulario + " #ctxUsuario");
	let vsFecha = $(arrFormulario + " #datFechaNac");
	let vsPregunta = $(arrFormulario + " #cmbPregunta");
	let vsPregunta2 = $(arrFormulario + " #cmbPregunta2");
	let vsClave = $(arrFormulario + " #pswClave");
	let vsClave2 = $(arrFormulario + " #pswClave2");
	let vsRespuesta = $(arrFormulario + " #ctxRespuesta");
	let vsRespuesta2 = $(arrFormulario + " #ctxRespuesta2");
	let vbComprobar = true; //variable javascript Comprobar, verificar que todo este true o un solo false no envía

	if (pvValor === "recuperar") {
		//si el Usuario está VACIO
		if (vsUsuario.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				text: 'EL USUARIO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsUsuario.focus();
			});
			return vbComprobar;
		}

		//la funcion tiene 2 parametros, Fecha de Nacimineto es obligatorio y fecha minima de edad (17 por defecto)
		let arrEdad = fjEdadMinima(vsFecha.value); //devuelve un arreglo con 2 valores
		// la posicion 0 con una cadena "menor" o "mayor", y la posicion 1 con la edad
		//console.log(arrEdad + " arreglo de edad ");

		if (arrEdad[2] == "menor") {
			vbComprobar = false;
			swal({
					title: '¡Atención!',
					html: 'LA EDAD INTRODUCIDA (' + arrEdad[0] + '), ES MENOR A LA ' +
						'PERMITIDA <br /> Por favor introduzca una edad minima (' +
						arrEdad[1] + ') valida para ' + pvValor.toUpperCase() ,
					type: 'info',
					confirmButtonText: 'Ok'
			}).then((result) => {
				vsFecha.focus();
			});
			return vbComprobar; //rompe la función para que el usuario verifique antes de continuar
		}

		//si la respuesta está vacía
		if (vsPregunta.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'DEBE SELECCIONAR LA PREGUNTA DE SEGURIDAD <br /> De la cual ' +
					'usted previamente registro ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsPregunta.focus();
			});
			return vbComprobar;
		}
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
		if (vsPregunta2.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'DEBE SELECCIONAR LA PREGUNTA DE SEGURIDAD <br /> De la cual ' +
					'usted previamente registro ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsPregunta2.focus();
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
		$("#formCompletarRegistro #operacion").val(pvValor); //valor.vista.Opcion del hidden
		//console.log($(arrFormulario + " #operacion"));
		arrFormulario.submit(); //Envía el formulario
	}
}
