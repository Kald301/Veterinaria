<?php
include("../config/conexion.php");

// Obtener veterinarios
$sql_veterinarios = "SELECT id, nombre FROM usuarios WHERE rol = 'veterinario'";
$resultado_veterinarios = $conexion->query($sql_veterinarios);

// Obtener horarios de un veterinario y fecha seleccionada
$veterinario_id = isset($_GET['veterinario_id']) ? $_GET['veterinario_id'] : null;
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : null;

if ($veterinario_id && $fecha) {
    $sql_horarios = "SELECT hora_inicio, hora_fin FROM horarios WHERE veterinario_id = '$veterinario_id' AND fecha = '$fecha' AND disponible = TRUE";
    $resultado_horarios = $conexion->query($sql_horarios);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios disponibles</title>
    <script>
       async function cargarHorarios(veterinarioId, fecha) {
            try {
                const response = await fetch(`../controllers/get_horarios.php?veterinario_id=${veterinarioId}&fecha=${fecha}`);
                const horarios = await response.json();
                
                console.log(horarios); // Verificación de la respuesta en la consola

                const listaHorarios = document.getElementById('listaHorarios');
                listaHorarios.innerHTML = ''; // Limpiar lista

                const selectHoras = document.getElementById('hora_inicio');
                selectHoras.innerHTML = '<option value="">Seleccionar Hora</option>'; // Limpiar las opciones previas

                // Agregar las opciones de horas al select
                horarios.forEach(horario => {
                    const option = document.createElement('option');
                    option.value = horario.hora_inicio;
                    option.textContent = `${horario.hora_inicio} - ${horario.hora_fin}`;
                    selectHoras.appendChild(option);
                });

                // Mostrar los horarios disponibles en la lista
                horarios.forEach(horario => {
                    const li = document.createElement('li');
                    li.textContent = `${horario.hora_inicio} - ${horario.hora_fin}`;
                    listaHorarios.appendChild(li);
                });
            } catch (error) {
                console.error('Error al cargar los horarios:', error);
            }
}
    </script>
</head>
<body>
    <h1>Seleccionar horario</h1>

    <!-- Mostrar veterinarios en el select -->
    <form method="POST" action="reservar_cita.php">
        <label for="veterinario_id">Veterinario:</label>
        <select name="veterinario_id" id="veterinario_id" onchange="cargarHorarios(this.value, document.getElementById('fecha').value)" required>
            <option value="">Seleccionar Veterinario</option>
            <?php while ($veterinario = $resultado_veterinarios->fetch_assoc()): ?>
                <option value="<?php echo $veterinario['id']; ?>"><?php echo $veterinario['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required onchange="cargarHorarios(document.getElementById('veterinario_id').value, this.value)">
        
        <label for="hora_inicio">Hora:</label>
        <select name="hora_inicio" id="hora_inicio" required>
            <option value="">Seleccionar Hora</option>
            <!-- Las horas se generarán dinámicamente aquí -->
        </select>
        
        <button type="submit">Reservar cita</button>
    </form>

    <h2>Horarios Disponibles</h2>
    <ul id="listaHorarios">
        <!-- Los horarios se cargarán aquí -->
    </ul>
</body>
</html>

<?php
$conexion->close();
?>
