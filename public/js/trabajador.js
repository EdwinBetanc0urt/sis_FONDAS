

var lsVista = "Trabajador";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar( pvValor ) {
	let arrFormulario = $( "#form" + lsVista );
	let viCodigo = $( "#form" + lsVista + " #numId");
	let viCedula = $( "#form" + lsVista + " #numCi");
	let vsNombre = $( "#form" + lsVista + " #ctxNombre");
	let vsFecha = $( "#form" + lsVista + " #datFechaIngreso" );
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía
/*
	if ( pvValor === "Registrar" || pvValor === "Modificar" ) {
		//si el cod está vació y el botón pulsado es igual a Registrar o Modificar no enviara el formulario
		if ( $.trim( viCedula.val() ) === "" ) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA CEDULA ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then( ( result ) => {
				viCedula.focus(); //enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}


		if ( $.trim( vsFecha.val() ) == "" ) {
			vbComprobar = false;
			//alert(" LA FECHA DE NACIMIENTO ES OBLIGATORIO \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atencion!',
				html: 'LA FECHA DE INGRESO ES OBLIGATORIA <br /> No puede estar vacía para ' + pvValor.toUpperCase() ,
				type: 'info',
				confirmButtonText: 'Ok'
			}).then( ( result ) => {
				vsFecha.focus();
			});
			return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
		}

	}
*/

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if ( vbComprobar ) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}



$(function () {

	fjMostrarLista( lsVista );

	$("#cmbCargo").attr("disabled" , true);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbDepartamento").change(function() {
		//habilita el combo hijo
		$("#cmbCargo").attr( "disabled" , false );
		$("#cmbCargo").val(""); //deselecciona el campo del combo
		//$("#hidCargo").val(""); //blanquea el campo del hidden
		fjComboGeneral( "Cargo" , "Departamento" );
	});


	if ( $("#hidCargo").val() != "" ) {
		$("#cmbCargo").attr("disabled" , false);
		viTemporal = $("#hidCargo").val(); //guarda el valor que trajo el GET
		fjComboGeneral( "Cargo" , "Departamento" ); //carga (y blanquea) el combo

		$("#hidCargo").val( viTemporal ) ; //reasigna el valor
		console.log( $("#hidCargo").val() + ", codigo del Cargo con el GET" );
	}
	else {
		console.log( "el hid del Cargo esta vacio" );
	}
});




function fjNuevoRegistro( ) {
	$("#form" + lsVista )[0].reset();

	$("#form" + lsVista + " #numCi").attr( "readonly" ,  false);
	fjUltimoID( lsVista );

    fjComboGeneral( "Tipo_Usuario" );
	fjComboGeneral( "Departamento" );
	fjComboGeneral( "Cargo" );
	fjComboGeneral( "Jornada" );

	if ( $( "#Registrar") ) {
		$( "#Registrar" ).css( "display" , "" );
	}

	if ( $( "#Modificar") ) {
		$( "#Modificar" ).css( "display" , "none" );
	}

	if ( $( "#Borrar") ) {
		$( "#Borrar" ).css( "display" , "none" );
	}

	if ( $( "#Restaurar") ) {
		$( "#Restaurar" ).css( "display" , "none" );
	}
}
function fjEditarRegistro( ) {
	if ( $( "#Registrar") ) {
		$( "#Registrar" ).css( "display" , "none" );
	}

	if ( $( "#Modificar") ) {
		$( "#Modificar" ).css( "display" , "" );
	}

	if ( $( "#Borrar") ) {
		$( "#Borrar" ).css( "display" , "" );
	}

	if ( $( "#Restaurar") ) {
		$( "#Restaurar" ).css( "display" , "none" );
	}
}





function fjSeleccionarRegistro( pvDOM ) {
    console.log( pvDOM );
    
    if ( jQuery.isFunction( pvDOM.attr ) )
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if ( typeof pvDOM.getAttribute !== 'undefined' )
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM
    
    console.log( arrFilas );

	$("#form" + lsVista + " #numCi").attr( "readonly" ,  true);

    $( "#form" + lsVista + " #hidEstatus" ).val( arrFilas[1].trim() );
    $( "#form" + lsVista + " #numId" ).val(  parseInt( arrFilas[2].trim() ) );
    $( "#form" + lsVista + " #hidNacionalidad" ).val( arrFilas[3].trim() );
    $( "#form" + lsVista + " #cmbNacionalidad" ).val( arrFilas[3].trim() );
    $( "#form" + lsVista + " #numCi" ).val( arrFilas[4].trim() );
    $( "#form" + lsVista + " #ctxNombre" ).val( arrFilas[5].trim() );
    $( "#form" + lsVista + " #ctxApellido" ).val( arrFilas[6].trim() );
    $( "#form" + lsVista + " #numTelefono" ).val( arrFilas[7].trim() );
    $( "#form" + lsVista + " #ctxCorreo" ).val( arrFilas[8].trim() );
    $( "#form" + lsVista + " #datFechaIngreso" ).val( arrFilas[9].trim() );

    $( "#form" + lsVista + " #hidTipo_Usuario" ).val( arrFilas[10].trim() );
    fjComboGeneral( "Tipo_Usuario" );

    $( "#form" + lsVista + " #hidDepartamento" ).val( arrFilas[12].trim() );
    fjComboGeneral( "Departamento" );

    $( "#form" + lsVista + " #hidCargo" ).val( arrFilas[14].trim() );
	fjComboGeneral( "Cargo" , "Departamento" );
	
	$( "#form" + lsVista + " #hidJornada").val( arrFilas[16].trim() );
    fjComboGeneral( "Jornada" );

	$("#cmbNacionalidad > option").attr("selected", false);
	$("#cmbNacionalidad > option[value="+ arrFilas[3].trim().toLowerCase() +"]").attr("selected", true);
	$('#cmbNacionalidad').val(arrFilas[3].trim().toLowerCase()).trigger('change'); 

	console.log(arrFilas[3].trim().toLowerCase());
    $( "#operacion" ).val( arrFilas[0].trim() );

    if ( arrFilas[1].trim() === "activo" ) {
		if ( $( "#Registrar") )
			$( "#Registrar" ).css( "display" , "none" );

		if ( $( "#Modificar") )
			$( "#Modificar" ).css( "display" , "" );

		if ( $( "#Borrar") )
			$( "#Borrar" ).css( "display" , "" );

		if ( $( "#Restaurar") )
			$( "#Restaurar" ).css( "display" , "none" );
    }
    //anulado o cerrado
    else {
		if ( $( "#Registrar") )
			$( "#Registrar" ).css( "display" , "none" );

		if ( $( "#Modificar") )
			$( "#Modificar" ).css( "display" , "none" );

		if ( $( "#Borrar") )
			$( "#Borrar" ).css( "display" , "none" );

		if ( $( "#Restaurar") )
			$( "#Restaurar" ).css( "display" , "" );
    }

    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}