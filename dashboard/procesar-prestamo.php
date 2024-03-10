<?php
// Conexión a la base de datos
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "inventario";

$conn = new mysqli($servername, $username_db, $password_db, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_prestador'])) {
    $tipo_de_documento = $_POST['tipo_de_documento'];
    $documento = $_POST['documento'];

    $sql = "SELECT * FROM prestador WHERE tipo_de_documento = ? AND documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tipo_de_documento, $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['prestador'] = $result->fetch_assoc();
    } else {
        $_SESSION['prestador'] = null;
    }
    header("Location: prestar-libro.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_prestamo'])) {
    $libro_id = $_POST['libro_id'];
    $prestador_id = $_SESSION['prestador']['id'];

    $sql = "UPDATE libro SET estado = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $libro_id);
    $stmt->execute();

    // Generar un número de ticket para la operación
    $ticket = rand(100000, 999999);
    $_SESSION['ticket'] = "El libro ha sido prestado. Tu número de ticket es: $ticket";

    header("Location: prestar-libro.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_prestador'])) {
    $nuevo_tipo_de_documento = $_POST['nuevo_tipo_de_documento'];
    $nuevo_documento = $_POST['nuevo_documento'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nuevo_direccion = $_POST['nuevo_direccion'];

    $sql = "INSERT INTO prestador (tipo_de_documento, documento, nombre, telefono, direccion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nuevo_tipo_de_documento, $nuevo_documento, $nuevo_nombre, $nuevo_telefono, $nuevo_direccion);
    $stmt->execute();

    header("Location: prestar-libro.php");
    exit;
}
?>