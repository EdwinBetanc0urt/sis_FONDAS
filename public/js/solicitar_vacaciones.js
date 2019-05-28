
var lsVista = "Solicitar_Vacaciones";

$(function () {
	fjMostrarLista(lsVista);

	$("#ctxFechaInicio").on("change", function() {
		if ($("#numDiasHabiles").val() != "" && parseInt($("#numDiasHabiles").val()) != 0) {
			fjFechaFinal();
		}
	});

	$("#numDiasHabiles").on("change", function() {
		if ($("#ctxFechaInicio").val() != "" && parseInt($("#ctxFechaInicio").val()) != 0) {
			fjFechaFinal();
		}
	});

	$("#cmbPeriodo").on("change", function() {
		// console.log($("#cmbPeriodo").val());
		if(parseInt($("#cmbPeriodo").val()) == 0) {
			swal({
				title: '¡Atención!',
				html: 'No posee períodos vacacionales aun, hasta no cumplir ' +
					'por lo menos un (1) año de haber ingresado o de haber ' +
					'usado las vacaciones no pude solicitar las mismas.',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			});
			return;
		}
		else if ($("#cmbPeriodo").val() == '') {
			swal({
				title: '¡Atención!',
				html: 'Debe seleccionar un periodo valido para calcular los ' +
					'días habitables de las vacaciones ',
				type: 'warning',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			});
			$("#numDiasHabiles").val('');
			$("#ctxFechaFin").val('');
			return;
		}
		else {
			setTimeout(() => {
					fjCalculaDias($("#cmbPeriodo").val());
				},
				500
			);
			if ($("#ctxFechaInicio").val() != "" && parseInt($("#ctxFechaInicio").val()) != 0) {
				setTimeout(() => {
						fjFechaFinal();
					},
					1000
				);
			}
		}
	});
});


