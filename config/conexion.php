<?php

$host = "localhost";
$usuario = "root"; 
$contrasena = "KMR44hbc87*";  
$base_datos = "veterinaria-PHP";


$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
echo "Conexión exitosa a la base de datos.";
?>
