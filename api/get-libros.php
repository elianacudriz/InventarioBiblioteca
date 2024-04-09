<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}

include "../modelo/conexion.php";


$libros = [];

$result = $conexion -> query("SELECT isbn, nombre, autor, COUNT(id) as count FROM libro WHERE estado = 1 GROUP BY isbn ORDER BY nombre ASC");


// Verificar si la consulta devuelve filas
if (mysqli_num_rows($result) > 0) {
    // Guardar los datos de cada fila
    while($row = mysqli_fetch_assoc($result)) {
        $libros[] = $row;
    }

    // Enviar los resultados en formato JSON
    echo json_encode($libros);
} else {
    echo json_encode([]);
}


$conexion->close();
?>