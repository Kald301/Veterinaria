<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
</head>

<body>
    <main>
    <h2>Añadir una mascota</h2>
    <form action="../controllers/mascota_controller.php" method="POST">
        <label for="nombre">Nombre de la mascota:</label>
        <input type="text" name="nombre" required><br>
        
        <label for="especie">Especie:</label>
        <input type="text" name="especie" required><br>
        
        <label for="edad">Edad:</label>
        <input type="number" name="edad" required><br>
        
        <button type="submit">Añadir mascota</button>
    </form>
    </main>
</body>

</html>