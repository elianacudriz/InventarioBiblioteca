
<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ../app/index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['procesar-ingreso-libro'])) {
    $isbn = $_POST['isbn'];
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];

    // Insertar datos en la tabla libro
    $stmt = $conexion->prepare("INSERT INTO libro (isbn, nombre, autor, estado, inactivo) VALUES (?, ?, ?, 1, 0)");
    $stmt->bind_param("sss", $isbn, $nombre, $autor);
    $stmt->execute();

    if ($stmt->errno) {
        echo "<script>alert('Error al ingresar el libro.')</script>";
        header("Location: ../app/dashboard/dashboard.php");
    } else {
        echo "<script>alert('Libro ingresado con éxito.')</script>";
        header("Location: ../app/dashboard/dashboard.php"); 
    }
}


?>