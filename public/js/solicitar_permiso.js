
var lsVista = "Solicitar_Permiso";

$(function () {
	fjMostrarLista(lsVista);

	$("#ctxFechaInicio").on("dp.change", function () {
    	fjFechaFinal(this.value, $("#cmbMotivo_Permiso").val());
	});
	$("#cmbMotivo_Permiso").on("change", function(){
    	fjFechaFinal($("#ctxFechaInicio").val(), this.value);
	});
});

//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjFechaFinal(psFechaInicio = "", piMotivo = "") {
	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conSolicitar_Permiso.php";
	$.post(vsRuta, {
			operacion: "FechaFin",
			cmbMotivo: parseInt(piMotivo),
			ctxFechaInicio: psFechaInicio.toString()
		},
		function(resultado) {
			if (!resultado) {
				console.log("sin consultas ");
				$("#form" + lsVista + " #ctxFechaFin").val("");
			}
			else {
				$("#form" + lsVista + " #ctxFechaFin").val(resultado);
			}
		}
	);
}

//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor) {
	let arrFormulario = $("#form" + lsVista);
	let vsNombre = $("#form" + lsVista + " #ctxNombre");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//console.log (vsEntrada.value.trim());
	//si el cod está vació y el botón pulsado es igual a Registar o Modificar no enviara el formulario
	if (vsNombre.val().trim() === "" && (pvValor === "Incluir" || pvValor === "Modificar")) {
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
	if (vbComprobar) {
		$("#form" + lsVista + " #operacion").val(pvValor);
		arrFormulario.submit(); //Envía el formulario
	}
}

function fjNuevoRegistro() {
	$("#form" + lsVista)[0].reset();
	fjUltimoID(lsVista);
	fjComboGeneral("Motivo_Permiso");

	//$("#form" + lsVista)[0].reset();
	//if ($(".chkDias").length > 0) {
		//$(".chkDias").attr("checked", false);
	//}
    //fjCargarDias();
	if ($("#Registar")) {
		$("#Registar").css("display", "");
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
}

function fjEditarRegistro() {
	if ($("#Registar")) {
		$("#Registar").css("display", "none");
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
    if (jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

    if (typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM

    $("#btnHabilitar").attr('disabled', false);

    $("#form" + lsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + lsVista + " #numId").val(parseInt(arrFilas[2].trim()));
    $("#form" + lsVista + " #ctxNombre").val(arrFilas[3].trim());
	$("#form" + lsVista + " #numIdTrabajador").val(arrFilas[4].trim());
	$("#form" + lsVista + " #ctxFechaElaboracion").val(arrFilas[5].trim());

	$("#form" + lsVista + " #hidMotivo_Permiso").val(arrFilas[6].trim());
	fjComboGeneral("Motivo_Permiso");

	$("#form" + lsVista + " #ctxObservacion").val(arrFilas[7].trim());
	$("#form" + lsVista + " #ctxFechaInicio").val(arrFilas[8].trim());
	$("#form" + lsVista + " #ctxFechaFin").val(arrFilas[9].trim());

	setTimeout(function() {
		//fjCargarDias(parseInt(arrFilas[2].trim()));
	}, 1000);

    $("#operacion").val(arrFilas[0].trim());

    if (arrFilas[1].trim() === "activo") {
		if ($("#Registar"))
			$("#Registar").css("display", "none");

		if ($("#Modificar"))
			$("#Modificar").css("display", "");

		if ($("#Borrar"))
			$("#Borrar").css("display", "");

		if ($("#Restaurar"))
			$("#Restaurar").css("display", "none");
    }
    //anulado o cerrado
    else {
		if ($("#Registar"))
			$("#Registar").css("display", "none");

		if ($("#Modificar"))
			$("#Modificar").css("display", "none");

		if ($("#Borrar"))
			$("#Borrar").css("display", "none");

		if ($("#Restaurar"))
			$("#Restaurar").css("display", "");
    }
    $("#VentanaModal").modal('show'); //para boostrap v3.3.7
}

function fjCargarDias(piJornada = ""){
	if (piJornada != "")
		$("#numId").val(piJornada);

    $.post("controlador/conJornada.php", {
            operacion: "ListaDias",
            numId: $("#numId").val()
        },
        function(resultado) {
            if (resultado == false)
                console.log("sin consultas de " + lsVista);
            else {
                $("#form" + lsVista + " #divListaDias").html(resultado) ;
                console.log(resultado);
            }
        }
	);
}

function verReporte(idRegistro, piAncho = 700, piAlto = 800) {
	var vjUrl="pdf/repComprobante_Permiso.php?id=" + idRegistro; //Maestra seleccionada
	var posicion_x=(screen.width/2)-(piAncho/2); //posicion horizontal en la pantalla
	var posicion_y=(screen.height/2)-(piAlto/2); //posicion vertical en la pantalla
	//document.getElementById("vvOpcion").value = pvValor; //valor.vista.Opcion del hidden
	//Crea una ventana donde muestra todos los listar de las diversas maestras
	window.open(vjUrl,'Listado de Accesos', 'width='+parseInt(piAncho),  'height='+parseInt(piAlto), 'left='+posicion_x,'top='+posicion_y, 'directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=yes');
	//if (window.focus) {newwindow.focus()}
}
