<?php
include("../../config/conexion.php");

$sql = "CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    edad INT NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rol VARCHAR(20) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB" ;


$sql = "CREATE TABLE mascotas (
    id INT AUTO_INCREMENT PRIMARY KEY,          
    nombre VARCHAR(100) NOT NULL,                
    especie VARCHAR(50) NOT NULL,                
    edad INT NOT NULL,                           
    usuario_id INT NOT NULL,                     
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) 
    ON DELETE CASCADE                            
) ENGINE=InnoDB" ;

$sql = "CREATE TABLE horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,               
    veterinario_id INT NOT NULL,                     
    fecha DATE NOT NULL,                             
    hora_inicio TIME NOT NULL,                       
    hora_fin TIME NOT NULL,                          
    disponible BOOLEAN DEFAULT TRUE,                 
    FOREIGN KEY (veterinario_id) REFERENCES usuarios(id) 
    ON DELETE CASCADE                                
) ENGINE=InnoDB" ;


