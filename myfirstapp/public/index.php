<?php
require_once '../config/conexion.php';
require_once '../config/jwt.php';
require_once '../app/usuarios.php';
require_once '../app/auth.php';
header('Content-Type: application/json');

$request = json_decode(file_get_contents("php://input"), true);

if (
    $_SERVER['REQUEST_URI'] == '/crearUs'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {

    $respuesta = crearUsuario($request);
    if ($respuesta) {
        echo json_encode([
            "mensaje" => "Registro exitoso"
        ]);
    } else {
        echo json_encode([
            "mensaje" => "Hubo un error"
        ]);
    }

    //echo json_encode($request);

    // crearUsuario();

} else

    if (
        $_SERVER['REQUEST_URI'] == '/listar'
        and $_SERVER['REQUEST_METHOD'] == 'GET'
    ) {

        $usuarios = listarUsuarios();
        echo json_encode($usuarios);
//login
} elseif (
    $_SERVER['REQUEST_URI'] == '/login'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {


    $usuario = iniciarSesion($request);
    
    if ($usuario) {
        $token = generarJwtToken($usuario);
        echo json_encode([
            "usuario"=>$usuario,
            'token' => $token
        ]);
    } elseif($usuario===false) {
        echo json_encode([
            'error' => 'Usuario o contraseña incorrectos'
        ]);
    }



} else {
    echo json_encode(['error' => 'Ruta no encontrada']);// aca arriba ya esta


    //listar los usuarios creados o los que ya exuisten en la base de datos
}

// Crear un nuevo permiso
if ($_SERVER['REQUEST_URI'] == '/crearPermiso' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $resultado = crearPermiso($data);
    echo json_encode(["success" => $resultado]);
}



// Crear un nuevo rol
if ($_SERVER['REQUEST_URI'] == '/crearrol' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $resultado = crearRol($data);
    echo json_encode(["success" => $resultado]);
}

// Listar permisos
if ($_SERVER['REQUEST_URI'] == '/listarpermisos' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $permisos = listarPermisos();
    echo json_encode($permisos);
}

// Listar roles
if ($_SERVER['REQUEST_URI'] == '/listarroles' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $roles = listarRoles();
    echo json_encode($roles);
}
if ($_SERVER['REQUEST_URI'] == '/asignarRolPermisos' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $resultado =asignarRolesPermisos ($data);
    echo json_encode(["success" => $resultado]);
}


