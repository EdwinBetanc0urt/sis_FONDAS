
$(function() {
	fjComboGeneral("Estado");
	$("#cmbMunicipio").attr("disabled", true);

	// cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbEstado").change(function() {
		// habilita el combo hijo
		$("#cmbMunicipio").attr("disabled", false);
		$("#cmbMunicipio").val(""); // deselecciona el campo del combo
		$("#hidMunicipio").val(""); // blanquea el campo del hidden
		fjComboGeneral("Municipio", "Estado");

		$("#cmbParroquia").val(""); // deselecciona el campo del combo
		$("#hidParroquia").val(""); // blanquea el campo del hidden
		$("#cmbParroquia").attr("disabled", true); // desabilita el combo de 3er nivel
	});

	$("#cmbParroquia").attr("disabled", true);

	// cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbMunicipio").change(function() {
		// habilita el combo de 2do nivel
		$("#cmbParroquia").attr("disabled", false);
		$("#cmbParroquia").val(""); // deselecciona el campo del combo
		$("#hidParroquia").val(""); // blanquea el campo del hidden
		fjComboGeneral("Parroquia", "Municipio");
	});

	fjComboGeneral("Pregunta", "", "Pregunta1");
	fjComboGeneral("Pregunta", "", "Pregunta2");
});

// Función para recuperar la contraseña
function enviar() {
	let arrFormulario = "#formCompletarRegistro";
	let nombre = $(arrFormulario + " #ctxNombre");
	let apellido = $(arrFormulario + " #ctxApellido");
	let sexo = $(arrFormulario + " #cmbSexo");
	let estadoCivil = $(arrFormulario + " #cmbEdoCivil");
	let fecha = $(arrFormulario + " #datFechaNac");
	let celular = $(arrFormulario + " #numTelefono");
	let direccion = $(arrFormulario + " #ctxDireccion");
	let estado = $(arrFormulario + " #cmbEstado");
	let municipio = $(arrFormulario + " #cmbMunicipio");
	let parroquia = $(arrFormulario + " #cmbParroquia");
	let vsPregunta = $(arrFormulario + " #cmbPregunta1");
	let vsPregunta2 = $(arrFormulario + " #cmbPregunta2");
	let vsRespuesta = $(arrFormulario + " #ctxRespuesta1");
	let vsRespuesta2 = $(arrFormulario + " #ctxRespuesta2");
	let vsClave = $(arrFormulario + " #pswClave");
	let vsClave2 = $(arrFormulario + " #pswClave2");
	let vbComprobar = true; //variable javascript Comprobar, verificar que todo este true o un solo false no envía

	//si el Usuario está VACIO
	if (nombre.val().trim() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL NOMBRE ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			nombre.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (apellido.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL APELLIDO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			apellido.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (sexo.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL SEXO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			sexo.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (estadoCivil.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL ESTADO CIVIL ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			estadoCivil.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (fecha.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'LA FECHA DE NACIMIENTO ES OBLIGATORIA, NO PUEDE ESTAR VACIA',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			fecha.focus();
		});
		return vbComprobar;
	}
	//la funcion tiene 2 parametros, Fecha de Nacimineto es obligatorio y fecha minima de edad (17 por defecto)
	let arrEdad = fjEdadMinima(fecha.val()); //devuelve un arreglo con 2 valores
	if (arrEdad[2] == "menor") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'LA EDAD INTRODUCIDA (' + arrEdad[0] + '), ES MENOR A LA ' +
				'PERMITIDA <br /> Por favor introduzca una edad minima (' +
				arrEdad[1] + ') valida.',
			type: 'info',
			confirmButtonText: 'Ok'
		}).then((result) => {
			fecha.focus();
		});
		return vbComprobar; //rompe la función para que el usuario verifique antes de continuar
	}

	//si el Usuario está VACIO
	if (celular.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL CELULAR ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			celular.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (direccion.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'LA DIRECCION ES OBLIGATORIA, NO PUEDE ESTAR VACIA',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			direccion.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (estado.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL ESTADO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			estado.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (municipio.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'EL MUNICIPIO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			municipio.focus();
		});
		return vbComprobar;
	}

	//si el Usuario está VACIO
	if (parroquia.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			text: 'LA PARROQUIA ES OBLIGATORIA, NO PUEDE ESTAR VACIA',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			parroquia.focus();
		});
		return vbComprobar;
	}

	//si la respuesta está vacía
	if (vsPregunta.val() == "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'DEBE SELECCIONAR LA PREGUNTA DE SEGURIDAD <br /> De la cual ' +
				'usted previamente registro ',
			type: 'info',
			showCloseButton: true,
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
				'la respuesta correcta ',
			type: 'info',
			showCloseButton: true,
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
				'usted previamente registro ',
			type: 'info',
			showCloseButton: true,
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
				'la respuesta correcta ',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			vsRespuesta2.focus();
		});
		return vbComprobar;
	}

	vbComprobar = validarClave();

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#formCompletarRegistro #operacion").val('Guardar'); //valor.vista.Opcion del hidden
		//console.log($(arrFormulario + " #operacion"));
		$(arrFormulario).submit(); //Envía el formulario
	}
}
