
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Redirigir
if ($_SESSION['usuario_rol'] === 'admin') {
    header("Location: ../views/admin.php");
} elseif ($_SESSION['usuario_rol'] === 'veterinario') {
    header("Location: ../views/lista_users.php");
} else {
    header("Location: dashboard.php"); 
}   
exit();
?>