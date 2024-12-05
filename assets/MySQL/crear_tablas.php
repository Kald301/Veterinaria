<?php
include("../../config/conexion.php");

$sql = "CREATE TABLE horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    veterinario_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (veterinario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB";

if ($conexion->query($sql) === TRUE) {
    echo "Tabla 'Horarios' creada exitosamente.";
} else {
    echo "Error al crear la tabla: " . $conexion->error;
}

$conexion->close();
?>