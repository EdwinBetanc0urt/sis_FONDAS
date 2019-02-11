

<?php

include_once("public/lib_Cifrado.php");


$objCifrado = new clsCifrado(); //instancia el objeto de cifrado

//nacionalidad, guion, documento. Ejemplo. V-12345678
$clave_encriptada = $objCifrado->flDesencriptar("lucSaSqR6clMkXEUhNxP7tCKqvFtBHXN/N3JSYtYEvs=");

echo "<hr>";
echo "$clave_encriptada";


?>