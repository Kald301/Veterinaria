<?php
// llamada  la conecion con mi base de datos
include("../../config/conexion.php");

// SQL para crear una tabla
$sql = "CREATE TABLE mascotas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    edad INT(3) NOT NULL,
    usuario_id INT(6) UNSIGNED,  -- Relación con la tabla usuarios
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
    echo "Tabla 'usuarios' creada exitosamente.";
} else {
    echo "Error al crear la tabla: " . $conexion->error;
}

$conexion->close();
?>