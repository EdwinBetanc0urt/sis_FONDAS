/* *
 * Validaciones
 * Open source under the BSD License.
 * Copyright © 2018 EdwinBetanc0urt <EdwinBetanc0urt@outlook.com>
 * All rights reserved.
*/


if(typeof jQuery === "undefined") {
    throw new Error("Las validaciones requieren jQuery, By EdwinBetanc0urt");
}


//funcion javascript Salir, utilizado por el botón de Cancelar en vis_CompletarRegistro
function fjSalir_Publico() {
    swal({
        title: '¡CUIDADO!',
        text: 'Está a punto de perder los datos... ¿Seguro que quiere cancelar el registro?',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        showCloseButton: true,
        confirmButtonText: 'Si, Salir',
        cancelButtonText: 'No, Continuar'
    }).then((result) => {
        if(result.value) {
            window.location.href = "controlador/conCerrar.php?getMotivoLogOut=datosincompletos";
        }
        if(result.dismiss == 'cancel') {
            swal(
                'Cancelado',
                '¡Gracias por permanecer en la página!',
                'error'
          );
        }
    });
}


//función javascript Excluir Caracteres, valida que sea cualquier caracter excepto los excluidos
//parámetro vita Valor, contiene la tecla
function fjExcluirCaracter(pvValor) {
    var CodigoTecla = pvValor.keycode || pvValor.which; // keycode lee el código de tecla, which lee los eventos
    var teclado = String.fromCharCode(CodigoTecla); //convierte el string en códigos unicode
    var vjCaracterresExcluidos = "|&'%¿?+!¡{}[]`´\""; // variable que contiene los caracteres no permitidos

    // si encuentra mas de un carater excluido retorna false
    if (vjCaracterresExcluidos.indexOf(teclado) >= 1) {
        return false;
    }
}


//Detecta si las teclas están escritas con el CapsLock activo
//parámetro vita Valor, contiene la tecla
function fjMayus(pvValor) {
    var CodigoTecla = pvValor.keyCode ? pvValor.keyCode : pvValor.which; // keycode lee el código de tecla, which lee los eventos
    var TeclaShift = pvValor.shiftKey ? pvValor.shiftKey : ((CodigoTecla == 16) ? true : false); //16=mayus
    var divM = document.getElementById("divMayus");
    divM.style.display = "none";

    //rango de teclas, mayúsculas 65=A ... 90=Z y minúsculas 97=a ... 122=z
    //if(((CodigoTecla>=65 && CodigoTecla<=90) &&! TeclaShift) ||((CodigoTecla>=97 && CodigoTecla<=122) && TeclaShift))
    if (((CodigoTecla >= 65 && CodigoTecla <= 90) && !TeclaShift) || ((CodigoTecla >= 97 && CodigoTecla <= 122) && TeclaShift)) {
        divM.style.display = 'block';
    } else {
        divM.style.display = 'none';
    }
}


//No permite la opción de copiar, pegar y cortar en el porta papeles, usado en las contraseñas
function fjNocopiar() {
    //alert("¡Atención! No se permite COPIAR en este campo.");
    swal({
        title: '¡Atención!',
        type: 'error',
        html: "No se permite <b>COPIAR</b> en este campo.",
        showCloseButton: true,
        confirmButtonText: 'Ok',
        footer: " "
    }).then((result) => {
        return false;
    });
    return false;
}

function fjNoCortar() {
    //alert("¡Atención! No se permite CORTAR en este campo.");
    swal({
        title: '¡Atención!',
        type: 'error',
        html: "No se permite <b>CORTAR</b> en este campo.",
        showCloseButton: true,
        confirmButtonText: 'Ok',
        footer: " "
    }).then((result) => {
        return false;
    });
    return false;
}

function fjNoPegar() {
    //alert("¡Atención! No se permite PEGAR en este campo.");
    swal({
        title: '¡Atención!',
        type: 'error',
        html: "No se permite <b>PEGAR</b> en este campo.",
        showCloseButton: true,
        confirmButtonText: 'Ok',
        footer: " "
    }).then((result) => {
        return false;
    });
    return false;}

function fjMenuContextual() {
    swal({
        title: '¡Atención!',
        html: "Por seguridad no se permite el <b>Menú Contextual</b> en esta sección.",
        type: 'error',
        showCloseButton: true,
        confirmButtonText: 'Ok',
        footer: " "
    }).then((result) => {
        return false;
    });
    return false;
}


