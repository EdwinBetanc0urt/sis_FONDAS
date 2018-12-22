

var lsVista = "Catalogo";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar( pvValor ) {
	var viCodigo = document.getElementById("numId");
	var vsNombre = document.getElementById("ctxNombre");
	var vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registrar o Modificar no enviara el formulario
	if (vsNombre.value.trim() === "" && ( pvValor === "Incluir" || pvValor === "Modificar" ) ) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>" ,
			type: 'error',
			confirmButtonText: 'Ok',
			showCloseButton: true
		}).then(function() {
			vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}


	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if ( vbComprobar ) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		document.formestado.submit(); //Envía el formulario
	}
}



$(function () {

	var dataTable = $('#tabLista').DataTable( {
		//"processing": true,
		//"serverSide": true,
		"ajax":{
			url :"controlador/con" + lsVista + ".php", // json datasource
			type: "post",  // method  , by default get
			data: { "operacion" : "ListaVista"},
			error: function(){  // error handling
				$(".employee-grid-error").html("");
				$("#tabLista").append('<tbody class="tabLista-grid-error"><tr><th colspan="3">Sin resultados en el servidor</th></tr></tbody>');
				$("#employee-grid_processing").css("display","none");
			}
		} ,


		"columns": [
			{"data": "idrenglon"},
			{"data": "nombre"},
			{"data": "estatus"},
		],

		"language": {
			//"url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
			"url": "public/DataTables/i18n/Esp.json"
		}
	});

	$('#tabLista tbody').on( 'click', 'button', function () {
		var data = dataTable.row( $(this).parents('tr') ).data();
		alert( data[0] +"'s salary is: "+ data[ 1 ] );
    });



	$( "#ctxNombre" ).autocomplete({
		// source: resultado ,
		minLength: 1 ,

		delay: 100 , //retraso en milisegundos luego de cada pulsacion de tecla
		source: function ( request , response ) {
			fjAutocompletado( response );
		} ,

		select: function( event , ui ) {
			//event.preventDefault();
			console.log( ui );
			if ( ui.item.idrenglon == null || ui.item.idrenglon == "undefined" ) {
				fjNuevoRegistro();
			}
			else {
				$("#numId").val( ui.item.idrenglon );
				$( "#ctxNombre" ).val( ui.item.nombre );
				fjEditarRegistro();
			}
		}
	});


});




function fjNuevoRegistro( ) {
	$( "#ctxNombre" ).val( "" );
	fjUltimoID( lsVista );
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




function fjAutocompletado( response ) {
	$.ajax({
		type: "POST" ,
		url:"controlador/con" + lsVista + ".php" ,
		data: {
			operacion: "Autocompletar" ,
			setBuscar: $("#ctxNombre").val() ,
		} ,
		success: function( data ) {
			response( 
				$.map( data , function( item ) {
					console.log( data );
					return {
						label: item.idrenglon + " - " + item.nombre ,
						value: item.nombre ,
						idrenglon: item.idrenglon ,
						nombre: item.nombre 
					}
				})
			);
		} ,
		error: function( xhr , status , error ) {
			swal({
				title: "¿Ops!",
				text: "Ha ocurrido un error, " + error ,
				type: 'error',
				showCloseButton: true ,
				confirmButtonText: 'Ok'
			});
			console.log( xhr );
		} ,
		dataType: 'json' ,
	});
}