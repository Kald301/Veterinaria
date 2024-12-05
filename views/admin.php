<?php
session_start();



// Verificar que el usuario sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");


$sql_veterinarios = "SELECT id, nombre FROM usuarios WHERE rol = 'veterinario'";
$resultado_veterinarios = $conexion->query($sql_veterinarios);


// Obtener los administradores
$sql_admins = "SELECT id, nombre, correo, telefono, rol FROM usuarios WHERE rol = 'admin'";
$resultado_admins = $conexion->query($sql_admins);

// Obtener los demás usuarios
$sql_usuarios = "SELECT id, nombre, correo, telefono, rol FROM usuarios WHERE rol != 'admin'";
$resultado_usuarios = $conexion->query($sql_usuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
</head>
<body>
    <h1>Administrar Usuarios</h1>
    <a href="../views/dashboard.php">Volver al Dashboard</a>

    <!-- Mostrar mensaje -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
        unset($_SESSION['mensaje']);
    }
    if (isset($_SESSION['error'])) {
        echo "<div style='color: red;'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    ?>

    <!-- Tabla de administradores -->
    <h2>Administradores</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($admin = $resultado_admins->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo $admin['nombre']; ?></td>
                    <td><?php echo $admin['correo']; ?></td>
                    <td><?php echo $admin['telefono']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Tabla de otros usuarios -->
    <h2>Otros Usuarios</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = $resultado_usuarios->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['correo']; ?></td>
                    <td><?php echo $usuario['telefono']; ?></td>
                    <td><?php echo $usuario['rol']; ?></td>
                    <td>
                        <a href="../views/edit_user.php?usuario_id=<?php echo $usuario['id']; ?>">Editar</a>
                        <a href="../controllers/delete_user.php?usuario_id=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>HORARIOS</h2>

    <form method="POST" action="../controllers/add_horario.php">
        <label for="veterinario_id">Veterinario:</label>
        <select name="veterinario_id" required>
            <option value="" disabled selected>Seleccione un veterinario</option>
            <?php while ($veterinario = $resultado_veterinarios->fetch_assoc()): ?>
                <option value="<?php echo $veterinario['id']; ?>">
                    <?php echo $veterinario['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required>
        <label for="hora_inicio">Hora de inicio:</label>
        <input type="time" name="hora_inicio" required>
        <label for="hora_fin">Hora de fin:</label>
        <input type="time" name="hora_fin" required>
        <button type="submit">Guardar horario</button>
    </form>

</body>
</html>

<?php
$conexion->close();
?>