//valida la edad minima con formato de fecha (yyyy/mm/dd)
function fjEdadMinima(psFechaNacimiento, piMinimo = 18) {

    //se obtiene la fecha actual del PC CLIENTE
    var objHoy = new Date(); //instancia un objeto
    viDiaActual = objHoy.getDate();
    viMesActual = objHoy.getMonth() + 1;
    viAnoActual = objHoy.getFullYear();
    console.log("fecha actual " + viAnoActual + "/" + viMesActual + "/" + viDiaActual);

    //separa la fecha de nacimiento del USUARIO en año, mes y dia
    var arrFechaNac = psFechaNacimiento.split("/");
    var viAnoNacimiento = parseInt(arrFechaNac[0]); //convierte la cadena en entero para hacer calculos
    var viMesNacimiento = parseInt(arrFechaNac[1]); //convierte la cadena en entero para hacer calculos
    var viDiaNacimiento = parseInt(arrFechaNac[2]); //convierte la cadena en entero para hacer calculos
    console.log("fecha nacimiento " + psFechaNacimiento);

    //la edad se obtiene con el año actual menos el año de nacimiento 1995-2016 = 21
    var viEdad = viAnoActual - viAnoNacimiento;

    //si el mes actual no ha llegado al mes de nacimiento se resta 1 al año 08<10 = 20
    if (viMesActual < viMesNacimiento) {
        console.log("falta(n) " + (viMesNacimiento - viMesActual) + " mes(es)");
        viEdad = viEdad - 1;
    }

    if (viEdad == piMinimo) {
        console.log("edad es igual al permitido");
        if (viMesActual == viMesNacimiento) {

            if (viDiaActual > viDiaNacimiento)
                console.log("el cumpleaños fue hace " + (viDiaActual - viDiaNacimiento) + " dia(s)");

            if (viDiaActual < viDiaNacimiento) {
                viEdad = viEdad - 1;
                console.log("falta(n) " + (viDiaNacimiento - viDiaActual) + " dia(s)");
            }

            if (viDiaActual == viDiaNacimiento)
                console.log("FELIZ CUMPLEAÑOS");
        }
    }

    //la edad es menor al minimo establecido retorna
    if (viEdad < piMinimo) {
        console.log(viEdad + " años es menor al permitido (" + piMinimo + ")");
        return [viEdad, piMinimo, "menor"]; //retorna un arreglo
    }
    console.log(viEdad + " años si cumple con el minimo permitido (" + piMinimo + ")");
    return [viEdad, piMinimo, "mayor"];
}


//valida la edad minima con formato de fecha (yyyy/mm/dd)
function fjFechaMaxima(psFecha) {

    //se obtiene la fecha actual del PC CLIENTE
    var objHoy = new Date(); //instancia un objeto
    viDiaActual = objHoy.getDate();
    viMesActual = objHoy.getMonth() + 1;
    viAnoActual = objHoy.getFullYear();
    console.log("fecha actual " + viAnoActual + "/" + viMesActual + "/" + viDiaActual);

    //separa la fecha de nacimiento del USUARIO en año, mes y dia
    var arrFecha = psFecha.split("/");
    var viAno = parseInt(arrFecha[0]); //convierte la cadena en entero para hacer calculos
    var viMes = parseInt(arrFecha[1]); //convierte la cadena en entero para hacer calculos
    var viDia = parseInt(arrFecha[2]); //convierte la cadena en entero para hacer calculos
    console.log("fecha es " + psFecha);

    //la edad se obtiene con el año actual menos el año de nacimiento 1995-2016 = 21
    var viEdad = viAnoActual - viAnoNacimiento;

    //si el mes actual no ha llegado al mes de nacimiento se resta 1 al año 08<10 = 20
    if (viMesActual < viMesNacimiento) {
        console.log("falta(n) " + (viMesNacimiento - viMesActual) + " mes(es)");
        viEdad = viEdad - 1;
    }

    if (viEdad == piMinimo) {
        console.log("edad es igual al permitido");
        if (viMesActual == viMesNacimiento) {

            if (viDiaActual > viDiaNacimiento)
                console.log("el cumpleaños fue hace " + (viDiaActual - viDiaNacimiento) + " dia(s)");

            if (viDiaActual < viDiaNacimiento) {
                viEdad = viEdad - 1;
                console.log("falta(n) " + (viDiaNacimiento - viDiaActual) + " dia(s)");
            }

            if (viDiaActual == viDiaNacimiento)
                console.log("FELIZ CUMPLEAÑOS");
        }
    }

    //la edad es menor al minimo establecido retorna
    if (viEdad < piMinimo) {
        console.log(viEdad + " años es menor al permitido (" + piMinimo + ")");
        return [viEdad, piMinimo, "menor"]; //retorna un arreglo
    }
    console.log(viEdad + " años si cumple con el minimo permitido (" + piMinimo + ")");
    return [viEdad, piMinimo, "mayor"];
}


