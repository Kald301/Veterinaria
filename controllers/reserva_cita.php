<?php
include("../config/conexion.php");
$usuario_id = $_SESSION['usuario_id'];
$veterinario_id = $_POST['veterinario_id'];
$fecha = $_POST['fecha'];
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = date('H:i:s', strtotime($hora_inicio . ' +1 hour')); // Cita de 1 hora

// Insertar cita
$sql_cita = "INSERT INTO citas (usuario_id, veterinario_id, fecha, hora_inicio, hora_fin) 
             VALUES ('$usuario_id', '$veterinario_id', '$fecha', '$hora_inicio', '$hora_fin')";
if ($conexion->query($sql_cita)) {
    // Actualizar horario
    $sql_update_horario = "UPDATE horarios 
                           SET disponible = FALSE 
                           WHERE veterinario_id = '$veterinario_id' AND fecha = '$fecha' AND hora_inicio = '$hora_inicio'";
    $conexion->query($sql_update_horario);
    echo "Cita reservada con éxito.";
} else {
    echo "Error al reservar cita: " . $conexion->error;
}
$conexion->close();
?>