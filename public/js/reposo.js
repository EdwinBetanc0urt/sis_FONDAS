
var lsVista = "Reposo";

$(function () {
	fjActualizarListas();

	$("#ctxFechaInicio").on("change, blur, focus, input", function(){
    	fjFechaFinal(this.value, $("#cmbMotivo_Reposo").val());
	});
	$("#cmbMotivo_Reposo").on("change", function(){
    	fjFechaFinal($("#ctxFechaInicio").val(), this.value);
	});
});

function fjAprobar(piReposo = "") {
	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conReposo.php";

	swal({
		html: "¿Está seguro de dar visto bueno a este reposo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Aceptar!",
		cancelButtonText: "Cancelar!",
		input: "textarea",
		showCloseButton: true
	}).then((result) => {
		if (result.value) {
			$.post(vsRuta, {
					//variables enviadas (name: valor)
					operacion: "AprobarReposos",
					idreposo: parseInt(piReposo),
					observacion: result.value.trim()
				},
				function (resultado) {
					if (resultado == false)
						console.log("sin consultas ");
					else {
						fjActualizarListas();
						console.log(resultado);
					}
				}
			);
		}
	});
}

function fjRechazar(piReposo = "") {
	//abre el archivo controlador y envia por POST
	vsRuta = "controlador/conReposo.php";

	swal({
		html: "¿Está seguro que no dara visto bueno a este reposo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Aceptar!",
		cancelButtonText: "Cancelar!",
		input: "textarea",
		showCloseButton: true
	}).then((result) => {
		if (result.value) {
			$.post(vsRuta, {
					//variables enviadas (name: valor)
					operacion: "RechazarReposos",
					idreposo: parseInt(piReposo),
					observacion: result.value.trim()
				},
				function(resultado) {
					if(resultado == false)
						console.log("sin consultas ");
					else {
						console.log(resultado);
						fjActualizarListas();
					}
				}
			);
		}
	});
}

function fjActualizarListas() {
	fjMostrarLista(lsVista);
	fjMostrarLista(lsVista, "", "", lsVista + "EnCurso", "ListaViewEnCurso");
	fjMostrarLista(lsVista, "", "", lsVista + "Culminado", "ListaViewCulminado");
	fjMostrarLista(lsVista, "", "", lsVista + "Rechazado", "ListaViewRechazado");
}
