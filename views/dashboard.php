<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión a la base de datos
include("../config/conexion.php");

// Obtener el ID del usuario actual
$usuario_id = $_SESSION['usuario_id'];

// Consultar las mascotas del usuario
$sql = "SELECT * FROM mascotas WHERE usuario_id = $usuario_id";
$resultado = $conexion->query($sql);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <a href="../controllers/logout.php">Cerrar sesión</a>

    <?php
    if ($_SESSION['usuario_rol'] === 'veterinario') {
        echo '<a href="../views/lista_users.php">Ver usuarios</a>';
    }
    ?>   
    
    <?php
        if ($_SESSION['usuario_rol'] === 'admin') {
            echo '<a href="../views/admin.php?usuario_id=' . $_SESSION['usuario_id'] . '">¡ADMIN!</a>';
        }
    ?>

    <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?>!</h1>
    <p>Has iniciado sesión exitosamente.</p>
    
    <a href="../views/addpet.php">Añadir mascota</a>
    
    <!-- Mostrar mensajes -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
        unset($_SESSION['mensaje']);
    }
    ?>

    <?php if ($resultado->num_rows > 0): ?>
        <h2>Tus Mascotas</h2>
        <ul>
            <?php while ($mascota = $resultado->fetch_assoc()): ?>
                <li>
                    <strong>Nombre:</strong> <?php echo $mascota['nombre']; ?>, 
                    <strong>Especie:</strong> <?php echo $mascota['especie']; ?>, 
                    <strong>Edad:</strong> <?php echo $mascota['edad']; ?> años
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No tienes mascotas registradas. ¡Añade una nueva desde <a href="../views/addpet.php">aquí</a>!</p>
    <?php endif; ?>

</body>
</html>

<?php
$conexion->close();
?>