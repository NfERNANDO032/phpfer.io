<?php
require_once '../config/conexion.php';
require_once '../config/jwt.php';
require_once '../app/usuarios.php';
require_once '../app/auth.php';
header('Content-Type: application/json');

$request = json_decode(file_get_contents("php://input"), true);

if (
    $_SERVER['REQUEST_URI'] == '/registrar/usuario'
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
    $_SERVER['REQUEST_URI'] == '/listarusuarios'
    and $_SERVER['REQUEST_METHOD'] == 'GET'
) {

    $usuarios = listarUsuarios();
    echo json_encode($usuarios);

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
    echo json_encode(['error' => 'Ruta no encontrada']);
}
if ($_SERVER['REQUEST_URI'] == '/listarusuarios' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuarios = listarUsuarios();
    echo json_encode($usuarios);
} 

// Crear un nuevo permiso
if ($_SERVER['REQUEST_URI'] == '/crearpermiso' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $resultado = crearPermiso($nombre, $descripcion);
    echo json_encode(['success' => $resultado]);
}

// Crear un nuevo rol
if ($_SERVER['REQUEST_URI'] == '/crearrol' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'];
  //
    $resultado = crearRol($nombre);
    echo json_encode(['success' => $resultado]);
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
if ($_SERVER['REQUEST_URI'] == '/asignarpermisoarol' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $rolId = $data['rol_id'];
    $permisoId = $data['permiso_id'];

    // Llamamos a la función para asignar el permiso al rol
    $resultado = asignarPermisoARol($rolId, $permisoId);

    // Respondemos con el resultado
    echo json_encode(['success' => $resultado]);
}

