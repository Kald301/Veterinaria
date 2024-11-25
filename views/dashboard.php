<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?>!</h1>
    <p>Has iniciado sesión exitosamente.</p>
    <a href="../controllers/logout.php">Cerrar sesión</a>
</body>
</html>