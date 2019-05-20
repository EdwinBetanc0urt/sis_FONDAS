
// Genera el alfabeto en options dentro del select que se le pase como parametro
// en el parametro va como cadena el id del select a insertar options
function fjAlfabetoCombo(pdCombo) {
    var arrAlfabeto = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's ', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    
    for(i = 0 ; i < arrAlfabeto.length ; i++) {
        //creo el option de la letra
        domLetraActual = $('<option value="' + arrAlfabeto[i] + '">' + arrAlfabeto[i].toUpperCase() + '</option>');
        //console.log(letraActual);
        //lo inserto en el select, en la capa con id botonesletras
        $("#"+ pdCombo).append(domLetraActual);
    }
}

//funcion javascript Salir, utilizado por el botón de OFF del menú
function fjSalir(psMotivo = "sesioncerrada", psForzado = "no") {
    if (psForzado == "no") {
        swal({
            title: '¡SALIR!',
            text: 'Está a punto de cerrar sesión... ¿Seguro que quiere salir del sistema?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            showCloseButton: true,
            confirmButtonText: 'Si, Salir',
            cancelButtonText: 'No, Quedarse'
        }).then((result) => {
            if (result.value) {
                window.location.href = "controlador/conCerrar.php?getMotivoLogOut=" + psMotivo;
            }
            else if (result.dismiss == 'cancel') {
                swal({
                    title: 'Cancelado',
                    text: '¡Gracias por permanecer en la página!',
                    showCloseButton: true,
                    type: 'error'
                });
            }
        });
    } 
    else {
        console.log(psForzado + " salir");
        window.location.href = "controlador/conCerrar.php?getMotivoLogOut=" + psMotivo;
    }
}

// Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjComboGeneral(psClase, psDependiente = "", psDestino = "") {

    let viDependiente = "";
    // abre el archivo controlador y envía por POST
    vsRuta = "controlador/con" + psClase + ".php";
    // si no tiene un código dependiente, padre o foráneo lo envía vació
    if (psDependiente != "") {
        viDependiente = parseInt($("#hid" + psDependiente).val());
        console.log("El padre o matriz es " + psDependiente); 
    }

    if (psDestino != "") {
        psClase =  psDestino;
        console.log("nuevo destino " + psClase);
    }

    $.post(vsRuta, {
            hidCodPadre:  viDependiente,
            operacion: "ListaCombo",
            hidCodigo: $("#hid" + psClase).val() 
        },
        function(resultado) {
            if (resultado == false) {
                console.log("sin consultas de " + psClase);
            }
            else {
                document.getElementById("cmb" + psClase).options.length = 1; //limpia los option del select
                $("#cmb" + psClase).attr("disabled", false); //habilita el campo de estado
                $("#cmb" + psClase).append(resultado); //agrega los nuevos option al select
                // console.log(resultado);
            }
        }
    );
}

$(function() {
    //funcion anonima que al cambiar un select asigna el valor al hidden que esta abajo de el
    //$('select > .dinamico').on('change', function() {
    $('select.dinamico').on('change', function() {
        let vsId = $(this).attr("id"); //toma el id del select
        //toma la cadena desde la posicion 3 hacia la derecha cmbEJEMPLO = EJEMPLO
        let vsClase = vsId.substr(3); //le quita las primeras 3 letras "cmb"
        
        //asigna el valor del select al hidden
        $("#hid" + vsClase).val($(this).val());
        // console.log(vsClase);
        //console.log($("#hid" + vsClase).val());

        //para tomar el texto
        if ($("#hid " + vsClase + "Texto")) {
            //let txt = $("#cmb" + vsClase + " option:selected").text();
            let txt = $("#cmb" + vsClase + " option:selected").html();
            $("#hid " + vsClase + "Texto").val(txt);
            //console.log(txt);
        }
    });
});

