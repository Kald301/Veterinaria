<?php

include("../config/conexion.php");

// capturar los datos enviados desde el formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$edad = $_POST['edad'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];

$password_encriptada = password_hash($password, PASSWORD_BCRYPT);

// Preparar datos para la base de datos
$sql = "INSERT INTO usuarios (nombre, correo, edad, telefono, password) 
        VALUES ('$nombre', '$correo', $edad, '$telefono', '$password_encriptada')";

// Ejecutar el envio
if ($conexion->query($sql) === TRUE) {
    $_SESSION['mensaje'] = "Usuario creado exitosamente.";
    header("Location: ../index.php");
} else {
    $_SESSION['error'] = "Error al registrar el usuario:  . $conexion->error";
    header("Location: ../views/login.php");

}

$conexion->close();
?>