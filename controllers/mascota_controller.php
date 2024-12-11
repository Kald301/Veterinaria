<?php
session_start();
include("../config/conexion.php");

// verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// obtener los datos del formulario
$nombre = $_POST['nombre'];
$especie = $_POST['especie'];
$edad = $_POST['edad'];
$usuario_id = $_SESSION['usuario_id'];  // ID del usuario logueado

// enviar datos a la base de datos
$sql = "INSERT INTO mascotas (nombre, especie, edad, usuario_id) VALUES ('$nombre', '$especie', '$edad', '$usuario_id')";

if ($conexion->query($sql) === TRUE) {
    // 
    $_SESSION['mensaje'] = "Mascota añadida exitosamente.";
    header("Location: ../views/dashboard.php");
} else {
    $_SESSION['mensaje'] = "Error al añadir la mascota: " . $conexion->error;
    header("Location: ../views/dashboard.php");
}


$conexion->close();
?>