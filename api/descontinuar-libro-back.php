<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['procesar-descontinuar-libro'])) {
    $id = $_POST['id'];
    $isbn = $_POST['isbn']; // Asegúrate de que el ISBN se está enviando correctamente desde el formulario

    // Buscar el estado del libro
    $stmt = $conexion->prepare("SELECT estado FROM libro WHERE id = ? OR isbn = ?");
    $stmt->bind_param("is", $id, $isbn);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $estado = $row['estado'];

        if ($estado == 0) {
            echo "<script>alert('No se puede descontinuar el libro pues está prestado. El prestador debe retornarlo primero')</script>";
        } else {
            // Actualizar estado y activo del libro
            $stmt2 = $conexion->prepare("UPDATE libro SET estado = 0, inactivo = 1 WHERE id = ? OR isbn = ?");
            $stmt2->bind_param("is", $id, $isbn);
            $stmt2->execute();

            if ($stmt2->errno) {
                echo "<script>alert('Error al descontinuar el libro.')</script>";
                header("Location: ../app/dashboard/dashboard.php");
            } else {
                echo "<script>alert('El libro ha sido descontinuado exitosamente.')</script>";
                header("Location: ../app/dashboard/dashboard.php");
            }
        }
    } else {
        echo "<script>alert('No se encontró un libro con el ID o ISBN proporcionado.')</script>";
        header("Location: ../app/dashboard/dashboard.php");
    }
}
?>