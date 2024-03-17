<?php
// Verificar si se han enviado datos por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión con la base de datos
    $servername = "localhost"; // Cambia esto si tu servidor de base de datos no está en localhost
    $db_username = "root";
    $db_password="";
    $database = "mecp_database"; // Cambia esto al nombre de tu base de datos

    // Crear conexión
    $conn = new mysqli($servername, $db_username,$db_password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Preparar la consulta SQL para insertar los datos en la tabla de usuarios
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        // Redireccionar a otra página
header("Location: login.php");
exit; // Asegúrate de detener la ejecución del script después de la redirección
    } else {
        echo "Error al registrar usuario: " . $conn->error;
    }
    // Cerrar la conexión
    $conn->close();
}
?>
<!doctype html>
<html>
<head>
    <title>My first PHP Website</title>
</head>
<body>
    <h2>Pagina de registro</h2>
    <a href="index.php">Click para ir atras</a><br/><br/>
    <form action="register.php" method="POST">
       Ingrese usuario: <input type="text" 
       name="username" id="username" required="required" /> <br/>
       Ingrese contraseña: <input type="password" 
       name="password" id="password" required="required" /> <br/>
       <input type="submit" value="Register"/>
    </form>
</body>
</html>
