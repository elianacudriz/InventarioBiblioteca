<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido al Dashboard</h2>
    <p>Funciona</p>
    
    <!-- Botón para cerrar sesión -->
    <form action="logout.php" method="post">
        <input type="submit" value="Cerrar sesión">
    </form>
</body>
</html>

