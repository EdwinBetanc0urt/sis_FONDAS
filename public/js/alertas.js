
//función javascript Mensajes, utilizado por las operaciones Incluir, Consultar, Modificar,
// Eliminar y Restaurar de las maestras, ademas de acciones del login
function fjMensajes( pvValorUrl ) { //parámetro de la vista (msjMensaje) que contiene los valores

    var colorFondo = "#e1e1e1";

    //si la búsqueda de la palabra noeliminousados en la cadena pvValorUrl no da error
    if ( pvValorUrl.search( "noeliminousados" ) !== - 1 ) {
        //if ( pvValorUrl.lastIndexOf("noeliminousados") != -1 )
        //toma los caracteres a partir de la posición 15 (los números del URL a la derecha de msjAlerta=noeliminousados2342)
        var vjRegistros = pvValorUrl.substring( 15 );
        //alert("No puede ser eliminado, es usado en: <br />   " + vjRegistros + " Registro(s)");
        swal({
            title: '¡Atención!',
            html: "No puede ser eliminado, es usado en: <br />   " + vjRegistros + " Registro(s)",
            type: 'error',
            confirmButtonText: 'Ok',
            background: '#b1b1b1' ,
            showCloseButton: true
        });
    }

    //si la búsqueda de la palabra noeliminousados en la cadena pvValorUrl no da error
    if ( pvValorUrl.search( "claverepetida" ) !== - 1 ) {
        //if ( pvValorUrl.lastIndexOf("noeliminousados") != -1 )
        //toma los caracteres a partir de la posición 13 (los números del URL a la derecha de msjAlerta=claverepetida5)
        var vjRango = pvValorUrl.substring( 13 );
        //alert("La clave debe ser diferente a las ultimas: <br />   " + vjRango + " claves que ha utilizado");
        swal({
            title: '¡Clave Repetida!',
            html: "La clave debe ser diferente a las ultimas: <br />   " + vjRango + " claves que ha utilizado",
            type: 'error',
            showCloseButton: true,
            background: colorFondo ,
            confirmButtonText: 'Ok'
        });
    }


    switch ( pvValorUrl ) {

        /*
        default:
            alert("Instituto Venezolano de Seguros Sociales <br />");
            break;
        */

        // si se solicita una pagina en construcción
        case "claverecuperada":
            swal({
                title: '¡Atención!',
                html: 'La clave ha sido recuperada exitosamente.',
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

            
        // si se solicita una pagina en construcción
        case "claveerrada":
            swal({
                title: '¡Atención!',
                html: 'La clave introducida es incorrecta.',
                type: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
			
			
        // si se solicita una pagina en construcción
        case "mantenimiento":
            swal({
                title: '¡Atención!',
                html: 'Pagina actualmente en mantenimiento.',
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

            // si se solicita una pagina en construcción
        case "accesoprohibido":
            swal({
                title: '¡Cuidado!',
                html: 'Hubo un intento de acceso a secciones restringidas, si continua tratando de acceder a dichas secciones sin los privilegios adecuados sera BLOQUEADO.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

            // si se CONSULTA la tabla en la base de datos
        case "sinconsulta":
            swal({
                title: '¡Ops!',
                html: 'No se encontró el registro buscado.',
                type: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;


        // si se REGISTRA en la base de datos una transaccion
        case "guardo":
            swal({
                title: '¡Hecho!',
                html: 'Registro guardado exitosamente',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "noguardo":
            swal({
                title: '¡Error!',
                html: 'El registro no fue guardado.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;

            // si se REGISTRA en la base de datos
        case "registro":
            swal({
                title: '¡Hecho!',
                html: 'Registro guardado exitosamente',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "noregistro":
            swal({
                title: '¡Error!',
                html: 'El registro no fue guardado.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "duplicado":
            swal({
                title: '¡Atención!',
                html: 'Registro duplicado, no sera registrado.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;



        case "pasado":
            swal({
                title: '¡Atención!',
                html: 'El Periodo a Gestionar se encuentra fuera del Rango valido, verifique e intentelo nuevamente.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
        case "verificar":
            swal({
                title: '¡Atención!',
                html: 'No se ha podido Registrar el Periodo, por favor verifique la fecha de Inicio y Final.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
        case "pabierto":
            swal({
                title: '¡Atención!',
                html: 'El Periodo ya se encuentra Abierto.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "pcerrado":
            swal({
                title: '¡Atención!',
                html: 'El Periodo ya se encuentra Cerrado.',
                type: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "abierto":
            swal({
                title: '¡Abierto!',
                html: 'El Periodo se Abrió correctamente.',
                type: 'success',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "cerrado":
            swal({
                title: '¡Cerrado!',
                html: 'El Periodo se cerro correctamente.',
                type: 'success',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "desactivado":
            swal({
                title: '¡Desactivado!',
                html: 'El registro esta actualmente desactivado.',
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "anulado":
            swal({
                title: '¡Anulado!',
                html: 'Registro anulado con éxito.',
                type: 'success',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "noanulado":
            swal({
                title: '¡No Anulado!',
                html: 'El registro no fue anulado. Revise la fecha en la que fue creada.',
                type: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "procesado":
            swal({
                title: '¡Procesado!',
                html: 'Registro procesado con éxito.',
                type: 'success',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
        case "noprocesado":
            swal({
                title: '¡No Procesado!',
                html: 'El registro no fue procesado con éxito.',
                type: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "aprobado":
            swal({
                title: '¡Aprobado!',
                html: 'Registro aprobado con éxito.',
                type: 'success',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
        case "noaprobado":
            //alert("El registro no fue aprobado.");
            swal({
                title: '¡Procesado!',
                html: 'El registro no fue aprobado.',
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
        case "rechazado":
            //alert("El registro no fue aprobado.");
            swal({
                title: '¡Procesado!',
                html: 'Solicitud Rechazada.',
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;

        case "espera":
            swal({
                title: '¡Agregado!',
                html: 'Registro agregado en espera con éxito.',
                type: 'success',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;
        case "noespera":
            //alert("El registro no fue agregado a espera.");
            swal({
                title: '¡No Agregado!',
                html: 'El registro no fue agregado a espera.',
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok'
            });
            break;


            // si se MODIFICA en la base de datos
        case "nocambio":
            swal({
                title: '¡Atención!',
                html: 'No se realizaron cambios.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "cambio":
            swal({
                title: '¡Hecho!',
                html: 'Cambios realizados con éxito.',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "igual":
            swal({
                title: '¡Duplicado!',
                html: 'No se realizaron cambios porque ya existe un registro igual.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;



            // si se ELIMINA en la base de datos
        case "elimino":
            swal({
                title: '¡Hecho!',
                html: 'El registro se elimino con éxito.',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "noelimino":
            swal({
                title: '¡Error!',
                html: 'Ningún registro se elimino.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
            /*case  ( pvValorUrl.search("noeliminousados") != -1 ):
                vjRegistros=pvValorUrl.substring(15); //toma los caracteres a partir de la posición 15 (los números del URL)
                alert("No puede ser eliminado, ya ha sido usado en: <br />   "+vjRegistros+" Registro(s)");
                break;*/



            // si se RESTAURA en la base de datos
        case "restauro":
            swal({
                title: '¡Hecho!',
                html: 'Registro restaurado con éxito.',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "norestauro":
            swal({
                title: '¡Error!',
                html: 'El registro no se restauro.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;

            // si se Desbloquea un usuario en la base de datos
        case "desbloqueo":
            swal({
                title: '¡Hecho!',
                html: 'Usuario desbloqueado con éxito.',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "nodesbloqueo":
            swal({
                title: '¡Error!',
                html: 'El Usuario no se desbloqueo.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;

            //viene del ctr_AsignarRol.php cuando usuario con menos acceso intenta cambiar rol a un superior
        case "rolmayor":
            swal({
                title: '¡Atención!',
                html: 'Sin cambios,<br /> debes tener un rol igual o mayor para cambiar el rol de este usuario..',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;


            // viene del ctr_CambiarClave y ctr_RecuperarClave
        case "respuestaincorrecta":
            swal({
                title: '¡Incorrecto!',
                html: 'Alguna o todas de las respuestas de secretas son incorrectas.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;


            // mensaje de ctr_RecuperarClave, exitoso
        case "clavecambio":
            swal({
                title: '¡Hecho!',
                html: 'Clave cambiada con éxito.',
                type: 'success',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
        case "clavenocambio":
            swal({
                title: '¡Error!',
                html: 'La clave no ha sido cambiada.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;

            //mensaje de ctr_Login.php
        case "logindeshabilitado":
            swal({
                title: '¡Atención!',
                html: 'Usuario inhabilitado... <br /> Contacte con usuario con privilegios para habilitar su Usuario.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;


            //mensaje ce ctr_Login.php si responde mal la contraseña
        case "claveousaurio":
            swal({
                title: '¡Atención!',
                type: 'error',
                html: 'USUARIO O CONTRASEÑA INCORRECTA...<br /> Por favor verifique e intente nuevamente.',
                showCloseButton: true,
                //background: colorFondo ,
                confirmButtonText: 'Ok'
            }).then( ( result ) => {
                if ( result.value ) {
                   $( "#ctxUsuario").focus();
                }
                else {
                    $( "#ctxUsuario").focus();
                }
            });
            /*document.getElementById("ctxUsuario").value = ""; //blanquea el usuario
            document.getElementById("pswClave").value = ""; //blanquea la contraseña*/
            break;


            //mensaje ce ctr_Login.php si responde mal la contraseña
        case "bloqueo_intentos":
            swal({
                title: '¡Atención!',
                html: 'USUARIO BLOQUEADO... <br /> Ha superado el máximo de intentos permitidos.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            /*document.getElementById("ctxUsuario").value = ""; //blanquea el usuario
            document.getElementById("pswClave").value = ""; //blanquea la contraseña*/
            break;


            //mensaje ce ctr_Login.php si responde mal la contraseña
        case "usuariobloqueado":
            swal({
                title: '¡Atención!',
                html: 'USUARIO BLOQUEADO... <br />por favor contacte soporte tecnico.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            /*document.getElementById("ctxUsuario").value = ""; //blanquea el usuario
            document.getElementById("pswClave").value = ""; //blanquea la contraseña*/
            break;


            //mensaje de ctr_Login de ctr_RecuperarClave al no encontrar usuario
        case "nousuario":
            swal({
                title: '¡Atención!',
                html: 'No se encontró el Usuario buscado.',
                type: 'error',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;


            //mensaje de ctr_Login si hay una sesión abierta
        case "enlinea":
            swal({
                title: '¡Atención!',
                html: 'USUARIO EN LINEA (ONLINE). <br /> No puede tener abierta mas de 1 vez las misma sesión del mismo usuario.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;

        case "tiempoexpirado":
            swal({
                title: '¡Atención!',
                html: 'TIEMPO DE SESION EXPIRADO. <br /> el usuario supero su máximo de tiempo inactivo.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;

        case "completadatos":
            swal({
                title: '¡Atención!',
                html: 'Es requerido que complete sus datos antes de iniciar sesión.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;


            //mensaje de ctr_AccesoRol al eliminar todos los accesos de un rol
        case "quitoacceso":
            swal({
                title: '¡Atención!',
                html: 'Se quitaron todos los accesos a la vista seleccionada.',
                type: 'info',
                showCloseButton: true,
                background: colorFondo ,
                confirmButtonText: 'Ok'
            });
            break;
    }
}