<?php
require_once '../config/conexion.php';
require_once '../config/jwt.php';
require_once '../public/index.php';
function iniciarSesion($request){

    $sql = "SELECT * FROM `usuarios` WHERE `correo` = '{$request['correo']}'";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    $usuario = $resultado->fetch_assoc();
    
    if ($usuario) {
        if (password_verify($request['password'], $usuario['password'])) {
            return $usuario;            
        } else {
            return false; 
        }
    } else {
        return false; 
    }
}



?>



