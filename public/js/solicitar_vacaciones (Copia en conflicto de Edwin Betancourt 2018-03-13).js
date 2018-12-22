
var lsVista = "Solicitar_Vacaciones";

$(function () {
	fjMostrarLista( lsVista );
});



//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar( pvValor ) {
	let arrFormulario = $( "#form" + lsVista );
	var viCodigo = document.getElementById("numId");
	var vsFechaIngreso = document.getElementById("ctxFechaIngreso");
	var Periodo = $( "#form" + lsVista + " .periodos" );
	var vsFechaInicio = $( "#form" + lsVista + " #ctxFechaInicio" );
	var vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registrar o Modificar no enviara el formulario
	if ( pvValor === "Registrar" || pvValor === "Modificar"  ) {
		
		if (vsFechaIngreso.value.trim() === "" ) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA Feca de ingreso ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then( ( result ) => {
				vsFechaIngreso.focus(); //enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
		if ( Periodo.length <= 0 || Periodo.is(':checked') == false ) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "Debe seleccionar un periodo vencido <br> si no aparece ningun periodo de año no puede solicitar vacaciones" ,
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
		if (vsFechaInicio.val().trim() === "" ) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA Fecha de inicio de vacaciones es ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then( ( result ) => {
				vsFechaInicio.focus(); //enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}

	} //cierre del condicional si es boton modificar o Incluir

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if ( vbComprobar ) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}



//comprueba si fue seleecionado por lo menos 1 elemento
function fjComprobarRadio() {
	//a = $('.chkBotones').is(':checked').length;
	//console.log( a );
	//if( $('.chkBotones').prop('checked') ) {
	//if( $('.chkBotones').attr('checked') ) {
	if( $('.periodos').is(':checked') ) {
		return true;
	}
	else
		return false;
}

function fjNuevoRegistro( ) {

	$("#form" + lsVista )[0].reset();
	$( "#form" + lsVista + " #divPeriodos" ).html("NO TIENE PERIODOS VENCIDOS" );
	
	fjFechaIngreso();
	fjListaPeriodos();
	fjUltimoID( lsVista );
	if ( $( "#registrar") ) {
		$( "#registrar" ).css( "display" , "" );
	}

	if ( $( "#modificar") ) {
		$( "#modificar" ).css( "display" , "none" );
	}

	if ( $( "#borrar") ) {
		$( "#borrar" ).css( "display" , "none" );
	}

	if ( $( "#restaurar") ) {
		$( "#restaurar" ).css( "display" , "none" );
	}
	fjAntiguedad();
}
function fjEditarRegistro( ) {
	if ( $( "#registrar") ) {
		$( "#registrar" ).css( "display" , "none" );
	}

	if ( $( "#modificar") ) {
		$( "#modificar" ).css( "display" , "" );
	}

	if ( $( "#borrar") ) {
		$( "#borrar" ).css( "display" , "" );
	}

	if ( $( "#restaurar") ) {
		$( "#restaurar" ).css( "display" , "none" );
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
	
	$( "#form" + lsVista + " #divPeriodos" ).html( arrFilas[3].trim() );
	
    $( "#form" + lsVista + " #ctxFechaInicio" ).val( arrFilas[4].trim() );
    $( "#form" + lsVista + " #ctxFechaFin" ).val( arrFilas[5].trim() );
    $( "#form" + lsVista + " #numDiasHabiles" ).val( arrFilas[6].trim() );

    $( "#operacion" ).val( arrFilas[0].trim() );

    if ( arrFilas[1].trim() === "1" ) {
		if ( $( "#registrar") )
			$( "#registrar" ).css( "display" , "none" );

		if ( $( "#modificar") )
			$( "#modificar" ).css( "display" , "none" );

		if ( $( "#borrar") )
			$( "#borrar" ).css( "display" , "none" );

		if ( $( "#restaurar") )
			$( "#restaurar" ).css( "display" , "none" );
    }
    //anulado o cerrado
    else {
		if ( $( "#registrar") )
			$( "#registrar" ).css( "display" , "none" );

		if ( $( "#modificar") )
			$( "#modificar" ).css( "display" , "none" );

		if ( $( "#borrar") )
			$( "#borrar" ).css( "display" , "none" );

		if ( $( "#restaurar") )
			$( "#restaurar" ).css( "display" , "none" );
    }

    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}

//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjListaPeriodos( ) {

	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post( vsRuta , { 
			//variables enviadas (name: valor)
			operacion: "ListaPeriodo"
		} ,
		function( resultado ) {
			if( resultado == false )
				console.log( "sin consultas " );
			else {
				vjResultado = document.getElementById("divPeriodos") ; //*/$( "#divListaAcceso" ).val();
				vjResultado.innerHTML = resultado;
				//console.log( resultado );	
			}
		}
	);
}


//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjCalculaDias( paPeriodos = "" ) {

	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post( vsRuta , { 
			//variables enviadas (name: valor)
			operacion: "CalculaDias" ,
			radPeriodo: paPeriodos
		} ,
		function( resultado ) {
			if( resultado == false )
				console.log( "sin consultas " );
			else {
				console.log( resultado );
				$("#form" + lsVista + " #numDiasHabiles" ).val( parseInt(resultado) );
			}
		}
	);
}



//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjFechaIngreso( piTrabajador = "" ) {

	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post( vsRuta , { 
			//variables enviadas (name: valor)
			operacion: "FechaIngreso" ,
			trabajdor: parseInt( piTrabajador )
		} ,
		function( resultado ) {
			if( resultado == false )
				console.log( "sin consultas " );
			else {
				console.log( resultado );
				$("#ctxFechaIngreso" ).val( resultado );
			}
		}
	);
}




//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjFechaFinal( psFechaInicio = "" ) {

	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post( vsRuta , { 
			//variables enviadas (name: valor)
			operacion: "FechaFin" ,
			numDiasHabiles: parseInt( $("#form" + lsVista + " #numDiasHabiles" ).val() ),
			ctxFechaInicio: $("#form" + lsVista + " #ctxFechaInicio" ).val().toString() 
		} ,
		function( resultado ) {
			if( resultado == false )
				console.log( "sin consultas " );
			else {
				console.log( resultado );
				$("#form" + lsVista + " #ctxFechaFin" ).val("");
				$("#form" + lsVista + " #ctxFechaFin" ).val( resultado );
			}
		}
	);
}

function fjAntiguedad( psFechaInicio = "" ) {

	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post( vsRuta , { 
			//variables enviadas (name: valor)
			operacion: "Antiguedad" ,
		} ,
		function( resultado ) {
			if( resultado == false )
				console.log( "sin consultas " );
			else {
				console.log( resultado );
				$("#form" + lsVista + " #Antiguedad" ).val( "" );
				$("#form" + lsVista + " #Antiguedad" ).val( resultado + " año_(s)");
				$("#form" + lsVista + " #numAntiguedad" ).val( resultado );
			}
		}
	);
}