//funcion para quitar acentos de las vocales, necesita jQuery
function fjQuitarTildes(psPalabra) {
    //console.log("palabra actual: " + psPalabra);
    /*
    psPalabra = psPalabra.replace(/[ñ]/n, 'n');
    psPalabra = psPalabrapsPalabra.replace(/[ç]/, 'c');
	*/

    if(psPalabra.search(/[áàäâãå]/) != -1)
        psPalabra = psPalabra.replace(/[áäàâãå]/gi, 'a');
    if(psPalabra.search(/[ÁÄÂÃÀ]/) != -1)
        psPalabra = psPalabra.replace(/[ÁÄÂÃÀ]/gi, 'A');

    if(psPalabra.search(/[éêëè]/) != -1)
        psPalabra = psPalabra.replace(/[éëè]/gi, 'e');
    if(psPalabra.search(/[ÉËÊÈ]/) != -1)
        psPalabra = psPalabra.replace(/[ÉËÊÈ]/gi, 'E');

    if(psPalabra.search(/[íïîì]/) != -1)
        psPalabra = psPalabra.replace(/[íïîì]/gi, 'i');
    if(psPalabra.search(/[ÍÏÎÌ]/) != -1)
        psPalabra = psPalabra.replace(/[ÍÏÎÌ]/gi, 'I');

    if(psPalabra.search(/[óöôò]/) != -1)
        psPalabra = psPalabra.replace(/[óöôò]/gi, 'o');
    if(psPalabra.search(/[ÓÖÔÒ]/) != -1)
        psPalabra = psPalabra.replace(/[ÓÖÔÒ]/gi, 'O');

    if(psPalabra.search(/[úüûù]/) != -1)
        psPalabra = psPalabra.replace(/[úüûù]/gi, 'u');
    if(psPalabra.search(/[ÚÜÛÙ]/) != -1)
        psPalabra = psPalabra.replace(/[ÚÜÛÙ]/gi, 'U');

    if(psPalabra.search(/[ýÿ]/) != -1)
        psPalabra = psPalabra.replace(/[ýÿ]/gi, 'y');
    if(psPalabra.search(/[Ý]/) != -1)
        psPalabra = psPalabra.replace(/[Ý]/gi, 'Y');
    //console.log("palabra nueva: " + psPalabra);

    return psPalabra;
}


function fjValidarInner() {
  $('.valida_num_entero').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    //valida la primera posición que no sea cero
    if(this.value.charAt(0) == "0") {
      this.value = this.value.substring(1);
      this.value = this.value.replace(/[^0-9]/g, '');
    }
  });
  // validaciones para NUMEROS DECIMALES
    $('.valida_num_moneda').keyup(function() {
        this.value = this.value.replace(/[^0-9,.]/g, '');

        //Busca la coma y cambia por un punto
        if (this.value.indexOf(","))
            this.value = this.value.replace(/[^0-9.]/g, '.');

        //valida la primera posición que no sea un cero, punto o coma
        if (this.value.charAt(0) == "0" || this.value.charAt(0) == "." || this.value.charAt(0) == ",") {
            this.value = this.value.substring(1);
            this.value = this.value.replace(/[^0-9]/g, '');
        }

        //valida la posición final para que no se repitan dos comas o puntos
        tam = this.value.length; //toma el tamaño de la cadena
        //si el carácter en la posición final y la antepenúltima son iguales y a su vez igual a un punto
        if (this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && this.value.charAt(tam - 1) == ".") {
            //toma el valor desde la posicion cero hasta una posición menos, borrando 2 puntos consecutivos
            this.value = this.value.substr(0, tam - 1);
        }
    });

    if(typeof priceFormat === 'function') {
        $('.valida_moneda_bolivares').priceFormat({
            prefix: '', //simbolo de moneda que va al principio (predeterminado toma USD$)
            suffix: '', //simbolo de moneda que va al final
            centsSeparator: '.', //separador de sentimos
            thousandsSeparator: '', //separador de miles
            insertPlusSign: false //un mas al principio
            //allowNegative: true //permite negativos
        });
    }

    /*
    $("body").on("keyup", "valida_num_entero", function(event){
        event.preventDefault();
                 //valida la primera posición que no sea cero
        if(this.value.charAt(0) == "0") {
            this.value = this.value.substring(1);
            this.value = this.value.replace(/[^0-9]/g, '');
        }
        //alert("Probando asignación");

    });
    */

    //validaciones para valores NUMERICOS con 0 antes
    $('.valida_numerico').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    console.log("reasinada la validacion a los innerHTML ");
}


