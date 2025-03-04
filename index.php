<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria inicio</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <main>

        <h1>BIENVENIDO A NUESTRA PAGINA VETERINARIA!</h1>
     <div class="links-container">
        <a href="views/login.php">Iniciar sesion</a>
        <a href="views/signin.php">Crear usuario</a>
    </div>
    
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<div style='color: green;'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        ?>
        

    </main>
    
</body>
</html>