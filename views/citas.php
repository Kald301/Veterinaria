<?php
session_start();

// Verificar que el usuario sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

// Consulta para obtener los horarios que están activos en este momento
$sql_horarios_activos = "
    SELECT h.id, h.fecha, h.hora_inicio, h.hora_fin, u.nombre AS veterinario
    FROM horarios h
    JOIN usuarios u ON h.veterinario_id = u.id
    WHERE h.disponible = TRUE
      AND h.fecha = CURDATE() -- Comparar con la fecha actual
      AND CURTIME() BETWEEN h.hora_inicio AND h.hora_fin -- Verificar que la hora actual esté en el rango
    ORDER BY h.hora_inicio";
$resultado_horarios_activos = $conexion->query($sql_horarios_activos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios Activos Ahora</title>
</head>
<body>
    <h2>Horarios Activos Ahora</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Veterinario</th>
                <th>Fecha</th>
                <th>Inicio horario atencion</th>
                <th>Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado_horarios_activos->num_rows > 0): ?>
                <?php while ($horario = $resultado_horarios_activos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $horario['id']; ?></td>
                        <td><?php echo $horario['veterinario']; ?></td>
                        <td><?php echo $horario['fecha']; ?></td>
                        <td><?php echo $horario['hora_inicio']; ?></td>
                        <td><?php echo $horario['hora_fin']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay veterinarios activos en este momento.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conexion->close();
?>