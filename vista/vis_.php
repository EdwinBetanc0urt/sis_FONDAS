
<?php

include_once("public/lib_Cifrado.php");

//nacionalidad, guion, documento. Ejemplo. V-12345678
$clave_encriptada = clsCifrado::getDescifrar("6tqRrsEqFyPYNJ5yEDHTcg==");

echo "<hr>";
echo "$clave_encriptada";

?>
