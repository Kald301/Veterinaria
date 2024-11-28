<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria inicio</title>
</head>
<body>
    <main>
        <a href="../views/login.php">Iniciar sesion</a>
        <a href="../views/signin.php">Crear usuario</a>
        <h1>BIENVENIDO :D</h1>


        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        ?>
        
    </main>
</body>
</html>