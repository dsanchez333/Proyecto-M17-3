<?php
require "function.php";  // Asegúrate de incluir la función DecodeJWT si es necesario

if(isset($_COOKIE["jwt"])){
    try {
        $decodedJWT = DecodeJWT($_COOKIE["jwt"]);
    } catch(Exception $e){
        // Manejar el error de deserialización de forma más segura
        error_log("Error decoding JWT: " . $e->getMessage());
    }
}

setcookie("jwt", "", time() - 3600, "/", "", false, true); // Configurar opciones de cookie seguras

if(headers_sent()) {
    // Si ya se han enviado encabezados, solo muestra un mensaje de error en el log
    error_log("No se puede limpiar la cookie JWT porque los encabezados ya se han enviado.");
} else {
    // Redirigir solo si los encabezados no se han enviado
    header("Location: index.php");
}

exit();
?>
