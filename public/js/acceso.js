
var lsVista = "Acceso";

$(function(){

	fjComboGeneral("Tipo_Usuario");
	fjComboGeneral("Modulo");

	//$("#cmbModulo").attr("disabled", true);

	$("#cmbTipo_Usuario").change(function() {
		console.log(this.value);
		$("#cmbModulo").attr("disabled", false);
		fjListaAcceso(this.value, $("#cmbModulo").val());
	});

	$("#cmbModulo").change(function() {
		console.log(this.value);
		//fjMostrarListaAcceso(lsVista);
		fjListaAcceso($("#cmbTipo_Usuario").val(), this.value);
	});

	$("#cmbTipo_Usuario").select2("open") ;
});



//comprueba si fue seleecionado por lo menos 1 elemento
function fjComprobarChekcbox() {
	if($('.chkBotones').is(':checked')) {
		return true;
	}
	else
		return false;
}



function fjEnviar(pvValor) {
	//se definen las variables locales
	let arrFormulario = $("#form" + lsVista);
	let liTipoUsuario = $("#cmbTipo_Usuario");
	let liModulo = $("#cmbModulo");
	let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía

	if(fjComprobarChekcbox()) {
		//si el ctxNombre está val botón pulsado es igual a Registrar o Modificar no enviara el formulario
		if(liTipoUsuario.val().trim() === "") {
			vbComprobar = false;
			//alert(" HA OCURRIDO UN ERROR \n El ROL no ha sido seleccionado ");
			swal({
				title: '¡Atencion!',
				text: 'HA OCURRIDO UN ERROR <br /> El TIPO DE USUARIO no ha sido seleccionado ',
				type: 'info',
				confirmButtonText: 'Ok'
			}).then((result) => {
				liTipoUsuario.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	}
	else {
		//alert(" DEBE SELEECIONAR POR LO MENOS UN (1) BOTON \n Para poder " + pvValor + " algun Acceso");
		swal({
				title: '¡Atencion!',
				text: 'Debe seleccionar por lo menos (1) BOTON \n Para poder ASIGNAR ACCESOS',
				type: 'warning',
				confirmButtonText: 'Ok'
			});
		vbComprobar = false;
		return;
	}
	
	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if(vbComprobar) {
		document.getElementById("operacion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}


//Elimina todos los accesos
function fjQuitarVista(piVista) {
	let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía
	let vsNombreVista = $("#ctxNombreVista" + piVista);
	let liTipoUsuario = $("#cmbTipo_Usuario");
	swal({
		title: '¡Atencion!',
		html: "¿Esta seguro que desea quitar todos los accesos de la pagina <b>" + vsNombreVista.val() + "</b>? <br> Esto restringira el acceso total a la misma",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si',
		showCloseButton: true,
		cancelButtonText: 'No',
	}).then((result) => {

		vsRuta = "controlador/conAcceso.php";
		$.post(vsRuta, { 
				//variables enviadas (name: valor)
				operacion: "EliminaVista", //abre la funcion en el controlador 
				setTipoUsuario: liTipoUsuario.val(),
				setVista: piVista 
			},
			function(resultado) {
				if(resultado == false)
					console.log("sin consultas ");
				else {
					
					vjResultado = document.getElementById("divListaAcceso") ; //*/$("#divListaAcceso").val();
					vjResultado.innerHTML = "";
					fjListaAcceso();
					//console.log(resultado);	
				}
			}
		);
	}, function(dismiss) {
		swal({
			title: 'Cancelado!',
			html: 'Se cancelo la operacion, no se realizaron cambios',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		});
	});
}



//selecciona o deselecciona el checkbox con solo tocar la fila
//para mejor facilidad al hacerlo con pantallas pequeñas
function fjSeleccionFila(paRegistro) {
	var viId = "chkBoton" + paRegistro.getAttribute('datos_id');
	//$('#' + viId).attr('checked', true) 
	if($("#" + viId).is(':checked')) {
		$("#" + viId).attr("checked", false); //deshabilita el campo
	}
	else {
			$("#" + viId).attr("checked", true); //deshabilita el campo
	}
}



//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjListaAcceso(piTipoUsuario = "", piModulo = "") {
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
	vsRuta = "controlador/conAcceso.php";

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


