<?php

$ruta = "";
if(is_file("modelo/clsLogin.php")){
	require_once("modelo/clsLogin.php");
}
else{
	$ruta = "../";
	require_once("{$ruta}modelo/clsLogin.php");
}

if (isset($_POST["operacion"]) AND $_POST["operacion"] == "ReCaptcha") {
	codigo_captcha();
}
else {
	// función para loguearme
	$objUsuario= new Login();
	$objUsuario->setUsuario($_POST['usuario']);
	$arrUsuario = $objUsuario->ConsultarUsuario();

	if ($arrUsuario) {
		$arrClave = $objUsuario->ConsultarClave($arrUsuario["id_usuario"]);

		// coincide el usuario y la clave
		if ($arrClave["clave"] == clsCifrado::getCifrar($_POST["clave"])) {
			// se busca los datos en la tabla persona
			$arrDatos = $objUsuario->fmConsultarPersona($arrUsuario['idpersona']);

			// el usuario esta activo
			if ($arrUsuario["estatus"] == "activo" || $arrUsuario["estatus"] == 1)  {
				$objUsuario->Bitacora($arrUsuario["id_usuario"]);
				$objUsuario->fmReiniciaIntento(); //cambia los intentos fallidos a 0
				$objFechaInicio = new DateTime($arrClave["fecha_creacion"]);
				$objFechaActual = new DateTime("now");
				$vsDiferencia = $objFechaInicio->diff($objFechaActual);

				// Clave Caducada
				if ($vsDiferencia->days >= $objUsuario->getDiasCaducidad()
					&& $arrClave["fecha_creacion"] != "0000-00-00"
					&& $arrClave["fecha_creacion"] != "0000-00-00 00:00:00") {
					$_SESSION = array(
						'sesion' => 'caducado',
						'sistema' => 'fondas',
						'usuario' => $arrDatos['usuario'],
						'idpersona' => $arrUsuario['idpersona'],
						'nacionalidad' => $arrDatos['nacionalidad'],
						'cedula' => $arrDatos['cedula'],
						'nombre' => $arrDatos['nombre'],
						'apellido' => $arrDatos['apellido'],
						'id_usuario' => $arrDatos['id_usuario'],
					);
					header("Location: ../?accion=ClaveCaducada");
				}
				else {
					$_SESSION = array(
						'sesion' => 'sistema',
						'sistema' => 'fondas',
						'usuario' => $arrDatos['usuario'],
						'tipo_usuario' => $arrDatos['tipo_usuario'],
						'idtipo_usuario' => $arrDatos['idtipo_usuario'],
						'idpersona' => $arrUsuario['idpersona'],
						'idtrabajador' => $arrDatos['idtrabajador'],
						'nacionalidad' => $arrDatos['nacionalidad'],
						'cedula' => $arrDatos['cedula'],
						'nombre' => $arrDatos['nombre'],
						'apellido' => $arrDatos['apellido'],
						'id_usuario' => $arrDatos['id_usuario'],
						'estatus' => $arrDatos['estatus'],
						'fecha_ingreso' => $arrDatos['fecha_ingreso'],
						'fecha_ingreso2' => $objUsuario->faFechaFormato(
							$arrDatos['fecha_ingreso']
						),
						'tiempo_sesion' => $arrUsuario['tiempo_sesion']
					);
					header("Location: ../?accion=Bienvenida");
				}
			}

			else if ($arrUsuario["estatus"] == "vacaciones") {
				header("Location: {$ruta}?accion=Login&msjAlerta=devacaciones");
			}

			else if ($arrUsuario["estatus"] == "completar") {
				$objUsuario->fmReiniciaIntento(); // cambia los intentos fallidos a 0
				$fecha = $objUsuario->faFechaFormato($arrDatos["fecha_ingreso"]);

				$_SESSION = array(
					'sesion' => 'completar',
					'sistema' => 'fondas',
					'usuario' => $arrDatos['usuario'],
					'nombre' => $arrDatos['nombre'],
					'apellido' => $arrDatos['apellido'],
					'cargo' => $arrDatos['cargo'],
					'idcargo' => $arrDatos['idcargo'],
					'tipo_usuario' => $arrDatos['tipo_usuario'],
					'idtipo_usuario' => $arrDatos['idtipo_usuario'],
					'idpersona' => $arrUsuario['idpersona'],
					'idtrabajador' => $arrDatos['idtrabajador'],
					'id_usuario' => $arrDatos['id_usuario'],
					'correo' => $arrDatos['correo'],
					'tel_mov' => $arrDatos['tel_mov'],
					'fecha_ingreso' => $fecha,
					'estatus' => $arrDatos['estatus']
				);
				$objUsuario->Bitacora($arrUsuario["id_usuario"]);
				header("Location: ../?accion=Completar");
			}

			else {
				header("Location: {$ruta}?accion=Login&msjAlerta=usuariobloqueado");
			}
		}

		// clave y usuario no corresponden
		else {
			$objUsuario->fmIntentoErroneo();// cada intento fallido aumenta a 1 mas
			// consulta los intentos que lleva el usuario y el máximo permitido que
			// especifica la configuración
			if ($objUsuario->fmContadorIntentos() >= 3) {
				// si los intentos llegan al máximo establecido bloquea al usuario
				$objUsuario->fmBloqueoUsuario();
				header("Location: {$ruta}?accion=Login&msjAlerta=bloqueo_intentos");
			}
			else
				header("Location: {$ruta}?accion=Login&msjAlerta=claveousaurio");
		}
	}
	else {
		header("Location: {$ruta}?accion=Login&msjAlerta=nousuario");
	}
}


function codigo_captcha(){
	$k = "";
	$paramentros = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$maximo = strlen($paramentros)-1;

	for($i=0; $i<5; $i++) {
		$k .= $paramentros{
			mt_rand(0, $maximo)
		};
	}
	echo $k;
}


?>
