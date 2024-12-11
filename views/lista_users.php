<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'veterinario') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

//  La lista de usuarios
$sql = "SELECT id, nombre, correo FROM usuarios WHERE rol = 'usuario'";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <main>
        <h1>Usuarios Registrados</h1>
        <a href="../views/dashboard.php">Volver al dashboard</a>
        <ul>
            <?php while ($usuario = $resultado->fetch_assoc()): ?>
                <li>
                    <strong>Nombre:</strong> <?php echo $usuario['nombre']; ?>
                    <strong>Email:</strong> <?php echo $usuario['correo']; ?>
                    <a href="../views/edit_pet.php?usuario_id=<?php echo $usuario['id']; ?>">Editar Mascotas</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </main>
</body>
</html>

<?php
$conexion->close();
?>