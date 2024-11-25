<?php
// Incluir archivo de conexión
include("../config/conexion.php");

// Capturar los datos enviados desde el formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$edad = $_POST['edad'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];

$password_encriptada = password_hash($password, PASSWORD_BCRYPT);

// Preparar la consulta SQL
$sql = "INSERT INTO usuarios (nombre, correo, edad, telefono, password) 
        VALUES ('$nombre', '$correo', $edad, '$telefono', '$password_encriptada')";

// Ejecutar la consulta y verificar si fue exitosa
if ($conexion->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error al registrar el usuario: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>