<?php
require __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$key = "clave_secreta"; 
function generarJwtToken($usuario) {
    global $key;
    $payload = [
        "id" => $usuario["id"],
        "email" => $usuario["mail"],//
        "iat" => time(),// Tiempo que inició el token
        "exp" => time() + (60 * 60) // Expira en 1 hora
    ];
    $token = JWT::encode($payload, $key,"HS256");
    return $token;  
 
}
