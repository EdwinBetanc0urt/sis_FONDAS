

var lsVista = "Mi_Perfil";


//funcion.javascript.Enviar (parametro.vista.Valor)
function enviar(pvValor) {
	let arrFormulario = $("#form" + lsVista);
	var viCodigo = document.getElementById("numId");
	var vsNombre = document.getElementById("ctxNombre");
	var vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

	//si el cod está vació y el botón pulsado es igual a Registrar o Modificar no enviara el formulario
	if (vsNombre.value.trim() === "" && pvValor === "Guardar") {
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



$(function () {

	fjObtenerDatos();

	fjComboGeneral("Estado");

	$("#cmbMunicipio").attr("disabled", true);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbEstado").change(function() {
		//habilita el combo hijo
		$("#cmbMunicipio").attr("disabled", false);
		$("#cmbMunicipio").val(""); //deselecciona el campo del combo
		$("#hidMunicipio").val(""); //blanquea el campo del hidden
		//fjCargarMunicipio();
		fjComboGeneral("Municipio", "Estado");

		$("#cmbParroquia").val(""); //deselecciona el campo del combo
		$("#hidParroquia").val(""); //blanquea el campo del hidden
		$("#cmbParroquia").attr("disabled", true); //desabilita el combo de 3er nivel
	});


	$("#cmbParroquia").attr("disabled", true);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbMunicipio").change(function() {
		//habilita el combo de 2do nivel
		$("#cmbParroquia").attr("disabled", false);
		$("#cmbParroquia").val(""); //deselecciona el campo del combo
		$("#hidParroquia").val(""); //blanquea el campo del hidden
		//fjCargarMunicipio();
		fjComboGeneral("Parroquia", "Municipio");
	});


});






function fjObtenerDatos() {
    //abre el archivo controlador y envia por POST
    console.log($("#form" + lsVista + " #idpersona").val()  + " el id de persona");
    let vsRuta = "controlador/con" + lsVista + ".php";
    $.post(vsRuta, { 
            //variables enviadas (name: valor)
            operacion: "Consultar" //abre la función de la lista en el controlador 
        },
        function(resultado) {
            if(resultado == false)
                console.log("sin consultas de busqueda de " + psClase);
            else {
                console.log(resultado);
 				$("#form" + lsVista + " #ctxNombre").val(resultado.nombre);
 				$("#form" + lsVista + " #ctxNombre2").val(resultado.seg_nombre);
 				$("#form" + lsVista + " #ctxApellido").val(resultado.apellido);
 				$("#form" + lsVista + " #ctxApellido2").val(resultado.seg_apellido);
 				$("#form" + lsVista + " #ctxCorreo").val(resultado.correo);
 				$("#form" + lsVista + " #numTelefono").val(resultado.tel_mov);
 				$("#form" + lsVista + " #numTelefono2").val(resultado.tel_fijo);
 				$("#form" + lsVista + " #ctxDireccion").val(resultado.direccion);
 				$("#form" + lsVista + " #cmbSexo").val(resultado.sexo);
 				$("#form" + lsVista + " #cmbEdoCivil").val(resultado.edo_civil);
 				$("#form" + lsVista + " #datFechaNac").val(resultado.fecha_naci);

				$("#cmbMunicipio").attr("disabled", false);
 				$("#form" + lsVista + " #hidEstado").val(resultado.idestado);
 				fjComboGeneral("Estado");

				$("#cmbParroquia").attr("disabled", false);
 				$("#form" + lsVista + " #hidMunicipio").val(resultado.idmunicipio);
 				fjComboGeneral("Municipio", "Estado");

 				$("#form" + lsVista + " #hidParroquia").val(resultado.idparroquia);
 				fjComboGeneral("Parroquia", "Municipio");
            }
        }
  );
}