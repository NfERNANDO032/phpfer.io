<?php
$host = "127.0.0.1"; //localhost
$usuario = "root";
$clave = "";
$bd = "fernando";

// Activar reporte de errores (opcional)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function conectar(){
    global $host, $usuario, $clave, $bd;
    $conexion = new mysqli($host, $usuario, $clave, $bd);

    if($conexion->connect_error){
        die("Error de conexión: " . $conexion->connect_error);
    }

    return $conexion;
}
?>
