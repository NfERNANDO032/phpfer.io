<?php

//crear un usuario

function crearUsuario($request)
{

    try {
        $passwordHash = password_hash($request['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO `usuarios`(`id`, `nombre`, `apellido`, `mail`, `password`, `idrol`)
     VALUES (null,'{$request['nombre']}','{$request['apellido']}',
     '{$request['mail']}','{$passwordHash}','{$request['idrol']}')";
        $conexion = conectar();
        $conexion->query($sql);
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}

function listarUsuarios()
{

    $sql = "SELECT * FROM usuarios";        
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC); //fetch_all trae todos los registros
    return $usuarios;
    //fetch_assoc trae un solo registro
    //ejem´plp de fetch_assoc
    // $usuarios = $resultado->fetch_assoc();
    //llenar un array con los datos de la base de datos
    /*  while ($usuario = $resultado->fetch_assoc()) {
        $usuarios[] = $usuario;
    } */
    
    //echo json_encode($sql);
}
function crearPermiso($nombre, $descripcion)
{
    $sql = "INSERT INTO `permisos`(`idpermiso`, `nombre`) VALUES (?, ?)";
    $conexion = conectar();
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion); // "ss" indica que ambos parámetros son cadenas
    $stmt->execute();
    return $stmt->affected_rows > 0; // Devuelve true si se insertó correctamente
}

function crearRol($request)
{
    $sql = "INSERT INTO `roles`( `idrol`,`nombre`)VALUES (null,'{$request['nombre']}')";
    $conexion = conectar();
   
    $conexion->query($sql);
    return 0; // Devuelve true si se insertó correctamente
}

function listarPermisos()
{
    $sql = "SELECT * FROM permisos";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    return $resultado->fetch_all(MYSQLI_ASSOC); // Trae todos los permisos
}

function listarRoles()
{
    $sql = "SELECT * FROM roles";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    return $resultado->fetch_all(MYSQLI_ASSOC); // Trae todos los roles
}

function asignarPermisoARol($rolId, $permisoId)
{
    // Conectar a la base de datos
    $conexion = conectar();
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO roles_permisos (idrol, idpermiso) VALUES (?, ?)";
    
    // Preparar la declaración
    $stmt = $conexion->prepare($sql);
    
    // Vincular los parámetros (en este caso, dos enteros)
    $stmt->bind_param("ii", $rolId, $permisoId);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Comprobar si se insertó correctamente
    if ($stmt->affected_rows > 0) {
        return true;  // Se insertó correctamente
    } else {
        return false; // No se insertó o hubo un problema
    }
}


