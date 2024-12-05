<?php

include("../config/conexion.php");

if (isset($_POST['veterinario_id'], $_POST['fecha'], $_POST['hora_inicio'], $_POST['hora_fin'])) {
    $veterinario_id = $_POST['veterinario_id'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $sql = "INSERT INTO horarios (veterinario_id, fecha, hora_inicio, hora_fin) 
            VALUES ('$veterinario_id', '$fecha', '$hora_inicio', '$hora_fin')";

    if ($conexion->query($sql)) {
        echo "Horario añadido con éxito.";
    } else {
        echo "Error al añadir horario: " . $conexion->error;
    }
} else {
    echo "Error: No se recibieron todos los datos necesarios.";
}


$sql = "SELECT * FROM horarios 
        WHERE veterinario_id = '$veterinario_id' AND fecha = '$fecha' AND disponible = TRUE";
$resultado = $conexion->query($sql);

$conexion->close();
?>