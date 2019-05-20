
$(function(){
	$('#btn_recargar').click(function(){
		document.location.reload();
		return false;
	});

	CargarCaptcha();

	//document.getElementById("hidDireccion").value = vsDireccion;
	//$("#hidDireccion").val(vsDireccion) ;
	$("#usuario, #clave").on('keyup keypress keydown change', function(){
		//caracteres a excluir
		this.value = fjQuitarTildes(this.value);
		//this.value = this.value.replace(/[¨´`'"~¡!¿? @#$%^&()°¬|=;:,<>\{\}\[\]\\\/]/gi, '');
		this.value = this.value.replace(/[^0-9.+*\-_$a-zñ]/gi, '');
	});

	$("#usuario, #clave").on('copy', function(){
		fjNocopiar();
	});
	$("#usuario, #clave").on('cut', function(){
		fjNoCortar();
	});
	$("#usuario, #clave").on('paste', function(){
		fjNoPegar();
	});
	$("#usuario, #clave").on('paste', function(){
		fjNoPegar();
	});

	$("body").on('contextmenu', function(e){
		e.preventDefault();
		disableMenuContextual();
	});
});

//desactiva la tecla F12
document.onkeydown = function(evento) {
	//console.log(evento);
	if(evento.keyCode == 123 || evento.which == 123 || evento.key == "F12" || evento.code == "F12") {
		//alert(evento);
		console.log("tecla F12 bloqueado");
		return false;
	}
}

//Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function CargarCaptcha() {
	$.post("controlador/conLogin.php", {
			operacion: "ReCaptcha",
		},
		function(resultado) {
			if (resultado == false) {
				console.log("sin consultas de " + psClase);
			}
			else {
				$("#captcha").val(""); //habilita el campo de estado
				$("#captcha").val(resultado); //habilita el campo de estado
				console.log(resultado);
			}
		}
	);
}

function f_Submit(){
	var user=document.getElementById("usuario");
	var pass=document.getElementById("clave");
	var copia=document.getElementById("txtcopia");
	var captcha=document.getElementById("captcha");

	if(user.value.trim() == ""){
		swal({
			title: '¡Atención!',
			html: 'Ingrese El Usuario.',
			footer: "EL USUARIO ES OBLIGATORIO, NO PUEDE ESTAR VACIO",
			type: 'error',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			user.focus();
		});
		return false;
	}
	else if (pass.value.trim() == "") {
		swal({
			title: '¡Atención!',
			html: 'Ingrese La Clave.',
			footer: "LA CLAVE ES OBLIGATORIA, NO PUEDE ESTAR VACIA.",
			showCloseButton: true,
			type: 'error',
			confirmButtonText: 'Ok'
		}).then((result) => {
			pass.focus();
		});
		return false;
	}
	else if (copia.value.trim() == ""){
		swal({
			title: '¡Atención!',
			html: 'Ingrese Código Captcha',
			footer: "ESTE CAMPO ES OBLIGATORIO NO PUEDE ESTAR VACIA.",
			showCloseButton: true,
			type: 'error',
			confirmButtonText: 'Ok'
		}).then((result) => {
			copia.focus();
		});
		return false;
	}
	else if(copia.value != captcha.value){
		swal({
			title: '¡Atención!',
			html: 'Código no Coincide',
			footer: "ingrese código valido, tome en cuenta mayúsculas y minúsculas",
			type: 'error',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			copia.focus();
		});
		return false;
	}
}

function desplegar() {
	$("#formRecuperarClave")[0].reset();
	fjComboGeneral("Pregunta");
	fjComboGeneral("Pregunta", "", "Pregunta2");
	$("#formRecuperarClave #ctxUsuario").focus();
}

