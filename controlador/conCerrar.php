<?php

session_start();

// existe y esta la variable de session
if ( isset( $_SESSION["sesion"] ) && $_SESSION["sesion"] == "sistema" ) {
	
	//include_once('../modelo/clsUsuario.php');
 
	//$mitusuario= new Usuario(); 
	//$mitusuario->Salir_control( $_SESSION['idusuario'] );

	unset($_SESSION);
	session_unset(); //liera la sesion iniciada
	session_destroy(); // destruye la sesión  
	session_write_close(); // cierre de la escritura de sesion
	if ( isset( $_GET["getMotivoLogOut"])) {
		?>
		<script>
			window.location="../index.php?accion=Login&msjAlerta=<?= $_GET["getMotivoLogOut"]; ?>";
		</script>
		<?php
	}
	else {
		?>
		<script>
			window.location="../index.php?accion=Login&sesion=cerrada";
		</script>
		<?php
	}
		
}
else{
	header('HTTP/1.0 403 Denegado');
	header( "Content-Type: text/html; charset=utf-8" );
	
	if ( isset( $_GET["getMotivoLogOut"])) {
		?>
		<script>
			alert("Acceso RESTRINGIDO");
			window.location="../index.php?accion=Login&msjAlerta<?= $_GET["getMotivoLogOut"]; ?>";
		</script>
		<?php
	}
	else {
		?>
		<script>
			alert("Acceso RESTRINGIDO");
			window.location="../index.php?accion=Login&";
		</script>
		<?php
	}

}

?>