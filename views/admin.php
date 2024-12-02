<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

$usuario_id = $_GET['usuario_id'];

$sql_usuario = "SELECT nombre, correo, telefono FROM usuarios WHERE id = $usuario_id";
$resultado_usuario = $conexion->query($sql_usuario);

if ($resultado_usuario->num_rows > 0) {
    $datos_usuario = $resultado_usuario->fetch_assoc();
} else {
    $_SESSION['error'] = "No se encontraron datos del usuario.";
    header("Location: ../views/lista_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN D:</title>
</head>
<body>
    <main>
        ESTA ES LA PAGINA ADMINISTRATIVA :D MUY BONITA POR CIERTO 

        <a href

    </main>
</body>
</html>