//funcion.javascript.Enviar (parámetro.vista.Valor)
function enviar(pvValor) {
	let arrFormulario = $("#form" + lsVista);
	var vsFechaIngreso = document.getElementById("ctxFechaIngreso");
	var Periodo = $("#form" + lsVista + " #cmbPeriodo");
	var vsFechaInicio = $("#form" + lsVista + " #ctxFechaInicio");
	var vbComprobar = true; // verifica que todo este true o un solo false no envía

	// verificar el formulario al Registrar o Modificar
	if (pvValor === "Registrar" || pvValor === "Modificar") {
		if (vsFechaIngreso.value.trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA Fecha de ingreso ES OBLIGATORIA<br /> No puede estar " +
					"vacía para <b>" + pvValor.toUpperCase() + "</b>",
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then((result) => {
				vsFechaIngreso.focus(); // enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}

		if (Periodo.val() == '' || parseInt(Periodo.val()) == 0) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "Debe seleccionar un periodo vencido <br> si no aparece " +
					"ningún periodo de año no puede solicitar vacaciones",
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then((result) => {
				Periodo.focus(); // enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función verificar antes de continuar
		}
		if (vsFechaInicio.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: "LA Fecha de inicio de vacaciones es ES OBLIGATORIA<br />" +
					" No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>",
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then((result) => {
				vsFechaInicio.focus(); // enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función verificar antes de continuar
		}
	} // cierre del condicional si es boton Modificar o Incluir

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}

function fjNuevoRegistro() {
	$("#form" + lsVista)[0].reset();
	fjListaPeriodos();

	if ($("#Registrar")) {
		$("#Registrar").css("display", "");
	}
	if ($("#Modificar")) {
		$("#Modificar").css("display", "none");
	}
	if ($("#Borrar")) {
		$("#Borrar").css("display", "none");
	}
	if ($("#Restaurar")) {
		$("#Restaurar").css("display", "none");
	}
	fjAntiguedad();
}

function fjEditarRegistro() {
	if ($("#Registrar")) {
		$("#Registrar").css("display", "none");
	}
	if ($("#Modificar")) {
		$("#Modificar").css("display", "");
	}

	if ($("#Borrar")) {
		$("#Borrar").css("display", "");
	}
	if ($("#Restaurar")) {
		$("#Restaurar").css("display", "none");
	}
}


function fjSeleccionarRegistro(pvDOM) {
	// debe ser con jquery porque es recibido como tal con jquery
	if (jQuery.isFunction(pvDOM.attr))
		arrFilas = pvDOM.attr('datos_registro').split('|');
	// debe ser con javascript porque es recibido directamente del DOM
	if (typeof pvDOM.getAttribute !== 'undefined')
		arrFilas = pvDOM.getAttribute('datos_registro').split('|'); 

	$("#btnHabilitar").attr('disabled', false);

	$("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
	$("#form" + lsVista + " #numId").val(parseInt(arrFilas[2].trim()));
	
	$("#form" + lsVista + " #cmbPeriodo")
		.prop('length', 1)
		.append(
			'<option value="' + arrFilas[3].trim() + '">' + 
				arrFilas[3].trim() +
			'</option>' 
		) // agrega los nuevos option al select
		.val(arrFilas[3].trim())
		// .attr('disabled', true)
		.trigger('change');

	$("#form" + lsVista + " #ctxFechaInicio")
		// .attr('disabled', true)
		.val(arrFilas[4].trim());
	$("#form" + lsVista + " #ctxFechaFin").val(arrFilas[5].trim());
	$("#form" + lsVista + " #numDiasHabiles").val(arrFilas[6].trim());

	$("#operacion").val(arrFilas[0].trim());

	if (arrFilas[1].trim() === "activo") {
		if ($("#Registrar"))
			$("#Registrar").css("display", "none");

		if ($("#Modificar"))
			$("#Modificar").css("display", "none");

		if ($("#Borrar"))
			$("#Borrar").css("display", "none");

		if ($("#Restaurar"))
			$("#Restaurar").css("display", "none");
	}
	// anulado o cerrado
	else {
		if ($("#Registrar"))
			$("#Registrar").css("display", "none");

		if ($("#Modificar"))
			$("#Modificar").css("display", "none");

		if ($("#Borrar"))
			$("#Borrar").css("display", "none");

		if ($("#Restaurar"))
			$("#Restaurar").css("display", "none");
	}
	$("#VentanaModal").modal('show'); //para bootstrap v3.3.7
}

// Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjListaPeriodos() {
	//abre el archivo controlador y envía por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post(vsRuta, { 
			operacion: "ListaPeriodo"
		},
		function(resultado) {
			// console.log(resultado);
			if(resultado == false) {
				console.log("sin consultas ");
			}
			else {
				$("#cmbPeriodo")
					.prop('length', 1) //limpia los option del select
					.attr("disabled", false) //habilita el campo de estado
					.append(resultado); //agrega los nuevos option al select
			}
		}
	);
}

// Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjCalculaDias(paPeriodos = "") {
	//abre el archivo controlador y envía por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post(vsRuta, { 
			operacion: "CalculaDias",
			radPeriodo: paPeriodos
		},
		function(resultado) {
			// console.log(resultado);
			if(resultado == false) {
				console.log("sin consultas ");
			}
			else {
				$("#form" + lsVista + " #numDiasHabiles").val(parseInt(resultado));
			}
		}
	);
}

// Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjFechaFinal() {
	if ($("#cmbPeriodo").val() == '' || parseInt($("#cmbPeriodo").val()) == 0) {
		swal({
			title: '¡Atención!',
			html: 'Debe seleccionar un periodo valido para obtener los ' +
				'días habitables de las vacaciones y calcular la fecha de reingreso.',
			type: 'warning',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			footer: ' '
		});
		$("#ctxFechaFin").val('');
		return;
	}
	if ($("#numDiasHabiles").val() == '' || parseInt($("#numDiasHabiles").val()) == 0) {
		swal({
			title: '¡Atención!',
			html: 'Debe seleccionar un periodo valido para obtener los ' +
				'días habitables de las vacaciones y calcular la fecha de reingreso.',
			type: 'warning',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			footer: ' '
		});
		$("#ctxFechaFin").val('');
		return;
	}
	if ($("#ctxFechaInicio").val() == '' || parseInt($("#ctxFechaInicio").val()) == 0) {
		swal({
			title: '¡Atención!',
			html: 'Debe indicar la fecha de inicio para calcular la fecha de reingreso.',
			type: 'warning',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			footer: ' '
		});
		$("#ctxFechaFin").val('');
		return;
	}
	// abre el archivo controlador y envía por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post(vsRuta, { 
			operacion: "FechaFin",
			numDiasHabiles: parseInt($("#form" + lsVista + " #numDiasHabiles").val()),
			ctxFechaInicio: $("#form" + lsVista + " #ctxFechaInicio").val().toString() 
		},
		function(resultado) {
			if(resultado == false)
				console.log("sin consultas ");
			else {
				// console.log(resultado);
				$("#form" + lsVista + " #ctxFechaFin").val("");
				$("#form" + lsVista + " #ctxFechaFin").val(resultado);
			}
		}
	);
}

function fjAntiguedad() {
	// abre el archivo controlador y envía por POST
	vsRuta = "controlador/conSolicitar_Vacaciones.php";

	$.post(vsRuta, { 
			// variables enviadas (name: valor)
			operacion: "Antiguedad",
		},
		function(resultado) {
			if(resultado == false)
				console.log("sin consultas ");
			else {
				// console.log(resultado);
				$("#form" + lsVista + " #Antiguedad").val("");
				$("#form" + lsVista + " #Antiguedad").val(resultado + " año(s)");
				$("#form" + lsVista + " #numAntiguedad").val(resultado);
			}
		}
	);
}

function fjVerVacacion(piVacacion, piAncho = 700, piAlto = 800) {
	var vjUrl="pdf/repSolicitud_Vacaciones.php?vacacicon="+piVacacion; //Maestra seleccionada
	var posicion_x=(screen.width/2)-(piAncho/2); //posicion horizontal en la pantalla
	var posicion_y=(screen.height/2)-(piAlto/2); //posicion vertical en la pantalla
	//document.getElementById("vvOpcion").value = pvValor; //valor.vista.Opcion del hidden
	//Crea una ventana donde muestra todos los listar de las diversas maestras
	window.open(vjUrl,'Listado de Accesos', 'width='+parseInt(piAncho),  'height='+parseInt(piAlto), 'left='+posicion_x,'top='+posicion_y, 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=yes');
	//if (window.focus) {newwindow.focus()}
}
