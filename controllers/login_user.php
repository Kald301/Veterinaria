<?php
session_start();

include("../config/conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

// consultar en la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($password, $usuario['password'])) {

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];


        header("Location: ../views/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
        header("Location: ../views/login.php");
        exit;
    }
} else {
    // guardar mensaje en la sesión
    $_SESSION['error'] = "No existe un usuario con ese correo.";
    header("Location: ../views/login.php");  // Redirigir a login para mostrar el error
    exit;
}

$conexion->close();
?>