//Función para recuperar la contraseña
function enviar(pvValor) {
	let arrFormulario = "#formRecuperarClave";
	let vsUsuario = $(arrFormulario + " #ctxUsuario");
	let vsPregunta = $(arrFormulario + " #cmbPregunta");
	let vsPregunta2 = $(arrFormulario + " #cmbPregunta2");
	let vsClave = $(arrFormulario + " #pswClave");
	let vsClave2 = $(arrFormulario + " #pswClave2");
	let vsRespuesta = $(arrFormulario + " #ctxRespuesta");
	let vsRespuesta2 = $(arrFormulario + " #ctxRespuesta2");
	let vbComprobar = true; // verifica que todo este true o un solo false no envía

	if (pvValor === "RecuperarClave") {
		if (vsUsuario.val().trim() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				text: 'EL USUARIO ES OBLIGATORIO, NO PUEDE ESTAR VACIO',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsUsuario.focus();
			});
			return vbComprobar;
		}
		if (vsPregunta.val().trim() == "" || vsPregunta2.val().trim() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'DEBE SELECCIONAR LA PREGUNTA DE SEGURIDAD <br /> De la cual ' +
					'usted previamente registro ',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok'
			}).then((result) => {
				if (vsPregunta.val().trim() == "") {
					vsPregunta.focus();
				}
				else {
					vsPregunta2.focus();
				}
			});
			return vbComprobar;
		}
		if (vsRespuesta.val().trim() == "" || vsRespuesta2.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'LA RESPUESTA ES OBLIGATORIA <br> Por su seguridad debe colocar ' +
					'la respuesta correcta ',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok'
			}).then((result) => {
				if (vsRespuesta.val().trim() == "") {
					vsPregunta.focus();
				}
				else {
					vsRespuesta2.focus();
				}
			});
			return vbComprobar;
		}
		if (vsClave.val().trim() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'LA CLAVE ES OBLIGATORIA <br> No puede estar vacía.',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsClave.focus();
			});
			return vbComprobar;
		}
		else if (vsClave2.val() == "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'LA CLAVE DE CONFIRMACIÓN ES OBLIGATORIA <br> No puede estar vacía.',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok'
			}).then((result) => {
				vsClave2.focus();
			});
			return vbComprobar;
		}
		else {
			vbComprobar = valida_clave();
		}
	}

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#formRecuperarClave #operacion").val(pvValor); //valor.vista.Opcion del hidden
		$("#formRecuperarClave").submit(); //Envía el formulario
		//arrFormulario.submit(); //Envía el formulario
	}
} // cierre de la función enviar

// función.javascript.Enviar (parámetro.vista.Valor)
function valida_clave (pvValor) {
	let arrFormulario = "#formRecuperarClave";
	let vsClave = $(arrFormulario + " #pswClave");
	let vsClave2 = $(arrFormulario + " #pswClave2");
	let vbComprobar = true; // verifica que todo este true o un solo false no envía

	if (vsClave.val().trim() === "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'LA CLAVE ES OBLIGATORIA <br /> No puede estar vacía.',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			vsClave.focus();
		});
		vjClave.focus(); // enfoca el cursor en el campo que falta del formulario
		return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
	}
	if (vsClave.val().trim().length <= 4) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'La clave debe ser mayor o igual a 5 caracteres. Ejemplos:<br> ' +
				'abcde<br> 12345<br> a1b2c',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			vsClave.focus();
		});
		return vbComprobar;
	}
	if (vsClave.val().trim().length >= 25) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'La clave debe ser menor o igual a 25 caracteres. Ejemplos:<br>' +
				'abcde<br> 12345<br> a1b2c',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			vsClave.focus();
		});
		return vbComprobar;
	}
	if (vsClave2.val().trim() === "") {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'LA CONFIRMACIÓN DE CLAVE ES OBLIGATORIA:<br>	No puede estar vacía ' +
				'para ' + pvValor.toUpperCase(),
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			vsClave2.focus(); // enfoca el cursor en el campo que falta del formulario
		});
		return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
	}
	if (vsClave.val().trim() != vsClave2.val().trim()) {
		vbComprobar = false;
		swal({
			title: '¡Atención!',
			html: 'LAS CLAVES NO COINCIDEN, por favor verifique.',
			type: 'info',
			showCloseButton: true,
			confirmButtonText: 'Ok'
		}).then((result) => {
			vsClave.focus();
		});
		vsClave.val(""); // se limpia la primera clave
		vsClave2.val(""); // se limpia la clave de confirmación
		vsClave2.focus(); // enfoca el cursor en el campo que falta del formulario
		return vbComprobar; // rompe la función para que el usuario verifique antes de continuar
	}

	return vbComprobar;
} // cierre de la función valida_clave