function fjUltimoID(pvObjeto, psDestino = "") {
    //abre el archivo controlador y envia por POST en name codPais con el valor del id cmbPais
    vsURL = "controlador/con" + pvObjeto + ".php";
    $.post(vsURL, {
            //variables enviadas (name: valor)
            operacion: "UltimoCodigo" //abre la funcion en el controlador 
        },
        function(resultado) {
            if (resultado == false)
                console.log("sin consultas de id");
            else {
                if (psDestino != "") {
                    pvObjeto =  psDestino;
                    console.log("nuevo destino para el id en form" + psClase);
                }
                console.log("el id que toca es " + resultado);
                //$(" #numId").val(parseInt(resultado)); //habilita el campo de estado 
                $("#form" + pvObjeto + " #numId").val(parseInt(resultado)); //habilita el campo de estado 
            }
        }
    );
}

function fjDetenerCronometro() {
    clearInterval(cronometro);
}

/**
 * @param integer piTiempo, Variable de sesion Inactivo maximo, configurado por el usuario para el tiempo de inactividad que pasara antes de cerrar la sesion
 */
function fjIniciarCronometro(piTiempoUsuario = 600) {
    contador_s = parseInt(piTiempoUsuario);
    viTiepoMensaje = 15; //segundos
    s = document.getElementById("segundos");
    m = document.getElementById("minutos");
    c = document.getElementById("cronometro");

    //alert(piTiempoUsuario);
    minutos = (contador_s / 60) - 1;
    segundos = 60;

    cronometro = setInterval(
        function() {

            if (segundos == 0) {
                segundos = 60;
                minutos = minutos - 1;
            }

            if (contador_s == 0) {
                swal({
                    timer: (viTiepoMensaje * 1000),
                    title: '¡Sin Actividad Reciente!',
                    text: 'Tiene ' + viTiepoMensaje + ' segundos para confirmar que permanecerá en la pagina o se cerrara la sesión, si cerra este mensaje también se cerrara la sesión. ',
                    type: 'warning',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Salir',
                    confirmButtonText: 'Permanecer'
                }).then((result) => {
                    console.log(result);
                    if (result.value) {
                        contador_s = piTiempoUsuario;
                        minutos = (piTiempoUsuario / 60) - 1;
                        segundos = 60;
                    }
                    if (result.dismiss == "timer") {
                        fjSalir("tiempoexpirado", "si");
                    }
                });
                //contador_s = 20;
            }

            c.innerHTML = contador_s; //muestra el cronometro en la pagina
            s.innerHTML = segundos; //muestra los segundos en la pagina
            m.innerHTML = minutos; //muestra los minutos en la pagina
            contador_s--;
            segundos--;
        }, 1000 //velocidad de conteo 1000 = segundos
    );
}

function fjTiempoSesion() {
    swal({
        title: 'Cambiar el Tiempo de Sesión',
        text: "Escriba el tiempo (en minutos) que perdurara la sesión mientras este inactivo",
        input: 'number',
        inputClass: "valida_num_entero",
        inputAttributes: {
            'maxlength': 10,
            'min': 1
        },
        showCloseButton: true,
        cancelButtonText: 'Cancelar',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        inputValidator: function(value) {
            return new Promise(function(resolve, reject) {
                if (value) {
                    resolve()
                } else {
                    reject('¡El campo no puede estar vació o contener valores diferentes a números (0 ... 9) !')
                }
            })
        }
    }).then((result) => {
        fjCambiarTiempo(result.value);
    });
}

//Cada combo debe llevar un hidden con su mismo nombre para hacer facil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjCambiarTiempo(piTiempo = 600) {
    //abre el archivo controlador y envia por POST
    $.post("controlador/conTiempoSesion.php", {
            //variables enviadas (name: valor)
            vvOpcion: "ModificarAjax", //abre la funcion en el controlador 
            ctxTiempo: piTiempo //codigo del que depende para filtrar
        },
        function(resultado) {
            //console.log(resultado);
            if (resultado == "no") {
                swal({
                    type: 'error',
                    showCloseButton: true,
                    html: 'No se realizaron cambios: '
                });
                console.log("sin consultas de ");
            } 
            else {
                console.log("si");
                swal({
                    type: 'success',
                    showCloseButton: true,
                    html: 'Cambios realizados'
                });
                liTiempo = parseInt(resultado);
                console.log("cambiado a " + resultado);
                fjIniciarCronometro(liTiempo);
                console.log(resultado);
            }
        }
    );
}

