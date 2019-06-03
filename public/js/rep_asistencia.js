
lsVista = "Rep_Asistencia";

//al cargar el documento
$(function() {
    $("#ctxFechaInicio")
        .attr('max', clientDateTime('d'))
        .on('change', function() {
            $("#ctxFechaFinal")
                .val(null)
                .attr('min', this.value)
                .attr('max', clientDateTime('d'));
        });
    $("#ctxFechaFinal").attr('max', clientDateTime('d'));

    //funcion en jsc_Reporte que genera los option en los select de la A a la Z
    //para los rangos de reporte desde letra inicial hasta letra incial
    fjComboGeneral("Trabajador");

    fjSinRango();

    //todos los registros
    $("#radRangoTipoT").click(function () {
        fjSinRango();
    });
    //rango fuera o dentro
    $("#radRangoTipoD, #radRangoTipoF ").click(function () {
        fjConRango();
    });

    $("#radRangoTrabajador").click(function () {
        fjRangoTrabajador();
    });

    //se retrasa el desabilitado mientras carga de la base de datos
    setTimeout(
        function () {
            $("#cmbTrabajador").attr('disabled', true);
        },
        1000
    );
});

function enviar(psOpcion) {
    let arrFormulario = $("#form" + lsVista);
    var viTrabajador = document.getElementById("cmbTrabajador");
    var vsFechaI = document.getElementById("ctxFechaInicio");
    var vsFechaF = document.getElementById("ctxFechaFinal");

    if(vsFechaI.value.trim() == "") {
        vbComprobar = false;
        swal({
            title: '¡Atención!',
            html: "La fecha inicial no puede estar vacia para <b>" + psOpcion.toUpperCase() + "</b>",
            type: 'error',
            confirmButtonText: 'Ok',
            showCloseButton: true
        }).then((result) => {
            vsFechaI.focus(); //enfoca el cursor en el campo que falta del formulario
        });
        return;
    }
    if(vsFechaF.value.trim() == "") {
        vbComprobar = false;
        swal({
            title: '¡Atención!',
            html: "La fecha final no puede estar vacia para <b>" + psOpcion.toUpperCase() + "</b>",
            type: 'error',
            confirmButtonText: 'Ok',
            showCloseButton: true
        }).then((result) => {
            vsFechaF.focus(); //enfoca el cursor en el campo que falta del formulario
        });
        return;
    }

    if(document.getElementById("radRangoTrabajador").checked == true) {
        if(viTrabajador.value.trim() == "") {
            vbComprobar = false;
            swal({
                title: '¡Atención!',
                html: "Selecciono rango especifico de trabajador <br /> Y este debe estar seleccionado para <b>" + psOpcion.toUpperCase() + "</b>",
                type: 'error',
                confirmButtonText: 'Ok',
                showCloseButton: true
            }).then((result) => {
                viTrabajador.focus(); //enfoca el cursor en el campo que falta del formulario
            });
            return;
        }
    }

    $('#operacion').val(psOpcion);
    arrFormulario.submit(); //Envía el formulario
}

//FUNCIONES PARA LAS VISTAS QUE TIENEN SOLO ID, NONBRE, ESTATUS
function fjSinRango() {
    //$('input:radio[name=radRangoTipo]:checked').val();
    $("#radRangoTrabajador").attr('disabled', true);
    $("#cmbTrabajador").attr('disabled', true);

}

function fjConRango() {
    //$('input:radio[name=radRangoTipo]:checked').val();
    //$('input:radio[id=radRangoEstatus]:checked').val();
    //$('#radRangoEstatus').prop("checked", true);
    $("#radRangoTrabajador").attr('disabled', false);
}

function fjRangoTrabajador() {
    //$('input:radio[name=radRango]:checked').val();
    $("#radRangoTrabajador").prop('checked', true);
    $("#cmbTrabajador").attr('disabled', false);
}
