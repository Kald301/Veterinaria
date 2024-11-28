<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'veterinario') {
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

// Obtener las mascotas
$sql = "SELECT * FROM mascotas WHERE usuario_id = $usuario_id";
$resultado = $conexion->query($sql);

// Actualizar datos de la mascota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
    $mascota_id = $_POST['mascota_id'];
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $edad = $_POST['edad'];

    $update_sql = "UPDATE mascotas SET nombre = '$nombre', especie = '$especie', edad = $edad WHERE id = $mascota_id";
    $conexion->query($update_sql);

    $_SESSION['mensaje'] = "Mascota actualizada correctamente.";
    header("Location: edit_pet.php?usuario_id=$usuario_id");
    exit();
}

// Eliminar mascota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    $mascota_id = $_POST['mascota_id'];

    $delete_sql = "DELETE FROM mascotas WHERE id = $mascota_id";
    $conexion->query($delete_sql);

    $_SESSION['mensaje'] = "Mascota eliminada correctamente.";
    header("Location: edit_pet.php?usuario_id=$usuario_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascotas</title>
    <script>
        function confirmarEliminacion(nombreMascota) {
            return confirm(`¿Estás seguro de que deseas eliminar a la mascota "${nombreMascota}"? Esta acción no se puede deshacer.`);
        }
    </script>
</head>
<body>
    <a href="../views/lista_users.php">Volver a la lista de usuarios</a>

    <h1>Editar Mascotas</h1>

    <!-- Mostrar mensaje si existe -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
        unset($_SESSION['mensaje']);
    }
    ?>
    <div>
        <h3>Editar Mascotas de <?php echo $datos_usuario['nombre']; ?></h3>
        <p>Correo: <?php echo $datos_usuario['correo']; ?></p>
        <p>Teléfono: <?php echo $datos_usuario['telefono']; ?></p>
    </div>


    <form method="POST">
    <?php if ($resultado->num_rows > 0): ?>    
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

                        <!-- Botón Guardar -->
                        <button type="submit" name="accion" value="actualizar">Guardar</button>

                        <!-- Botón Eliminar con confirmación -->
                        <button type="submit" name="accion" value="eliminar" 
                                onclick="return confirmarEliminacion('<?php echo $mascota['nombre']; ?>')">Eliminar</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
        <p>El usuario no tiene mascotas registradas</p>
        <?php endif; ?>
        <a href="add_pet_adm.php?usuario_id=<?php echo $usuario_id; ?>">Añadir nueva mascota</a>
    </form>
</body>
</html>

<?php
$conexion->close();
?>