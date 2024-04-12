<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

if (!isset($_SESSION['username'])) {
    header("Location: ../app/index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['procesar-prestamo-existe'])) {
    $prestador = $_SESSION['prestador'];
    $carrito = $_SESSION['carrito'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    $stmt = $conexion->prepare("INSERT INTO ticket (prestador_tipo_de_documento, prestador_documento, fecha_prestamo, fecha_devolucion, estado) VALUES (?, ?, NOW(), ?, 1)");
    $stmt->bind_param("sss", $prestador['tipo_de_documento'], $prestador['documento'], $fecha_devolucion);
    $stmt->execute();
    $ticket_id = $conexion->insert_id;

    foreach ($carrito as $libro) {
        $stmt2 = $conexion->prepare("INSERT INTO ticket_libro (ticket_id, libro_id, libro_isbn) VALUES (?, ?, ?)");
        $stmt2->bind_param("iss", $ticket_id, $libro['id'], $libro['isbn']);
        $stmt2->execute();

        $stmt3 = $conexion->prepare("UPDATE libro SET estado = 0 WHERE id = ?");
        $stmt3->bind_param("i", $libro['id']);
        $stmt3->execute();
    }

    if ($stmt->errno || $stmt2->errno || $stmt3->errno) {
        echo "<script>alert('Error intentando crear el prestamo del libro. Intente de nuevo.')</script>";
        header("Location: ../app/dashboard/dashboard.php");  
    } else {
        $_SESSION['mensaje'] = "Préstamo realizado con éxito. ID del ticket: {$ticket_id}, con fecha de retorno: {$fecha_devolucion}.";
        header("Location: ../app/dashboard/dashboard.php");  
    } 

    // Vaciar el carrito después de procesar todos los libros
    $_SESSION['carrito'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['procesar-prestamo-no'])) {
    $tipo_de_documento = $_POST['tipo_de_documento'];
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Insertar datos en la tabla prestador
    $stmt0 = $conexion->prepare("INSERT INTO prestador (tipo_de_documento, documento, nombre, telefono, direccion) VALUES (?, ?, ?, ?, ?)");
    $stmt0->bind_param("sssss", $tipo_de_documento, $documento, $nombre, $telefono, $direccion);
    $stmt0->execute();

    $carrito = $_SESSION['carrito'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    $stmt = $conexion->prepare("INSERT INTO ticket (prestador_tipo_de_documento, prestador_documento, fecha_prestamo, fecha_devolucion, estado) VALUES (?, ?, NOW(), ?, 1)");
    $stmt->bind_param("sss", $tipo_de_documento, $documento, $fecha_devolucion);
    $stmt->execute();
    $ticket_id = $conexion->insert_id;

    foreach ($carrito as $libro) {
        $stmt2 = $conexion->prepare("INSERT INTO ticket_libro (ticket_id, libro_id, libro_isbn) VALUES (?, ?, ?)");
        $stmt2->bind_param("iss", $ticket_id, $libro['id'], $libro['isbn']);
        $stmt2->execute();

        $stmt3 = $conexion->prepare("UPDATE libro SET estado = 0 WHERE id = ?");
        $stmt3->bind_param("i", $libro['id']);
        $stmt3->execute();
    }

    if ($stmt->errno || $stmt2->errno || $stmt3->errno) {
        echo "<script>alert('Error intentando crear el prestamo del libro. Intente de nuevo.')</script>";
        header("Location: ../app/dashboard/dashboard.php");  
    } else {
        $_SESSION['mensaje'] = "Préstamo realizado con éxito. ID del ticket: {$ticket_id}, con fecha de retorno: {$fecha_devolucion}.";
        header("Location: ../app/dashboard/dashboard.php");  
    } 

    // Vaciar el carrito después de procesar todos los libros
    $_SESSION['carrito'] = [];
}

?>