
$(function () {
	
	fjComboGeneral( "Estado" );

	$("#cmbMunicipio").attr("disabled" , true);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbEstado").change(function() {
		//habilita el combo hijo
		$("#cmbMunicipio").attr( "disabled" , false );
		$("#cmbMunicipio").val(""); //deselecciona el campo del combo
		$("#hidMunicipio").val(""); //blanquea el campo del hidden
		//fjCargarMunicipio();
		fjComboGeneral( "Municipio" , "Estado" );

		$("#cmbParroquia").val(""); //deselecciona el campo del combo
		$("#hidParroquia").val(""); //blanquea el campo del hidden
		$("#cmbParroquia").attr( "disabled" , true ); //desabilita el combo de 3er nivel
	});


	$("#cmbParroquia").attr( "disabled" , true );

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbMunicipio").change(function() {
		//habilita el combo de 2do nivel
		$("#cmbParroquia").attr("disabled" , false);
		$("#cmbParroquia").val(""); //deselecciona el campo del combo
		$("#hidParroquia").val(""); //blanquea el campo del hidden
		//fjCargarMunicipio();
		fjComboGeneral( "Parroquia" , "Municipio" );
	});


	fjComboGeneral( "Pregunta" , "" , "Pregunta1" );

	fjComboGeneral( "Pregunta" , "" , "Pregunta2");

});	


/*

		if ( $.trim( vsFecha.val() ) == "" ) {
			vbComprobar = false;
			//alert(" LA FECHA DE NACIMIENTO ES OBLIGATORIO \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA FECHA DE NACIMIENTO ES OBLIGATORIO <br /> No puede estar vacía para ' + pvValor.toUpperCase() ,
				type: 'info',
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsFecha.focus();
			});
			return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
		}
		//la funcion tiene 2 parametros, Fecha de Nacimineto es obligatorio y fecha minima de edad (17 por defecto)
		let arrEdad = fjEdadMinima( vsFecha.val() ); //devuelve un arreglo con 2 valores
		// la posicion 0 con una cadena "menor" o "mayor", y la posicion 1 con la edad
			console.log( arrEdad + " arreglo de edad ");

		if ( arrEdad[2] == "menor" ) {
			vbComprobar = false;
			//alert(" LA EDAD INTRODUCIDA (" + arrEdad[0] + "), ES MENOR A LA PERMITIDA \n Por favor introduzca una edad minima (" + arrEdad[1] + ") valida para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA EDAD INTRODUCIDA (' + arrEdad[0] + '), ES MENOR A LA PERMITIDA <br /> Por favor introduzca una edad minima (' + arrEdad[1] + ') valida para ' + pvValor.toUpperCase() ,
				type: 'info',
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsFecha.focus();
			});
			return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
		}



*/



//Funcion para recuperar la contraseña
function enviar( pvValor ) {
    let arrFormulario = "#formCompletarRegistro";
    let vsUsuario = $( arrFormulario + " #ctxUsuario" );
    let vsFecha = $( arrFormulario + " #datFechaNac" );
    let vsPregunta = $( arrFormulario + " #cmbPregunta" );
    let vsPregunta2 = $( arrFormulario + " #cmbPregunta2" );
    let vsClave = $( arrFormulario + " #pswClave" );
    let vsClave2 = $( arrFormulario + " #pswClave2" );
    let vsRespuesta = $( arrFormulario + " #ctxRespuesta" );
    let vsRespuesta2 = $( arrFormulario + " #ctxRespuesta2" );
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	if ( pvValor === "recuperar" ) {	
		
		//si el Usuario está VACIO
		if ( vsUsuario.val() == "" ) {
			vbComprobar=false;
			//alert("EL USUARIO ES OBLIGATORIO, NO PUEDE ESTAR VACIO");
			swal({
				title: '¡Atención!',
				text: 'EL USUARIO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsUsuario.focus();
			});
			return vbComprobar;
		}

		//la funcion tiene 2 parametros, Fecha de Nacimineto es obligatorio y fecha minima de edad (17 por defecto)
		let arrEdad = fjEdadMinima( vsFecha.value ); //devuelve un arreglo con 2 valores
		// la posicion 0 con una cadena "menor" o "mayor", y la posicion 1 con la edad
		console.log(arrEdad + " arreglo de edad ");

		if ( arrEdad[2] == "menor" ) {
			vbComprobar = false;
			//alert(" LA EDAD INTRODUCIDA (" + arrEdad[0] + "), ES MENOR A LA PERMITIDA \n Por favor introduzca una edad minima (" + arrEdad[1] + ") valida para " + pvValor.toUpperCase());
			swal({
					title: '¡Atencion!',
					html: 'LA EDAD INTRODUCIDA (' + arrEdad[0] + '), ES MENOR A LA PERMITIDA <br /> Por favor introduzca una edad minima (' + arrEdad[1] + ') valida para ' + pvValor.toUpperCase() ,
					type: 'info',
					confirmButtonText: 'Ok'
			}).then((result) => {
				vsFecha.focus();
			});
			return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
		}

		//si la respuesta está vacía
		if ( vsPregunta.val() == "" ) {
			vbComprobar = false;
			//alert(" LA RESPUESTA ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atención!',
				html: 'DEBE SELECCIONAR LA PREGUNTA DE SEGURIDAD <br /> De la cual usted previamente registro ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsPregunta.focus();
			});
			return vbComprobar;
		}

		//si la respuesta está vacía
		if ( vsRespuesta.val() == "" ) {
			vbComprobar = false;
			//alert(" LA RESPUESTA ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA RESPUESTA ES OBLIGATORIA <br> Por su seguridad debe colocar la respuesta correcta ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsRespuesta.focus();
			});
			return vbComprobar;
		}

		//si la respuesta está vacía
		if ( vsPregunta2.val() == "" ) {
			vbComprobar = false;
			//alert(" LA RESPUESTA ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atención!',
				html: 'DEBE SELECCIONAR LA PREGUNTA DE SEGURIDAD <br /> De la cual usted previamente registro ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsPregunta2.focus();
			});
			return vbComprobar;
		}
		//si la respuesta está vacía
		if ( vsRespuesta2.val() == "" ) {
			vbComprobar = false;
			//alert(" LA RESPUESTA ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA RESPUESTA ES OBLIGATORIA <br> Por su seguridad debe colocar la respuesta correcta ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsRespuesta2.focus();
			});
			return vbComprobar;
		}

		//si el pswClave está vació no enviara el formulario
		if ( vsClave.val().trim() == "" ) {
			vbComprobar = false;
			//alert(" LA CLAVE ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA CLAVE ES OBLIGATORIA <br> No puede estar vacía ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsClave.focus();
			});
			return vbComprobar;
		}
		//si el pswClave está vació no enviara el formulario
		else if ( vsClave2.val().trim() == "" ) {
			vbComprobar = false;
			//alert(" LA CLAVE ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA CLAVE ES OBLIGATORIA <br> No puede estar vacía ' ,
				type: 'info',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsClave2.focus();
			});
			return vbComprobar;
		}
		else {
			vbComprobar = valida_clave();
		}

	}
		
	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if ( vbComprobar ) {
		$( "#formCompletarRegistro #operacion" ).val( pvValor ); //valor.vista.Opcion del hidden
		console.log( $( arrFormulario + " #operacion" ) );
		//$( "#formCompletarRegistro" ).submit(); //Envía el formulario
		//arrFormulario.submit(); //Envía el formulario
	}
}





