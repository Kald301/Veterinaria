<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

$usuario_id = $_GET['usuario_id'];

// Obtener los datos del usuario
$sql = "SELECT id, nombre, correo, telefono, rol FROM usuarios WHERE id = $usuario_id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    $_SESSION['error'] = "No se encontró el usuario.";
    header("Location: admin.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $rol = $_POST['rol'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Actualizar datos
    if ($password) {
        $sql_update = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo', telefono = '$telefono', password = '$password', rol = '$rol' WHERE id = $usuario_id";
    } else {
        $sql_update = "UPDATE usuarios SET nombre = '$nombre', correo = '$correo', telefono = '$telefono', rol = '$rol' WHERE id = $usuario_id";
    }

    if ($conexion->query($sql_update) === TRUE) {
        $_SESSION['mensaje'] = "Usuario actualizado correctamente.";
        header("Location: admin.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>          
    <h1>Editar Usuario</h1>
    <a href="admin.php">Volver a la lista</a><br>

    <a href="../views/edit_pet.php?usuario_id=<?php echo $usuario['id']; ?>">Editar Mascotas</a>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required>
        <br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $usuario['telefono']; ?>" required>
        <br>
        <label for="password">Contraseña (dejar en blanco para no cambiar):</label>
        <input type="password" name="password">
        <br>
        <label for="rol">Rol del usuario actual: <?php echo $usuario['rol']; ?> </label><br>
        <select name="rol" id="rol">
            <option value="usuario" <?php echo $usuario['rol'] === 'usuario' ? 'selected' : ''; ?>>Usuario</option>
            <option value="veterinario" <?php echo $usuario['rol'] === 'veterinario' ? 'selected' : ''; ?>>Veterinario</option>
        </select>
        <br>
        <button type="submit">Guardar</button>

    </form>
</body>
</html>