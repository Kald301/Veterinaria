<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_rol'] !== 'veterinario' && $_SESSION['usuario_rol'] !== 'admin')) {
    header("Location: ../views/dashboard.php");
    exit();
}


include("../config/conexion.php");

$usuario_id = $_GET['usuario_id'];

    // nueva mascota

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $edad = $_POST['edad'];

    $sql = "INSERT INTO mascotas (nombre, especie, edad, usuario_id) VALUES ('$nombre', '$especie', $edad, $usuario_id)";
    if ($conexion->query($sql) === TRUE) {
        $_SESSION['mensaje'] = "Mascota añadida correctamente.";
        header("Location: edit_pet.php?usuario_id=$usuario_id");
        exit();
    } else {
        $_SESSION['error'] = "Error al añadir la mascota: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Mascota</title>
</head>
<body>
    <a href="edit_pet.php?usuario_id=<?php echo $usuario_id; ?>">Volver a la lista de mascotas</a>

    <h1>Añadir Mascota</h1>

    <!-- Mostrar mensaje -->
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div style='color: red;'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    ?>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="especie">Especie:</label>
        <input type="text" id="especie" name="especie" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="0" required><br><br>

        <button type="submit">Añadir Mascota</button>
    </form>
</body>
</html>