/**
 * @param string psClase, indica el controlador de la clase que abrira dentro del modulo anterior
 * @param integer piPagina, envía el atributo de la subpagina que imprimira de la paginacion
 * @param string psOrden, envía el atributo en que realizara el ordenado
 * @param string psDesino, por defecto el destino donde imprimirá los datos es el formulario lista de la clase sin embargo puede cambiar
 * @param string psSwicth, por defecto la lista que llamara es ListaVista (anteriormente ListaInteligente) pero pueden existir mas de una lista del mismo controlador
 */
function fjMostrarLista(psClase, piPagina = "", psOrden = "", psDestino = "", psSwicth = "ListaView", psOpcional = "") {
    //abre el archivo controlador y envia por POST
    let vsRuta = "controlador/con" + psClase + ".php";
    let liItem = $.trim($("#formLista" + psClase + " #numItems").val());
    //si el parametro contiene algo, reasigna el valor enviado
    if (piPagina != "") {
        $("#formLista" + psClase + " #subPagina").val(piPagina);
    }

    if (psDestino != "") {
        psClase =  psDestino;
        console.log("nuevo formulario destino " + psClase);
    }

    if (psOrden != "") {
        $("#formLista" + psClase + " #hidOrden").val(psOrden);
        //$("#formLista" + psClase + " #tabLista" + psClase  + " thead tr span").removeClass(" glyphicon-sort-by-attributes");
        //$("#formLista" + psClase + " #tabLista" + psClase  + " thead tr span").addClass(" glyphicon-sort");
        //console.log($("#formLista" + psClase + " #tabLista" + psClase  + " thead tr span"));

        $("#formLista" + psClase + " #tabLista" + psClase  + " thead tr th").click(function(e){
           //var id = e.target.id;
           //e.target.firstElementChild.addClass(" glyphicon-sort-by-attributes ");
           $(this).children().addClass(" glyphicon-sort-by-attributes ");
           console.log($(this).children());
           console.log($(this));
       });
    }

    //si el orden es el mismo alterna el tipo
    /*if(psOrden == $("#formLista" + psClase + " #hidOrden").val()) {
        fjTipoOrdenLista(psClase);
    }*/

    //renglones a mostrar
    if(liItem == ""  || parseInt(liItem) < 1 || liItem == NaN) {
        liItem = 10;
    }

    $.post(vsRuta, { 
            //variables enviadas (name: valor)
            operacion: psSwicth, //abre la función de la lista en el controlador 
            setBusqueda: $("#formLista" + psClase + " #ctxBusqueda").val(), //palabra para filtrar la búsqueda
            setItems: parseInt(liItem), //cantidad de items a mostrar
            subPagina: parseInt($("#formLista" + psClase + " #subPagina").val()),
            setOrden: $("#formLista" + psClase + " #hidOrden").val(),
            setTipoOrden: $("#formLista" + psClase + " #hidTipoOrden").val(),
            setOpcional: psOpcional //valor adicional que se quiera enviar
        },
        function(resultado) {
            if(resultado == false)
                console.log("sin consultas de busqueda de " + psClase);
            else {
                $("#formLista" + psClase + " #divListado").html(resultado) ;
                //console.log(resultado); 
                
                if (psOrden != "") {
                    $("#formLista" + psClase + " #tabLista" + psClase  + " thead tr span").removeClass(" glyphicon-sort-by-attributes");
                    $("#formLista" + psClase + " #tabLista" + psClase  + " thead tr span").addClass(" glyphicon-sort");
                    //console.log($("#formLista" + psClase + " #tabLista" + psClase  + " thead tr span"));

                    $("#formLista" + psClase + " #tabLista" + psClase  + " thead tr th").click(function(e){
                       //var id = e.target.id;
                       //e.target.firstElementChild.addClass(" glyphicon-sort-by-attributes ");
                       $(this).children().addClass(" glyphicon-sort-by-attributes ");
                       console.log($(this).children());
                    });  
                    //console.log($("#formLista" + psClase + " #tabLista" + psClase  + " thead tr"));
                }
            }
        }
    );
}

function startTime2() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById("txt").innerHTML = h + ":" + m + ":" + s;
    var t = setTimeout(
        startTime()
     , 500
    );
}

function checkTime2(i) {
    if (i < 10) {
        i = "0" + i
    };  // add zero in front of numbers < 10
    return i;
}
