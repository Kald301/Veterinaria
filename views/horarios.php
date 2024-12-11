<?php
session_start();

// Verificar que el usuario sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: ../views/dashboard.php");
    exit();
}

include("../config/conexion.php");

// consulta para obtener los horarios que están activos
$sql_horarios_activos = "
    SELECT h.id, h.fecha, h.hora_inicio, h.hora_fin, u.nombre AS veterinario
    FROM horarios h
    JOIN usuarios u ON h.veterinario_id = u.id
    WHERE h.disponible = TRUE
      AND h.fecha = CURDATE()
    ORDER BY h.hora_inicio";
$resultado_horarios_activos = $conexion->query($sql_horarios_activos);

// optener mi hora local
date_default_timezone_set('America/Bogota'); // Ajusta tu zona horaria
$horaActual = date('H:i'); // Hora actual en formato HH:mm

/**
 * func para freaccionar los horarios (roto)
 */
function dividirHorariosEnIntervalos($horaInicio, $horaFin) {
    $intervalos = [];
    $inicio = new DateTime($horaInicio);
    $fin = new DateTime($horaFin);

    while ($inicio < $fin) {
        $siguiente = clone $inicio;
        $siguiente->modify('+1 hour');
        if ($siguiente > $fin) {
            $siguiente = $fin;
        }
        $intervalos[] = [
            'hora_inicio' => $inicio->format('H:i'),
            'hora_fin' => $siguiente->format('H:i')
        ];
        $inicio = $siguiente;
    }

    return $intervalos;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios Activos - Intervalos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .expirado {
            background-color: #f8d7da;
            color: #721c24;
        }
        .en-curso {
            background-color: #fff3cd;
            color: #856404;
        }
        .disponible {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <h2>Horarios Activos Desglosados</h2>
    <table>
        <thead>
            <tr>
                <th>Veterinario</th>
                <th>Fecha</th>
                <th>Intervalo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado_horarios_activos->num_rows > 0): ?>
                <?php while ($horario = $resultado_horarios_activos->fetch_assoc()): ?>
                    <?php 
                    $intervalos = dividirHorariosEnIntervalos($horario['hora_inicio'], $horario['hora_fin']);
                    foreach ($intervalos as $intervalo): 
                        // Determinar el estado del intervalo
                        $estado = '';
                        if ($horaActual >= $intervalo['hora_fin']) {
                            $estado = 'Expirado';
                        } elseif ($horaActual >= $intervalo['hora_inicio'] && $horaActual < $intervalo['hora_fin']) {
                            $estado = 'En Curso';
                        } else {
                            $estado = 'Disponible';
                        }
                    ?>
                        <tr class="<?php echo strtolower($estado); ?>">
                            <td><?php echo $horario['veterinario']; ?></td>
                            <td><?php echo $horario['fecha']; ?></td>
                            <td><?php echo $intervalo['hora_inicio'] . " - " . $intervalo['hora_fin']; ?></td>
                            <td><?php echo $estado; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay veterinarios activos en este momento.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conexion->close();
?>