<?php
// llamad a  la conecion con mi base de datos
include("./config/conexion.php");

// SQL para crear una tabla
$sql = "CREATE TABLE usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL UNIQUE,
    edad INT(3) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
    echo "Tabla 'usuarios' creada exitosamente.";
} else {
    echo "Error al crear la tabla: " . $conexion->error;
}

$conexion->close();
?>