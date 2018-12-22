
var lsVista = "Asistencia";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar( pvValor = "incluir" ) {
	let arrFormulario = $( "#form" + lsVista );
	let viCodigo = document.getElementById("numId");
	let vsNombre = document.getElementById("ctxNombre");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registar o Modificar no enviara el formulario
	if (pvValor === "incluir" || pvValor === "Modificar") {
		if (vsNombre.value.trim() ) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then( ( result ) => {
				vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
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

	// PESTAÑA DETALLE
	$("#liDetalle").addClass("disabled"); //elimina la clase disable
	$("#liDetalle a").removeAttr( "data-toggle" , "tab" ); //agrega el atributo de data-toggle
	$("#liDetalle").removeClass("active"); //agrega la clase para que se mueva la pestaña a ese lugar
	$("#pestDetalle").removeClass( "in active" ); //elimina el atributo de disable
});



function fjNuevoRegistro( ) {
	/*
	// fjCamposNoSoloLectura( "#form" + lsVista );
	$( "#form" + lsVista + " #tabDetalle tbody" ).html( "" );
	$( "#form" + lsVista + " #ctxCodigos" ).val( "" );
	$( "#form" + lsVista + " #tabDetalle thead #trAgregarDetalle" ).css( "display" , "" );
	*/
	fjSoloDetalle();
	//fjUltimoID( lsVista );

	/*
	$( "#form" + lsVista + " #hidCondicion" ).val( "" );
	$( "#form" + lsVista + " #divBotonesG" ).css( "display" , "" );
	$( "#form" + lsVista + " #divBotonesP" ).css( "display" , "" );
	$( "#form" + lsVista + " #divBotonesA" ).css( "display" , "none" );
	$( "#form" + lsVista + " #divBotonesC" ).css( "display" , "none" );
	*/
}
function fjEditarRegistro( ) {
	if ( $( "#Registar") ) {
		$( "#Registar" ).css( "display" , "none" );
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



function fjSoloDetalle() {
	// PESTAÑA LISTADO
	$("#liListado").addClass("disabled"); //agrega la clase disable para que no le de click
	$("#liListado a").removeAttr( "data-toggle" , "tab" ); //elimina el atributo de data-toggle
	$("#liListado").removeClass("active"); //elimina la clase active para que no este principal
	$("#pestListado").removeClass( "in active" ); //elimina el atributo de disable

	// PESTAÑA DETALLE
	$("#liDetalle").removeClass("disabled"); //elimina la clase disable
	$("#liDetalle a").attr( "data-toggle" , "tab" ); //agrega el atributo de data-toggle
	$("#liDetalle").addClass("active"); //agrega la clase para que se mueva la pestaña a ese lugar
	$("#pestDetalle").addClass( "in active" ); //elimina el atributo de disable
	
}





function fjCancelar() { 
	$( "#form" + lsVista + " #tabDetalle tbody" ).html( "" );
	$( "#form" + lsVista + " #ctxCodigos" ).val( "" );

	// PESTAÑA LISTADO
	$("#liListado").removeClass("disabled"); //agrega la clase disable para que no le de click
	$("#liListado a").attr( "data-toggle" , "tab" ); //elimina el atributo de data-toggle
	$("#liListado").addClass("active"); //elimina la clase active para que no este principal
	$("#pestListado").addClass( "in active" ); //elimina el atributo de disable
	
	// PESTAÑA DETALLE
	$("#liDetalle").addClass("disabled"); //elimina la clase disable
	$("#liDetalle a").removeAttr( "data-toggle" , "tab" ); //agrega el atributo de data-toggle
	$("#liDetalle").removeClass("active"); //agrega la clase para que se mueva la pestaña a ese lugar
	$("#pestDetalle").removeClass( "in active" ); //elimina el atributo de disable

	$("#form" + lsVista + " #numId").val( "" );
	$("#form" + lsVista + " #txaObservacion").val( "" );
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
    $( "#form" + lsVista + " #ctxNombre" ).val( arrFilas[3].trim() );
    $( "#form" + lsVista + " #ctxDescripcion" ).val( arrFilas[4].trim() );
    $("#ctxHoraEntrada").val($("#ctxReloj").val() );

    $( "#form" + lsVista + " #hidDepartamento" ).val( arrFilas[5].trim() );
    fjComboGeneral( "Departamento" );

    $( "#operacion" ).val( arrFilas[0].trim() );

    if ( arrFilas[1].trim() === "1" ) {
		if ( $( "#Registar") )
			$( "#Registar" ).css( "display" , "none" );

		if ( $( "#Modificar") )
			$( "#Modificar" ).css( "display" , "" );

		if ( $( "#Borrar") )
			$( "#Borrar" ).css( "display" , "" );

		if ( $( "#Restaurar") )
			$( "#Restaurar" ).css( "display" , "none" );
    }
    //anulado o cerrado
    else {
		if ( $( "#Registar") )
			$( "#Registar" ).css( "display" , "none" );

		if ( $( "#Modificar") )
			$( "#Modificar" ).css( "display" , "none" );

		if ( $( "#Borrar") )
			$( "#Borrar" ).css( "display" , "none" );

		if ( $( "#Restaurar") )
			$( "#Restaurar" ).css( "display" , "" );
    }

}



function fjDesplegarCatalogo(){
	arrDatos = [ "" , $("#ctxCodigos").val() ];
	fjMostrarLista( "Trabajador" , "" , "" , "" , "ListaCatalogo" , arrDatos );
	$( "#VentanaModal" ).modal( 'show' ); //para boostrap v3.3.7
	$("#formLista #ctxBusqueda").focus();
}



//función para agregar los datos al arreglo
function fjAgregarDetalle() {
	let tabla = document.getElementById("tabBodyDetalle"); //se toma el id de la tabla
	//let tabla = document.getElementById("tabDetalle").getElementsByTagName("tbody")[0]; //funciona
	//let tabla = document.getElementById("tabDetalle").getElementById("tabBodyDetalle")[0]; //no funciona
	let viTrabajador = document.getElementById('numIdTrabajador'); //variable JavaScript Trabajador
	let vsNombre = document.getElementById('ctxNombreTrabajador'); //se toma el id del objeto
	let vtHoraEntrada = document.getElementById('ctxHoraEntrada'); //variable JavaScript Cantidad
	let vjDetalles = document.getElementById('ctxCodigos'); // un hidden que guarda valores mientras se manejan los detalles
	//let vjObservacion = document.getElementById('ctxObservacionTrabajador').value; //variable JavaScript Observación

	//si el numIdTrabajador está vació no agregara el detalle al formulario
	if ( viTrabajador.value.trim() === "" ) {
		swal({
			title: '¡Atención!',
			text: 'El Trabajador no puede estar vació, \n Realice una búsqueda o ingrese su código si lo conoce ' ,
			type: 'warning',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			//$("#VentanaModalTrabajador" ).modal('show'); //para boostrap v3.3.7
			fjDesplegarCatalogo();
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}

	//si el ctxCantidadTrabajador está vació no agregara el detalle al formulario
	if ( vtHoraEntrada.value.trim() === "" ) {
		swal({
			title: '¡Atención!',
			text: 'Debe colocar la cantidad que sale del Trabajador' ,
			type: 'info',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			vtHoraEntrada.focus();
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}

	//si el ctxCantidadTrabajador es menor a 1 no agregara el detalle al formulario
	if ( parseInt( vtHoraEntrada.value.trim() ) <= 0 ) {
		swal({
			title: '¡Atención!',
			text: 'La cantidad a ingresar no puede ser menor a 1' ,
			type: 'info',
			showCloseButton: true ,
			confirmButtonText: 'Ok'
		}).then( ( result ) => {
			vtHoraEntrada.focus();
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}

	//pasa las validaciones del detalle
	else {

		let tr = tabla.insertRow( -1 ); //agrega la columna 
		let td0 = tr.insertCell(0);	//agrega la celda comenzando con un arreglo 0
		let td1 = tr.insertCell(1);	
		let td2 = tr.insertCell(2);
		//console.log(vjDetalles.value);
		arrDetalles = vjDetalles.value.split( ',' ); //crea un arreglo separando cada posición con comas
		tamArreglo = arrDetalles.length; //mide el tamaño del arreglo para saber el final del ciclo
		
		//recorre el arreglo
		for ( var i = 0 ; i < tamArreglo ; i++ ) {
			//compara el elemento del arreglo en X posición con el valor del Trabajador
			if ( parseInt( arrDetalles[i] ) == viTrabajador.value ) {
				swal({
					title: '¡Atención!',
					text: 'Ya se ha agregado el trabajador: ' + vsNombre.value.toUpperCase() + ', y no puede agregarse 2 veces ' ,
					type: 'info',
					showCloseButton: true ,
					confirmButtonText: 'Ok'
				}).then( ( result ) => {
					vtHoraEntrada.focus();
					viTrabajador.value = "";
					vsNombre.value = "";
					vtHoraEntrada.value = "";
					fjDesplegarCatalogo();
				});
				return; //rompe el ciclo si encuentra un código igual
			}
		} //cierre del for

		if ( tamArreglo == 1 && arrDetalles[0] == 0 )
			vjDetalles.value =  viTrabajador.value; //agrego ese id de articulo al arreglo

		//if ( tamArreglo == 0 )
		//	vjDetalles.value =  viTrabajador.value; //agrego ese id de articulo al arreglo
		else
			vjDetalles.value +=  ", " + viTrabajador.value; //agrego ese id de articulo al arreglo
		//arrDetalles.push( 23 ); //agrego ese id de articulo al arreglo
		//vjDetalles.value =  arrDetalles.toString();

		//en la primera fila muestra el nombre en el html y agrega un campo oculto con el código del articulo para enviar al servidor
		td0.innerHTML = vsNombre.value + "<input type='hidden' class='form-control' id='detIdTrabajador" + viTrabajador.value + "' name='detIdTrabajador[]' value='" + viTrabajador.value + "' readOnly />";

		td1.innerHTML = "<input type='text' class='valida_num_entero form-control' id='detHoraEntrada" + viTrabajador.value + "' name='detHoraEntrada[]' maxlength='4' value='" + vtHoraEntrada.value + "' />";

		td2.innerHTML = "<button type='button' class='btn' onclick='fjQuitarDetalle(this.parentNode, " + viTrabajador.value + ");' value='del' name='delService'>Quitar</button>";
		//limpia los campos de la vista
		viTrabajador.value = "";
		vsNombre.value = "";
		vtHoraEntrada.value = "";
		vsNombre.focus() ;

		console.log( vjDetalles.value );
		//reasigna validaciones a los innput
		fjValidarInner();
	} // cierre del else si no esta vació
}



//función JavaScript Quitar Detalle 
function fjQuitarDetalle( nodoPadre , piTrabajador ) {
	var vjDetalles = document.getElementById('ctxCodigos'); //un hidden que guarda valores mientras se manejan los detalles

	arrDetalles = vjDetalles.value.split( ',' ); //crea un arreglo separando cada posición con comas
	tamArreglo = arrDetalles.length;  //mide el tamaño del arreglo para saber el final del ciclo
	//recorre el arreglo
	for ( var i = 0 ; i < tamArreglo ; i++ ) {
		//compara el elemento del arreglo en X posición con el valor del Trabajador
		//si en X posición encuentra un valor igual
		if ( parseInt( arrDetalles[i] ) == parseInt( piTrabajador ) ) {
			arrDetalles[i]=0; //reasigna el valor a 0, ya que no hay códigos con 0 de los artículos
			//console.log(arrDetalles[0]);
		}
	} //cierre del for*/
	vjDetalles.value = arrDetalles; //reasigno los valores del arreglo en la vista
	console.log( arrDetalles );
	nodoPadre.parentNode.remove(); //quitar los datos de toda la fila
}

function fjSeleccionarTrabajador( pvDOM ) {
	let vtHoraEntrada = document.getElementById('ctxCantidadTrabajador'); //variable JavaScript Cantidad
	console.log( pvDOM );
	
	if ( jQuery.isFunction( pvDOM.attr ) )
		arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

	if ( typeof pvDOM.getAttribute !== 'undefined' )
		arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM
	
	console.log( arrFilas );

	$( "#numIdTrabajador" ).val( parseInt( arrFilas[2] ) );

	lsDatos = arrFilas[3] + "-" + arrFilas[4] + ", " + arrFilas[5] + " " + arrFilas[6] ;
	$( "#ctxNombreTrabajador" ).val( lsDatos );

	$("#VentanaModal" ).modal('hide'); //para boostrap v3.3.7
	vtHoraEntrada.focus(); //enfoca el cursor en el campo que falta del formulario
}