/*  VALIDACIONES USADAS EN FORMULARIOS */
//Validaciones con JQuey
$(function() {
  if(typeof priceFormat === 'function') {
    $('.valida_moneda_bolivares').priceFormat({
      prefix: '', //simbolo de moneda que va al principio (predeterminado toma USD$)
      suffix: '', //simbolo de moneda que va al final
      centsSeparator: '.', //separador de sentimos
      thousandsSeparator: '', //separador de miles
      insertPlusSign: false //un mas al principio
      //allowNegative: true //permite negativos
    });
  }
  //alert($('#ctxIdentificacion').unmask());

  //validacion para que no permita empezar a escribir con espacios o tenga 2 espacios seguidos al final
  $('input, textarea').keyup(function() {
    this.value = this.value.replace(/  /gim, '');
    this.value = this.value.replace(/^\s+/, ''); //quita los espacios al inicio
    //valida la primera posición que no sea un espacio
    /*if(this.value.charAt(0) == " ") {
    	this.value = this.value.substring(1);
    	//this.value = this.value.replace(/[^0-9]/g, '');
    }*/
    //*/
    /*
    //valida la posición final para que no se repitan dos comas o puntos
    tam = this.value.length; //toma el tamaño de la cadena
    //si el carácter en la posición final y la antepenúltima son iguales y a su vez igual a un punto
    if(this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && this.value.charAt(tam - 1) == " ") {
    	//toma el valor desde la posición cero hasta una posición menos, borrando 2 puntos consecutivos
    	this.value = this.value.substr(0, tam - 1) ;
    }*/
  });

  //Coloca todas las letras en mayúscula
  $('.valor_mayuscula').keyup(function() {
    this.value = this.value.toUpperCase();
  });

  //Coloca todas las letras en mayúscula
  $('.valor_minuscula').keyup(function() {
    this.value = this.value.toLowerCase();
  });

  //validaciones para valores de FECHAS
  $('.valida_desc_fecha, valida_fecha').keyup(function() {
    this.value = this.value.replace(/[^0-9\-\/]/g, '');
  });

  //validaciones para valores de FECHAS
  $('.valida_tiempo').keyup(function() {
    this.value = this.value.replace(/[¨´`~!@#$%^&*()_°¬|+\-=¿?;'",.<>\{\}\[\]\\\/]/gi, '');
    this.value = this.value.replace(/[bcdefghijklnñoqrstuvwxyzBCDEFGHIJKLNÑOQRSTUVWXYZ]/gi, '');
  });

  //Descripcion alfanumerica para nombres propios de componentes
  $('.valida_desc_alfanum').keyup(function() {
    this.value = fjQuitarTildes(this.value);
    this.value = this.value.replace(/[`~!@#%^&$¡¨¿*()°¬|\=?;:'"<>\{\}\[\]]/gi, '');
  });

  //para direcciones de domicilio
  $('.valida_direccion').keyup(function() {
    this.value = fjQuitarTildes(this.value);
    this.value = this.value.replace(/[`~!@%^&$¡¨¿*_¬|+\=?;:'"<>\{\}\[\]\\\/]/gi, '');
  });

  //para direcciones de domicilio
  $('.valida_pregunta').keyup(function() {
    this.value = fjQuitarTildes(this.value);
    this.value = this.value.replace(/[0-9¨´`~!@#$%^&*()_°¬|+\-=;:'",.<>\{\}\[\]\\\/]/gi, '');
  });

  //validacion para CORREOS ALFANUMERICOS
  $('.valida_correo').keyup(function() {
    this.value = fjQuitarTildes(this.value);
    //this.value = (this.value).replace(/[ñ`´~!#%^&$¡¨¿*()°¬|+\=?,;:'"<>\{\}\[\]\\\/]/gi,'');
    this.value = this.value.replace(/[^0-9._\-@a-z]/gi, '');
  });

  //para clave de usuario
  $('.valida_clave').keyup(function() {
    //caracteres a excluir en validacion de clave
    this.value = fjQuitarTildes(this.value);
    //this.value = this.value.replace(/[¨´`'"~¡!¿? @#$%^&()°¬|=;:,<>\{\}\[\]\\\/]/gi, '');
    this.value = this.value.replace(/[^0-9.+*\-_$a-z]/gi, '');
    //this.value = this.value.replace(/[0-9.+*\-_$a-z]/gi, '');
    //this.value = this.value.replace(/[`´~!@#%^&$¡¨¿*()_°¬|+\=?;:'"<>\{\}\[\]]/gi, '');
  }); //para clave de usuario

  //Descripcion alfanumerica para nombres propios de componentes
  $('.valida_buscar').keyup(function() {
    this.value = fjQuitarTildes(this.value); //caracteres a quitar las tildes
    this.value = this.value.replace(/[`´~!@#%^&$¡¨¿*()_°¬|+\=?;:'"<>\{\}\[\]]/gi, '');
  }); // caracteres a exluir para evitar erroes   |&'%¿?+!¡{}[]`´\"

  //validacion para valores ALFABETICOS
  $('.valida_alfabetico').keyup(function() {
    this.value = fjQuitarTildes(this.value); //vocales a quitar las tildes
    //caracteres a excluir
    this.value = this.value.replace(/[0-9¨´`~!@#$%^&*()_°¬|+\-=¿?;:'",.<>\{\}\[\]\\\/]/gi, '');
  });

  //validacion para valores ALFANUMERICOS
  $('.valida_alfa_numerico').keyup(function() {
    this.value = fjQuitarTildes(this.value); //vocales a quitar las tildes
    this.value = this.value.replace(/[¨´`'"~!@#$%^&*()_°¬|+\-=?;:,._ç+*/¡<>\{\}\[\]\\\/]/gi, '');
  });

  $('.val_operacion_numerica').keyup(function() {
    //caracteres permitidos
    this.value = this.value.replace(/[^0-9.+*\-\/%=]/gi, '');
  });

  //validaciones para valores NUMERICOS con 0 antes
  $('.valida_numerico').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  //validaciones para valores NUMERICOS con 0 antes
  $('.valida_num_identificacion').keyup(function() {
    this.value = this.value.replace(/[^0-9\-]/g, '');
    //valida la primera posicion que no sea un guion
    if (this.value.charAt(0) == " - ") {
      this.value = this.value.substring(1);
      this.value = this.value.replace(/[^0-9]/g, '');
    }
    //valida la posicion final para que no se repitan dos comas o puntos
    tam = this.value.length; //toma el tamaño de la cadena
    //si el caracter en la posición final y la antepenúltima son iguales y a su vez igual a un guion
    if (this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && this.value.charAt(tam - 1) == "-") {
      //toma el valor desde la posicion cero hasta una posicion menos, borrando 2 puntos consecutivos
      this.value = this.value.substr(0, tam - 1);
    }
  });

  //validaciones para NUMEROS ENTEROS sin 0 antes del valor
  $('.valida_num_entero').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    //valida la primera posición que no sea cero
    if(this.value.charAt(0) == "0") {
      this.value = this.value.substring(1);
      this.value = this.value.replace(/[^0-9]/g, '');
    }
  });

  // validaciones para NUMEROS DECIMALES
  $('.valida_num_decimal').keyup(function() {
    this.value = this.value.replace(/[^0-9,.]/g, '');

    //Busca la coma y cambia por un punto
    if (this.value.indexOf(","))
      this.value = this.value.replace(/[^0-9.]/g, '.');

    //valida la primera posición que no sea un cero, punto o coma
    if (this.value.charAt(0) == "0" || this.value.charAt(0) == "." || this.value.charAt(0) == ",") {
      this.value = this.value.substring(1);
      this.value = this.value.replace(/[^0-9]/g, '');
    }

    //valida la posición final para que no se repitan dos comas o puntos
    tam = this.value.length; //toma el tamaño de la cadena
    //si el carácter en la posición final y la antepenúltima son iguales y a su vez igual a un punto
    if (this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && this.value.charAt(tam - 1) == ".") {
      //toma el valor desde la posicion cero hasta una posición menos, borrando 2 puntos consecutivos
      this.value = this.value.substr(0, tam - 1);
    }
  });

    // validaciones para NUMEROS DECIMALES
  $('.valida_num_moneda').keyup(function() {
    //this.value = this.value.replace(/^\$(((\d{1,3},)(\d{3},)*\d{3})|(\d{1,3}))\.\d{2}$/g, '');
    this.value = this.value.replace(/^\$(\d{1,3})\.\d{2}$/g, '');
    /*
    //Busca la coma y cambia por un punto
    if (this.value.indexOf(","))
        this.value = this.value.replace(/[^0-9.]/g, '.');

    //valida la primera posición que no sea un cero, punto o coma
    if (this.value.charAt(0) == "0" || this.value.charAt(0) == "." || this.value.charAt(0) == ",") {
      this.value = this.value.substring(1);
      this.value = this.value.replace(/[^0-9]/g, '');
    }

    //valida la posición final para que no se repitan dos comas o puntos
    tam = this.value.length; //toma el tamaño de la cadena
    //si el carácter en la posición final y la antepenúltima son iguales y a su vez igual a un punto
    if (this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && this.value.charAt(tam - 1) == ".") {
      //toma el valor desde la posicion cero hasta una posición menos, borrando 2 puntos consecutivos
      this.value = this.value.substr(0, tam - 1);
    }*/
  });

  //validaciones para NUMEROS DE TELEFONO Y FAX, locales e internacionales
  //falta validar que no repita mas de 1 vez el guion y el mas
  $('.valida_num_telefono').keyup(function() {
    this.value = this.value.replace(/[^0-9+-]/gi, '');
    //valida la primera posición sea un cero o un mas
    tam = this.value.length; //toma el tamaño de la cadena
    //sino identifica inicialmente el + toma un cero
    if (this.value.charAt(0) != "+") {
      this.value = "0" + this.value.substr(1);
      if (tam == 4 && this.value.charAt(4) != "-")
        this.value = this.value.substr(0, 4) + "-" + this.value.substr(5);
    }
    else {
      this.value = "+" + this.value.substr(1);
      if (tam == 3 && this.value.charAt(4) != "-")
        this.value = this.value.substr(0, 3) + "-" + this.value.substr(3);
    }

    //si el carácter en la posición final y la antepenúltima son iguales
    //y a su vez igual a un guion o un mas elimina el ultimo repetido
    if (this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && (this.value.charAt(tam - 1) == "-" || this.value.charAt(tam - 1) == "+")) {
      //toma el valor desde la posicion cero hasta una posición menos, borrando 1 de los guiones al final
      this.value = this.value.substr(0, tam - 1);
    }
  });

  //para cantidad en presentacion ????
  $('.valida_num_real').keyup(function() {
    this.value = this.value.replace(/[^0-9.]/g, '');
  });

  //validaciones para NUMEROS DE REGISTRO DE INFORMACION FISCAL (RIF)
  //falta validar que no repita mas de 1 vez el guion
  $('.valida_num_rif').keyup(function() {
    this.value = this.value.replace(/[^0-9-]/g, '');

    tam = this.value.length; //toma el tamaño de la cadena
    //si el caracter en la posición final y la antepenúltima son iguales
    //y a su vez igual a un guion elimina el iltimo repetido
    if (this.value.charAt(tam - 1) == this.value.charAt(tam - 2) && this.value.charAt(tam - 1) == "-") {
      //toma el valor desde la posición cero hasta una posición menos, borrando 1 de los guiones al final
      this.value = this.value.substr(0, tam - 1);
    }
  });

  /****** FIN DE VALIRDACIONES USADAS EN MAESTEROS***************/

});
