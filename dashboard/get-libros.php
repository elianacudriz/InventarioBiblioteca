<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Redirigir a la página de inicio si no hay sesión activa
    exit;
}
//include 'db.php';
// Conexión a la base de datos
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "inventario";

//Crear conexión
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Primera consulta para obtener todos los libros
// $sql = "SELECT id, nombre, autor, isbn, estado FROM libro";
// $result = mysqli_query($conn, $sql);

$libros = [];
// while($row = mysqli_fetch_assoc($result)) {
//     $libros[$row['isbn']] = $row;
//     $libros[$row['isbn']]['count'] = 0; // Inicializamos el conteo en 0
// }

// Segunda consulta para obtener los conteos de ISBN
$sqlCount = "SELECT isbn, nombre, autor, COUNT(id) as count FROM libro WHERE estado = 1 GROUP BY isbn ORDER BY nombre ASC";
$result = mysqli_query($conn, $sqlCount);

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

// Cerrar conexión
mysqli_close($conn);
?>