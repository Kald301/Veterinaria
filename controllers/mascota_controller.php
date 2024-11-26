<?php
session_start();
include("../config/conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$especie = $_POST['especie'];
$edad = $_POST['edad'];
$usuario_id = $_SESSION['usuario_id'];  // ID del usuario logueado

// Preparar la consulta para insertar la mascota en la base de datos
$sql = "INSERT INTO mascotas (nombre, especie, edad, usuario_id) VALUES ('$nombre', '$especie', '$edad', '$usuario_id')";

if ($conexion->query($sql) === TRUE) {
    // Si la inserción fue exitosa, redirigir al dashboard con un mensaje de éxito
    $_SESSION['mensaje'] = "Mascota añadida exitosamente.";
    header("Location: ../views/dashboard.php");
} else {
    $_SESSION['mensaje'] = "Error al añadir la mascota: " . $conexion->error;
    header("Location: ../views/dashboard.php");
}

// Cerrar la conexión
$conexion->close();
?>