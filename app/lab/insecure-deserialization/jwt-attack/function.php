<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require "vendor/autoload.php";

// Almacena la clave de forma segura (puede ser en un archivo de configuración o variable de entorno)
$key = "dragon";

function CreateJWT($username = "defaultUser")
{
    global $key;

    $header = [
        "alg" => "HS512",
        "typ" => "JWT"
    ];

    $payload = [
        "username" => $username,
        "exp" => time() + 3600  // Token expira en 1 hora
    ];

    $JWT = JWT::encode($payload, $key, "HS256", null, $header);

    return $JWT;
}

function DecodeJWT($JWT)
{
    global $key;

    try {
        $decoded = JWT::decode($JWT, new Key($key, 'HS256'));
        $decoded = get_object_vars($decoded);
        return $decoded;
    } catch (Exception $e) {
        // Manejar el error de deserialización de forma segura (puedes loggear el error, retornar un valor predeterminado, etc.)
        error_log("Error decoding JWT: " . $e->getMessage());
        return null;
    }
}
?>
