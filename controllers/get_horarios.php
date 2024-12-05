<?php
include("../config/conexion.php");

// Verificar si los parámetros 'veterinario_id' y 'fecha' están presentes en la URL
if (isset($_GET['veterinario_id']) && isset($_GET['fecha'])) {
    $veterinario_id = $_GET['veterinario_id'];
    $fecha = $_GET['fecha'];

    // Consulta para obtener los horarios disponibles
    $sql_horarios = "SELECT hora_inicio, hora_fin FROM horarios WHERE veterinario_id = '$veterinario_id' AND fecha = '$fecha' AND disponible = TRUE";
    $resultado_horarios = $conexion->query($sql_horarios);

    $horarios = [];
    while ($horario = $resultado_horarios->fetch_assoc()) {
        $horarios[] = $horario;
    }

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($horarios);
} else {
    // Si los parámetros no están presentes, devolver un error
    echo json_encode(["error" => "Faltan parámetros: veterinario_id o fecha"]);
}

$conexion->close();
?>