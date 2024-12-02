<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

$usuario_id = $_GET['usuario_id'];

// Eliminar el usuario
$sql_delete = "DELETE FROM usuarios WHERE id = $usuario_id";

if ($conexion->query($sql_delete) === TRUE) {
    $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
} else {
    $_SESSION['error'] = "Error al eliminar el usuario.";
}

header("Location: ../views/admin.php");
exit();