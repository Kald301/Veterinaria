<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
</head>

<body>
    <main>
        <h1>Registro de Usuarios</h1>
        <form action="../controllers/registrar_user.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <br><br>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" required>
            <br><br>

            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" required>
            <br><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono">
            <br><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <br><br>


            <button type="submit">Registrar</button>
        </form>
    </main>
</body>

</html>