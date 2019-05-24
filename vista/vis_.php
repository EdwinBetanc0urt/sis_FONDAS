
<?php

include_once("public/lib_Cifrado.php");

//nacionalidad, guion, documento. Ejemplo. V-12345678
$clave_encriptada = clsCifrado::getDescifrar("lucSaSqR6clMkXEUhNxP7tCKqvFtBHXN/N3JSYtYEvs=");

echo "<hr>";
echo "$clave_encriptada";

?>
