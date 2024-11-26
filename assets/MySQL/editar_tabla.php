<?php
// Incluir archivo de conexión
include("../../config/conexion.php");

// SQL para añadir el campo 'telefono'
$sql = "ALTER TABLE usuarios ADD rol ENUM('usuario', 'veterinario', 'admin') DEFAULT 'usuario'";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
    echo "Campo 'telefono' añadido exitosamente.";
} else {
    echo "Error al modificar la tabla: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
