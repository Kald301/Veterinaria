<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>

<body>
    <main>
        <h1>Iniciar Sesión</h1>
        <form action="../controllers/login_user.php" method="POST">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" required>
            <br><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">
            <br><br>

            <button type="submit">Ingresar</button>
        </form>
    </main>
</body>

</html>