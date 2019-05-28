
var lsVista = "Vacaciones";

$(function() {
	fjMostrarLista(lsVista);
	fjMostrarLista(lsVista, "", "", "VacacionesAprobado", "ListaViewAprobado");
	fjMostrarLista(lsVista, "", "", "VacacionesEnCurso", "ListaViewEnCurso");
	fjMostrarLista(lsVista, "", "", "VacacionesCulminado", "ListaViewCulminado");
	fjMostrarLista(lsVista, "", "", "VacacionesRechazado", "ListaViewRechazado");
});

//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor) {
	let arrFormulario = $("#form" + lsVista);
	let vsNombre = document.getElementById("ctxNombre");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registrar o Modificar no enviara el formulario
	if (vsNombre.value.trim() === "" &&(pvValor === "Incluir" || pvValor === "Modificar")) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: "LA DESCRIPCION ES OBLIGATORIA<br /> No puede estar vacía para <b>" + pvValor.toUpperCase() + "</b>",
			type: 'error',
			confirmButtonText: 'Ok',
			showCloseButton: true
		}).then((result) => {
			vsNombre.focus(); //enfoca el cursor en el campo que falta del formulario
		});
		return; // rompe la función para que el usuario verifique antes de continuar
	}

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if(vbComprobar) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}

function fjNuevoRegistro() {
	$("#form" + lsVista)[0].reset();
	fjUltimoID(lsVista);
    fjComboGeneral("Departamento");
	if($("#Registrar")) {
		$("#Registrar").css("display", "");
	}

	if($("#Modificar")) {
		$("#Modificar").css("display", "none");
	}

	if($("#Borrar")) {
		$("#Borrar").css("display", "none");
	}

	if($("#Restaurar")) {
		$("#Restaurar").css("display", "none");
	}
}

function fjEditarRegistro() {
	if($("#Registrar")) {
		$("#Registrar").css("display", "none");
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

function fjSeleccionarRegistro(pvDOM) {
    if(jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if(typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM

    $("#btnHabilitar").attr('disabled', false);

    $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + lsVista + " #numId").val( parseInt(arrFilas[2].trim()));
    $("#form" + lsVista + " #ctxNombre").val(arrFilas[3].trim());
    $("#form" + lsVista + " #ctxDescripcion").val(arrFilas[4].trim());

    $("#form" + lsVista + " #hidDepartamento").val(arrFilas[5].trim());
    fjComboGeneral("Departamento");

    $("#operacion").val(arrFilas[0].trim());

    if(arrFilas[1].trim() === "activo") {
		if($("#Registrar"))
			$("#Registrar").css("display", "none");

		if($("#Modificar"))
			$("#Modificar").css("display", "");

		if($("#Borrar"))
			$("#Borrar").css("display", "");

		if($("#restaurar"))
			$("#restaurar").css("display", "none");
    }
    //anulado o cerrado
    else {
		if($("#Registrar"))
			$("#Registrar").css("display", "none");

		if($("#Modificar"))
			$("#Modificar").css("display", "none");

		if($("#Borrar"))
			$("#Borrar").css("display", "none");

		if($("#restaurar"))
			$("#restaurar").css("display", "");
    }

    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}

//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjListaPeriodos(PiTrabajador = "", psFecha = "") {
	let liTipoUsuario = "";
	let liModulo = "";
	
	if(piTipoUsuario != "") 
		liTipoUsuario = piTipoUsuario;
	else
		liTipoUsuario = $("#cmbTipo_Usuario").val();

	if(piModulo != "") 
		liModulo = piModulo;
	else
		liModulo = $("#cmbModulo").val();
	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conVacaciones.php";

	$.post(vsRuta, { 
			//variables enviadas (name: valor)
			operacion: "ListaAcceso", //abre la funcion en el controlador 
			setTipoUsuario: liTipoUsuario,
			setModulo: liModulo 
		},
		function(resultado) {
			if(resultado == false)
				console.log("sin consultas ");
			else {
				vjResultado = document.getElementById("divListaAcceso") ; //*/$("#divListaAcceso").val();
				vjResultado.innerHTML = resultado;
				//console.log(resultado);	
			}
		}
	);
}

function fjAprobar(piVacaciones = "") {
	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conVacaciones.php";
	
	swal({   
		html: "¿Está seguro de aceptar o aprobar estas vacaciones?",  
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55", 
		confirmButtonText: "Aceptar!",   
		cancelButtonText: "Cancelar!",   
		showCloseButton: true
	}).then((result) => {
		if (result.value) {	

			$.post(vsRuta, { 
					//variables enviadas (name: valor)
					operacion: "AprobarVacaciones",
					idvacaciones: parseInt(piVacaciones)
				},
				function(resultado) {
					if(resultado == false)
						console.log("sin consultas ");
					else {
						console.log(resultado);
						fjMostrarLista(lsVista);
						fjMostrarLista(lsVista, "", "", "VacacionesRechazado", "ListaViewRechazado");
						fjMostrarLista(lsVista, "", "", "VacacionesAprobado", "ListaViewAprobado");
					}
				}
			);
		}
	});
}

function fjRechazar(piVacaciones = "") {
	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conVacaciones.php";

	swal({   
		html: "¿Está seguro de rechazar o denegar estas vacaciones?",  
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55", 
		confirmButtonText: "Aceptar!",   
		cancelButtonText: "Cancelar!",   
		showCloseButton: true
	}).then((result) => {
		if (result.value) {	
			$.post(vsRuta, { 
					//variables enviadas (name: valor)
					operacion: "RechazarVacaciones",
					idvacaciones: parseInt(piVacaciones)
				},
				function(resultado) {
					if(resultado == false)
						console.log("sin consultas ");
					else {
						console.log(resultado);
						fjMostrarLista(lsVista);
						fjMostrarLista(lsVista, "", "", "VacacionesRechazado", "ListaViewRechazado");
						fjMostrarLista(lsVista, "", "", "VacacionesAprobado", "ListaViewAprobado");
					}
				}
			);
		}
	});
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