//funcion.javascript.Enviar (parametro.vista.Valor)
function valida_clave () {

    let arrFormulario = "#formCompletarRegistro";
    let vsClave = $( arrFormulario + " #pswClave" );
    let vsClave2 = $( arrFormulario + " #pswClave2" );
	let vbComprobar = true; // letiable boleana Comprobar, para verificar que todo este true o un solo false no envía

	//si el ctxNombre está vació
	if ( vsClave.val().trim() === "" ) {
		vbComprobar = false;
		swal({
			title: '¡Atencion!',
			html: 'LA CLAVE ES OBLIGATORIA <br /> No puede estar vacía ' ,
			type: 'info',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			vsClave.focus();
		});
		vjClave.focus(); //enfoca el cursor en el campo que falta del formulario
		return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
	}

	
	if ( vsClave.val().trim().length <= 4 ) {
		vbComprobar = false;
		swal({
			title: '¡Atencion!',
			html: 'La clave debe ser mayor o igual a 5 caracteres. Ejemplos:<br>     abcde<br>        12345<br>        a1b2c' ,
			type: 'info',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			vsClave.focus();
		});
		return vbComprobar;
	}
	if ( vsClave.val().trim().length >= 25 ) {
		vbComprobar = false;
		swal({
			title: '¡Atencion!',
			html: 'La clave debe ser menor o igual a 25 caracteres. Ejemplos:<br>     abcde<br>        12345<br>        a1b2c' ,
			type: 'info',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			vsClave.focus();
		});
		return vbComprobar;
	}
	
	if ( vsClave2.val().trim() === "" ) {
		vbComprobar = false;
		alert(" LA CONFIRMACIÓN DE CLAVE ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
		vsClave2.focus(); //enfoca el cursor en el campo que falta del formulario
		return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
	}

	if ( vsClave.val().trim() != vsClave2.val().trim() ) {
		vbComprobar = false;
		swal({
			title: '¡Atencion!',
			html: 'LAS CLAVES NO COINCIDEN, Verifique ' ,
			type: 'info',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			vsClave.focus();
		});
		vsClave.val( "" ); //se limpia la primera clave
		vsClave2.val( "" ); //se limpia la clave de confirmacion
		vsClave2.focus(); //enfoca el cursor en el campo que falta del formulario
		return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
	}

	return vbComprobar;
}


function salir( psRuta = "" ){
	swal({   
		html: "¿Está seguro que quiere salir?",  
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55", 
		confirmButtonText: "Aceptar!",   
		cancelButtonText: "Cancelar!",   
		showCloseButton: true
	}).then( (result ) => {
		if (result.value ) {
			location.href= psRuta + "controlador/conCerrar.php";
		}
		else if (result.dismiss) {
			swal({
				html: "Espere en 5 segundos!",
				text: "¡Gracias por permanecer en la página!",
				timer: 5000,
				showConfirmButton: false
			});
		}
	});
}
