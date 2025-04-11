<?php

//crear un usuario

function crearUsuario($request)
{
    try {
        $passwordHash = password_hash($request['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (id, nombre, correo, password, id_rol)
                VALUES (NULL, '{$request['nombre']}', '{$request['correo']}', '{$passwordHash}', '{$request['id_rol']}')";
        
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
    return $resultado->fetch_all(MYSQLI_ASSOC); // Trae todos los usuarios
}


function crearPermiso($request)
{
    $sql = "INSERT INTO permisos (id_permiso, nombre_permiso) VALUES (NULL, '{$request['nombre_permiso']}')";
    $conexion = conectar();
    return $conexion->query($sql);
}


function crearRol($request)
{
    $sql = "INSERT INTO roles(id_rol, nombre_rol) VALUES (NULL, '{$request['nombre_rol']}')";
    $conexion = conectar();
    return $conexion->query($sql);
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

function asignarRolesPermisos ($request)
{
    $sql = "INSERT INTO rolypermiso (id_rol, id_permiso) VALUES ('{$request['id_rol']}', '{$request['id_permiso']}')";
    $conexion = conectar();
    return $conexion->query($sql);
}



