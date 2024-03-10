<?php
//include 'db.php'; // Asegúrate de que este archivo establece la conexión a la base de datos.

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

// Carga los libros con el ISBN dado si está presente en la URL
$libros = [];
if (isset($_GET['isbn'])) {
    $isbn = htmlspecialchars($_GET['isbn']);
    $sql = "SELECT id, nombre, autor FROM libro WHERE isbn = '$isbn' AND estado = 1";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $libros[] = $row;
    }
}
$prestador = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_prestador'])) {
    $tipo_de_documento = $_POST['tipo_de_documento'];
    $documento = $_POST['documento'];

    $sql = "SELECT * FROM prestador WHERE tipo_de_documento = ? AND documento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tipo_de_documento, $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $prestador = $result->fetch_assoc();
    }
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
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_prestamo'])) {
    $libro_id = $_POST['libro_id'];
    $prestador_id = $_POST['prestador_id'];

    $sql = "UPDATE libro SET estado = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $libro_id);
    $stmt->execute();

    $ticket = rand(100000, 999999);
    echo "El libro ha sido prestado. Tu número de ticket es: $ticket";
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prestar Libro</title>
</head>
<body>
    <h1>Prestar Libro</h1>
    <form method="post">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo isset($isbn) ? $isbn : ''; ?>" />

        <!-- Mostrar la información del libro cargado -->
        <?php foreach ($libros as $libro): ?>
            <p>ID: <?php echo $libro['id']; ?>, Nombre: <?php echo $libro['nombre']; ?>, Autor: <?php echo $libro['autor']; ?></p>
        <?php endforeach; ?>

        <!-- Formulario para buscar el prestador -->
        <input type="text" name="tipo_de_documento" placeholder="Tipo de documento">
        <input type="text" name="documento" placeholder="Número de documento">
        <input type="submit" name="buscar_prestador" value="Buscar Prestador">

        <!-- Aquí puedes agregar campos para mostrar la información del prestador si se encontró -->
            <?php if ($prestador): ?>
                <p>Nombre: <?php echo $prestador['nombre']; ?></p>
                <p>Telefono: <?php echo $prestador['telefono']; ?></p>
                <p>Direccion: <?php echo $prestador['direccion']; ?></p>
                <!-- Agrega aquí más campos según la información que tengas en la tabla prestador -->
            <?php endif; ?>

        <!-- Formulario para confirmar el préstamo -->
<?php if ($prestador): ?>
    <form method="post">
        <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
        <input type="hidden" name="prestador_id" value="<?php echo $prestador['id']; ?>">
        <input type="submit" name="confirmar_prestamo" value="Prestar Libro">
    </form>
<?php endif; ?>

        <!-- Formulario para crear un nuevo prestador si no se encontró uno existente -->
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_prestador']) && !$prestador): ?>
    <form method="post">
        <h2>Crear nuevo prestador</h2>
        <input type="text" name="nuevo_tipo_de_documento" placeholder="Tipo de documento">
        <input type="text" name="nuevo_documento" placeholder="Número de documento">
        <input type="text" name="nuevo_nombre" placeholder="Nombre">
        <input type="text" name="nuevo_telefono" placeholder="Telefono">
        <input type="text" name="nuevo_direccion" placeholder="Direccion">
        <input type="submit" name="crear_prestador" value="Crear Prestador">
    </form>
<?php endif; ?>
        <input type="submit" name="prestar_libro" value="Prestar Libro">
    </form>
</body>
</html>
