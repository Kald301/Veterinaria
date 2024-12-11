<?php
include("../config/conexion.php");

date_default_timezone_set("America/Bogota"); // Cambia esto a tu zona horaria local

// llamar la fecha y hora actual
$fecha_actual = date("Y-m-d");
$hora_actual = date("H:i:s");

// eliminar horarios que ya pasaron
$sql_eliminar = "
    DELETE FROM horarios 
    WHERE fecha < '$fecha_actual' 
       OR (fecha = '$fecha_actual' AND hora_fin <= '$hora_actual')
";

if ($conexion->query($sql_eliminar) === TRUE) {
    echo "Horarios pasados eliminados correctamente.";
} else {
    echo "Error al eliminar horarios: " . $conexion->error ; 
}


echo "Hora del servidor (UTC): " . date("Y-m-d H:i:s") . "<br>";

// configura tu zona horaria para eliminar correctamente los horarios obsoletos
echo "Hora local configurada: " . date("Y-m-d H:i:s") . "<br>";


$conexion->close();
?>