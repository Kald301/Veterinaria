<?php
include("../config/conexion.php");

// Datos de inicio
$correo = $_POST['correo'];
$password = $_POST['password'];

// Consultar en la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($password, $usuario['password'])) {

        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        
        // Redirigir al dashboard o página principal
        header("Location: ../views/dashboard.php");
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "No existe un usuario con ese correo.";
}

// Cerrar conexión
$conexion->close();
?>