

var lsVista = "Usuario";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar( pvValor ) {
	let arrFormulario = $( "#form" + lsVista );
	let viCodigo = document.getElementById("numId");
	let viCedula = document.getElementById("numCi");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registrar o Modificar no enviara el formulario
	if ( pvValor === "Registrar" || pvValor === "Modificar" ) {
		if (viCedula.value.trim() === "" ) {
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
	}

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if ( vbComprobar ) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}



$(function () {

	fjMostrarLista( lsVista );

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbDepartamento").change(function() {
		$("#cmbCargo").attr("disabled" , false);
		$("#cmbCargo").val(""); //deselecciona el campo del combo
		$("#hidCargo").val(""); //blanquea el campo del hidden
		//fjCargarMunicipio();
		fjComboGeneral( "Cargo" , "Departamento" );
	});

});




function fjNuevoRegistro( ) {
	$("#form" + lsVista )[0].reset();
	fjUltimoID( lsVista );

	fjComboGeneral( "Tipo_Usuario" );
	fjComboGeneral( "Departamento" );

	$( "#cmbCargo" ).attr( "disabled" , true );

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

    $("#btnHabilitar").attr( 'disabled' , false );

    $( "#form" + lsVista + " #hidEstatus" ).val( arrFilas[1].trim() );
    $( "#form" + lsVista + " #numId" ).val(  parseInt( arrFilas[2].trim() ) );
    $( "#form" + lsVista + " #numCI" ).val( arrFilas[3].trim() );

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



function bloquear( piId ) {
	swal({
		title: '¡Atención!',
		html: "Va a bloquear el usuario" ,
		type: 'error',
		confirmButtonText: 'Ok',
		showCloseButton: true
	}).then( ( result ) => {
		if ( result.value )
			enviousuario( piId , "Bloqueo");
		else if ( result.dismiss ) {
			return;
		}
	});
}

function desbloquear( piId ) {

	swal({
		title: '¡Atención!',
		html: "Va a desbloquear el usuario" ,
		type: 'error',
		confirmButtonText: 'Ok',
		showCloseButton: true
	}).then( ( result ) => {
		if ( result.value )
			enviousuario( piId , "Desbloqueo");
		else if ( result.dismiss ) {
			return;
		}
	});
}



function enviousuario( piId , psEstatus = "Desbloqueo" ) {

    vsRuta = "controlador/con" + lsVista + ".php";

    $.post( vsRuta , {
            operacion: psEstatus ,
            numUsuario: parseInt( piId )
        },
        function( resultado ) {
		console.log( resultado );
            if ( resultado == false )
                console.log("sin consultas de " + psClase);
            else {
            	swal({
					title: '¡Atención!',
					html: "El usuario ha sido <b>" + psEstatus.toUpperCase() + "</b> con exito" ,
					type: 'error',
					confirmButtonText: 'Ok',
					showCloseButton: true
				});
				fjMostrarLista( lsVista );
            }
        }
    );
}

function veraccesos( piUsuario, piAncho = 700, piAlto = 800 ) {

	var vjUrl="pdf/repAccesosUsuario.php?usuario="+piUsuario; //Maestra seleccionada

	var posicion_x=(screen.width/2)-(piAncho/2); //posicion horizontal en la pantalla
	var posicion_y=(screen.height/2)-(piAlto/2); //posicion vertical en la pantalla

	//document.getElementById("vvOpcion").value = pvValor; //valor.vista.Opcion del hidden
	//Crea una ventana donde muestra todos los listar de las diversas maestras
	window.open(vjUrl,'Listado de Accesos', 'width='+parseInt(piAncho),  'height='+parseInt(piAlto), 'left='+posicion_x,'top='+posicion_y, 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=yes' );
	//if (window.focus) {newwindow.focus()}

}