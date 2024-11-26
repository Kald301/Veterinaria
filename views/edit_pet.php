<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'veterinario') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

// Obtener el ID del usuario desde la URL
$usuario_id = $_GET['usuario_id'];

// Obtener las mascotas del usuario
$sql = "SELECT * FROM mascotas WHERE usuario_id = $usuario_id";
$resultado = $conexion->query($sql);

// Actualizar datos de la mascota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mascota_id = $_POST['mascota_id'];
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $edad = $_POST['edad'];

    $update_sql = "UPDATE mascotas SET nombre = '$nombre', especie = '$especie', edad = $edad WHERE id = $mascota_id";
    $conexion->query($update_sql);

    $_SESSION['mensaje'] = "Mascota actualizada correctamente.";
    header("Location: editar_mascotas.php?usuario_id=$usuario_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascotas</title>
</head>
<body>
    <h1>Editar Mascotas</h1>
    <a href="../views/lista_users.php">Volver a la lista de usuarios</a>

    <!-- Mostrar mensaje si existe -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
        unset($_SESSION['mensaje']);
    }
    ?>

    <form method="POST">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Edad</th>
                <th>Acciones</th>
            </tr>
            <?php while ($mascota = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><input type="text" name="nombre" value="<?php echo $mascota['nombre']; ?>"></td>
                    <td><input type="text" name="especie" value="<?php echo $mascota['especie']; ?>"></td>
                    <td><input type="number" name="edad" value="<?php echo $mascota['edad']; ?>"></td>
                    <td>
                        <input type="hidden" name="mascota_id" value="<?php echo $mascota['id']; ?>">
                        <button type="submit">Guardar</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </form>
</body>
</html>

<?php
$conexion->close();
?>