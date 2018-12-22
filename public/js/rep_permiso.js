
lsVista = "Rep_Permiso";

//al cargar el documento
$( function() {
    //funcion en jsc_Reporte que genera los option en los select de la A a la Z
    //para los rangos de reporte desde letra inicial hasta letra incial
    fjComboGeneral("Trabajador");

    fjSinRango();
 
    //todos los registros
    $("#radRangoTipoT").click(function () {  
        fjSinRango();
    });
    //rango fuera o dentro
    $("#radRangoTipoD , #radRangoTipoF ").click(function () {    
        fjConRango();
    });
 
    $("#radRangoTrabajador").click(function () {     
        fjRangoTrabajador();
    });

    $("#radRangoEstatus").click(function () {    
        fjRangoEstatus();
    });

    $("#radRangoFecha").click(function () {    
        fjRangoFecha();
    });
 
    //se retrasa el desabilitado mientras carga de la base de datos
    setTimeout(
        function () {
            $("#cmbTrabajador").attr( 'disabled' , true );
        },
        1000
    );
});




function enviar(ps = "" ) {
    // alert("sdasdasdas");
    let arrFormulario = $( "#form" + lsVista );
    var vsEstatus = document.getElementById("cmbCondicion");
    var viTrabajador = document.getElementById("cmbTrabajador");
    var vsFechaI = document.getElementById("ctxFechaInicio");
    var vsFechaF = document.getElementById("ctxFechaFinal");

    if ( document.getElementById("radRangoEstatus").checked == true ) {
        if ( vsEstatus.value.trim() == "" ) {
            vbComprobar = false;
            swal({
                title: '¡Atención!',
                html: "Selecciono rango especifico de estatus <br /> Y este debe ser seleccionado para <b>" + pvValor.toUpperCase() + "</b>" ,
                type: 'error',
                confirmButtonText: 'Ok',
                showCloseButton: true
            }).then( ( result ) => {
                vsEstatus.focus(); //enfoca el cursor en el campo que falta del formulario
            });
            return;
        }
    }


    if ( document.getElementById("radRangoTrabajador").checked == true ) {
        if ( viTrabajador.value.trim() == "" ) {
            vbComprobar = false;
            swal({
                title: '¡Atención!',
                html: "Selecciono rango especifico de trabajador <br /> Y este debe estar seleccionado para <b>" + pvValor.toUpperCase() + "</b>" ,
                type: 'error',
                confirmButtonText: 'Ok',
                showCloseButton: true
            }).then( ( result ) => {
                viTrabajador.focus(); //enfoca el cursor en el campo que falta del formulario
            });
            return;
        }
    }

    if ( document.getElementById("radRangoFecha").checked == true ) {
        if ( vsFechaI.value.trim() == "" ) {
            vbComprobar = false;
            swal({
                title: '¡Atención!',
                html: "Selecciono rango de fechas <br /> Y la fecha inicial no puede estar vacia para <b>" + pvValor.toUpperCase() + "</b>" ,
                type: 'error',
                confirmButtonText: 'Ok',
                showCloseButton: true
            }).then( ( result ) => {
                vsFechaI.focus(); //enfoca el cursor en el campo que falta del formulario
            });
            return;
        }
        if ( vsFechaF.value.trim() == "" ) {
            vbComprobar = false;
            swal({
                title: '¡Atención!',
                html: "Selecciono rango de fechas <br /> Y la fecha final no puede estar vacia para <b>" + pvValor.toUpperCase() + "</b>" ,
                type: 'error',
                confirmButtonText: 'Ok',
                showCloseButton: true
            }).then( ( result ) => {
                vsFechaF.focus(); //enfoca el cursor en el campo que falta del formulario
            });
            return;
        }
    }

    arrFormulario.submit(); //Envía el formulario
    // alert(vsModulo);
    // alert(lsVista);
}



//FUNCIONES PARA LAS VISTAS QUE TIENEN SOLO ID, NONBRE, ESTATUS

function fjSinRango() {
    //$('input:radio[name=radRangoTipo]:checked').val();

    $("#radRangoEstatus").attr( 'disabled' , true );
    $("#cmbCondicion").attr( 'disabled' , true );

    $("#radRangoFecha").attr( 'disabled' , true );
    $("#ctxFechaInicio").attr( 'disabled' , true );
    $("#ctxFechaFinal").attr( 'disabled' , true );

    $("#radRangoTrabajador").attr( 'disabled' , true );
    $("#cmbTrabajador").attr( 'disabled' , true );

}

function fjConRango() {
    //$('input:radio[name=radRangoTipo]:checked').val();
    //$('input:radio[id=radRangoEstatus]:checked').val();
    //$('#radRangoEstatus').prop( "checked" , true );
    $("#radRangoTrabajador").attr( 'disabled' , false );
    $("#radRangoEstatus").attr( 'disabled' , false );
    $("#radRangoFecha").attr( 'disabled' , false );
    fjRangoEstatus();
}

function fjRangoTrabajador() {
    //$('input:radio[name=radRango]:checked').val();
    $("#radRangoTrabajador").prop( 'checked' , true );
    $("#cmbTrabajador").attr( 'disabled' , false );

    $("#cmbCondicion").attr( 'disabled' , true );

    $("#ctxFechaInicio").attr( 'disabled' , true );
    $("#ctxFechaFinal").attr( 'disabled' , true );
}

function fjRangoEstatus() {
    //$('input:radio[name=radRango]:checked').val();
    $("#cmbTrabajador").attr( 'disabled' , true );

    $("#radRangoEstatus").prop( 'checked' , true );
    $("#cmbCondicion").attr( 'disabled' , false )
    ;
    $("#ctxFechaInicio").attr( 'disabled' , true );
    $("#ctxFechaFinal").attr( 'disabled' , true );
}


function fjRangoFecha() {
    //$('input:radio[name=radRango]:checked').val();
    // $("#radRangoEstatus").prop( 'checked' , true );
    $("#cmbTrabajador").attr( 'disabled' , true );

    $("#cmbCondicion").attr( 'disabled' , true );

    $("#radRangoFecha").prop( 'checked' , true );
    $("#ctxFechaInicio").attr( 'disabled' , false );
    $("#ctxFechaFinal").attr( 'disabled' , false );
}


