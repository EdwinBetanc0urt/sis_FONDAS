
var lsVista = "Asistencia";

$(function () {
	startTime();

	fjMostrarLista(lsVista);

	// PESTAÑA DETALLE
	$("#liDetalle").addClass("disabled"); //elimina la clase disable
	$("#liDetalle a").removeAttr("data-toggle", "tab"); //agrega el atributo de data-toggle
	$("#liDetalle").removeClass("active"); //agrega la clase para que se mueva la pestaña a ese lugar
	$("#pestDetalle").removeClass("in active"); //elimina el atributo de disable
});


function startTime() {
	let today = new Date();
	let h = today.getHours();
	let m = today.getMinutes();
	let s = today.getSeconds();
	m = checkTime(m);
	s = checkTime(s);
	document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
	document.getElementById('ctxReloj').value = h + ":" + m + ":" + s;
	document.getElementById('ctxHoraEntrada').value = h + ":" + m + ":" + s;
	setTimeout(startTime, 500);
}


function checkTime(i) {
	if (i < 10) {
		i = "0" + i
	};  // add zero in front of numbers < 10
	return i;
}


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor = "incluir") {
	let arrFormulario = $("#form" + lsVista);
	let vsDetalles = $(".renglon")
	// let viCodigo = document.getElementById("numId");
	// let vsNombre = document.getElementById("ctxNombre");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registar o Modificar no enviara el formulario
	if (pvValor === "incluir" || pvValor === "Modificar") {
		if (vsDetalles.length < 1) {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'NO HAY RENGLONES AGREGADOS<br /> No puede estar vacía' +
					'para <b>' + pvValor.toUpperCase() + '</b >',
				type: 'error',
				confirmButtonText: 'Ok',
				showCloseButton: true
			}).then((result) => {
				vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	}
	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if(vbComprobar) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}


function fjNuevoRegistro() {
	/*
	// fjCamposNoSoloLectura("#form" + lsVista);
	$("#form" + lsVista + " #tabDetalle tbody").html("");
	$("#form" + lsVista + " #ctxCodigos").val("");
	$("#form" + lsVista + " #tabDetalle thead #trAgregarDetalle").css("display", "");
	*/
	fjSoloDetalle();
	//fjUltimoID(lsVista);

	/*
	$("#form" + lsVista + " #hidCondicion").val("");
	$("#form" + lsVista + " #divBotonesG").css("display", "");
	$("#form" + lsVista + " #divBotonesP").css("display", "");
	$("#form" + lsVista + " #divBotonesA").css("display", "none");
	$("#form" + lsVista + " #divBotonesC").css("display", "none");
	*/
}


function fjEditarRegistro() {
	if($("#Registar")) {
		$("#Registar").css("display", "none");
	}

	if($("#Modificar")) {
		$("#Modificar").css("display", "");
	}

	if($("#Borrar")) {
		$("#Borrar").css("display", "");
	}

	if($("#Restaurar")) {
		$("#Restaurar").css("display", "none");
	}
}


function fjSoloDetalle() {
	// PESTAÑA LISTADO
	$("#liListado").addClass("disabled"); //agrega la clase disable para que no le de click
	$("#liListado a").removeAttr("data-toggle", "tab"); //elimina el atributo de data-toggle
	$("#liListado").removeClass("active"); //elimina la clase active para que no este principal
	$("#pestListado").removeClass("in active"); //elimina el atributo de disable

	// PESTAÑA DETALLE
	$("#liDetalle").removeClass("disabled"); //elimina la clase disable
	$("#liDetalle a").attr("data-toggle", "tab"); //agrega el atributo de data-toggle
	$("#liDetalle").addClass("active"); //agrega la clase para que se mueva la pestaña a ese lugar
	$("#pestDetalle").addClass("in active"); //elimina el atributo de disable
}


function fjCancelar() { 
	$("#form" + lsVista + " #tabDetalle tbody").html("");
	$("#form" + lsVista + " #ctxCodigos").val("");

	// PESTAÑA LISTADO
	$("#liListado").removeClass("disabled"); //agrega la clase disable para que no le de click
	$("#liListado a").attr("data-toggle", "tab"); //elimina el atributo de data-toggle
	$("#liListado").addClass("active"); //elimina la clase active para que no este principal
	$("#pestListado").addClass("in active"); //elimina el atributo de disable
	
	// PESTAÑA DETALLE
	$("#liDetalle").addClass("disabled"); //elimina la clase disable
	$("#liDetalle a").removeAttr("data-toggle", "tab"); //agrega el atributo de data-toggle
	$("#liDetalle").removeClass("active"); //agrega la clase para que se mueva la pestaña a ese lugar
	$("#pestDetalle").removeClass("in active"); //elimina el atributo de disable

	$("#form" + lsVista + " #numId").val("");
	$("#form" + lsVista + " #txaObservacion").val("");
}


function fjSeleccionarRegistro(pvDOM) {
    console.log(pvDOM);
    
    if(jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if(typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM
    
    console.log(arrFilas);

    $("#btnHabilitar").attr('disabled', false);

    $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + lsVista + " #numId").val( parseInt(arrFilas[2].trim()));
    $("#form" + lsVista + " #ctxNombre").val(arrFilas[3].trim());
    $("#form" + lsVista + " #ctxDescripcion").val(arrFilas[4].trim());
    $("#ctxHoraEntrada").val($("#ctxReloj").val());

    $("#form" + lsVista + " #hidDepartamento").val(arrFilas[5].trim());
    fjComboGeneral("Departamento");

    $("#operacion").val(arrFilas[0].trim());

    if(arrFilas[1].trim() === "1") {
		if($("#Registar"))
			$("#Registar").css("display", "none");

		if($("#Modificar"))
			$("#Modificar").css("display", "");

		if($("#Borrar"))
			$("#Borrar").css("display", "");

		if($("#Restaurar"))
			$("#Restaurar").css("display", "none");
    }
    //anulado o cerrado
    else {
		if($("#Registar"))
			$("#Registar").css("display", "none");

		if($("#Modificar"))
			$("#Modificar").css("display", "none");

		if($("#Borrar"))
			$("#Borrar").css("display", "none");

		if($("#Restaurar"))
			$("#Restaurar").css("display", "");
    }

}


function fjDesplegarCatalogo(){
	arrDatos = ["", $("#ctxCodigos").val()];
	fjMostrarLista("Trabajador", "", "", "", "ListaCatalogo", arrDatos);
	$("#VentanaModal").modal('show'); //para boostrap v3.3.7
	$("#formListaTrabajador #ctxBusqueda").focus();
}


function agregarDetalle() {
	if($("#numIdTrabajador").val() == "") {
		swal({
			title: '¡Atención!',
			html: 'El Trabajador no puede estar vació para agregar un renglon, ' +
				'<br> Realice una búsqueda o ingrese su código si lo conoce ',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			onClose: () => {
				fjDesplegarCatalogo();
			},
			footer: ' '
		});
		return;
	}

	if($("#ctxHoraEntrada").val() == "") {
		swal({
			title: '¡Atención!',
			html: 'Debe colocar la el tiempo de marcaje del Trabajador',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			footer: ' ',
			onClose: () => {
				$("#ctxHoraEntrada").focus();
			}
		});
		return;
	}

	if (parseInt($("#ctxHoraEntrada").val()) <= 0) {
		swal({
			title: '¡Atención!',
			text: 'La cantidad a ingresar no puede ser menor a 1',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			footer: ' ',
			onClose: () => {
				$("#ctxHoraEntrada").focus();
			}
		});
		return;
	}

	//si no encuentra repetidos lo agrega
	if (!buscaDetalleRepetido($("#numIdTrabajador").val())) {
		$('#tabDetalle tbody').append(
			'<tr onclick="//eliminarDetalle(this);" orden="' + $("#numNivel").val() + '">' +
				'<td>' +
				 	$("#ctxNombreTrabajador").val().toUpperCase() +
					'<input type="hidden" name="detIdTrabajador[]" readOnly ' +
					'id="detIdTrabajador' + $("#numIdTrabajador").val() + '" ' +
					'value = "' + $("#numIdTrabajador").val() + '" ' +
					'class= "form-control renglon" /> ' +
				'</td>' +
				'<td>' +
					'<input type="time" name="detHoraEntrada[]" id="detHoraEntrada' +
					$("#numIdTrabajador").val() + '" value="' + $("#ctxHoraEntrada").val() +
					'" class="form-control" />' +
				'</td>' +
				'<td>' +
					'<input type="button" id="btnButtonDel" value="Eliminar"'+
					'class= "btn btn-danger form-control" ' +
					'onclick="eliminarDetalle(this, 2);" />' +
				'</td>' +
			'</tr>'
		);
	}
	else {
		swal({
			type: "error",
			html: 'En esta jornada ya se encuentra agregado el trabajador: <b>' +
				$("#ctxNombreTrabajador").val().toUpperCase() + '</b>, y no ' +
				'puede agregarse más de dos (2) veces.',
			showCloseButton: true,
			confirmButtonText: 'Ok',
			footer: ' ',
			onClose: () => {
				$("#ctxHoraEntrada").val(null);
				$("#ctxNombreTrabajador").val(null);
				$("#numIdTrabajador").val(null);
				fjDesplegarCatalogo();
			}
		});
		return;
	}

	$("#ctxHoraEntrada").val(null);
	$("#ctxNombreTrabajador").val(null);
	$("#numIdTrabajador").val(null);
	fjValidarInner();
	// fjLimpiaValores();
} //cierre de la función


function buscaDetalleRepetido(piCodigo, psDetalle = ".renglon"){
	let vbRepetido = false;
	let _elementosDOM = document.querySelectorAll(psDetalle);
	//console.log(_elementosDOM);

	for (let i = 0; i < _elementosDOM.length; i++){
		// compara el elemento del arreglo en X posición con el valor
		// si en X posición encuentra un valor igual
		if (parseInt(_elementosDOM[i].value.trim()) == parseInt(piCodigo.trim()) ) {
			vbRepetido = true;
			break;
		}
	}

	//si esta repetido retorna true
	return vbRepetido;
} //cierre de la función


/**
 * 
 * @param {Object} nodo Elemento Dom
 * @param {Number} nivelArriba Nivel del elemento hacia arriba para remover
 */
function eliminarDetalle(nodo, nivelArriba = 0) {
	for (let i = 1; i <= nivelArriba; i++) {
		nodo = nodo.parentNode
	}
	nodo.remove();
} //cierre de la función


function fjSeleccionarTrabajador(pvDOM) {
	let vtHoraEntrada = document.getElementById('ctxHoraEntrada'); //variable JavaScript Cantidad
	//debe ser con jquery porque es recibido como tal con jquery
	if (jQuery.isFunction(pvDOM.attr)) {
		arrFilas = pvDOM.attr('datos_registro').split('|'); 
	}
	//debe ser con javascript porque es recibido cdirectamete del DOM
	if (typeof pvDOM.getAttribute !== 'undefined') {
		arrFilas = pvDOM.getAttribute('datos_registro').split('|');
	}
	else {
		return;
	}

	$("#numIdTrabajador").val(parseInt(arrFilas[2]));

	lsDatos = arrFilas[3] + "-" + arrFilas[4] + ", " + arrFilas[5] + " " + arrFilas[6] ;
	$("#ctxNombreTrabajador").val(lsDatos);

	$("#VentanaModal").modal('hide'); //para boostrap v3.3.7
	vtHoraEntrada.focus(); //enfoca el cursor en el campo que falta del formulario
}
