<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();

}



// Conexion base de datos
include("../config/conexion.php");

// Obtener el ID logueada
$usuario_id = $_SESSION['usuario_id'];

// Consultar las pets
$sql = "SELECT * FROM mascotas WHERE usuario_id = $usuario_id";
$resultado = $conexion->query($sql);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../assets/css/dash.css">
</head>
<body>
<div class="navbar">
    <div class="nav-item">
        <a href="../controllers/logout.php">Cerrar sesión</a>
    </div>
    <div class="nav-item">
        <a href="admin.php">¡ADMIN!</a>
    </div>
    <div class="nav-item">
    <a href="../views/addpet.php">Añadir mascota</a>
    </div>
</div>

    <?php
    if ($_SESSION['usuario_rol'] === 'veterinario') {
        echo '<a href="../views/lista_users.php">Ver usuarios</a>';
    }
    ?>   
    
    <?php
        if ($_SESSION['usuario_rol'] === 'admin') {
            echo '<a href="../views/admin.php?usuario_id=' . $_SESSION['usuario_id'] . '"></a>';
        }
    ?>
    <div class="main-box">
    <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?>!</h1>
    <p>AQUI ENCONTRARAS A TUS MASCOTAS!.</p>
        <div class= "mascotas">
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
        </div>
    </div>
    
    <!-- Mostrar mensajes -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
        unset($_SESSION['mensaje']);
    }
    ?>

    <?php if ($resultado->num_rows > 0): ?>
        
        
    <?php else: ?>
        <p>No tienes mascotas registradas. ¡Añade una nueva desde <a href="../views/addpet.php">aquí</a>!</p>
    <?php endif; ?>

</body>
</html>

<?php
$conexion->close();
?>